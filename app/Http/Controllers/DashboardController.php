<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Simpanan;
use App\Models\Pinjaman;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display the Admin Dashboard.
     */
    public function adminDashboard()
    {
        $totalMembers = User::where('role', 'anggota')->count();
        $totalSavings = Simpanan::sum('nominal');
        $totalLoansDisbursed = Pinjaman::whereIn('status', ['berjalan', 'lunas'])->sum('nominal_pinjaman');
        $activeLoansCount = Pinjaman::where('status', 'berjalan')->count();
        $paidLoansCount = Pinjaman::where('status', 'lunas')->count();
        
        $recentRequests = Pinjaman::with('user')
            ->where('status', 'menunggu')
            ->orderBy('tanggal_pengajuan', 'desc')
            ->take(5)
            ->get();

        // Chart calculations for 2026
        $savingsMonthly = array_fill(0, 12, 0);
        $loansMonthly = array_fill(0, 12, 0);

        $simpananList = Simpanan::whereYear('tanggal_transaksi', 2026)->get();
        foreach ($simpananList as $s) {
            $monthIndex = date('n', strtotime($s->tanggal_transaksi)) - 1;
            $savingsMonthly[$monthIndex] += (float)$s->nominal;
        }

        $pinjamanList = Pinjaman::whereYear('tanggal_pengajuan', 2026)
            ->whereIn('status', ['berjalan', 'lunas'])
            ->get();
        foreach ($pinjamanList as $p) {
            $monthIndex = date('n', strtotime($p->tanggal_pengajuan)) - 1;
            $loansMonthly[$monthIndex] += (float)$p->nominal_pinjaman;
        }

        // Accumulate savings trend
        $accumulatedSavings = 0;
        $savingsTrend = [];
        foreach ($savingsMonthly as $val) {
            $accumulatedSavings += $val;
            $savingsTrend[] = $accumulatedSavings;
        }

        return view('admin.dashboard', compact(
            'totalMembers', 'totalSavings', 'totalLoansDisbursed', 
            'activeLoansCount', 'paidLoansCount', 'recentRequests',
            'savingsTrend', 'loansMonthly'
        ));
    }

    /**
     * Display the Anggota Dashboard.
     */
    public function anggotaDashboard()
    {
        $user = Auth::user();

        $totalSavings = Simpanan::where('user_id', $user->id)->sum('nominal');
        $totalWajib = Simpanan::where('tipe_simpanan', 'wajib')->sum('nominal');
        $totalManasuka = Simpanan::where('tipe_simpanan', 'manasuka')->sum('nominal');  
        $activeLoan = Pinjaman::where('user_id', $user->id)->where('status', 'berjalan')->first();
        $latestLoan = Pinjaman::where('user_id', $user->id)->orderBy('created_at', 'desc')->first();

        // Breakdown categories
        $wajib = Simpanan::where('user_id', $user->id)
            ->where('tipe_simpanan', 'wajib')
            ->sum('nominal');

        $manasuka = Simpanan::where('user_id', $user->id)
            ->where('tipe_simpanan', 'manasuka')
            ->sum('nominal');

        // Recent activity
        $savings = Simpanan::where('user_id', $user->id)
            ->select('tanggal_transaksi as date', 'tipe_simpanan as label', 'nominal as amount', DB::raw("'simpanan' as type"), DB::raw("'sukses' as status"))
            ->orderBy('tanggal_transaksi', 'desc')
            ->take(5)
            ->get();

        $loans = Pinjaman::where('user_id', $user->id)
            ->select('tanggal_pengajuan as date', DB::raw("'Pinjaman Baru' as label"), 'nominal_pinjaman as amount', DB::raw("'pinjaman' as type"), 'status')
            ->orderBy('tanggal_pengajuan', 'desc')
            ->take(5)
            ->get();

        // Merge and sort
        $recentTransactions = $savings->concat($loans)
            ->sortByDesc('date')
            ->take(5);

        return view('anggota.dashboard', compact(
            'totalSavings',
            'activeLoan',
            'latestLoan',
            'wajib',
            'manasuka',
            'recentTransactions'
        ));
    }
}
