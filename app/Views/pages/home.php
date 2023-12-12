<?= $this->extend('templates/main') ?>
<?= $this->section('content') ?>
<section id="hero" class="d-flex align-items-center">
    <div class="container">
        <h1><?= getEnv('appName') ?></h1>
        <h2>Organisasi Mahasiswa <br><?= getEnv('appUniv') ?></h2>
    </div>
</section>
<main id="main">
    <section id="why-us" class="why-us">
        <div class="container" data-aos="fade-up">
            <div class="row">
                <div class="col-lg-4 d-flex align-items-stretch">
                    <div class="content">
                        <h3>Kenapa harus <?= ucwords(strtolower(getEnv('appName'))) ?>?</h3>
                        <p>
                            Situs web Organisasi Mahasiswa adalah platform yang inovatif
                            dan inklusif yang bertujuan untuk menyatukan berbagai organisasi
                            mahasiswa di dalam satu sistem terintegrasi. Dengan desain
                            yang intuitif dan ramah pengguna, situs ini memfasilitasi komunikasi
                            efektif dan kolaborasi antara berbagai kelompok mahasiswa di berbagai
                            organisasi mahasiswa.
                        </p>
                        <div class="text-center">
                            <a href="#" class="more-btn">Learn More <i class="bx bx-chevron-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 d-flex align-items-stretch">
                    <div class="icon-boxes d-flex flex-column justify-content-center">
                        <div class="row">
                            <div class="col-xl-4 d-flex align-items-stretch">
                                <div class="icon-box mt-4 mt-xl-0">
                                    <i class='bx bxs-user-detail'></i>
                                    <h4>Manajemen Anggota</h4>
                                    <p>Manajement anggota yang memberikan pengalaman terbaik dengan menampilkan Keanggotaaan yang mudah dan nyaman.</p>
                                </div>
                            </div>
                            <div class="col-xl-4 d-flex align-items-stretch">
                                <div class="icon-box mt-4 mt-xl-0">
                                    <i class="bx bx-wallet"></i>
                                    <h4>Manajemen Dana Kas</h4>
                                    <p>Manajemen dana kas yang memudahkan mahasiswa untuk mengelola dana kas dengan aman dan nyaman.</p>
                                </div>
                            </div>
                            <div class="col-xl-4 d-flex align-items-stretch">
                                <div class="icon-box mt-4 mt-xl-0">
                                    <i class="bx bx-chat"></i>
                                    <h4>Komunikasi Antar Anggota</h4>
                                    <p>Manajemen komunikasi antar anggota dengan mudah dan realtime dengan fitur chat.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <section id="organization">
        <div class="container">
            <div class="section-title">
                <h2>Gabung Organisasi</h2>
                <p>
                    Daftarkan diri anda untuk menjadi anggota organisasi di kampus kamu!
                </p>
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