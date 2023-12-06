<?= $this->extend('templates/main') ?>
<?= $this->section('content') ?>
<main id="main">
    <section style="margin-top: 120px;">
        <div class="container">
            <div class="section-title">
                <h2>Profile</h2>
            </div>
            <?php if($warning ?? false): ?>
            <div class="alert alert-warning"><?= $warning ?></div>
            <?php endif ?>
            <?php if($success ?? false): ?>
            <div class="alert alert-success"><?= $success ?></div>
            <?php endif ?>
            <div class="row">
                <div class="col-sm-12 col-md-auto text-center mb-3">
                    <div class="card mb-2">
                        <div class="card-body">
                            <img src="<?= $profile['avatar'] ?>" alt="Profile picture" width="220px" height="220px" class="rounded-circle">
                        </div>
                    </div>
                    <a href="#" class="btn btn-outline-primary w-100 mb-2">Ganti foto profile</a>
                    <a href="<?= base_url('logout') ?>" class="btn btn-outline-dark w-100 mb-2">Keluar</a>
                </div>
                <div class="col-sm-12 col-md mb-3">
                    <div class="card">
                        <nav class="card-header pb-0 border-0">
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <button class="nav-link active" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">
                                    <i class="fas fa-user"></i>
                                    <span class="d-none d-md-inline-block">Profile</span>
                                </button>
                                <button class="nav-link" id="nav-org-tab" data-bs-toggle="tab" data-bs-target="#nav-org" type="button" role="tab" aria-controls="nav-org" aria-selected="false">
                                    <i class="fas fa-users"></i>
                                    <span class="d-none d-md-inline-block">Organisasi saya</span>
                                </button>
                            </div>
                        </nav>
                        <div class="card-body">
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab" tabindex="0">
                                    <form action="<?= base_url('profile/update_save') ?>" method="post">
                                        <?= csrf_field() ?>
                                        <div class="mb-3">
                                            <label class="form-label">Nama lengkap</label>
                                            <input type="text" value="<?= $profile['full_name'] ?>" name="full_name" class="form-control" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Alamat email</label>
                                            <input type="text" value="<?= $profile['email'] ?>" name="email" class="form-control" disabled>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Nomor telepon</label>
                                            <input type="text" value="<?= $profile['phone'] ?>" name="phone" class="form-control" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Jenis kelamin</label>
                                            <select name="gender" class="form-control" required>
                                                <option value="">-- pilih jenis kelamin --</option>
                                                <option value="male" <?= $profile['gender'] == 'male' ? 'selected' : '' ?>>Laki-laki</option>
                                                <option value="female" <?= $profile['gender'] == 'female' ? 'selected' : '' ?>>Perempuan</option>
                                            </select>
                                        </div>
                                        <div class="mb-3 text-end">
                                            <button type="submit" class="btn btn-primary">Simpan perubahan</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="nav-org" role="tabpanel" aria-labelledby="nav-org-tab" tabindex="0">
                                    <?php if($orgs): foreach($orgs as $org): ?>
                                    <a href="<?= base_url('organizations/dashboard/'.$org['organization_id']) ?>">
                                        <div class="row border rounded p-3 mb-3">
                                            <div class="col-sm-12 col-md-3 mb-3">
                                                <img src="<?= $org['organization_avatar'] ?>" class="w-100 rounded">
                                            </div>
                                            <div class="col-sm-12 col-md-9 mb-3">
                                                <div class="fw-bold"><?= $org['organization_title'] ?></div>
                                                <div class="text-dark">
                                                    <i class="fas fa-user-tie"></i>
                                                    <span><?= $org['position'] ?> (<?= $org['role'] ?>)</span>
                                                </div>
                                                <div class="text-dark">
                                                    <i class="fas fa-circle"></i>
                                                    <span><?= ucwords($org['status']) ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                    <?php endforeach; else: ?>
                                    <div class="alert alert-secondary">
                                        <i class="fas fa-info-circle"></i>
                                        Anda belum tergabung ke dalam organisasi manapun, silahkan gabung organisasi dan mulai keseruannya!
                                    </div>
                                    <?php endif ?>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<?= $this->endSection() ?>