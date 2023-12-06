<div class="text-center">
    <?php if(($tagihan['transaksi']['status'] ?? 'none') == 'unpaid'): ?>
    <div class="alert alert-warning">Tagihan menunggu pembayaran</div>
    <?php elseif(($tagihan['transaksi']['status'] ?? 'none') == 'paid'): ?>
    <div class="alert alert-success">Tagihan Lunas</div>
    <?php else: ?>
    <div class="alert alert-warning">Tagihan belum dibayar</div>
    <?php endif ?>
</div>
<div>
    <div class="mb-3">
        <label class="form-label">Jenis pembayaran</label>
        <input type="text" class="form-control" value="<?= ucwords($tagihan['transaksi']['payment'] ?? 'Offline') ?>" disabled>
    </div>
    <div class="mb-3">
        <label class="form-label">Nominal pembayaran</label>
        <input type="text" class="form-control" value="<?= rupiah($tagihan['transaksi']['amount'] ?? $tagihan['amount'] ?? 0) ?>" disabled>
    </div>
    <div class="mb-3">
        <?php if(isset($tagihan['transaksi']['status'])): ?>
        <?php if($tagihan['transaksi']['status'] == 'unpaid'): ?>
        <a href="<?= base_url('organizations/tagihan_verify/paid?id='.($tagihan['transaksi']['id'] ?? '')) ?>" class="btn btn-outline-primary w-100">Verifikasi Tagihan Lunas</a>
        <?php else: ?>
        <a href="<?= base_url('organizations/tagihan_verify/unpaid?id='.($tagihan['transaksi']['id'] ?? '')) ?>" class="btn btn-outline-primary w-100">Verifikasi Tagihan Belum Bayar</a>
        <?php endif ?>
        <?php else: ?>
        <div class="alert alert-secondary">
            <i class="fas fa-info-circle"></i>
            <span>Pengguna belum menyatakan pembayaran</span>
        </div>
        <?php endif ?>
    </div>
</div>