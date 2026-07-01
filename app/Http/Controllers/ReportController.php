<?php

namespace App\Http\Controllers;

use App\Models\Simpanan;
use App\Models\Pinjaman;
use App\Models\Angsuran;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Display reporting screen with optional filtered records.
     */
    public function laporan(Request $request)
    {
        $jenisLaporan = $request->jenis_laporan;
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        $reports = collect();
        $totalNominal = 0;

        if ($jenisLaporan && $startDate && $endDate) {

            if ($jenisLaporan == 'simpanan') {

                $reports = Simpanan::with('user')
                    ->whereBetween('tanggal_transaksi', [$startDate, $endDate])
                    ->orderBy('tanggal_transaksi')
                    ->get();

                $totalNominal = $reports->sum('nominal');

            } elseif ($jenisLaporan == 'pinjaman') {

                $reports = Pinjaman::with('user')
                    ->whereBetween('tanggal_pengajuan', [$startDate, $endDate])
                    ->orderBy('tanggal_pengajuan')
                    ->get();

                $totalNominal = $reports->sum('nominal_pinjaman');

            } elseif ($jenisLaporan == 'angsuran') {

                $reports = \App\Models\Angsuran::with('pinjaman.user')
                    ->whereBetween('tanggal_bayar', [$startDate, $endDate])
                    ->orderBy('tanggal_bayar')
                    ->get();

                $totalNominal = $reports->sum('nominal_bayar');

            }

        }

        return view('admin.laporan', compact(
            'reports',
            'jenisLaporan',
            'startDate',
            'endDate',
            'totalNominal'
        ));
    }
}
