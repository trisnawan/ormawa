<?= $this->extend('templates/main') ?>
<?= $this->section('content') ?>
<main id="main">
    <section style="margin-top: 120px;" class="services">
        <div class="container">
            <div class="section-title">
                <h2><?= $title ?></h2>
                <p>
                    Pastikan Anda adalah Mahasiswa Aktif di Universitas Bina Sarana Informatika.
                    Setelah mengajukan pendaftaran, akun Anda akan di review oleh admin Organisasi
                    <?= $org['title'] ?> maksimal 3x24 (tidak termasuk waktu libur).
                </p>
            </div>
            <form action="<?= current_url() ?>" method="post">
                <?= csrf_field() ?>
                <div class="mb-3">
                    <label for="" class="form-label">Jabatan Anda di organisasi?</label>
                    <input type="text" name="position" id="position" value="Anggota" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="" class="small form-label text-muted">
                        *
                        Dengan klik "Ajukan Sekarang" Anda setuju terhadap syarat dan ketentuan
                        yang berlalu di <?= $org['title'] ?>.
                    </label>
                    <button type="submit" class="btn btn-primary w-100">Ajukan Sekarang</button>
                </div>
            </form>
        </div>
    </section>
</main>
<?= $this->endSection() ?>