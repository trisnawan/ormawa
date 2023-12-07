<?= $this->extend('templates/main') ?>
<?= $this->section('content') ?>
<main id="main">
    <section style="margin-top: 120px;">
        <div class="container">
            <div class="section-title">
                <h2><?= $title ?></h2>
            </div>
            <div class="row mb-4">
                <div class="col-sm-12 col-md-3 mb-3">
                    <a href="#" class="d-block border rounded mb-3" style="overflow:hidden;">
                        <img src="<?= $data['avatar'] ?>" width="100%">
                        <?php if($data['member']['role'] == 'admin'): ?>
                        <div class="p-2 text-center text-primary small">Ganti Logo</div>
                        <?php endif ?>
                    </a>
                    <div class="border rounded p-3 mb-3">
                        <?php if($data['member']['role'] == 'admin'): ?>
                        <div class="mb-0">
                            <span>Status</span>
                            <span class="badge bg-<?= $data['status'] == 'verified' ? 'primary' : 'warning' ?> rounded-pill">
                                <?= ucwords($data['status']) ?>
                            </span>
                        </div>
                        <?php endif ?>
                        <div class="mb-0">
                            <span>Anggota</span>
                            <a href="<?= base_url('organizations/members/'.$data['id'].'') ?>" class="badge bg-primary rounded-pill text-white"><?= $data['jumlah_anggota'] ?> anggota</a>
                        </div>
                    </div>
                    <div class="border rounded p-3 mb-3">
                        <div class="mb-0">
                            <span>Jabatan</span>
                            <span class="badge bg-primary rounded-pill text-white"><?= $data['member']['position'] ?></span>
                        </div>
                        <div class="mb-0">
                            <span>Role</span>
                            <span class="badge bg-primary rounded-pill text-white"><?= ucwords($data['member']['role']) ?></span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-9 mb-3">
                    <p>
                        <?= $data['description'] ?>
                    </p>
                    <?php if($warning ?? false): ?>
                    <div class="alert alert-warning"><?= $warning ?></div>
                    <?php endif ?>
                    <?php if($success ?? false): ?>
                    <div class="alert alert-success"><?= $success ?></div>
                    <?php endif ?>
                    <div class="card">
                        <div class="card-header pb-0 border-0">
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <a href="#" class="nav-link active" id="nav-kas-tab" data-bs-toggle="tab" data-bs-target="#nav-kas" role="tab" aria-controls="nav-kas" aria-selected="true">
                                        <i class="fas fa-coins"></i>
                                        <span class="d-none d-md-inline-block">Kas</span>
                                    </a>
                                    <?php if($data['member']['role'] == 'admin'): ?>
                                    <a href="#" class="nav-link" id="nav-anggota-tab" data-bs-toggle="tab" data-bs-target="#nav-anggota" role="tab" aria-controls="nav-anggota" aria-selected="true">
                                        <i class="fas fa-users"></i>
                                        <span class="d-none d-md-inline-block">Pendaftaran</span>
                                    </a>
                                    <?php endif ?>
                                    <a href="#" class="nav-link" id="nav-event-tab" data-bs-toggle="tab" data-bs-target="#nav-event" role="tab" aria-controls="nav-event" aria-selected="true">
                                        <i class="far fa-calendar"></i>
                                        <span class="d-none d-md-inline-block">Acara</span>
                                    </a>
                                    <a href="<?= base_url('chat/'.$data['id']) ?>" class="nav-link">
                                        <i class="far fa-comment"></i>
                                        <span class="d-none d-md-inline-block">Chat</span>
                                    </a>
                                </div>
                            </nav>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="nav-kas" role="tabpanel" aria-labelledby="nav-kas-tab" tabindex="0">
                                    <?php if($data['member']['status'] == 'verified'): ?>
                                    <div class="mb-4">
                                        <div class="small">Saldo</div>
                                        <div class="h2 text-dark">
                                            <?= rupiah($data['saldo']) ?>
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <div class="d-flex small mb-2">
                                            <div class="flex-fill">Tagihan Dana Kas</div>
                                            <?php if($data['member']['role'] == 'admin'): ?>
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#kasModal"><i class="fas fa-plus"></i> Buat tagihan</a>
                                            <?php endif ?>
                                        </div>
                                        <div>
                                            <?php if($tagihan): foreach($tagihan as $tg): ?>
                                            <a href="<?= base_url('organizations/tagihan/'.$data['id'].'?id='.$tg['id']) ?>" class="d-flex align-items-center border rounded p-2 mb-2">
                                                <div class="flex-fill">
                                                    <i class="fas fa-angle-right"></i>
                                                    <span><?= $tg['title'] ?></span>
                                                </div>
                                                <div>
                                                    <span class="badge bg-primary"><?= rupiah($tg['amount']) ?></span>
                                                </div>
                                            </a>
                                            <?php endforeach; else: ?>
                                            <div class="alert alert-secondary">Belum ada tagihan kas saat ini.</div>
                                            <?php endif ?>
                                        </div>
                                    </div>
                                    <?php else: ?>
                                    <div class="alert alert-warning">
                                        <i class="fas fa-info-circle"></i>
                                        <span>Saat ini Anda tidak memiliki akses ke fitur ini. Anda belum di setujui untuk masuk ke organisasi.</span>
                                    </div>
                                    <?php endif ?>
                                </div>
                                <?php if($data['member']['role'] == 'admin'): ?>
                                <div class="tab-pane fade" id="nav-anggota" role="tabpanel" aria-labelledby="nav-anggota-tab" tabindex="0">
                                    <?php if($data['member']['status'] == 'verified'): ?>
                                    <div>
                                        <?php if($verifing_member ?? false): foreach($verifing_member as $mem): ?>
                                        <a href="#" class="d-block card mb-2 text-dark" data-bs-toggle="modal" data-bs-target="#anggotaModal" data-bs-id="<?= $mem['id'] ?>">
                                            <div class="card-body">
                                                <div class="d-flex">
                                                    <div class="me-2">
                                                        <img src="<?= $mem['user_avatar'] ?>" width="50px" height="50px" class="rounded-circle">
                                                    </div>
                                                    <div>
                                                        <div><?= $mem['user_full_name'] ?></div>
                                                        <div class="small text-muted">Menunggu verifikasi...</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                        <?php endforeach; else: ?>
                                        <div class="alert alert-secondary">Belum ada pendaftaran untuk saat ini.</div>
                                        <?php endif ?>
                                    </div>
                                    <?php endif ?>
                                </div>
                                <?php endif ?>
                                <div class="tab-pane fade" id="nav-event" role="tabpanel" aria-labelledby="nav-event-tab" tabindex="0">
                                    <?php if($data['member']['role'] == 'admin'): ?>
                                    <div class="text-end mb-3">
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#kegiatanModal"><i class="fas fa-plus"></i> Buat acara</a>
                                    </div>
                                    <?php endif ?>
                                    <?php if($data['member']['status'] == 'verified'): ?>
                                    <div class="row">
                                        <div class="col-12 mb-3">
                                            <a href="#" class="d-block text-dark card">
                                                <div class="card-body">
                                                    <div class="fw-bold">Judul</div>
                                                    <div class="small">
                                                        <i class="fas fa-clock"></i>
                                                        <span>Waktu</span>
                                                    </div>
                                                    <div class="small">
                                                        <i class="fas fa-location-dot"></i>
                                                        <span>Location</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                    <?php else: ?>
                                    <div class="alert alert-warning">
                                        <i class="fas fa-info-circle"></i>
                                        <span>Saat ini Anda tidak memiliki akses ke fitur ini. Anda belum di setujui untuk masuk ke organisasi.</span>
                                    </div>
                                    <?php endif ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-end">
                <?php if($data['member']['role'] == 'admin'): ?>
                <a href="#" class="btn btn-sm btn-outline-primary"><i class="fas fa-pen"></i> Ubah data organisasi</a>
                <?php endif ?>
                <a href="#" class="btn btn-sm btn-outline-danger"><i class="fas fa-times"></i> Keluar dari organisasi</a>
            </div>
        </div>
    </section>
