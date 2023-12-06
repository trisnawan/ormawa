<?= $this->extend('templates/main') ?>
<?= $this->section('content') ?>
<main id="main">
    <section style="margin-top: 120px;" class="services">
        <div class="container">
            <div class="section-title">
                <h2><?= $title ?></h2>
            </div>
            <?php if($orgs): ?>
            <div class="row">
                <?php foreach($orgs as $org): ?>
                <div class="col-sm-12 col-md-3 mb-4" data-aos="fade-up">
                    <a href="<?= base_url('organizations/desc/'.$org['id']) ?>" class="card text-dark" style="text-decoration:none">
                        <img src="<?= $org['avatar'] ?>" alt="" class="card-img-top">
                        <div class="card-body">
                            <h5 class="card-title mb-3"><?= $org['title'] ?></h5>
                            <div class="border rounded-pill border text-center small p-1">
                                Gabung
                            </div>
                        </div>
                    </a>
                </div>
                <?php endforeach ?>
            </div>
            <?php else: ?>
            <div class="alert alert-secondary">Saat ini belum ada organisasi terdaftar.</div>
            <?php endif ?>
        </div>
    </section>
</main>
<?= $this->endSection() ?>