<?php $__env->startSection('title', 'Ledger Pinjaman - Koperasi Guru'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid p-0">

    <!-- Page Header & Action -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h4 class="fw-bold text-navy mb-1">Ledger Pinjaman: <?php echo e($loan->user->name); ?></h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo e(route('admin.pinjaman.index')); ?>">Pinjaman</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Amortisasi</li>
                </ol>
            </nav>
        </div>
        <a href="<?php echo e(route('admin.pinjaman.index')); ?>" class="btn btn-light border d-flex align-items-center gap-2">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke List
        </a>
    </div>

    <!-- Loan details summary -->
    <div class="row g-4 mb-4">
        <!-- Debtor Details Card -->
        <div class="col-12 col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
                <span class="text-muted xsmall uppercase fw-semibold mb-3 d-block border-bottom pb-1">Detail Kredit & Debitur</span>
                
                <div class="d-flex align-items-center gap-2 mb-3">
                    <div class="profile-avatar bg-navy text-white fw-semibold" style="width: 40px; height: 40px; font-size: 1.1rem;">
                        <?php echo e(substr($loan->user->name, 0, 1)); ?>

                    </div>
                    <div>
                        <h6 class="mb-0 text-dark fw-bold small"><?php echo e($loan->user->name); ?></h6>
                        <span class="xsmall text-muted">NIP: <?php echo e($loan->user->nip ?? '-'); ?></span>
                    </div>
                </div>

                <div class="d-flex flex-column gap-2 small">
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Tanggal Pinjam:</span>
                        <span class="fw-semibold text-dark"><?php echo e(date('d-m-Y', strtotime($loan->tanggal_pengajuan))); ?></span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Tenor Waktu:</span>
                        <span class="fw-semibold text-dark"><?php echo e($loan->lama_angsuran_bulan); ?> Bulan</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Suku Bunga:</span>
                        <span class="fw-semibold text-dark"><?php echo e($loan->bunga_persen); ?>% / Bulan</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Status Kredit:</span>
                        <?php if($loan->status === 'berjalan'): ?>
                            <span class="badge bg-primary-subtle text-primary px-2 py-1 rounded small">Berjalan</span>
                        <?php elseif($loan->status === 'lunas'): ?>
                            <span class="badge bg-success-subtle text-success px-2 py-1 rounded small">Lunas</span>
                        <?php else: ?>
                            <span class="badge bg-danger-subtle text-danger px-2 py-1 rounded small">Ditolak</span>
                        <?php endif; ?>
                    </div>
                    <div class="mt-2 p-2 bg-light rounded italic xsmall text-muted">
                        "<?php echo e($loan->alasan); ?>"
                    </div>
                </div>
            </div>
        </div>

        <!-- Repayments progress summary -->
        <div class="col-12 col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100 d-flex flex-column justify-content-between">
                <div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted xsmall uppercase fw-semibold border-bottom pb-1 d-block flex-fill">Statistik Angsuran</span>
                        <?php if($loan->status === 'berjalan'): ?>
                            <form action="<?php echo e(route('admin.pinjaman.pay', $loan->id)); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="btn btn-success btn-sm px-3 fw-medium"><i class="fa-solid fa-wallet me-1"></i> Bayar Cicilan</button>
                            </form>
                        <?php endif; ?>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-4">
                            <div class="p-2 border-start border-primary border-4 bg-light rounded">
                                <span class="xsmall text-muted d-block">Cicilan Bulanan</span>
                                <span class="fw-bold text-dark small">Rp <?php echo e(number_format($totalBulanan, 0, ',', '.')); ?></span>
                                <span class="xsmall text-muted d-block mt-0.5" style="font-size: 0.75rem;">(Bunga: Rp <?php echo e(number_format($bungaBulanan, 0, ',', '.')); ?>)</span>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="p-2 border-start border-success border-4 bg-light rounded">
                                <span class="xsmall text-muted d-block">Total Terbayar</span>
                                <span class="fw-bold text-dark small">Rp <?php echo e(number_format($totalPaid, 0, ',', '.')); ?></span>
                                <span class="xsmall text-muted d-block mt-0.5" style="font-size: 0.75rem;">(<?php echo e(count($paidInstallments)); ?> kali bayar)</span>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="p-2 border-start border-warning border-4 bg-light rounded">
                                <span class="xsmall text-muted d-block">Sisa Pinjam</span>
                                <span class="fw-bold text-dark small">Rp <?php echo e(number_format($totalRemaining > 0 ? $totalRemaining : 0, 0, ',', '.')); ?></span>
                                <span class="xsmall text-muted d-block mt-0.5" style="font-size: 0.75rem;">(<?php echo e($loan->sisa_angsuran_bulan); ?> bln sisa)</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Progress Bar -->
                <?php 
                    $percentPaid = $loan->lama_angsuran_bulan > 0 ? (($loan->lama_angsuran_bulan - $loan->sisa_angsuran_bulan) / $loan->lama_angsuran_bulan) * 100 : 0;
                ?>
                <div class="mt-2">
                    <div class="d-flex justify-content-between small text-muted mb-1">
                        <span>Kemajuan Pelunasan</span>
                        <span class="fw-semibold text-dark"><?php echo e(number_format($percentPaid, 1)); ?>%</span>
                    </div>
                    <div class="progress rounded-pill" style="height: 10px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo e($percentPaid); ?>%" aria-valuenow="<?php echo e($percentPaid); ?>" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Amortization Schedule Table -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white p-4">
        <h5 class="fw-semibold text-navy mb-3 border-bottom pb-2"><i class="fa-solid fa-calendar-check me-1"></i> Rencana Amortisasi & Cicilan Bulanan</h5>
        <div class="table-responsive">
            <table class="table custom-table align-middle mb-0 text-start">
                <thead>
                    <tr class="table-light text-muted small">
                        <th>Cicilan Ke-</th>
                        <th>Jatuh Tempo Estimasi</th>
                        <th>Nominal Angsuran</th>
                        <th>Bunga (<?php echo e($loan->bunga_persen); ?>%)</th>
                        <th>Status</th>
                        <th>Tanggal Bayar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php for($i = 1; $i <= $loan->lama_angsuran_bulan; $i++): ?>
                        <?php
                            $isPaid = in_array($i, $paidInstallments);
                            $payment = $loan->angsuran->where('angsuran_ke', $i)->first();
                            $dueEst = $loan->tanggal_jatuh_tempo? date('d-m-Y', strtotime($loan->tanggal_jatuh_tempo . " + " . ($i - 1) . " month")): '-';
                        ?>
                        <tr>
                            <td class="fw-medium text-dark">#<?php echo e($i); ?></td>
                            <td><?php echo e($dueEst); ?></td>
                            <td class="fw-semibold text-dark">Rp <?php echo e(number_format($totalBulanan, 0, ',', '.')); ?></td>
                            <td class="text-muted">Rp <?php echo e(number_format($bungaBulanan, 0, ',', '.')); ?></td>
                            <td>
                                <?php if($isPaid): ?>
                                    <span class="badge bg-success-subtle text-success px-2 py-1 rounded small">Lunas</span>
                                <?php else: ?>
                                    <span class="badge bg-warning-subtle text-warning px-2 py-1 rounded small">Belum Bayar</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span class="small text-muted"><?php echo e($isPaid && $payment ? date('d-m-Y', strtotime($payment->tanggal_bayar)) : '-'); ?></span>
                            </td>
                        </tr>
                    <?php endfor; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Koperasi_SimpanPinjam\resources\views/admin/pinjaman/detail.blade.php ENDPATH**/ ?>