<?= $this->extend('templates/main') ?>
<?= $this->section('content') ?>
<main id="main">
    <section style="margin-top: 120px;" class="services">
        <div class="container">
            <div class="section-title">
                <h2><?= $title ?></h2>
                <p>
                    Bergabung dalam Organisasi Mahasiswa dan bersenang-senang dengan
                    bergabung dengan banyak orang.<br>Bangun Organisasi Anda dengan mudah
                    di platform ORMAWA (Organisasi Mahasiswa).
                </p>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-6 d-flex align-items-stretch mb-3">
                    <div class="icon-box w-100" data-aos="fade-up">
                        <div class="icon"><i class="fas fa-check"></i></div>
                        <h4><a href="<?= base_url('organizations/list') ?>">Gabung Organisasi</a></h4>
                        <p>Gabung dengan organisasi yang kamu inginkan!</p>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 d-flex align-items-stretch mb-3">
                    <div class="icon-box w-100" data-aos="fade-up">
                        <div class="icon"><i class="fas fa-square-plus"></i></div>
                        <h4><a href="<?= base_url('organizations/registration') ?>">Daftarkan Organisasi</a></h4>
                        <p>Daftarkan Organisasi Anda di ORMAWA</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<?= $this->endSection() ?>