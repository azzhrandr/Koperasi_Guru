<?php $__env->startSection('title', 'Simpanan Saya - Koperasi Guru'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid p-0">

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h4 class="fw-bold text-navy mb-1">Simpanan Saya</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('anggota.dashboard')); ?>">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Simpanan Saya</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Savings Ledger Summary Grid -->
    <div class="row g-3 mb-4">

    <div class="col-md-4">
        <div class="card border-0 shadow-sm p-3 rounded-4 bg-white text-center">
            <span class="xsmall text-muted d-block mb-1">
                Simpanan Wajib
            </span>

            <h5 class="fw-bold text-dark mb-0">
                Rp <?php echo e(number_format($wajib,0,',','.')); ?>

            </h5>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm p-3 rounded-4 bg-white text-center">
            <span class="xsmall text-muted d-block mb-1">
                Simpanan Manasuka
            </span>

            <h5 class="fw-bold text-dark mb-0">
                Rp <?php echo e(number_format($manasuka,0,',','.')); ?>

            </h5>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border border-primary shadow-sm p-3 rounded-4 text-center">

            <span class="small text-dark d-block mb-1">
                Total Simpanan
            </span>

            <h5 class="fw-bold text-primary mb-0">
                Rp <?php echo e(number_format($total, 0, ',', '.')); ?>

            </h5>

        </div>
    </div>

</div>

    <!-- Mutations Ledger Table -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white p-4">
        <h5 class="fw-semibold text-navy mb-3 border-bottom pb-2"><i class="fa-solid fa-receipt me-1"></i> Rincian Mutasi Setoran</h5>
        <div class="table-responsive">
            <table class="table custom-table align-middle mb-0 text-start small">
                <thead>
                    <tr class="table-light text-muted">
                        <th>No</th>
                        <th>Tanggal Transaksi</th>
                        <th>Kategori Simpanan</th>
                        <th>Nominal Setoran</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $simpanan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="text-muted"><?php echo e($simpanan->firstItem() + $idx); ?></td>
                            <td><?php echo e(date('d-m-Y', strtotime($s->tanggal_transaksi))); ?></td>
                            <td>
                                <?php if($s->tipe_simpanan == 'wajib'): ?>

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
                            <td class="text-muted"><?php echo e($s->keterangan); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="fa-regular fa-folder-open fa-2x mb-2 text-slate-300"></i>
                                <p class="mb-0 small">Belum ada catatan mutasi tabungan Anda.</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <?php if($simpanan->hasPages()): ?>
            <div class="d-flex justify-content-center py-3 border-top bg-white">
                <?php echo e($simpanan->links('pagination::bootstrap-5')); ?>

            </div>
        <?php endif; ?>
    </div>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Koperasi_SimpanPinjam\resources\views/anggota/simpanan.blade.php ENDPATH**/ ?>