<?php $__env->startSection('title', 'Kelola Pinjaman - Koperasi Guru'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid p-0">

    <!-- Page Header & Action -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h4 class="fw-bold text-navy mb-1">Kelola Pinjaman Koperasi</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Pinjaman</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Filter & Search Card -->
    <div class="card border-0 shadow-sm rounded-4 p-3 mb-4">
        <form action="<?php echo e(route('admin.pinjaman.index')); ?>" method="GET" class="row g-3 align-items-center">
            <div class="col-12 col-md-5">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-solid fa-magnifying-glass"></i></span>
                    <input type="text" class="form-control bg-light border-start-0 ps-0" name="search" value="<?php echo e($search); ?>" placeholder="Cari nama guru atau NIP...">
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <select class="form-select bg-light" name="status">
                    <option value="all" <?php echo e($status === 'all' ? 'selected' : ''); ?>>Semua Status</option>
                    <option value="menunggu" <?php echo e($status === 'menunggu' ? 'selected' : ''); ?>>Menunggu Persetujuan</option>
                    <option value="berjalan" <?php echo e($status === 'berjalan' ? 'selected' : ''); ?>>Aktif/Berjalan</option>
                    <option value="lunas" <?php echo e($status === 'lunas' ? 'selected' : ''); ?>>Lunas</option>
                    <option value="ditolak" <?php echo e($status === 'ditolak' ? 'selected' : ''); ?>>Ditolak</option>
                </select>
            </div>
            <div class="col-12 col-sm-6 col-md-4 d-flex gap-2">
                <button type="submit" class="btn btn-navy flex-fill"><i class="fa-solid fa-filter me-1"></i> Filter</button>
                <a href="<?php echo e(route('admin.pinjaman.index')); ?>" class="btn btn-light border flex-fill"><i class="fa-solid fa-arrows-rotate me-1"></i> Reset</a>
            </div>
        </form>
    </div>

    <!-- Loans Table Card -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table custom-table align-middle mb-0">
                <thead class="table-navy">
                    <tr>
                        <th class="ps-4">No</th>
                        <th>Nama Anggota</th>
                        <th>Nominal Pinjaman</th>
                        <th>Bunga</th>
                        <th>Tenor</th>
                        <th>Tgl Pengajuan</th>
                        <th>Status</th>
                        <th class="text-center pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $loans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $loan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="ps-4 text-muted"><?php echo e($loans->firstItem() + $index); ?></td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="profile-avatar bg-primary-subtle text-primary fw-semibold" style="width: 32px; height: 32px; font-size: 0.95rem;">
                                        <?php echo e(substr($loan->user->name, 0, 1)); ?>

                                    </div>
                                    <div>
                                        <h6 class="mb-0 text-dark fw-semibold small"><?php echo e($loan->user->name); ?></h6>
                                        <span class="xsmall text-muted">NIP: <?php echo e($loan->user->nip ?? '-'); ?></span>
                                    </div>
                                </div>
                            </td>
                            <td class="fw-bold text-dark">Rp <?php echo e(number_format($loan->nominal_pinjaman, 0, ',', '.')); ?></td>
                            <td><?php echo e($loan->bunga_persen); ?>%</td>
                            <td><?php echo e($loan->lama_angsuran_bulan); ?> Bulan</td>
                            <td><?php echo e(date('d-m-Y', strtotime($loan->tanggal_pengajuan))); ?></td>
                            <td>
                                <?php if($loan->status === 'menunggu'): ?>
                                    <span class="badge bg-warning-subtle text-warning px-2.5 py-1.5 rounded small">Menunggu</span>
                                <?php elseif($loan->status === 'berjalan'): ?>
                                    <span class="badge bg-primary-subtle text-primary px-2.5 py-1.5 rounded small">Berjalan</span>
                                <?php elseif($loan->status === 'lunas'): ?>
                                    <span class="badge bg-success-subtle text-success px-2.5 py-1.5 rounded small">Lunas</span>
                                <?php else: ?>
                                    <span class="badge bg-danger-subtle text-danger px-2.5 py-1.5 rounded small">Ditolak</span>
                                <?php endif; ?>
                            </td>
                            <td class="pe-4 text-center">
                                <?php if($loan->status === 'menunggu'): ?>
                                    <button class="btn btn-navy btn-sm px-3 py-1" data-bs-toggle="modal" data-bs-target="#processLoanModal<?php echo e($loan->id); ?>">
                                        <i class="fa-solid fa-gavel"></i> Proses
                                    </button>
                                <?php else: ?>
                                    <a href="<?php echo e(route('admin.pinjaman.detail', $loan->id)); ?>" class="btn btn-light btn-sm text-primary">
                                        <i class="fa-solid fa-circle-info"></i> Detail
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>

                        <!-- Process Approval Modal -->
                        <?php if($loan->status === 'menunggu'): ?>
                            <div class="modal fade" id="processLoanModal<?php echo e($loan->id); ?>" tabindex="-1" aria-labelledby="processLoanModalLabel<?php echo e($loan->id); ?>" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content rounded-4 border-0 shadow">
                                        <div class="modal-header border-bottom-0 pb-0">
                                            <h5 class="modal-title fw-bold text-navy" id="processLoanModalLabel<?php echo e($loan->id); ?>">Persetujuan Pinjaman</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="<?php echo e(route('admin.pinjaman.approve', $loan->id)); ?>" method="POST" id="approvalForm<?php echo e($loan->id); ?>">
                                            <?php echo csrf_field(); ?>
                                            <div class="modal-body py-3">
                                                <div class="p-3 bg-light rounded-3 mb-3 text-start small">
                                                    <div class="d-flex justify-content-between mb-1">
                                                        <span class="text-muted">Nama Anggota:</span>
                                                        <span class="fw-semibold text-dark"><?php echo e($loan->user->name); ?></span>
                                                    </div>
                                                    <div class="d-flex justify-content-between mb-1">
                                                        <span class="text-muted">Nominal Kredit:</span>
                                                        <span class="fw-bold text-dark">Rp <?php echo e(number_format($loan->nominal_pinjaman, 0, ',', '.')); ?></span>
                                                    </div>
                                                    <div class="d-flex justify-content-between mb-1">
                                                        <span class="text-muted">Tenor Angsuran:</span>
                                                        <span class="fw-semibold text-dark"><?php echo e($loan->lama_angsuran_bulan); ?> Bulan</span>
                                                    </div>
                                                    <div class="d-flex justify-content-between">
                                                        <span class="text-muted">Alasan Pengajuan:</span>
                                                        <span class="fw-semibold text-navy text-end ms-2">"<?php echo e($loan->alasan); ?>"</span>
                                                    </div>
                                                </div>

                                                <!-- Hidden Input for Action type -->
                                                <input type="hidden" name="action" id="actionInput<?php echo e($loan->id); ?>" value="setujui">

                                                <!-- Inputs for Approval -->
                                                <div id="approvalInputs<?php echo e($loan->id); ?>">
                                                    <div class="row g-3 mb-3">
                                                        <div class="col-6">
                                                            <label class="form-label small fw-medium">Suku Bunga Koperasi (% / Bulan)</label>
                                                            <input type="number" class="form-control" name="bunga_persen" value="1.5" step="0.1" min="0" max="100">
                                                        </div>
                                                        <div class="col-6">
                                                            <label class="form-label small fw-medium">Jatuh Tempo Cicilan I</label>
                                                            <input type="date" class="form-control" name="tanggal_jatuh_tempo" value="<?php echo e(date('Y-m-d', strtotime('+1 month'))); ?>">
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Input for Rejection -->
                                                <div class="mb-0 d-none" id="rejectionInput<?php echo e($loan->id); ?>">
                                                    <label class="form-label small fw-medium text-danger">Alasan Penolakan Pinjaman</label>
                                                    <textarea class="form-control border-danger" name="catatan" rows="3" placeholder="Tulis alasan mengapa pengajuan ditolak..."></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer border-top-0 pt-0 justify-content-between">
                                                <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Tutup</button>
                                                <div class="d-flex gap-2">
                                                    <!-- Toggle Reject View -->
                                                    <button type="button" class="btn btn-outline-danger" id="rejectBtnToggle<?php echo e($loan->id); ?>" onclick="toggleRejectForm(<?php echo e($loan->id); ?>)">Tolak</button>
                                                    <!-- Submit Button -->
                                                    <button type="submit" class="btn btn-success px-4" id="submitBtn<?php echo e($loan->id); ?>">Setujui & Cairkan</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                <i class="fa-regular fa-folder-open fa-3x mb-2 text-slate-400 d-block"></i>
                                <span>Tidak ditemukan pengajuan pinjaman.</span>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <?php if($loans->hasPages()): ?>
            <div class="d-flex justify-content-center py-3 border-top bg-white">
                <?php echo e($loans->appends(request()->query())->links('pagination::bootstrap-5')); ?>

            </div>
        <?php endif; ?>
    </div>

</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    function toggleRejectForm(loanId) {
        const actionInput = document.getElementById('actionInput' + loanId);
        const approvalInputs = document.getElementById('approvalInputs' + loanId);
        const rejectionInput = document.getElementById('rejectionInput' + loanId);
        const toggleBtn = document.getElementById('rejectBtnToggle' + loanId);
        const submitBtn = document.getElementById('submitBtn' + loanId);

        if (actionInput.value === 'setujui') {
            // Switch to Penolakan (Rejection)
            actionInput.value = 'tolak';
            approvalInputs.classList.add('d-none');
            rejectionInput.classList.remove('d-none');
            toggleBtn.textContent = 'Batalkan Penolakan';
            toggleBtn.className = 'btn btn-outline-secondary';
            submitBtn.textContent = 'Kirim Penolakan';
            submitBtn.className = 'btn btn-danger px-4';
        } else {
            // Switch back to Approval (Setujui)
            actionInput.value = 'setujui';
            approvalInputs.classList.remove('d-none');
            rejectionInput.classList.add('d-none');
            toggleBtn.textContent = 'Tolak';
            toggleBtn.className = 'btn btn-outline-danger';
            submitBtn.textContent = 'Setujui & Cairkan';
            submitBtn.className = 'btn btn-success px-4';
        }
    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Koperasi_SimpanPinjam\resources\views/admin/pinjaman/index.blade.php ENDPATH**/ ?>