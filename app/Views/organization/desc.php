<?= $this->extend('templates/main') ?>
<?= $this->section('content') ?>
<main id="main">
    <section style="margin-top: 120px;" class="services">
        <div class="container">
            <div class="section-title">
                <h2><?= $title ?></h2>
            </div>
            <div class="row">
                <div class="col-sm-12 col-lg-3 mb-3">
                    <div>
                        <img src="<?= $org['avatar'] ?>" class="w-100">
                    </div>
                </div>
                <div class="col-sm-12 col-lg-9 mb-3">
                    <div><?= $org['description'] ?></div>
                    <div class="text-end mt-3">
                        <a href="<?= base_url('organizations/join/'.$org['id']) ?>" class="btn btn-outline-primary">
                            <i class="fas fa-check"></i>
                            <span>Join Organisasi</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<?= $this->endSection() ?>