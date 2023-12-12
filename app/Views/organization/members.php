<?= $this->extend('templates/main') ?>
<?= $this->section('content') ?>
<main id="main">
    <section style="margin-top: 120px;">
        <div class="container">
            <div class="section-title">
                <h2><?= $title ?></h2>
            </div>
            <div class="row mb-4">
                <div class="col-sm-12 col-md mb-2">
                    <div class="input-group">
                        <input type="text" name="search" id="search" class="form-control" placeholder="Pencarian...">
                        <button type="submit" class="btn btn-outline-primary">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
                <div class="col-sm-12 col-md-auto mb-2">
                    <a href="#" class="btn btn-primary w-100 w-md-auto">
                        <i class="fas fa-download"></i>
                        <span>Download Report</span>
                    </a>
                </div>
            </div>
            <div>
                <?php foreach($members as $member): ?>
                <a href="#" class="d-block card mb-3">
                    <div class="card-body text-dark">
                        <div class="d-flex">
                            <img src="<?= $member['user_avatar'] ?>" class="rounded-circle" width="60px" height="60px">
                            <div class="ms-3">
                                <div class="fw-bold"><?= $member['user_full_name'] ?></div>
                                <div class="small text-muted">
                                    <?= $member['position'] ?>
                                    <span class="badge bg-primary"><?= $member['role'] ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
                <?php endforeach ?>
            </div>
        </div>
    </section>
</main>
<?= $this->endSection() ?>