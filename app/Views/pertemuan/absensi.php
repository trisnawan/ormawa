<?= $this->extend('templates/main') ?>
<?= $this->section('content') ?>
<main id="main">
    <section style="margin-top: 120px;">
        <div class="container">
            <div class="section-title">
                <h2><?= $title ?></h2>
            </div>

            <?php if($warning ?? false): ?>
            <div class="alert alert-warning"><?= $warning ?></div>
            <?php endif ?>
            <?php if($success ?? false): ?>
            <div class="alert alert-success"><?= $success ?></div>
            <?php endif ?>
            
            <div class="row mb-4">
                <div class="col-12 mb-3" data-aos="fade-up">
                    <div class="card">
                        <div class="card-body">
                            <div class="fw-bold"><?= $data['title'] ?></div>
                            <div>
                                <i class="fas fa-clock"></i>
                                <span><?= date('H:i, d F Y', strtotime($data['start_at'])) ?></span>
                            </div>
                            <div>
                                <i class="fas fa-location"></i>
                                <span><?= $data['location'] ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 mb-3" data-aos="fade-up">
                    <div class="card">
                        <div class="card-body">
                            <div class="fw-bold mb-2">Kehadiran saya</div>
                            <div class="input-group">
                                <input type="text" class="form-control" value="<?= getKehadiran($saya['status'] ?? 'A') ?>" disabled>
                                <div class="btn-group dropup">
                                    <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Ubah Kehadiran
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="<?= base_url('pertemuan/absensi_save/'.$data['id'].'?status=H') ?>">Hadir</a></li>
                                        <li><a class="dropdown-item" href="<?= base_url('pertemuan/absensi_save/'.$data['id'].'?status=S') ?>">Sakit</a></li>
                                        <li><a class="dropdown-item" href="<?= base_url('pertemuan/absensi_save/'.$data['id'].'?status=I') ?>">Ijin</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <h3>Kehadiran anggota</h3>
                <?php if($members ?? false): ?>
                <div class="row mb-4">
                    <?php foreach($members as $member): ?>
                    <div class="col-12 mb-2">
                        <a href="#" class="d-block card" data-bs-toggle="modal" data-bs-target="#detailModal" data-bs-member="<?= $member['id'] ?>" data-bs-tagihan="<?= $data['id'] ?>" data-bs-title="<?= $member['user_full_name'] ?>">
                            <div class="card-body text-dark">
                                <div class="d-flex">
                                    <div class="me-2">
                                        <img src="<?= $member['user_avatar'] ?>" width="50px" height="50px" class="rounded-circle">
                                    </div>
                                    <div>
                                        <div><?= $member['user_full_name'] ?></div>
                                        <div class="small text-dark">
                                            <i class="fas fa-user"></i>
                                            <span><?= getKehadiran($member['presensi_status'] ?? 'A') ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php endforeach ?>
                </div>

                <div class="text-end">
                    <div class="btn-group dropup">
                        <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-download"></i>
                            <span>Download kehadiran</span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-print"></i> Print</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-file"></i> PDF</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-file-excel"></i> Excel</a></li>
                        </ul>
                    </div>
                </div>
                
                <?php else: ?>
                <div class="alert alert-warning">Server error!</div>
                <?php endif ?>
            </div>
        </div>
    </section>
</main>
<?= $this->endSection() ?>