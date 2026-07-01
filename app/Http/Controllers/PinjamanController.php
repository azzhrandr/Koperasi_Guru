<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pinjaman;
use App\Models\Angsuran;
use App\Models\Simpanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PinjamanController extends Controller
{
    /**
     * Display a listing of all loans.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');

        $query = Pinjaman::with('user');

        if ($search) {
            $query->whereHas('user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nip', 'like', "%{$search}%");
            });
        }

        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }

        $loans = $query->orderBy('tanggal_pengajuan', 'desc')->paginate(10);

        return view('admin.pinjaman.index', compact('loans', 'search', 'status'));
    }

    /**
     * Display details of a specific loan including the installment ledger and schedule.
     */
    public function detail($id)
    {
        $loan = Pinjaman::with(['user', 'angsuran'])->findOrFail($id);

        // Amortization calculation
        $pokokBulanan = $loan->nominal_pinjaman / $loan->lama_angsuran_bulan;
        $bungaBulanan = $loan->nominal_pinjaman * ($loan->bunga_persen / 100);
        $totalBulanan = $pokokBulanan + $bungaBulanan;

        $paidInstallments = $loan->angsuran->pluck('angsuran_ke')->toArray();
        $totalPaid = $loan->angsuran->sum('nominal_bayar');
        $totalRemaining = ($totalBulanan * $loan->lama_angsuran_bulan) - $totalPaid;

        return view('admin.pinjaman.detail', compact(
            'loan', 'pokokBulanan', 'bungaBulanan', 'totalBulanan', 
            'paidInstallments', 'totalPaid', 'totalRemaining'
        ));
    }

    /**
     * Approve or reject a pending loan request.
     */
    public function approveOrReject(Request $request, $id)
    {
        $loan = Pinjaman::findOrFail($id);

        $request->validate([
            'action' => 'required|in:setujui,tolak',
            'bunga_persen' => 'required_if:action,setujui|numeric|min:0|max:100',
            'tanggal_jatuh_tempo' => 'required_if:action,setujui|date',
            'catatan' => 'nullable|string',
        ]);

        if ($request->action === 'setujui') {
            $loan->status = 'berjalan';
            $loan->bunga_persen = $request->bunga_persen;
            $loan->tanggal_jatuh_tempo = $request->tanggal_jatuh_tempo;
            $loan->sisa_angsuran_bulan = $loan->lama_angsuran_bulan;
            $message = 'Pengajuan pinjaman berhasil disetujui.';
        } else {
            $loan->status = 'ditolak';
            $loan->alasan = $request->catatan ?? 'Ditolak oleh admin.';
            $message = 'Pengajuan pinjaman telah ditolak.';
        }

        $loan->save();

        return redirect()->route('admin.pinjaman.index')->with('success', $message);
    }

    /**
     * Record a new installment payment for a loan.
     */
    public function payInstallment(Request $request, $id)
    {
        $loan = Pinjaman::findOrFail($id);

        if ($loan->status !== 'berjalan' || $loan->sisa_angsuran_bulan <= 0) {
            return back()->with('error', 'Pinjaman ini tidak dalam masa cicilan aktif.');
        }

        $pokokBulanan = $loan->nominal_pinjaman / $loan->lama_angsuran_bulan;
        $bungaBulanan = $loan->nominal_pinjaman * ($loan->bunga_persen / 100);
        $nominalBayar = $pokokBulanan + $bungaBulanan;

        $angsuranKe = $loan->lama_angsuran_bulan - $loan->sisa_angsuran_bulan + 1;

        Angsuran::create([
            'pinjaman_id' => $loan->id,
            'angsuran_ke' => $angsuranKe,
            'nominal_bayar' => $nominalBayar,
            'tanggal_bayar' => now()->toDateString(),
        ]);

        // Decrement remaining installments
        $loan->sisa_angsuran_bulan = $loan->sisa_angsuran_bulan - 1;
        
        if ($loan->sisa_angsuran_bulan <= 0) {
            $loan->status = 'lunas';
        }

        $loan->save();

        return back()->with('success', "Pembayaran angsuran ke-{$angsuranKe} berhasil dicatat.");
    }

    /**
    * Member: Show the loan application form.
    */
    public function formPengajuan()
    {
        $user = Auth::user();

        $hasActiveLoan = Pinjaman::where('user_id', $user->id)
            ->whereIn('status', ['berjalan', 'disetujui', 'menunggu'])
            ->exists();

        return view('anggota.pinjaman.pengajuan', compact('hasActiveLoan'));
    }

    /**
    * Member: Store a newly submitted loan request.
    */
    public function storePengajuan(Request $request)
    {
        $user = Auth::user();

        // Cek apakah masih memiliki pinjaman aktif / menunggu
        $hasActiveLoan = Pinjaman::where('user_id', $user->id)
            ->whereIn('status', ['berjalan', 'disetujui', 'menunggu'])
            ->exists();

        if ($hasActiveLoan) {
            return redirect()->route('anggota.pinjaman.index')
                ->with('error', 'Anda tidak dapat mengajukan pinjaman baru karena masih memiliki pengajuan aktif atau pinjaman berjalan.');
        }

        // ===========================
        // CEK SIMPANAN WAJIB
        // ===========================

        $totalWajib = Simpanan::where('user_id', $user->id)
            ->where('tipe_simpanan', 'wajib')
            ->sum('nominal');

        $minimalWajib = 500000;

        if ($totalWajib < $minimalWajib) {
            return back()->withInput()->with(
                'error',
                'Minimal Simpanan Wajib Rp 500.000 sebelum mengajukan pinjaman.'
            );
        }

        // ===========================
        // VALIDASI INPUT
        // ===========================

        $request->validate([
            'nominal_pinjaman' => 'required|numeric|min:50000|max:50000000',
            'lama_angsuran_bulan' => 'required|integer|in:3,6,12,18,24',
            'alasan' => 'required|string|max:500',
        ]);

        // ===========================
        // CEK BATAS MAKSIMAL PINJAMAN
        // ===========================

        $totalSimpanan = Simpanan::where('user_id', $user->id)
            ->sum('nominal');

        $maksimalPinjaman = $totalSimpanan * 5;

        if ($request->nominal_pinjaman > $maksimalPinjaman) {
            return back()->withInput()->with(
                'error',
                'Nominal pinjaman melebihi batas maksimal. Maksimal pinjaman Anda adalah Rp ' .
                number_format($maksimalPinjaman, 0, ',', '.')
            );
        }

        // ===========================
        // SIMPAN DATA PENGAJUAN
        // ===========================

        Pinjaman::create([
            'user_id' => $user->id,
            'nominal_pinjaman' => $request->nominal_pinjaman,
            'bunga_persen' => 0,
            'lama_angsuran_bulan' => $request->lama_angsuran_bulan,
            'sisa_angsuran_bulan' => $request->lama_angsuran_bulan,
            'tanggal_pengajuan' => now()->toDateString(),
            'status' => 'menunggu',
            'alasan' => $request->alasan,
        ]);

        return redirect()->route('anggota.pinjaman.index')
            ->with('success', 'Pengajuan pinjaman berhasil dikirim dan menunggu persetujuan admin.');
    }

    /**
     * Member: View Personal Loans History.
     */
    public function anggotaPinjaman()
    {
        $user = Auth::user();
        
        $loans = Pinjaman::where('user_id', $user->id)
            ->orderBy('tanggal_pengajuan', 'desc')
            ->paginate(10);

        return view('anggota.pinjaman.index', compact('loans'));
    }
}
