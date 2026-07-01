<?php $__env->startSection('title', 'Ajukan Pinjaman - Koperasi Guru'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid p-0">

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h4 class="fw-bold text-navy mb-1">Form Pengajuan Pinjaman</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('anggota.dashboard')); ?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo e(route('anggota.pinjaman.index')); ?>">Pinjaman Saya</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Pengajuan</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row justify-content-start">
        <div class="col-12 col-md-8 col-lg-6">
            <?php if(session('error')): ?>
            <div class="alert alert-danger shadow-sm rounded-3">
                <i class="fa-solid fa-circle-exclamation me-2"></i>
                <?php echo e(session('error')); ?>

            </div>
            <?php endif; ?>
            
            <?php if($hasActiveLoan): ?>
                <!-- Warning: Already has active/pending loan -->
                <div class="card border-0 shadow-sm rounded-4 p-4 text-center bg-white">
                    <div class="text-warning mb-3">
                        <i class="fa-solid fa-triangle-exclamation fa-3x"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-2">Pengajuan Terkunci</h5>
                    <p class="text-muted small mb-4">Anda tidak dapat mengajukan pinjaman baru saat ini karena Anda masih memiliki pinjaman aktif yang sedang berjalan atau pengajuan sebelumnya yang masih menunggu persetujuan admin.</p>
                    <a href="<?php echo e(route('anggota.pinjaman.index')); ?>" class="btn btn-light border px-4 py-2 small fw-medium"><i class="fa-solid fa-clock-rotate-left me-1"></i> Periksa Riwayat Pinjaman</a>
                </div>
            <?php else: ?>
                <!-- Form Page -->
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                    <h5 class="fw-semibold text-navy mb-3 border-bottom pb-2"><i class="fa-solid fa-file-signature me-1"></i> Ajukan Kredit Baru</h5>
                    
                    <form action="<?php echo e(route('anggota.pinjaman.store')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        
                        <div class="mb-3">
                            <label class="form-label small fw-medium">Nominal Pinjaman yang Diajukan (Rp)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-muted fw-semibold">Rp</span>
                                <input type="number" class="form-control" name="nominal_pinjaman" id="nominalInput" placeholder="Contoh: 5000000" min="500000" max="50000000" required>
                            </div>
                            <span class="xsmall text-muted mt-1 d-block"><i class="fa-solid fa-circle-info me-1"></i> Batas nominal pengajuan: <strong>Rp 50.000 s/d Rp 10.000.000</strong></span>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-medium">Tenor Angsuran (Jangka Waktu)</label>
                            <select class="form-select" name="lama_angsuran_bulan" id="tenorInput" required>
                                <option value="3">3 Bulan</option>
                                <option value="6" selected>6 Bulan</option>
                                <option value="12">12 Bulan</option>
                                <option value="18">18 Bulan</option>
                                <option value="24">24 Bulan</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label small fw-medium">Alasan Pengajuan Pinjaman</label>
                            <textarea class="form-control" name="alasan" rows="3" placeholder="Tulis alasan mendesak pengajuan pinjaman (misal: biaya sekolah anak, renovasi mendesak, pengobatan)..." required></textarea>
                        </div>

                        <!-- Interactive Calculation Summary -->
                        <div class="p-3 bg-light rounded-3 mb-4 small text-start border d-none" id="calcSummary">
                            <h6 class="fw-bold text-navy mb-2"><i class="fa-solid fa-calculator me-1"></i> Estimasi Simulasi Cicilan</h6>
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-muted">Pokok Cicilan Bulanan:</span>
                                <span class="fw-semibold text-dark" id="calcPokok">Rp 0</span>
                            </div>
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-muted">Estimasi Bunga:</span>
                                <span class="fw-semibold text-dark" id="calcBunga">Rp 0</span>
                            </div>
                            <hr class="my-2">
                            <div class="d-flex justify-content-between">
                                <strong class="text-dark">Estimasi Total Bayar Bulanan:</strong>
                                <strong class="text-navy" id="calcTotal">Rp 0</strong>
                            </div>
                            <span class="xsmall text-muted d-block mt-2 italic">*Suku bunga sesungguhnya akan ditentukan oleh admin koperasi saat persetujuan.</span>
                        </div>

                        <div class="d-flex gap-2 justify-content-end">
                            <a href="<?php echo e(route('anggota.pinjaman.index')); ?>" class="btn btn-light border">Batal</a>
                            <button type="submit" class="btn btn-navy px-4">Kirim Pengajuan</button>
                        </div>
                    </form>
                </div>
            <?php endif; ?>

        </div>
    </div>

</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<?php if(!$hasActiveLoan): ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const nominalInput = document.getElementById('nominalInput');
        const tenorInput = document.getElementById('tenorInput');
        const calcSummary = document.getElementById('calcSummary');
        const calcPokok = document.getElementById('calcPokok');
        const calcBunga = document.getElementById('calcBunga');
        const calcTotal = document.getElementById('calcTotal');

        function calculateSimulation() {
            const nominal = parseFloat(nominalInput.value);
            const tenor = parseInt(tenorInput.value);

            if (isNaN(nominal) || nominal < 50000) {
                calcSummary.classList.add('d-none');
                return;
            }

            const pokok = nominal / tenor;
            const bunga = nominal * 0.015; // Estimate 1.5% interest
            const total = pokok + bunga;

            calcPokok.textContent = 'Rp ' + Math.round(pokok).toLocaleString('id-ID');
            calcBunga.textContent = 'Rp ' + Math.round(bunga).toLocaleString('id-ID');
            calcTotal.textContent = 'Rp ' + Math.round(total).toLocaleString('id-ID');

            calcSummary.classList.remove('d-none');
        }

        nominalInput.addEventListener('input', calculateSimulation);
        tenorInput.addEventListener('change', calculateSimulation);
    });
</script>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Koperasi_SimpanPinjam\resources\views/anggota/pinjaman/pengajuan.blade.php ENDPATH**/ ?>