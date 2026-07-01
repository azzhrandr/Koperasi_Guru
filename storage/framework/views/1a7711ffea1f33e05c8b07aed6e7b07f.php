<?php $__env->startSection('title', 'Dashboard Admin - Koperasi Guru'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid p-0">

    <!-- Page Header & Breadcrumb -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h4 class="fw-bold text-navy mb-1">Dashboard Admin</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                </ol>
            </nav>
        </div>
        <div class="text-muted small">
            <i class="fa-regular fa-calendar-days me-1"></i> Hari ini: <?php echo e(date('d M Y')); ?>

        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-3 mb-4">
        <!-- Card: Members -->
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="stats-card">
                <div class="card-data">
                    <h6>Jumlah Anggota</h6>
                    <h3><?php echo e(number_format($totalMembers)); ?></h3>
                </div>
                <div class="card-icon stats-icon-blue">
                    <i class="fa-solid fa-users"></i>
                </div>
            </div>
        </div>

        <!-- Card: Savings -->
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="stats-card">
                <div class="card-data">
                    <h6>Total Simpanan</h6>
                    <h3>Rp <?php echo e(number_format($totalSavings, 0, ',', '.')); ?></h3>
                </div>
                <div class="card-icon stats-icon-green">
                    <i class="fa-solid fa-piggy-bank"></i>
                </div>
            </div>
        </div>

        <!-- Card: Loans -->
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="stats-card">
                <div class="card-data">
                    <h6>Total Pinjaman</h6>
                    <h3>Rp <?php echo e(number_format($totalLoansDisbursed, 0, ',', '.')); ?></h3>
                </div>
                <div class="card-icon stats-icon-orange">
                    <i class="fa-solid fa-hand-holding-dollar"></i>
                </div>
            </div>
        </div>

        <!-- Card: Status Counts -->
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="stats-card">
                <div class="card-data">
                    <h6>Cicilan Berjalan</h6>
                    <h3><?php echo e(number_format($activeLoansCount)); ?> / <span class="fs-6 text-muted"><?php echo e(number_format($paidLoansCount)); ?> Lunas</span></h3>
                </div>
                <div class="card-icon stats-icon-purple">
                    <i class="fa-solid fa-arrow-trend-up"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart & Table Area -->
    <div class="row g-4 mb-4">
        <!-- Graphic Chart -->
        <div class="col-12 col-xl-8">
            <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
                <h5 class="fw-semibold mb-3 text-dark">Grafik Perkembangan Keuangan (2026)</h5>
                <div style="position: relative; height: 320px;">
                    <canvas id="financeChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Recent Pending Loans -->
        <div class="col-12 col-xl-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-semibold mb-0 text-dark">Pengajuan Pinjaman</h5>
                    <span class="badge bg-warning-subtle text-warning px-2.5 py-1.5 rounded-pill small"><?php echo e($recentRequests->count()); ?> Menunggu</span>
                </div>
                
                <div class="list-group list-group-flush gap-3" style="max-height: 320px; overflow-y: auto;">
                    <?php $__empty_1 = true; $__currentLoopData = $recentRequests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $req): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="list-group-item border-0 p-0 d-flex flex-column gap-1 bg-transparent">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-medium text-dark"><?php echo e($req->user->name); ?></span>
                                <span class="badge bg-warning-subtle text-warning text-xsmall uppercase px-2 py-1 rounded">Menunggu</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center text-muted small">
                                <span>Plafon: <strong>Rp <?php echo e(number_format($req->nominal_pinjaman, 0, ',', '.')); ?></strong></span>
                                <span><?php echo e($req->lama_angsuran_bulan); ?> bln</span>
                            </div>
                            <span class="xsmall text-muted text-truncate italic">"<?php echo e($req->alasan); ?>"</span>
                            <div class="d-flex gap-2 mt-1">
                                <a href="<?php echo e(route('admin.pinjaman.detail', $req->id)); ?>" class="btn btn-primary-subtle btn-sm flex-fill py-1"><i class="fa-solid fa-circle-info"></i> Detail</a>
                            </div>
                            <hr class="my-2 text-slate-200">
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="text-center py-5 text-muted">
                            <i class="fa-regular fa-folder-open fa-2x mb-2 text-slate-400 d-block"></i>
                            <span class="small">Tidak ada pengajuan pinjaman pending.</span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('financeChart').getContext('2d');
        
        // Data populated from controller arrays
        const savingsData = <?php echo json_encode($savingsTrend, 15, 512) ?>;
        const loansData = <?php echo json_encode($loansMonthly, 15, 512) ?>;

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agt', 'Sep', 'Okt', 'Nov', 'Des'],
                datasets: [
                    {
                        label: 'Akumulasi Simpanan',
                        data: savingsData,
                        borderColor: '#0ea5e9',
                        backgroundColor: 'rgba(14, 165, 233, 0.05)',
                        fill: true,
                        tension: 0.3,
                        borderWidth: 2.5
                    },
                    {
                        label: 'Penyaluran Pinjaman',
                        data: loansData,
                        borderColor: '#f59e0b',
                        backgroundColor: 'transparent',
                        fill: false,
                        tension: 0.3,
                        borderWidth: 2.5,
                        borderDash: [5, 5]
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            font: {
                                family: 'Inter',
                                size: 12
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            },
                            font: {
                                family: 'Inter',
                                size: 10
                            }
                        }
                    },
                    x: {
                        ticks: {
                            font: {
                                family: 'Inter',
                                size: 10
                            }
                        }
                    }
                }
            }
        });
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Koperasi_SimpanPinjam\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>