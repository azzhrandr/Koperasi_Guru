<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Simpanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SimpananController extends Controller
{
    /**
     * Display aggregated list of savings per member.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = User::where('role', 'anggota')
            ->with('simpanan');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nip', 'like', "%{$search}%");
            });
        }

        $members = $query->orderBy('name', 'asc')->paginate(10);

        $activeMembers = User::where('role', 'anggota')
            ->where('status', 'aktif')
            ->orderBy('name', 'asc')
            ->get();

        return view('admin.simpanan.index', compact(
            'members',
            'activeMembers',
            'search'
        ));
    }

    /**
     * Store a new saving transaction.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'tipe_simpanan' => 'required|in:wajib,manasuka',
            'nominal' => 'required|numeric|min:1000',
            'tanggal_transaksi' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        Simpanan::create([
            'user_id' => $request->user_id,
            'tipe_simpanan' => $request->tipe_simpanan,
            'nominal' => $request->nominal,
            'tanggal_transaksi' => $request->tanggal_transaksi,
            'keterangan' => $request->keterangan ??
                'Setoran Simpanan ' . ucfirst($request->tipe_simpanan),
        ]);

        return redirect()
            ->route('admin.simpanan.index')
            ->with('success', 'Transaksi simpanan berhasil dicatat.');
    }

    /**
     * Show detailed savings ledger of a specific member.
     */
    public function detail($userId)
    {
        $user = User::findOrFail($userId);

        $simpanan = Simpanan::where('user_id', $user->id)
            ->orderBy('tanggal_transaksi', 'desc')
            ->get();

        $wajib = $simpanan
            ->where('tipe_simpanan', 'wajib')
            ->sum('nominal');

        $manasuka = $simpanan
            ->where('tipe_simpanan', 'manasuka')
            ->sum('nominal');

        $total = $wajib + $manasuka;

        return view('admin.simpanan.detail', compact(
            'user',
            'simpanan',
            'wajib',
            'manasuka',
            'total'
        ));
    }

    /**
     * Delete a saving transaction.
     */
    public function destroy($id)
    {
        $simpanan = Simpanan::findOrFail($id);

        $userId = $simpanan->user_id;

        $simpanan->delete();

        return redirect('/admin/simpanan/' . $userId)
            ->with('success', 'Transaksi simpanan berhasil dihapus.');
    }

    /**
     * Member: View Personal Savings Ledger.
     */
    public function anggotaSimpanan()
    {
        $user = Auth::user();

        $simpanan = Simpanan::where('user_id', $user->id)
            ->orderBy('tanggal_transaksi', 'desc')
            ->paginate(15);

        $wajib = $simpanan
            ->where('tipe_simpanan', 'wajib')
            ->sum('nominal');

        $manasuka = $simpanan
            ->where('tipe_simpanan', 'manasuka')
            ->sum('nominal');

        $total = $wajib + $manasuka;

        return view('anggota.simpanan', compact(
            'simpanan',
            'wajib',
            'manasuka',
            'total'
        ));
    }
}