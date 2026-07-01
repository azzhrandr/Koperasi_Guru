<?php $__env->startSection('title', 'Ledger Simpanan - Koperasi Guru'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid p-0">

    <!-- Page Header & Action -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h4 class="fw-bold text-navy mb-1">Detail Simpanan: <?php echo e($user->name); ?></h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo e(route('admin.simpanan.index')); ?>">Simpanan</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Detail Simpanan</li>
                </ol>
            </nav>
        </div>
        <a href="<?php echo e(route('admin.simpanan.index')); ?>" class="btn btn-light border d-flex align-items-center gap-2">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Rekap
        </a>
    </div>

    <!-- Savings Ledger Summary Grid -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm p-3 rounded-4 bg-white text-center">
                <span class="xsmall text-muted d-block mb-1">Simpanan Wajib</span>
                <h5 class="fw-bold text-dark mb-0">
                    Rp <?php echo e(number_format($wajib, 0, ',', '.')); ?>

                </h5>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm p-3 rounded-4 bg-white text-center">
                <span class="xsmall text-muted d-block mb-1">Simpanan Manasuka</span>
                <h5 class="fw-bold text-dark mb-0">
                    Rp <?php echo e(number_format($manasuka, 0, ',', '.')); ?>

                </h5>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm p-3 rounded-4 bg-navy text-center">
                <span class="xsmall text-white-50 d-block mb-1">Total Saldo Simpanan</span>
                <h5 class="fw-bold text-white mb-0">
                    Rp <?php echo e(number_format($total, 0, ',', '.')); ?>

                </h5>
            </div>
        </div>
    </div>

    <!-- Savings Mutation Ledger Table -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white p-4">
        <h5 class="fw-semibold text-navy mb-3 border-bottom pb-2"><i class="fa-solid fa-receipt me-1"></i>Riwayat Transaksi Simpanan</h5>
        <div class="table-responsive">
            <table class="table custom-table align-middle mb-0">
                <thead>
                    <tr class="table-light text-muted small">
                        <th>No</th>
                        <th>Tanggal Transaksi</th>
                        <th>Jenis Simpanan</th>
                        <th>Nominal</th>
                        <th>Keterangan</th>
                        <th class="text-center">Hapus</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $simpanan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="text-muted small"><?php echo e($idx + 1); ?></td>
                            <td><?php echo e(date('d-m-Y', strtotime($s->tanggal_transaksi))); ?></td>
                            <td>
                                <?php if($s->tipe_simpanan === 'wajib'): ?>

                                <span class="badge bg-success-subtle text-success text-xsmall uppercase px-2 py-1 rounded">
                                    Wajib
                                </span>

                                <?php else: ?>

                                <span class="badge bg-warning-subtle text-warning text-xsmall uppercase px-2 py-1 rounded">
                                    Manasuka
                                </span>

                                <?php endif; ?>
                            </td>
                            <td class="fw-bold text-dark">Rp <?php echo e(number_format($s->nominal, 0, ',', '.')); ?></td>
                            <td class="small text-muted"><?php echo e($s->keterangan); ?></td>
                            <td class="text-center">
                                <button class="btn btn-light btn-sm text-danger" data-bs-toggle="modal" data-bs-target="#deleteSavingModal<?php echo e($s->id); ?>">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </td>
                        </tr>

                        <!-- Delete Confirmation Modal -->
                        <div class="modal fade" id="deleteSavingModal<?php echo e($s->id); ?>" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-sm">
                                <div class="modal-content rounded-4 border-0 shadow">
                                    <div class="modal-body text-center py-4">
                                        <div class="text-danger mb-3">
                                            <i class="fa-solid fa-circle-exclamation fa-3x"></i>
                                        </div>
                                        <h6 class="fw-bold text-dark mb-2">Hapus Transaksi Simpanan?</h6>
                                        <p class="text-muted small mb-0">Apakah Anda yakin ingin menghapus transaksi senilai <strong>Rp <?php echo e(number_format($s->nominal, 0, ',', '.')); ?></strong>Tindakan ini akan mengurangi saldo simpanan anggota secara permanen.</p>
                                    </div>
                                    <div class="modal-footer border-top-0 pt-0 justify-content-center">
                                        <button type="button" class="btn btn-light border px-3" data-bs-dismiss="modal">Batal</button>
                                        <form action="<?php echo e(route('admin.simpanan.destroy', $s->id)); ?>" method="POST">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-danger px-3">Ya, Hapus</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="fa-regular fa-folder-open fa-2x mb-2 text-slate-400 d-block"></i>
                                <span class="small">Belum ada mutasi buku untuk guru ini.</span>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Koperasi_SimpanPinjam\resources\views/admin/simpanan/detail.blade.php ENDPATH**/ ?>