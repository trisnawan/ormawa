<?= $this->extend('templates/main') ?>
<?= $this->section('content') ?>
<main id="main">
    <section style="margin-top: 120px;">
        <div class="container">
            <div class="section-title">
                <h2>Masuk</h2>
            </div>
            <div class="row justify-content-center">
                <div class="col-sm-12 col-md-6">
                    <?php if($warning ?? false): ?>
                    <div class="alert alert-warning"><?= $warning ?></div>
                    <?php endif ?>
                    <form action="<?= current_url() ?>" method="post" class="mb-4">
                        <?= csrf_field() ?>
                        <div class="mb-3">
                            <label for="email" class="form-label">Alamat email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="Alamat email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Kata sandi</label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Kata sandi" required>
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary w-100">Masuk</button>
                        </div>
                    </form>
                    <div class="mb-3">
                        <div class="small text-center mb-2">Apakah anda belum memiliki akun?</div>
                        <a href="<?= base_url('registration') ?>" class="btn btn-outline-dark w-100">Buat akun baru</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<?= $this->endSection() ?>