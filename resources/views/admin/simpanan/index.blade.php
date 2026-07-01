@extends('layouts.app')

@section('title', 'Kelola Simpanan Anggota - Koperasi Guru')

@section('content')
<div class="container-fluid p-0">

    <!-- Page Header & Action -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h4 class="fw-bold text-navy mb-1">Kelola Simpanan Anggota</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Simpanan</li>
                </ol>
            </nav>
        </div>
        <button class="btn btn-navy d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#recordSavingModal">
            <i class="fa-solid fa-file-invoice"></i> Catat Setoran Baru
        </button>
    </div>

    <!-- Search Form -->
    <div class="card border-0 shadow-sm rounded-4 p-3 mb-4">
        <form action="{{ route('admin.simpanan.index') }}" method="GET" class="row g-3 align-items-center">
            <div class="col-12 col-md-8">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-solid fa-magnifying-glass"></i></span>
                    <input type="text" class="form-control bg-light border-start-0 ps-0" name="search" value="{{ $search }}" placeholder="Cari berdasarkan nama guru atau NIP...">
                </div>
            </div>
            <div class="col-12 col-md-4 d-flex gap-2">
                <button type="submit" class="btn btn-navy flex-fill"><i class="fa-solid fa-magnifying-glass me-1"></i> Cari</button>
                <a href="{{ route('admin.simpanan.index') }}" class="btn btn-light border flex-fill"><i class="fa-solid fa-arrows-rotate me-1"></i> Reset</a>
            </div>
        </form>
    </div>

    <!-- Savings Table -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table custom-table align-middle mb-0">
                <thead class="table-navy">
                    <tr>
                        <th class="ps-4">No</th>
                        <th>Nama Anggota</th>
                        <th>Simpanan Wajib</th>
                        <th>Simpanan Manasuka</th>
                        <th>Total Saldo</th>
                        <th class="text-center pe-4">Detail Simpanan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($members as $index => $m)
                        <tr>
                            <td class="ps-4 text-muted">{{ $members->firstItem() + $index }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="profile-avatar bg-primary-subtle text-primary fw-semibold" style="width: 32px; height: 32px; font-size: 0.95rem;">
                                        {{ substr($m->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <h6 class="mb-0 text-dark fw-semibold small">{{ $m->name }}</h6>
                                        <span class="xsmall text-muted">NIP: {{ $m->nip ?? '-' }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="fw-medium text-dark">
                                Rp {{ number_format($m->simpanan->where('tipe_simpanan','wajib')->sum('nominal'),0,',','.') }}
                            </td>

                            <td class="fw-medium text-dark">
                                Rp {{ number_format($m->simpanan->where('tipe_simpanan','manasuka')->sum('nominal'),0,',','.') }}
                            </td>

                            <td class="fw-bold text-navy">
                                Rp {{ number_format($m->simpanan->sum('nominal'),0,',','.') }}
                            </td>
                            <td class="pe-4 text-center">
                                <a href="{{ route('admin.simpanan.detail', $m->id) }}" class="btn btn-light btn-sm text-primary">
                                    <i class="fa-solid fa-book-open"></i> Lihat Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="fa-regular fa-folder-open fa-3x mb-2 text-slate-400 d-block"></i>
                                <span>Tidak ditemukan data saldo simpanan guru.</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($members->hasPages())
            <div class="d-flex justify-content-center py-3 border-top bg-white">
                {{ $members->appends(request()->query())->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>

</div>

<!-- Record Savings Modal -->
<div class="modal fade" id="recordSavingModal" tabindex="-1" aria-labelledby="recordSavingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold text-navy" id="recordSavingModalLabel">Catat Setoran Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.simpanan.store') }}" method="POST">
                @csrf
                <div class="modal-body py-3">
                    <div class="mb-3">
                        <label class="form-label small fw-medium">Nama Anggota Guru</label>
                        <select class="form-select" name="user_id" required>
                            <option value="" disabled selected>Pilih guru setoran...</option>
                            @foreach($activeMembers as $am)
                                <option value="{{ $am->id }}">{{ $am->name }} (NIP: {{ $am->nip ?? '-' }})</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <label class="form-label small fw-medium">Jenis Simpanan</label>
                            <select class="form-select" name="tipe_simpanan" required>
                            <option value="wajib">Simpanan Wajib</option>
                            <option value="manasuka">Simpanan Manasuka</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-medium">Tanggal Transaksi</label>
                            <input type="date" class="form-control" name="tanggal_transaksi" value="{{ date('Y-m-d') }}" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-medium">Nominal Setoran (Rp)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted fw-semibold">Rp</span>
                            <input type="number" class="form-control" name="nominal" placeholder="Contoh: 250000" min="1000" required>
                        </div>
                    </div>

                    <div class="mb-0">
                        <label class="form-label small fw-medium">Keterangan Tambahan</label>
                        <input type="text" class="form-control" name="keterangan" placeholder="Contoh: Setoran Simpanan Manasuka">
                    </div>
                </div>
                <div class="modal-footer border-top-0 pt-0">
                    <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-navy px-4">Simpan Setoran</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
