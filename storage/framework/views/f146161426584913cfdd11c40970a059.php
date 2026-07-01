<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Anggota - Koperasi Simpan Pinjam Guru</title>
    
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- FontAwesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom Style -->
    <link rel="stylesheet" href="<?php echo e(asset('css/style.css')); ?>">
</head>
<body class="bg-slate d-flex align-items-center justify-content-center min-vh-100 py-5">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-10 col-md-8 col-lg-6">
                
                <!-- Logo/Brand Header -->
                <div class="text-center mb-4">
                    <div class="d-inline-flex align-items-center justify-content-center bg-navy text-white p-3 rounded-4 shadow-sm mb-3">
                        <i class="fa-solid fa-graduation-cap fa-2x text-sky"></i>
                    </div>
                    <h3 class="fw-bold text-navy mb-1">Daftar Anggota Koperasi</h3>
                    <p class="text-muted small">Pendaftaran guru anggota baru koperasi simpan pinjam</p>
                </div>
                
                <!-- Register Card -->
                <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                    <h5 class="fw-semibold mb-3 text-dark">Formulir Registrasi</h5>
                    
                    <?php if($errors->any()): ?>
                        <div class="alert alert-danger border-0 small mb-3">
                            <i class="fa-solid fa-circle-exclamation me-1"></i> <?php echo e($errors->first()); ?>

                        </div>
                    <?php endif; ?>

                    <form action="<?php echo e(route('register.post')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        
                        <div class="row g-3 mb-3">
                            <div class="col-12 col-md-6">
                                <label for="name" class="form-label small fw-medium">Nama Lengkap & Gelar</label>
                                <input type="text" class="form-control" id="name" name="name" value="<?php echo e(old('name')); ?>" placeholder="Contoh: Ani Rahmawati, S.Pd." required>
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="nip" class="form-label small fw-medium">NIP (Nomor Induk Pegawai)</label>
                                <input type="text" class="form-control" id="nip" name="nip" value="<?php echo e(old('nip')); ?>" placeholder="Contoh: 19870425..." required>
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-12 col-md-6">
                                <label for="email" class="form-label small fw-medium">Alamat Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?php echo e(old('email')); ?>" placeholder="guru@sekolah.sch.id" required>
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="phone" class="form-label small fw-medium">Nomor HP / WhatsApp</label>
                                <input type="text" class="form-control" id="phone" name="phone" value="<?php echo e(old('phone')); ?>" placeholder="Contoh: 081234567..." required>
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-12 col-md-6">
                                <label for="password" class="form-label small fw-medium">Kata Sandi Baru</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Minimal 6 karakter" required>
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="password_confirmation" class="form-label small fw-medium">Konfirmasi Kata Sandi</label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Ketik ulang sandi" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="address" class="form-label small fw-medium">Alamat Rumah Lengkap</label>
                            <textarea class="form-control" id="address" name="address" rows="2" placeholder="Tulis alamat tinggal sekarang..." required><?php echo e(old('address')); ?></textarea>
                        </div>

                        <button type="submit" class="btn btn-navy w-100 py-2.5 rounded-3 fw-semibold mb-3">
                            <i class="fa-solid fa-user-plus me-2"></i> Daftar Sekarang
                        </button>

                        <div class="text-center small">
                            <span class="text-muted">Sudah terdaftar sebagai anggota?</span>
                            <a href="<?php echo e(route('login')); ?>" class="text-navy fw-semibold ms-1">Masuk di sini</a>
                        </div>
                    </form>
                </div>
                
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\Koperasi_SimpanPinjam\resources\views/auth/register.blade.php ENDPATH**/ ?>