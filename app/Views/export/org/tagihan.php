<?= $this->extend('templates/export') ?>
<?= $this->section('content') ?>
<div class="">
    <p>
        <div class="fw-bold text-center">Laporan Tagihan Kas</div>
        <div class="fw-bold text-center"><?= $tagihan['title'] ?? '-' ?></div>
    </p>
    <table class="table table-bordered border-dark w-100 mt-5 mb-5" border="1">
        <thead>
            <tr>
                <th class="text-center">No</th>
                <th class="text-center">Nama Lengkap</th>
                <th class="text-center">Alamat Email</th>
                <th class="text-center">Nomor Telepon</th>
                <th class="text-center">Nominal</th>
                <th class="text-center">Status Pembayaran</th>
            </tr>
        </thead>
        <tbody>
            <?php $total = 0; ?>
            <?php if($members ?? false): foreach($members as $i => $member): ?>
            <?php $total += ($member['amount_paid'] ?? 0); ?>
            <tr>
                <td class="text-center"><?= $i + 1 ?></td>
                <td class="text-start"><?= $member['user_full_name'] ?></td>
                <td class="text-start"><?= $member['user_email'] ?></td>
                <td class="text-start"><?= $member['user_phone'] ?></td>
                <td class="text-start"><?= rupiah($member['amount_paid'] ?? 0) ?></td>
                <td class="text-start"><?= ucwords($member['transaction_status']) ?></td>
            </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="4" class="fw-bold">Total Penerimaan Dana</td>
                <td colspan="2" class="fw-bold"><?= rupiah($total) ?></td>
            </tr>
            <?php else: ?>
            <tr>
                <td colspan="5">Belum ada anggota</td>
            </tr>
            <?php endif ?>
        </tbody>
    </table>
    <p class="small text-start">
        Dicetak pada <?= date('l, d F Y H:i:s') ?><br>
        Scurity Print Key <?= md5(date('d M Y H:i:s')); ?>
    </p>
</div>
<?= $this->endSection() ?>