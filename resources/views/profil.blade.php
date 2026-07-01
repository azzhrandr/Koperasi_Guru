@extends('layouts.app')

@section('title', 'Profil Saya - Koperasi Guru')

@section('content')
<div class="container-fluid p-0">

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h4 class="fw-bold text-navy mb-1">Pengaturan Profil Saya</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Profil</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row g-4">
        <!-- Profile Card View -->
        <div class="col-12 col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 text-center bg-white">
                <div class="profile-avatar bg-navy text-white mx-auto mb-3" style="width: 80px; height: 80px; font-size: 2.2rem; border-radius: 50%;">
                    {{ substr($user->name, 0, 1) }}
                </div>
                <h5 class="fw-bold text-dark mb-1">{{ $user->name }}</h5>
                <span class="badge bg-secondary-subtle text-secondary px-3 py-1.5 rounded-pill mb-4">{{ $user->nip ?? 'NIP: -' }}</span>
                
                <div class="text-start border-top pt-3 small">
                    <div class="mb-2">
                        <span class="text-muted d-block">Hak Akses:</span>
                        <strong class="text-dark">{{ ucfirst($user->role) }}</strong>
                    </div>
                    <div class="mb-2">
                        <span class="text-muted d-block">Status Akun:</span>
                        <span class="badge bg-success-subtle text-success">Aktif</span>
                    </div>
                    <div class="mb-0">
                        <span class="text-muted d-block">Terdaftar Sejak:</span>
                        <strong class="text-dark">{{ $user->created_at->format('d F Y') }}</strong>
                    </div>
                </div>
            </div>
        </div>

        <!-- Profile Edit Form -->
        <div class="col-12 col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                <h5 class="fw-semibold text-navy mb-3 border-bottom pb-2"><i class="fa-solid fa-user-pen me-1"></i> Perbarui Informasi Personal</h5>
                
                <form action="{{ route('profil.update') }}" method="POST">
                    @csrf
                    
                    <div class="row g-3 mb-3">
                        <div class="col-12 col-md-6">
                            <label class="form-label small fw-medium">Nama Lengkap & Gelar</label>
                            <input type="text" class="form-control" name="name" value="{{ old('name', $user->name) }}" required>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label small fw-medium">NIP (Nomor Induk Pegawai)</label>
                            <input type="text" class="form-control" name="nip" value="{{ old('nip', $user->nip) }}" {{ $user->role !== 'admin' ? 'readonly' : '' }}>
                            @if($user->role !== 'admin')
                                <span class="xsmall text-muted mt-1 d-block"><i class="fa-solid fa-circle-info me-1"></i> NIP hanya dapat diubah oleh administrator koperasi.</span>
                            @endif
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-12 col-md-6">
                            <label class="form-label small fw-medium">Alamat Email</label>
                            <input type="email" class="form-control" name="email" value="{{ old('email', $user->email) }}" required>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label small fw-medium">No. Telepon / WhatsApp</label>
                            <input type="text" class="form-control" name="phone" value="{{ old('phone', $user->phone) }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-medium">Alamat Lengkap Tinggal</label>
                        <textarea class="form-control" name="address" rows="2">{{ old('address', $user->address) }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-medium">Ganti Kata Sandi (Kosongkan jika tidak ingin diubah)</label>
                        <input type="password" class="form-control" name="password" placeholder="••••••••">
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-navy px-4">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection
