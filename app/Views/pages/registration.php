<?= $this->extend('templates/main') ?>
<?= $this->section('content') ?>
<main id="main">
    <section style="margin-top: 120px;">
        <div class="container">
            <div class="section-title">
                <h2>Daftar sekarang</h2>
            </div>
            <div class="row justify-content-center">
                <div class="col-sm-12 col-md-6">
                    <?php if($warning ?? false): ?>
                    <div class="alert alert-warning"><?= $warning ?></div>
                    <?php endif ?>
                    <form action="<?= current_url() ?>" method="post" class="mb-4">
                        <?= csrf_field() ?>
                        <div class="mb-3">
                            <label for="full_name" class="form-label">Nama lengkap</label>
                            <input type="text" name="full_name" id="full_name" value="<?= old('full_name') ?? '' ?>" class="form-control" placeholder="Nama lengkap" maxlength="60" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Alamat email</label>
                            <input type="email" name="email" id="email" value="<?= old('email') ?? '' ?>" class="form-control" placeholder="Alamat email" maxlength="40" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Nomor telepon</label>
                            <input type="text" name="phone" id="phone" value="<?= old('phone') ?? '' ?>" class="form-control" placeholder="Nomor telepon" maxlength="20" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Kata sandi</label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Kata sandi" required>
                        </div>
                        <div class="mb-3">
                            <label for="password_conf" class="form-label">Konfirmasi kata sandi</label>
                            <input type="password" name="password_conf" id="password_conf" class="form-control" placeholder="Konfirmasi kata sandi" required>
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary w-100">Daftar</button>
                        </div>
                    </form>
                    <div class="mb-3">
                        <div class="small text-center mb-2">Apakah anda sudah memiliki akun?</div>
                        <a href="<?= base_url('login') ?>" class="btn btn-outline-dark w-100">Masuk sekarang</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<?= $this->endSection() ?>