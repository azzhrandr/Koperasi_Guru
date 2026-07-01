@extends('layouts.app')

@section('title', 'Dashboard Saya - Koperasi Guru')

@section('content')
<div class="container-fluid p-0">

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h4 class="fw-bold text-navy mb-1">Dashboard Anggota</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard Saya</li>
                </ol>
            </nav>
        </div>
        <div class="text-muted small">
            <i class="fa-regular fa-calendar-days me-1"></i> Hari ini: {{ date('d M Y') }}
        </div>
    </div>

    <!-- Savings Breakdown Overview Card -->
    <div class="row g-4 mb-4">
        <!-- Main Balance Card -->
        <div class="col-12 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 p-4 text-white h-100" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);">
                <span class="xsmall text-white-50 uppercase fw-semibold mb-1 d-block">
                    Total Simpanan Saya
                </span>

                <h2 class="fw-bold mb-4">
                    Rp {{ number_format($totalSavings, 0, ',', '.') }}
                </h2>
                
                <div class="row g-2 text-start">

                    <div class="col-6 border-end border-slate-700">
                        <span class="xsmall text-white-50 d-block">
                            Simpanan Wajib
                        </span>

                        <span class="fw-semibold text-white small">
                            Rp {{ number_format($wajib, 0, ',', '.') }}
                        </span>
                    </div>

                    <div class="col-6">
                        <span class="xsmall text-white-50 d-block">
                            Simpanan Manasuka
                        </span>

                        <span class="fw-semibold text-white small">
                            Rp {{ number_format($manasuka, 0, ',', '.') }}
                        </span>
                    </div>

                </div>
            </div>
        </div>

        <!-- Active Loan details -->
        <div class="col-12 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100 d-flex flex-column justify-content-between">
                <div>
                    <h5 class="fw-semibold text-dark mb-3"><i class="fa-solid fa-hand-holding-dollar me-1 text-warning"></i> Pinjaman Aktif Saya</h5>
                    @if($activeLoan)
                        @php
                            $pokokBulanan = $activeLoan->nominal_pinjaman / $activeLoan->lama_angsuran_bulan;
                            $bungaBulanan = $activeLoan->nominal_pinjaman * ($activeLoan->bunga_persen / 100);
                            $totalBulanan = $pokokBulanan + $bungaBulanan;
                        @endphp
                        <div class="row g-2 small text-muted">
                            <div class="col-6">
                                <span class="d-block">Sisa Pinjaman Berjalan:</span>
                                <strong class="text-navy fs-5">Rp {{ number_format($totalBulanan * $activeLoan->sisa_angsuran_bulan, 0, ',', '.') }}</strong>
                            </div>
                            <div class="col-6 text-end">
                                <span class="d-block">Angsuran Bulanan:</span>
                                <strong class="text-dark">Rp {{ number_format($totalBulanan, 0, ',', '.') }}</strong>
                            </div>
                            <div class="col-12 mt-3">
                                <span class="d-block mb-1">Masa Sisa Angsuran: <strong>{{ $activeLoan->sisa_angsuran_bulan }} dari {{ $activeLoan->lama_angsuran_bulan }} Bulan</strong></span>
                                <div class="progress rounded-pill" style="height: 8px;">
                                    @php 
                                        $percentPaid = (($activeLoan->lama_angsuran_bulan - $activeLoan->sisa_angsuran_bulan) / $activeLoan->lama_angsuran_bulan) * 100;
                                    @endphp
                                    <div class="progress-bar bg-success" style="width: {{ $percentPaid }}%"></div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-4 text-muted small">
                            <i class="fa-solid fa-face-smile fa-2x text-slate-300 mb-2"></i>
                            <p class="mb-0">Anda tidak memiliki tagihan pinjaman aktif saat ini.</p>
                            @if($latestLoan && $latestLoan->status === 'menunggu')
                                <div class="mt-2 alert alert-warning py-1.5 border-0 rounded small mb-0">
                                    <i class="fa-solid fa-circle-notch fa-spin me-1"></i> Pengajuan pinjaman Anda sebelumnya sedang direview admin.
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Recent personal logs -->
    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
        <h5 class="fw-semibold text-navy mb-3 border-bottom pb-2"><i class="fa-solid fa-clock-rotate-left me-1"></i> Transaksi Terakhir Saya</h5>
        <div class="table-responsive">
            <table class="table custom-table align-middle mb-0 small text-start">
                <thead>
                    <tr class="table-light text-muted">
                        <th>Tanggal</th>
                        <th>Kategori</th>
                        <th>Keterangan</th>
                        <th>Nominal</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentTransactions as $tx)
                        <tr>
                            <td>{{ date('d-m-Y', strtotime($tx->date)) }}</td>
                            <td>
                                @if($tx->type === 'simpanan')
                                    <span class="badge bg-success-subtle text-success text-xsmall uppercase px-2 py-0.5 rounded">Setoran</span>
                                @else
                                    <span class="badge bg-warning-subtle text-warning text-xsmall uppercase px-2 py-0.5 rounded">Pinjaman</span>
                                @endif
                            </td>
                            <td class="text-muted">{{ $tx->label }}</td>
                            <td class="fw-semibold text-dark">Rp {{ number_format($tx->amount, 0, ',', '.') }}</td>
                            <td>
                                @if($tx->status === 'sukses' || $tx->status === 'berjalan' || $tx->status === 'lunas')
                                    <span class="badge bg-success-subtle text-success text-xsmall px-2 py-0.5 rounded">Sukses</span>
                                @elseif($tx->status === 'menunggu')
                                    <span class="badge bg-warning-subtle text-warning text-xsmall px-2 py-0.5 rounded">Menunggu</span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger text-xsmall px-2 py-0.5 rounded">Ditolak</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">
                                <i class="fa-regular fa-folder-open fa-2x mb-2 text-slate-300"></i>
                                <p class="mb-0 small">Belum ada aktivitas transaksi terdaftar.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
