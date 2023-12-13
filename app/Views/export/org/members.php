<?= $this->extend('templates/export') ?>
<?= $this->section('content') ?>
<div class="">
    <p>
        <div class="fw-bold text-center">Laporan Anggota</div>
        <div class="fw-bold text-center"><?= $org['title'] ?? '-' ?></div>
        <div class="text-center"><?= date('d F Y') ?></div>
    </p>
    <table class="table table-bordered border-dark w-100 mt-5 mb-5"  border="1">
        <thead>
            <tr>
                <th class="text-center">No</th>
                <th class="text-center">Nama Lengkap</th>
                <th class="text-center">Alamat Email</th>
                <th class="text-center">Nomor Telepon</th>
                <th class="text-center">Jabatan</th>
            </tr>
        </thead>
        <tbody>
            <?php if($members ?? false): foreach($members as $i => $member): ?>
            <tr>
                <td class="text-center"><?= $i + 1 ?></td>
                <td class="text-start"><?= $member['user_full_name'] ?></td>
                <td class="text-start"><?= $member['user_email'] ?></td>
                <td class="text-start"><?= $member['user_phone'] ?></td>
                <td class="text-start"><?= $member['position'] ?></td>
            </tr>
            <?php endforeach; else: ?>
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