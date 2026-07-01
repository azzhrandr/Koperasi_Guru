@extends('layouts.app')

@section('title', 'Detail Anggota - Koperasi Guru')

@section('content')
<div class="container-fluid p-0">

    <!-- Page Header & Action -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h4 class="fw-bold text-navy mb-1">Detail Anggota: {{ $user->name }}</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.anggota.index') }}">Anggota</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Detail</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('admin.anggota.index') }}" class="btn btn-light border d-flex align-items-center gap-2">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke List
        </a>
    </div>

    <div class="row g-4">
        <!-- Sidebar Profile Card -->
        <div class="col-12 col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 text-center mb-4 bg-white">
                <div class="profile-avatar bg-navy text-white mx-auto mb-3" style="width: 80px; height: 80px; font-size: 2.2rem; border-radius: 50%;">
                    {{ substr($user->name, 0, 1) }}
                </div>
                <h5 class="fw-bold text-dark mb-1">{{ $user->name }}</h5>
                <span class="badge bg-secondary-subtle text-secondary px-3 py-1.5 rounded-pill mb-4">{{ $user->nip ?? 'NIP: -' }}</span>
                
                <div class="text-start">
                    <span class="text-muted xsmall uppercase fw-semibold mb-3 d-block border-bottom pb-1">Biodata Anggota</span>
                    <div class="mb-3">
                        <label class="text-muted small d-block">Status Keanggotaan</label>
                        @if($user->status === 'aktif')
                            <span class="badge bg-success-subtle text-success px-2.5 py-1.5 rounded small"><i class="fa-solid fa-circle-check me-1"></i> Aktif</span>
                        @else
                            <span class="badge bg-danger-subtle text-danger px-2.5 py-1.5 rounded small"><i class="fa-solid fa-circle-xmark me-1"></i> Nonaktif</span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label class="text-muted small d-block">Email</label>
                        <span class="small text-dark fw-medium">{{ $user->email }}</span>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted small d-block">WhatsApp / Telp</label>
                        <span class="small text-dark fw-medium">{{ $user->phone ?? '-' }}</span>
                    </div>
                    <div class="mb-0">
                        <label class="text-muted small d-block">Alamat Tinggal</label>
                        <span class="small text-dark fw-medium">{{ $user->address ?? '-' }}</span>
                    </div>
                </div>
            </div>
            
            <!-- Account Savings Aggregate Summary -->
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                <span class="text-muted xsmall uppercase fw-semibold mb-3 d-block border-bottom pb-1">Ringkasan Tabungan</span>
                <div class="d-flex flex-column gap-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="small text-muted"><i class="fa-solid fa-circle text-primary me-2 xsmall"></i> Simpanan Pokok</span>
                        <span class="small fw-semibold text-dark">Rp {{ number_format($pokok, 0, ',', '.') }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="small text-muted"><i class="fa-solid fa-circle text-success me-2 xsmall"></i> Simpanan Wajib</span>
                        <span class="small fw-semibold text-dark">Rp {{ number_format($wajib, 0, ',', '.') }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="small text-muted"><i class="fa-solid fa-circle text-warning me-2 xsmall"></i> Simpanan Sukarela</span>
                        <span class="small fw-semibold text-dark">Rp {{ number_format($sukarela, 0, ',', '.') }}</span>
                    </div>
                    <hr class="my-1">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-bold text-dark">Total Saldo</span>
                        <span class="fw-bold text-navy">Rp {{ number_format($totalSimpanan, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Ledger & Loan tabs -->
        <div class="col-12 col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 bg-white">
                <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0">
                    <ul class="nav nav-tabs border-bottom" id="memberTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active fw-semibold text-navy py-2.5 px-3" id="simpanan-tab" data-bs-toggle="tab" data-bs-target="#simpanan-panel" type="button" role="tab" aria-controls="simpanan-panel" aria-selected="true">
                                <i class="fa-solid fa-piggy-bank me-2"></i> Mutasi Simpanan
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link fw-semibold text-navy py-2.5 px-3" id="pinjaman-tab" data-bs-toggle="tab" data-bs-target="#pinjaman-panel" type="button" role="tab" aria-controls="pinjaman-panel" aria-selected="false">
                                <i class="fa-solid fa-clock-rotate-left me-2"></i> Riwayat Pinjaman
                            </button>
                        </li>
                    </ul>
                </div>
                
                <div class="tab-content p-4" id="memberTabsContent">
                    
                    <!-- Panel: Savings Mutations -->
                    <div class="tab-pane fade show active" id="simpanan-panel" role="tabpanel" aria-labelledby="simpanan-tab">
                        <div class="table-responsive">
                            <table class="table custom-table align-middle mb-0">
                                <thead>
                                    <tr class="table-light text-muted small">
                                        <th>Tanggal</th>
                                        <th>Tipe Simpanan</th>
                                        <th>Nominal</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($simpanan as $s)
                                        <tr>
                                            <td>{{ date('d-m-Y', strtotime($s->tanggal_transaksi)) }}</td>
                                            <td>
                                                @if($s->tipe_simpanan === 'pokok')
                                                    <span class="badge bg-primary-subtle text-primary text-xsmall uppercase px-2 py-1 rounded">Pokok</span>
                                                @elseif($s->tipe_simpanan === 'wajib')
                                                    <span class="badge bg-success-subtle text-success text-xsmall uppercase px-2 py-1 rounded">Wajib</span>
                                                @else
                                                    <span class="badge bg-warning-subtle text-warning text-xsmall uppercase px-2 py-1 rounded">Sukarela</span>
                                                @endif
                                            </td>
                                            <td class="fw-semibold text-dark">Rp {{ number_format($s->nominal, 0, ',', '.') }}</td>
                                            <td class="small text-muted">{{ $s->keterangan }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-5 text-muted">
                                                <i class="fa-regular fa-folder-open fa-2x mb-2 text-slate-400 d-block"></i>
                                                <span class="small">Belum ada transaksi simpanan tercatat.</span>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <!-- Panel: Loans History -->
                    <div class="tab-pane fade" id="pinjaman-panel" role="tabpanel" aria-labelledby="pinjaman-tab">
                        <div class="table-responsive">
                            <table class="table custom-table align-middle mb-0">
                                <thead>
                                    <tr class="table-light text-muted small">
                                        <th>Tanggal</th>
                                        <th>Plafon</th>
                                        <th>Tenor</th>
                                        <th>Status</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($pinjaman as $p)
                                        <tr>
                                            <td>{{ date('d-m-Y', strtotime($p->tanggal_pengajuan)) }}</td>
                                            <td class="fw-semibold text-dark">Rp {{ number_format($p->nominal_pinjaman, 0, ',', '.') }}</td>
                                            <td>{{ $p->lama_angsuran_bulan }} bln</td>
                                            <td>
                                                @if($p->status === 'menunggu')
                                                    <span class="badge bg-warning-subtle text-warning text-xsmall uppercase px-2 py-1 rounded">Menunggu</span>
                                                @elseif($p->status === 'berjalan')
                                                    <span class="badge bg-primary-subtle text-primary text-xsmall uppercase px-2 py-1 rounded">Berjalan</span>
                                                @elseif($p->status === 'lunas')
                                                    <span class="badge bg-success-subtle text-success text-xsmall uppercase px-2 py-1 rounded">Lunas</span>
                                                @else
                                                    <span class="badge bg-danger-subtle text-danger text-xsmall uppercase px-2 py-1 rounded">Ditolak</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('admin.pinjaman.detail', $p->id) }}" class="btn btn-light btn-sm text-primary">
                                                    <i class="fa-solid fa-circle-info"></i> Rincian
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-5 text-muted">
                                                <i class="fa-regular fa-folder-open fa-2x mb-2 text-slate-400 d-block"></i>
                                                <span class="small">Belum ada pengajuan pinjaman.</span>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
