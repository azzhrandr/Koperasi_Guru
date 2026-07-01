<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'Koperasi Simpan Pinjam Guru'); ?></title>
    
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
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <?php echo $__env->yieldContent('styles'); ?>
</head>
<body>

    <div id="app-container">
        <!-- Sidebar Overlay (for Mobile) -->
        <div id="sidebar-overlay" class="d-print-none"></div>

        <!-- Sidebar -->
        <aside id="sidebar" class="d-print-none">
            <div class="brand">
                <i class="fa-solid fa-graduation-cap brand-logo"></i>
                <span class="brand-name">Koperasi Guru</span>
            </div>
            
            <ul class="menu-list">
                <?php if(auth()->user()->role === 'admin'): ?>
                    <!-- Admin Menu -->
                    <li class="menu-item">
                        <a href="<?php echo e(route('admin.dashboard')); ?>" class="menu-link <?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>">
                            <i class="fa-solid fa-chart-line"></i>
                            <span>Dashboard Admin</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="<?php echo e(route('admin.anggota.index')); ?>" class="menu-link <?php echo e(request()->routeIs('admin.anggota.*') ? 'active' : ''); ?>">
                            <i class="fa-solid fa-users"></i>
                            <span>Data Anggota</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="<?php echo e(route('admin.simpanan.index')); ?>" class="menu-link <?php echo e(request()->routeIs('admin.simpanan.*') ? 'active' : ''); ?>">
                            <i class="fa-solid fa-wallet"></i>
                            <span>Kelola Simpanan</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="<?php echo e(route('admin.pinjaman.index')); ?>" class="menu-link <?php echo e(request()->routeIs('admin.pinjaman.*') ? 'active' : ''); ?>">
                            <i class="fa-solid fa-hand-holding-dollar"></i>
                            <span>Kelola Pinjaman</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="<?php echo e(route('admin.laporan')); ?>" class="menu-link <?php echo e(request()->routeIs('admin.laporan') ? 'active' : ''); ?>">
                            <i class="fa-solid fa-file-invoice-dollar"></i>
                            <span>Cetak Laporan</span>
                        </a>
                    </li>
                <?php else: ?>
                    <!-- Member Menu -->
                    <li class="menu-item">
                        <a href="<?php echo e(route('anggota.dashboard')); ?>" class="menu-link <?php echo e(request()->routeIs('anggota.dashboard') ? 'active' : ''); ?>">
                            <i class="fa-solid fa-house"></i>
                            <span>Dashboard Saya</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="<?php echo e(route('anggota.simpanan')); ?>" class="menu-link <?php echo e(request()->routeIs('anggota.simpanan') ? 'active' : ''); ?>">
                            <i class="fa-solid fa-piggy-bank"></i>
                            <span>Simpanan Saya</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="<?php echo e(route('anggota.pinjaman.index')); ?>" class="menu-link <?php echo e(request()->routeIs('anggota.pinjaman.index') ? 'active' : ''); ?>">
                            <i class="fa-solid fa-clock-rotate-left"></i>
                            <span>Pinjaman Saya</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="<?php echo e(route('anggota.pinjaman.ajukan')); ?>" class="menu-link <?php echo e(request()->routeIs('anggota.pinjaman.ajukan') ? 'active' : ''); ?>">
                            <i class="fa-solid fa-file-signature"></i>
                            <span>Ajukan Pinjaman</span>
                        </a>
                    </li>
                <?php endif; ?>
                
                <li class="menu-item"><hr style="border-color: rgba(255,255,255,0.1); margin: 0.75rem 0;"></li>
                
                <li class="menu-item">
                    <a href="<?php echo e(route('profil')); ?>" class="menu-link <?php echo e(request()->routeIs('profil') ? 'active' : ''); ?>">
                        <i class="fa-solid fa-user-gear"></i>
                        <span>Profil Saya</span>
                    </a>
                </li>
                
                <li class="menu-item">
                    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="menu-link text-danger">
                        <i class="fa-solid fa-right-from-bracket text-danger"></i>
                        <span class="text-danger">Keluar</span>
                    </a>
                </li>
            </ul>
        </aside>

        <!-- Logout Form -->
        <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="d-none">
            <?php echo csrf_field(); ?>
        </form>

        <!-- Main Content Area -->
        <div id="main-content">
            
            <!-- Navbar -->
            <header id="top-navbar" class="d-print-none">
                <button class="toggle-sidebar-btn" id="toggleSidebar">
                    <i class="fa-solid fa-bars-staggered"></i>
                </button>
                
                <div class="d-none d-md-flex align-items-center ms-3">
                    <span class="text-muted small">Sistem Informasi Simpan Pinjam Sekolah</span>
                </div>
                
                <div class="nav-right ms-auto">
                    <!-- Role Switcher Badge -->
                    <a href="<?php echo e(route('switch-role')); ?>" class="role-switcher-badge text-decoration-none" title="Klik untuk beralih mode cepat">
                        <?php if(auth()->user()->role === 'admin'): ?>
                            <i class="fa-solid fa-shuffle"></i> Admin Mode
                        <?php else: ?>
                            <i class="fa-solid fa-shuffle"></i> Anggota Mode
                        <?php endif; ?>
                    </a>

                    <div class="vr text-slate-300 mx-2 d-none d-sm-block" style="height: 24px;"></div>

                    <!-- User Dropdown -->
                    <div class="dropdown">
                        <div class="nav-profile dropdown-toggle d-flex align-items-center gap-2" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="cursor: pointer;">
                            <div class="profile-avatar bg-primary text-white d-flex align-items-center justify-content-center fw-bold" style="width: 36px; height: 36px; border-radius: 50%;">
                                <?php echo e(substr(auth()->user()->name, 0, 1)); ?>

                            </div>
                            <div class="profile-info d-none d-sm-block">
                                <div class="profile-name"><?php echo e(auth()->user()->name); ?></div>
                                <div class="profile-role"><?php echo e(ucfirst(auth()->user()->role)); ?></div>
                            </div>
                        </div>
                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow mt-2" aria-labelledby="profileDropdown">
                            <li><a class="dropdown-item" href="<?php echo e(route('profil')); ?>"><i class="fa-solid fa-circle-user me-2 text-muted"></i>Profil Saya</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item text-danger" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fa-solid fa-right-from-bracket me-2"></i>Keluar
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </header>
            
            <!-- Page Body Pane -->
            <main class="page-body">
                <?php echo $__env->yieldContent('content'); ?>
            </main>
            
        </div>
    </div>

    <!-- Toast Notification (Bootstrap Alert replacement for SPA Toast) -->
    <?php if(session('success') || session('error') || $errors->any()): ?>
        <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1100;">
            <?php if(session('success')): ?>
                <div class="toast show align-items-center text-white bg-success border-0 shadow" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body">
                            <i class="fa-solid fa-circle-check me-2"></i> <?php echo e(session('success')); ?>

                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>
            <?php endif; ?>

            <?php if(session('error')): ?>
                <div class="toast show align-items-center text-white bg-danger border-0 shadow" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body">
                            <i class="fa-solid fa-circle-xmark me-2"></i> <?php echo e(session('error')); ?>

                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>
            <?php endif; ?>

            <?php if($errors->any()): ?>
                <div class="toast show align-items-center text-white bg-danger border-0 shadow" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body">
                            <i class="fa-solid fa-triangle-exclamation me-2"></i> <?php echo e($errors->first()); ?>

                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <!-- Bootstrap 5 Bundle JS with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Sidebar Toggle Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtn = document.getElementById('toggleSidebar');
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');

            if (toggleBtn && sidebar) {
                toggleBtn.addEventListener('click', function() {
                    sidebar.classList.toggle('show-sidebar');
                    if (overlay) {
                        overlay.classList.toggle('show-overlay');
                    }
                });
            }

            if (overlay) {
                overlay.addEventListener('click', function() {
                    sidebar.classList.remove('show-sidebar');
                    overlay.classList.remove('show-overlay');
                });
            }

            // Auto-hide toast notifications after 4 seconds
            const toasts = document.querySelectorAll('.toast');
            toasts.forEach(t => {
                setTimeout(() => {
                    const bsToast = new bootstrap.Toast(t);
                    bsToast.hide();
                }, 4000);
            });
        });
    </script>
    
    <?php echo $__env->yieldContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\Koperasi_SimpanPinjam\resources\views/layouts/app.blade.php ENDPATH**/ ?>