</main>

<?php if($data['member']['role'] == 'admin'): ?>
<div class="modal fade" id="kasModal" tabindex="-1" aria-labelledby="kasModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form class="modal-content" method="post" action="<?= base_url('organizations/kas_create') ?>">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="kasModalLabel">Buat tagihan kas</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?= csrf_field() ?>
                <input type="hidden" name="organization_id" value="<?= $data['id'] ?>">
                <div class="mb-3">
                    <label class="form-label">Judul tagihan</label>
                    <input type="text" name="title" id="title" placeholder="Judul tagihan" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Nominal tagihan</label>
                    <input type="number" name="amount" id="amount" placeholder="Nominal tagihan" class="form-control" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Buat tagihan</button>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id="kegiatanModal" tabindex="-1" aria-labelledby="kegiatanModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form class="modal-content" method="post" action="<?= base_url('organizations/kegiatan_create') ?>">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="kegiatanModalLabel">Buat kegiatan</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?= csrf_field() ?>
                <input type="hidden" name="organization_id" value="<?= $data['id'] ?>">
                <input type="hidden" name="member_id" value="<?= $data['member']['id'] ?>">
                <div class="mb-3">
                    <label class="form-label">Judul kegiatan</label>
                    <input type="text" name="title" id="title" placeholder="Judul tagihan" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Waktu mulai</label>
                    <div class="input-group">
                        <input type="time" class="form-control" name="start_time" id="start_time" required>
                        <input type="date" class="form-control" name="start_date" id="start_date" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Waktu selesai</label>
                    <div class="input-group">
                        <input type="time" class="form-control" name="end_time" id="end_time" required>
                        <input type="date" class="form-control" name="end_date" id="end_date" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Lokasi kegiatan</label>
                    <input type="text" name="location" id="location" placeholder="Lokasi tagihan" class="form-control" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Buat kegiatan</button>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id="anggotaModal" tabindex="-1" aria-labelledby="anggotaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <form class="modal-content" method="post" action="<?= base_url('organizations/terima/'.$data['id']) ?>">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="anggotaModalLabel">Penerimaan anggota</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?= csrf_field() ?>
                <div id="member_detail"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                <a href="#" class="btn btn-danger btn-tolak">Tolak anggota</a>
                <button type="submit" class="btn btn-primary">Terima anggota</button>
            </div>
        </form>
    </div>
</div>
<?php endif ?>

<script>
    const anggotaModal = document.getElementById('anggotaModal');
    if (anggotaModal) {
        anggotaModal.addEventListener('show.bs.modal', event => {
            const button = event.relatedTarget;
            const id = button.getAttribute('data-bs-id');
            $('#member_detail').html('<div class="alert alert-warning">Loading...</div>');
            $('#member_detail').load('<?= base_url('organizations/member_fragment/') ?>'+id, function(){
                $('.btn-tolak').attr('href', '<?= base_url('organizations/tolak/'.$data['id']) ?>?id='+id);
            });
        });
    };
</script>
<?= $this->endSection() ?>