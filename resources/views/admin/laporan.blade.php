@extends('layouts.app')

@section('title', 'Cetak Laporan Keuangan - Koperasi Guru')

@section('content')
<div class="container-fluid p-0">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2 d-print-none">
        <div>
            <h4 class="fw-bold text-navy mb-1">Laporan Keuangan</h4>

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.dashboard') }}">
                            Home
                        </a>
                    </li>

                    <li class="breadcrumb-item active">
                        Laporan Keuangan
                    </li>
                </ol>
            </nav>
        </div>

        @if($jenisLaporan && count($reports)>0)

        <button
            onclick="window.print()"
            class="btn btn-navy d-flex align-items-center gap-2">

            <i class="fa-solid fa-print"></i>

            Cetak Laporan

        </button>

        @endif
    </div>

    <!-- Filter -->
    <div class="card border-0 shadow-sm rounded-4 p-4 mb-4 d-print-none">

        <h5 class="fw-semibold mb-3">
            Filter Laporan
        </h5>

        <form action="{{ route('admin.laporan') }}" method="GET">

            <div class="row g-3">

                <div class="col-md-4">

                    <label class="form-label">
                        Jenis Laporan
                    </label>

                    <select
                        class="form-select"
                        name="jenis_laporan"
                        required>

                        <option value="" disabled {{ !$jenisLaporan ? 'selected' : '' }}>
                            Pilih laporan...
                        </option>

                        <option value="simpanan"
                            {{ $jenisLaporan=='simpanan' ? 'selected' : '' }}>
                            Laporan Simpanan
                        </option>

                        <option value="pinjaman"
                            {{ $jenisLaporan=='pinjaman' ? 'selected' : '' }}>
                            Laporan Pinjaman
                        </option>

                        <option value="angsuran"
                            {{ $jenisLaporan=='angsuran' ? 'selected' : '' }}>
                            Laporan Angsuran
                        </option>

                    </select>

                </div>

                <div class="col-md-3">

                    <label class="form-label">
                        Tanggal Mulai
                    </label>

                    <input
                        type="date"
                        class="form-control"
                        name="start_date"
                        value="{{ $startDate }}"
                        required>

                </div>

                <div class="col-md-3">

                    <label class="form-label">
                        Tanggal Selesai
                    </label>

                    <input
                        type="date"
                        class="form-control"
                        name="end_date"
                        value="{{ $endDate }}"
                        required>

                </div>

                <div class="col-md-2 d-flex align-items-end">

                    <button
                        class="btn btn-navy w-100">

                        Tarik Data

                    </button>

                </div>

            </div>

        </form>

    </div>

@if($jenisLaporan)

