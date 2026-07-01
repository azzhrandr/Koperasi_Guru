@extends('layouts.app')

@section('title', 'Pinjaman Saya - Koperasi Guru')

@section('content')
<div class="container-fluid p-0">

    <!-- Page Header & Action -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h4 class="fw-bold text-navy mb-1">Riwayat Pinjaman Saya</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('anggota.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Pinjaman Saya</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('anggota.pinjaman.ajukan') }}" class="btn btn-navy d-flex align-items-center gap-2">
            <i class="fa-solid fa-file-signature"></i> Ajukan Pinjaman Baru
        </a>
    </div>

    <!-- Personal Loans Table -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white p-4">
        <div class="table-responsive">
            <table class="table custom-table align-middle mb-0 text-start small">
                <thead>
                    <tr class="table-light text-muted">
                        <th>No</th>
                        <th>Tgl Pengajuan</th>
                        <th>Nominal Pinjaman</th>
                        <th>Bunga</th>
                        <th>Tenor</th>
                        <th>Status</th>
                        <th>Jatuh Tempo</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($loans as $idx => $loan)
                        <tr>
                            <td class="text-muted">{{ $loans->firstItem() + $idx }}</td>
                            <td>{{ date('d-m-Y', strtotime($loan->tanggal_pengajuan)) }}</td>
                            <td class="fw-bold text-dark">Rp {{ number_format($loan->nominal_pinjaman, 0, ',', '.') }}</td>
                            <td>{{ $loan->bunga_persen }}% / Bln</td>
                            <td>{{ $loan->lama_angsuran_bulan }} Bulan</td>
                            <td>
                                @if($loan->status === 'menunggu')
                                    <span class="badge bg-warning-subtle text-warning px-2 py-1 rounded">Menunggu</span>
                                @elseif($loan->status === 'berjalan')
                                    <span class="badge bg-primary-subtle text-primary px-2 py-1 rounded">Berjalan</span>
                                @elseif($loan->status === 'lunas')
                                    <span class="badge bg-success-subtle text-success px-2 py-1 rounded">Lunas</span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger px-2 py-1 rounded">Ditolak</span>
                                @endif
                            </td>
                            <td>
                                <span class="text-muted small">{{ $loan->tanggal_jatuh_tempo ? date('d-m-Y', strtotime($loan->tanggal_jatuh_tempo)) : '-' }}</span>
                            </td>
                            <td class="text-center">
                                @if($loan->status === 'berjalan' || $loan->status === 'lunas')
                                    <!-- Modal Trigger for Amortization Schedule -->
                                    <button class="btn btn-light btn-sm text-primary" data-bs-toggle="modal" data-bs-target="#amortizationModal{{ $loan->id }}">
                                        <i class="fa-solid fa-calendar-days"></i> Jadwal Cicilan
                                    </button>
                                @elseif($loan->status === 'ditolak')
                                    <span class="text-muted xsmall" title="{{ $loan->alasan }}">Lihat Alasan Ditolak</span>
                                @else
                                    <span class="text-muted small">-</span>
                                @endif
                            </td>
                        </tr>

                        <!-- Amortization Schedule Modal for Member -->
                        @if($loan->status === 'berjalan' || $loan->status === 'lunas')
                            @php
                                $pokokBulanan = $loan->nominal_pinjaman / $loan->lama_angsuran_bulan;
                                $bungaBulanan = $loan->nominal_pinjaman * ($loan->bunga_persen / 100);
                                $totalBulanan = $pokokBulanan + $bungaBulanan;
                                $paidInstallments = $loan->angsuran->pluck('angsuran_ke')->toArray();
                            @endphp
                            <div class="modal fade" id="amortizationModal{{ $loan->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content rounded-4 border-0 shadow">
                                        <div class="modal-header border-bottom-0 pb-0">
                                            <h5 class="modal-title fw-bold text-navy"><i class="fa-solid fa-receipt me-1"></i> Rencana Pembayaran Kredit</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body py-3">
                                            <div class="row g-2 mb-3 bg-light p-3 rounded text-start xsmall">
                                                <div class="col-6">
                                                    <span class="text-muted d-block">Nominal Pinjaman:</span>
                                                    <strong class="text-dark">Rp {{ number_format($loan->nominal_pinjaman, 0, ',', '.') }}</strong>
                                                </div>
                                                <div class="col-6 text-end">
                                                    <span class="text-muted d-block">Tagihan Bulanan:</span>
                                                    <strong class="text-navy">Rp {{ number_format($totalBulanan, 0, ',', '.') }} (Bunga: {{ $loan->bunga_persen }}%)</strong>
                                                </div>
                                            </div>

                                            <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">
                                                <table class="table custom-table align-middle mb-0 text-start xsmall">
                                                    <thead>
                                                        <tr class="table-light text-muted">
                                                            <th>Angsuran Ke-</th>
                                                            <th>Jatuh Tempo</th>
                                                            <th>Nominal Angsuran</th>
                                                            <th>Status</th>
                                                            <th>Tanggal Bayar</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @for($i = 1; $i <= $loan->lama_angsuran_bulan; $i++)
                                                            @php
                                                                $isPaid = in_array($i, $paidInstallments);
                                                                $payment = $loan->angsuran->where('angsuran_ke', $i)->first();

                                                                $dueEst = $loan->tanggal_jatuh_tempo
                                                                    ? date(
                                                                        'd-m-Y',
                                                                        strtotime($loan->tanggal_jatuh_tempo . " + " . ($i - 1) . " month")
                                                                    )
                                                                    : '-';
                                                            @endphp
                                                            <tr>
                                                                <td class="fw-semibold text-dark">#{{ $i }}</td>
                                                                <td>{{ $dueEst }}</td>
                                                                <td class="fw-semibold text-dark">Rp {{ number_format($totalBulanan, 0, ',', '.') }}</td>
                                                                <td>
                                                                    @if($isPaid)
                                                                        <span class="badge bg-success-subtle text-success px-2 py-0.5 rounded">Lunas</span>
                                                                    @else
                                                                        <span class="badge bg-warning-subtle text-warning px-2 py-0.5 rounded">Belum Bayar</span>
                                                                    @endif
                                                                </td>
                                                                <td class="text-muted">
                                                                    {{ $isPaid && $payment ? date('d-m-Y', strtotime($payment->tanggal_bayar)) : '-' }}
                                                                </td>
                                                            </tr>
                                                        @endfor
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-top-0 pt-0">
                                            <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                <i class="fa-regular fa-folder-open fa-2x mb-2 text-slate-300"></i>
                                <p class="mb-0 small">Anda belum memiliki riwayat pengajuan pinjaman.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($loans->hasPages())
            <div class="d-flex justify-content-center py-3 border-top bg-white">
                {{ $loans->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>

</div>
@endsection
