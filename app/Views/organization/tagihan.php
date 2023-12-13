<?= $this->extend('templates/main') ?>
<?= $this->section('content') ?>
<main id="main">
    <section style="margin-top: 120px;">
        <div class="container mb-5">
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
                <div class="col-sm-12 col-md-6 mb-3" data-aos="fade-up-right">
                    <a href="#" class="d-block border rounded p-3 h-100 text-dark">
                        <div class="small">Total tagihan</div>
                        <div class="h4 m-0"><?= rupiah($tagihan['amount']) ?></div>
                    </a>
                </div>
                <div class="col-sm-12 col-md-6 mb-3" data-aos="fade-up-left">
                    <a href="#" class="d-block border rounded p-3 h-100 text-dark" data-bs-toggle="modal" data-bs-target="#bayarModal">
                        <div class="small">Status tagihan anda</div>
                        <div class="h4 m-0">
                            <?= ucwords($tagihan['transaksi']['status'] ?? 'unpaid') ?>
                            <?php if(($tagihan['transaksi']['status'] ?? 'unpaid') != 'paid'): ?>
                            <span class="badge bg-primary rounded-pill">Bayar</span>
                            <?php endif ?>
                        </div>
                    </a>
                </div>
            </div>
            <div>
                <h3>Laporan pembayaran</h3>
                <?php if($members ?? false): ?>
                <div class="row mb-4" data-aos="fade-up">
                    <?php foreach($members as $member): ?>
                    <div class="col-12 mb-2">
                        <a href="#" class="d-block card" data-bs-toggle="modal" data-bs-target="#detailModal" data-bs-member="<?= $member['id'] ?>" data-bs-tagihan="<?= $tagihan['id'] ?>" data-bs-title="<?= $member['user_full_name'] ?>">
                            <div class="card-body text-dark">
                                <div class="d-flex">
                                    <div class="me-2">
                                        <img src="<?= $member['user_avatar'] ?>" width="50px" height="50px" class="rounded-circle">
                                    </div>
                                    <div>
                                        <div><?= $member['user_full_name'] ?></div>
                                        <div class="small text-<?= $member['transaction_status'] == 'paid' ? 'success' : 'danger' ?>"><?= $member['transaction_status'] == 'paid' ? 'Lunas' : ($member['transaction_status'] == 'none' ? 'Belum Bayar' : 'Menunggu Pembayaran') ?></div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php endforeach ?>
                </div>
                <?php else: ?>
                <div class="alert alert-warning">Server error!</div>
                <?php endif ?>

                <?php if($is_admin ?? true): ?>
                <div class="text-end">
                    <div class="drowdown">
                        <a href="#" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-download"></i>
                            <span>Download Report</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="<?= base_url('export/org/tagihan/print/'.$tagihan['id']) ?>" target="_blank">Cetak Laporan</a></li>
                            <li><a class="dropdown-item" href="<?= base_url('export/org/tagihan/pdf/'.$tagihan['id']) ?>" target="_blank">Download PDF</a></li>
                            <li><a class="dropdown-item" href="<?= base_url('export/org/tagihan/excel/'.$tagihan['id']) ?>" target="_blank">Download Excel</a></li>
                        </ul>
                    </div>
                </div>
                <?php endif ?>
            </div>
        </div>
    </section>
</main>
<div class="modal fade" id="bayarModal" tabindex="-1" aria-labelledby="bayarModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form class="modal-content" method="post" action="<?= current_url() ?>">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="bayarModalLabel">Pilih cara pembayaran</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?= csrf_field() ?>
                <input type="hidden" name="tagihan_id" value="<?= $_GET['id'] ?? '' ?>">
                <div class="mb-3">
                    <label for="" class="form-label">Menggunakan apa Anda akan membayar?</label>
                    <select name="payment" id="payment" class="form-select">
                        <option value="online">Bayar secara online</option>
                        <option value="offline">Bayar cash ke admin</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Bayar sekarang</button>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="detailModalLabel">Detail tagihan</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body tagihan-detail">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
            </div>
        </div>
    </div>
</div>

<script>
    const detailModal = document.getElementById('detailModal');
    if (detailModal) {
        detailModal.addEventListener('show.bs.modal', event => {
            const button = event.relatedTarget;
            const id = button.getAttribute('data-bs-tagihan');
            const member = button.getAttribute('data-bs-member');
            const title = button.getAttribute('data-bs-title');
            $('#detailModalLabel').text(title);
            $('.tagihan-detail').html('<div class="alert alert-warning">Loading...</div>');
            $('.tagihan-detail').load('<?= base_url('organizations/tagihan_view/') ?>'+id+'/'+member, function(){
                $('.btn-action').attr('href', '<?= base_url('organizations/tolak/'.$tagihan['id']) ?>?id='+id);
            });
        });
    };
</script>
<?= $this->endSection() ?>