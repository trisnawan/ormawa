<?= $this->extend('templates/main') ?>
<?= $this->section('content') ?>
<main id="main">
    <section style="margin-top: 120px;" class="services">
        <div class="container">
            <div class="section-title">
                <h2><?= $title ?></h2>
            </div>
            <?php if($warning ?? false): ?>
            <div class="alert alert-warning"><?= $warning ?></div>
            <?php endif ?>
            <form action="<?= current_url() ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <div class="mb-3">
                    <label class="form-label">Nama organisasi</label>
                    <input type="text" name="title" id="title" class="form-control" placeholder="Nama organisasi" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Logo organisasi (.png atau .jpg)</label>
                    <input type="file" name="avatar" id="avatar" class="form-control" accept=".jpg,.png,.jpeg" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Deskripsi organisasi</label>
                    <textarea name="description" id="description" class="form-control" placeholder="Deskripsi organisasi" required></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Dokumen legal organisasi (.pdf, .png atau .jpg)</label>
                    <input type="file" name="legal_doc" id="legal_doc" class="form-control" accept=".pdf,.jpg,.png,.jpeg" required>
                </div>
                <div class="mb-3 mt-4">
                    <button type="submit" class="btn btn-primary w-100">Daftarkan Sekarang</button>
                </div>
            </form>
        </div>
    </section>
</main>
<?= $this->endSection() ?>