<?php $__env->startSection('title', 'Kelola Anggota Guru - Koperasi Guru'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid p-0">

    <!-- Page Header & Action -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h4 class="fw-bold text-navy mb-1">Data Anggota Guru</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Anggota</li>
                </ol>
            </nav>
        </div>
        <button class="btn btn-navy d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#createMemberModal">
            <i class="fa-solid fa-user-plus"></i> Tambah Anggota Baru
        </button>
    </div>

    <!-- Filter & Search Card -->
    <div class="card border-0 shadow-sm rounded-4 p-3 mb-4">
        <form action="<?php echo e(route('admin.anggota.index')); ?>" method="GET" class="row g-3 align-items-center">
            <div class="col-12 col-md-5">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-solid fa-magnifying-glass"></i></span>
                    <input type="text" class="form-control bg-light border-start-0 ps-0" name="search" value="<?php echo e($search); ?>" placeholder="Cari berdasarkan nama, NIP, atau email...">
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <select class="form-select bg-light" name="status">
                    <option value="all" <?php echo e($status === 'all' ? 'selected' : ''); ?>>Semua Status</option>
                    <option value="aktif" <?php echo e($status === 'aktif' ? 'selected' : ''); ?>>Aktif</option>
                    <option value="nonaktif" <?php echo e($status === 'nonaktif' ? 'selected' : ''); ?>>Nonaktif</option>
                </select>
            </div>
            <div class="col-12 col-sm-6 col-md-4 d-flex gap-2">
                <button type="submit" class="btn btn-navy flex-fill"><i class="fa-solid fa-filter me-1"></i> Filter</button>
                <a href="<?php echo e(route('admin.anggota.index')); ?>" class="btn btn-light border flex-fill"><i class="fa-solid fa-arrows-rotate me-1"></i> Reset</a>
            </div>
        </form>
    </div>

    <!-- Members Table Card -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table custom-table align-middle mb-0">
                <thead class="table-navy">
                    <tr>
                        <th class="ps-4">No</th>
                        <th>Foto & Nama</th>
                        <th>NIP</th>
                        <th>Email</th>
                        <th>No. Telepon</th>
                        <th>Status</th>
                        <th class="text-center pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $anggota; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="ps-4 text-muted"><?php echo e($anggota->firstItem() + $index); ?></td>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="profile-avatar bg-primary-subtle text-primary fw-semibold">
                                        <?php echo e(substr($member->name, 0, 1)); ?>

                                    </div>
                                    <div>
                                        <h6 class="mb-0 text-dark fw-semibold"><?php echo e($member->name); ?></h6>
                                        <span class="xsmall text-muted">ID: <?php echo e(str_pad($member->id, 4, '0', STR_PAD_LEFT)); ?></span>
                                    </div>
                                </div>
                            </td>
                            <td><code class="text-secondary"><?php echo e($member->nip ?? '-'); ?></code></td>
                            <td><?php echo e($member->email); ?></td>
                            <td><?php echo e($member->phone ?? '-'); ?></td>
                            <td>
                                <?php if($member->status === 'aktif'): ?>
                                    <span class="badge bg-success-subtle text-success px-2 py-1 rounded">Aktif</span>
                                <?php else: ?>
                                    <span class="badge bg-danger-subtle text-danger px-2 py-1 rounded">Nonaktif</span>
                                <?php endif; ?>
                            </td>
                            <td class="pe-4">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="<?php echo e(route('admin.anggota.detail', $member->id)); ?>" class="btn btn-light btn-sm text-primary" title="Buku Tabungan & Pinjaman">
                                        <i class="fa-solid fa-book-open"></i> Detail
                                    </a>
                                    <button class="btn btn-light btn-sm text-secondary" data-bs-toggle="modal" data-bs-target="#editMemberModal<?php echo e($member->id); ?>" title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i> Edit
                                    </button>
                                    <button class="btn btn-light btn-sm text-danger" data-bs-toggle="modal" data-bs-target="#deleteMemberModal<?php echo e($member->id); ?>" title="Hapus">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <!-- Edit Member Modal -->
                        <div class="modal fade" id="editMemberModal<?php echo e($member->id); ?>" tabindex="-1" aria-labelledby="editMemberModalLabel<?php echo e($member->id); ?>" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content rounded-4 border-0 shadow">
                                    <div class="modal-header border-bottom-0 pb-0">
                                        <h5 class="modal-title fw-bold text-navy" id="editMemberModalLabel<?php echo e($member->id); ?>">Edit Biodata Guru</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="<?php echo e(route('admin.anggota.update', $member->id)); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PUT'); ?>
                                        <div class="modal-body py-3">
                                            <div class="mb-3">
                                                <label class="form-label small fw-medium">Nama Lengkap & Gelar</label>
                                                <input type="text" class="form-control" name="name" value="<?php echo e($member->name); ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label small fw-medium">NIP (Nomor Induk Pegawai)</label>
                                                <input type="text" class="form-control" name="nip" value="<?php echo e($member->nip); ?>">
                                            </div>
                                            <div class="row g-3 mb-3">
                                                <div class="col-6">
                                                    <label class="form-label small fw-medium">No. HP (WhatsApp)</label>
                                                    <input type="text" class="form-control" name="phone" value="<?php echo e($member->phone); ?>">
                                                </div>
                                                <div class="col-6">
                                                    <label class="form-label small fw-medium">Status Keanggotaan</label>
                                                    <select class="form-select" name="status">
                                                        <option value="aktif" <?php echo e($member->status === 'aktif' ? 'selected' : ''); ?>>Aktif</option>
                                                        <option value="nonaktif" <?php echo e($member->status === 'nonaktif' ? 'selected' : ''); ?>>Nonaktif</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label small fw-medium">Alamat Email</label>
                                                <input type="email" class="form-control" name="email" value="<?php echo e($member->email); ?>" required>
                                            </div>
                                            <div class="mb-0">
                                                <label class="form-label small fw-medium">Alamat Rumah</label>
                                                <textarea class="form-control" name="address" rows="2"><?php echo e($member->address); ?></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-top-0 pt-0">
                                            <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-navy px-4">Simpan Perubahan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Delete Confirmation Modal -->
                        <div class="modal fade" id="deleteMemberModal<?php echo e($member->id); ?>" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-sm">
                                <div class="modal-content rounded-4 border-0 shadow">
                                    <div class="modal-body text-center py-4">
                                        <div class="text-danger mb-3">
                                            <i class="fa-solid fa-triangle-exclamation fa-3x"></i>
                                        </div>
                                        <h5 class="fw-bold text-dark mb-2">Hapus Anggota?</h5>
                                        <p class="text-muted small mb-0">Tindakan ini akan menghapus permanen data guru <strong><?php echo e($member->name); ?></strong> beserta seluruh riwayat simpanan/pinjaman.</p>
                                    </div>
                                    <div class="modal-footer border-top-0 pt-0 justify-content-center">
                                        <button type="button" class="btn btn-light border px-3" data-bs-dismiss="modal">Batal</button>
                                        <form action="<?php echo e(route('admin.anggota.destroy', $member->id)); ?>" method="POST">
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
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="fa-regular fa-folder-open fa-3x mb-2 text-slate-400 d-block"></i>
                                <span>Tidak ditemukan data guru anggota.</span>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <!-- Pagination Links -->
        <?php if($anggota->hasPages()): ?>
            <div class="d-flex justify-content-center py-3 border-top bg-white">
                <?php echo e($anggota->appends(request()->query())->links('pagination::bootstrap-5')); ?>

            </div>
        <?php endif; ?>
    </div>

</div>

<!-- Create Member Modal -->
<div class="modal fade" id="createMemberModal" tabindex="-1" aria-labelledby="createMemberModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold text-navy" id="createMemberModalLabel">Tambah Anggota Guru Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo e(route('admin.anggota.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="modal-body py-3">
                    <div class="mb-3">
                        <label class="form-label small fw-medium">Nama Lengkap & Gelar</label>
                        <input type="text" class="form-control" name="name" placeholder="Contoh: Budi Setiawan, S.Pd." required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-medium">NIP (Nomor Induk Pegawai)</label>
                        <input type="text" class="form-control" name="nip" placeholder="Contoh: 198503122010011002">
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <label class="form-label small fw-medium">No. HP (WhatsApp)</label>
                            <input type="text" class="form-control" name="phone" placeholder="Contoh: 08987654321">
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-medium">Status Keanggotaan</label>
                            <select class="form-select" name="status">
                                <option value="aktif" selected>Aktif</option>
                                <option value="nonaktif">Nonaktif</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-medium">Alamat Email</label>
                        <input type="email" class="form-control" name="email" placeholder="Contoh: guru@sekolah.sch.id" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-medium">Kata Sandi Default</label>
                        <input type="password" class="form-control" name="password" value="guru123" placeholder="Sandi masuk awal" required>
                        <span class="xsmall text-muted mt-1 d-block"><i class="fa-solid fa-circle-info me-1"></i> Bawaan sandi awal anggota baru adalah: <strong>guru123</strong></span>
                    </div>
                    <div class="mb-0">
                        <label class="form-label small fw-medium">Alamat Rumah</label>
                        <textarea class="form-control" name="address" rows="2" placeholder="Tulis alamat tempat tinggal lengkap..."></textarea>
                    </div>
                </div>
                <div class="modal-footer border-top-0 pt-0">
                    <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-navy px-4">Tambahkan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Koperasi_SimpanPinjam\resources\views/admin/anggota/index.blade.php ENDPATH**/ ?>