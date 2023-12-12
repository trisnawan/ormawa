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

            <div class="card">
                <div class="card-header pb-0 border-0">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">
                                <i class="fas fa-signal"></i>
                                <span>Statistik</span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">
                                <i class="fas fa-users"></i>
                                <span>Organisasi</span>
                            </button>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                            <div class="services">
                                <div class="row">
                                    <?php foreach($statistik as $stat): ?>
                                    <div class="col-sm-12 col-md-6 col-xl-4 mb-3">
                                        <div class="icon-box shadow-sm w-100 aos-init aos-animate">
                                            <h4 class="m-0">
                                                <a href="#"><?= $stat['rows'] ?></a>
                                            </h4>
                                            <p><?= $stat['title'] ?></p>
                                        </div>
                                    </div>
                                    <?php endforeach ?>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                            <form class="input-group form-org-query mb-4">
                                <select name="status" id="status" class="form-select">
                                    <option value="verifing">Menunggu Verifikasi</option>
                                    <option value="verified">Sudah Terverifikasi</option>
                                    <option value="blocked">Terblokir</option>
                                </select>
                                <input type="text" name="search" id="search" placeholder="Pencarian..." class="form-control">
                                <button type="submit" class="btn btn-outline-primary">
                                    <i class="fas fa-search"></i>
                                    <span>Cari</span>
                                </button>
                            </form>
                            <div class="org-list">
                                <div class="alert alert-secondary">Loading...</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="detailModalLabel">Detail organisasi</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <img src="" class="w-100 mb-3">
                <div class="mb-3">
                    <label class="form-label">Nama organisasi</label>
                    <input type="text" id="title" class="form-control" disabled>
                </div>
                <div class="mb-3">
                    <label class="form-label">Deskripsi organisasi</label>
                    <textarea id="description" class="form-control" disabled></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Dokumen legal organisasi</label>
                    <a href="#" class="btn btn-outline-dark btn-legal-doc w-100">Lihat Dokumen</a>
                </div>
                <div class="mb-3">
                    <label class="form-label">Ubah status organisasi</label>
                    <a href="#" class="btn btn-outline-primary btn-org-verify btn-sm w-100 mb-2" data-status="verified" data-id="">Ubah ke Terverifikasi</a>
                    <a href="#" class="btn btn-outline-warning btn-org-verify btn-sm w-100 mb-2" data-status="verifing" data-id="">Ubah ke Menunggu Verifikasi</a>
                    <a href="#" class="btn btn-outline-danger btn-org-verify btn-sm w-100 mb-2" data-status="blocked" data-id="">Ubah ke Blokir</a>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>
<script>
    const detailModal = document.getElementById('detailModal');
    if (detailModal) {
        detailModal.addEventListener('show.bs.modal', event => {
            const button = event.relatedTarget;
            const id = button.getAttribute('data-bs-id');
            const modalTitle = detailModal.querySelector('.modal-title');

            modalTitle.textContent = 'Loading...';
            $.ajax({
                url: "<?= base_url('api/org/detail') ?>?id=" + id,
                context: document.body,
                success: function(result){
                    modalTitle.textContent = result.title;
                    $("#detailModal img").attr('src', result.avatar);
                    $("#detailModal #title").val(result.title);
                    $("#detailModal #description").text(result.description);
                    $("#detailModal .btn-legal-doc").attr('href', result.legal_doc);
                    $(".btn-org-verify").attr('data-id', id);
                }
            }).done(function() {
                
            });
            
            // modalTitle.textContent = `New message to ${recipient}`;
            // modalBodyInput.value = recipient;
        });
    }

    $(".btn-org-verify").click(function(){
        var id = $(this).attr('data-id');
        var status = $(this).attr('data-status');

        $(this).attr('disabled', true);
        $.ajax({
            url: "<?= base_url('api/org/verify') ?>?id=" + id + "&status=" + status,
            context: document.body,
        }).done(function() {
            $(this).attr('disabled', false);
            $("#detailModal").modal('hide');
            $('.form-org-query').submit();
        });
    });
</script>
<script>
    $('.form-org-query').submit(function(){
        var data = $(this).serialize();

        $('.form-org-query button').attr('disabled', true);
        $.ajax({
            url: "<?= base_url('api/org/list') ?>?" + data,
            context: document.body,
            success: function(result){
                $('.org-list').html('');
                if(result.result.length > 0){
                    for(let i = 0; i < result.result.length; i++){
                        $('.org-list').append('<div class="border p-2 mb-3"><div class="row"><div class="col-sm-12 col-md-2 mb-2"><img src="'+result.result[i].avatar+'" class="w-100" /></div><div class="col-sm-12 col-md mb-2"><a href="#" class="fw-bold d-block">'+result.result[i].title+'</a><div class="mt-2"><a href="#" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#detailModal" data-bs-id="'+result.result[i].id+'"><i class="fas fa-eye"></i> '+result.result[i].status+'</a></div></div></div></div>');
                    }
                }else{
                    $('.org-list').html('<div class="alert alert-secondary">Belum ada data organisasi.</div>');
                }
            }
        }).done(function() {
            $('.form-org-query button').attr('disabled', false);
        });
        return false;
    });

    $('.form-org-query select').change(function(){
        $('.form-org-query').submit();
    });

    $(document).ready(function(){
        $('.form-org-query').submit();
    });
</script>
<?= $this->endSection() ?>