<div class="card border-0 shadow-sm rounded-4 p-4">

    <!-- Kop Surat -->

    <div class="text-center border-bottom pb-3 mb-4">

        <h4 class="fw-bold mb-1">

            KOPERASI SIMPAN PINJAM GURU

        </h4>

        <span class="text-muted">

           SMP NEGERI 2 BAYUNING

        </span>

    </div>

    <div class="row mb-4">

        <div class="col-md-6">

            <small class="text-muted">

                Judul Laporan

            </small>

            <h6 class="fw-bold">

                @if($jenisLaporan=='simpanan')

                    Laporan Simpanan

                @elseif($jenisLaporan=='pinjaman')

                    Laporan Pinjaman

                @else

                    Laporan Angsuran

                @endif

            </h6>

        </div>

        <div class="col-md-6 text-end">

            <small class="text-muted">

                Periode

            </small>

            <h6 class="fw-bold">

                {{ date('d-m-Y',strtotime($startDate)) }}

                -

                {{ date('d-m-Y',strtotime($endDate)) }}

            </h6>

        </div>

    </div>

    <div class="table-responsive">

        <table class="table table-bordered align-middle">

            <thead class="table-light">

            @if($jenisLaporan=='simpanan')

            <tr>

                <th>No</th>

                <th>Tanggal</th>

                <th>Nama</th>

                <th>NIP</th>

                <th>Jenis</th>

                <th>Nominal</th>

                <th>Keterangan</th>

            </tr>

            @elseif($jenisLaporan=='pinjaman')

            <tr>

                <th>No</th>

                <th>Tanggal</th>

                <th>Nama</th>

                <th>NIP</th>

                <th>Nominal</th>

                <th>Bunga</th>

                <th>Tenor</th>

                <th>Status</th>

            </tr>

            @else

            <tr>

                <th>No</th>

                <th>Tanggal Bayar</th>

                <th>Nama</th>

                <th>Angsuran Ke</th>

                <th>Nominal Bayar</th>

            </tr>

            @endif

            </thead>

            <tbody>
                @forelse($reports as $index => $rep)

                @if($jenisLaporan=='simpanan')

                <tr>

                    <td>{{ $index+1 }}</td>

                    <td>{{ date('d-m-Y',strtotime($rep->tanggal_transaksi)) }}</td>

                    <td>{{ $rep->user->name }}</td>

                    <td>{{ $rep->user->nip ?? '-' }}</td>

                    <td>

                        {{ $rep->tipe_simpanan=='wajib' ? 'Wajib' : 'Manasuka' }}

                    </td>

                    <td>

                        Rp {{ number_format($rep->nominal,0,',','.') }}

                    </td>

                    <td>{{ $rep->keterangan }}</td>

                </tr>

                @elseif($jenisLaporan=='pinjaman')

                <tr>

                    <td>{{ $index+1 }}</td>

                    <td>{{ date('d-m-Y',strtotime($rep->tanggal_pengajuan)) }}</td>

                    <td>{{ $rep->user->name }}</td>

                    <td>{{ $rep->user->nip ?? '-' }}</td>

                    <td>

                        Rp {{ number_format($rep->nominal_pinjaman,0,',','.') }}

                    </td>

                    <td>

                        {{ $rep->bunga_persen }}%

                    </td>

                    <td>

                        {{ $rep->lama_angsuran_bulan }} Bulan

                    </td>

                    <td>

                        {{ ucfirst($rep->status) }}

                    </td>

                </tr>

                @else

                <tr>

                    <td>{{ $index+1 }}</td>

                    <td>{{ date('d-m-Y',strtotime($rep->tanggal_bayar)) }}</td>

                    <td>{{ $rep->pinjaman->user->name }}</td>

                    <td>

                        Ke-{{ $rep->angsuran_ke }}

                    </td>

                    <td>

                        Rp {{ number_format($rep->nominal_bayar,0,',','.') }}

                    </td>

                </tr>

                @endif

                @empty

                <tr>

                <td colspan="{{ $jenisLaporan=='simpanan' ? 7 : ($jenisLaporan=='pinjaman' ? 8 : 5) }}"
                class="text-center py-5">

                <i class="fa-regular fa-folder-open fa-2x mb-2 text-secondary d-block"></i>

                Tidak ada data pada periode tersebut.

                </td>

                </tr>

                @endforelse

                </tbody>

                @if(count($reports)>0)

                <tfoot>

                <tr class="table-light fw-bold">

                @if($jenisLaporan=='simpanan')

                <td colspan="5" class="text-end">

                TOTAL

                </td>

                <td colspan="2">

                Rp {{ number_format($totalNominal,0,',','.') }}

                </td>

                @elseif($jenisLaporan=='pinjaman')

                <td colspan="4" class="text-end">

                TOTAL

                </td>

                <td colspan="4">

                Rp {{ number_format($totalNominal,0,',','.') }}

                </td>

                @else

                <td colspan="4" class="text-end">

                TOTAL

                </td>

                <td>

                Rp {{ number_format($totalNominal,0,',','.') }}

                </td>

                @endif

                </tr>

                </tfoot>

                @endif

                </table>

                </div>

                <!-- Tanda Tangan -->

                <div class="row mt-5">

                    <div class="col-6 text-center">

                        Mengetahui,

                        <br><br><br>

                        <strong>

                            Ketua Koperasi

                        </strong>

                    </div>

                    <div class="col-6 text-center">

                        Kuningan,

                        {{ date('d F Y') }}

                        <br><br><br>

                        <strong>

                            Bendahara

                        </strong>

                    </div>

                </div>

                </div>

                @else

                <div class="card border-0 shadow-sm rounded-4 p-5 text-center">

                <i class="fa-solid fa-file-lines fa-3x text-secondary mb-3"></i>

                <h5>

                Silakan pilih jenis laporan terlebih dahulu.

                </h5>

                <p class="text-muted">

                Gunakan filter di atas untuk menampilkan laporan.

                </p>

                </div>

                @endif

                </div>

                @endsection