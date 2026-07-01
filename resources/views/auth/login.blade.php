<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Koperasi Simpan Pinjam Guru</title>
    
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- FontAwesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom Style -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body class="bg-slate d-flex align-items-center justify-content-center min-vh-100 py-5">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-8 col-md-6 col-lg-4">
                
                <!-- Logo/Brand Header -->
                <div class="text-center mb-4">
                    <div class="login-logo mx-auto mb-4">
                        <img src="{{ asset('images/LOGO.png') }}"
                            alt="Logo Koperasi Guru">
                    </div>
                    <h4 class="fw-bold text-dark mb-1">
                        Koperasi Guru
                    </h4>

                    <p class="text-muted small mb-0">
                        Sistem Informasi Koperasi Simpan Pinjam Sekolah
                    </p>
                </div>
                
                <!-- Login Card -->
                <div class="card login-card border-0 shadow rounded-4 mb-4">
                    <div class="card-body p-5">
                    <h5 class="fw-bold mb-1">
                        Selamat Datang Kembali
                    </h5>

                    <p class="text-muted small mb-4">
                        Silakan masuk menggunakan akun Anda.
                    </p>
                    
                    @if($errors->any())
                        <div class="alert alert-danger border-0 small mb-3">
                            <i class="fa-solid fa-circle-exclamation me-1"></i> {{ $errors->first() }}
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="alert alert-success border-0 small mb-3">
                            <i class="fa-solid fa-circle-check me-1"></i> {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('login.post') }}" method="POST" id="loginForm">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold" style="font-size:13px;">Alamat Email</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-solid fa-envelope"></i></span>
                                <input type="email" class="form-control bg-light border-start-0 py-2" id="email" name="email" value="{{ old('email') }}" placeholder="nama@sekolah.sch.id" required autofocus>
                            </div>
                        </div>
                        
                       <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <label for="password" class="form-label fw-semibold" style="font-size:13px;">
                                    Password
                                </label>
                            </div>

                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-muted">
                                    <i class="fa-solid fa-lock"></i>
                                </span>

                                <input
                                    type="password"
                                    class="form-control bg-light border-start-0 py-2" style="font-size:14px;"
                                    id="password"
                                    name="password"
                                    placeholder="••••••••"
                                    required>
                            </div>
                        </div>
                                                
                        <button type="submit" class="btn btn-navy w-100 py-2 rounded-3 fw-semibold shadow-sm" style="font-size:15px;">
                            <i class="fa-solid fa-right-to-bracket me-2"></i> Masuk ke Sistem
                        </button>
                        
                        <div class="text-center" style="font-size:13px;">
                            <span class="text-muted">Belum terdaftar sebagai anggota?</span>
                            <a href="{{ route('register') }}" class="text-navy fw-semibold ms-1">Daftar di sini</a>
                        </div>
                    </form>
                    </div>
                </div>
                
                <!-- Quick Login Help -->
                <div class="card border-0 shadow rounded-4 p-4 bg-white">
                    <span class="text-muted xsmall uppercase fw-semibold tracking-wider mb-3 d-block">Akun Demo</span>
                    
                    <div class="d-flex gap-2">
                        <button class="btn btn-outline-primary flex-fill rounded-3 py-2 small fw-medium" onclick="quickLogin('admin@koperasi.id', 'admin123')">
                            <i class="fa-solid fa-user-shield me-1"></i> Admin Koperasi
                        </button>
                        <button class="btn btn-outline-success flex-fill rounded-3 py-2 small fw-medium" onclick="quickLogin('guru@koperasi.id', 'guru123')">
                            <i class="fa-solid fa-chalkboard-user me-1"></i> Anggota Guru
                        </button>
                    </div>
                </div>
                
            </div>
        </div>
    </div>

    <!-- Quick Login script -->
    <script>
        function quickLogin(email, password) {
            document.getElementById('email').value = email;
            document.getElementById('password').value = password;
            document.getElementById('loginForm').submit();
        }
    </script>
    
    <!-- Bootstrap 5 Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
