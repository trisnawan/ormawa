<?= $this->extend('templates/main') ?>
<?= $this->section('content') ?>
<main id="main">
    <section style="margin-top: 120px;" class="services">
        <div class="container mb-5">
            <div class="section-title">
                <h2><?= $title ?></h2>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-sm" style="height: 70vh; overflow:hidden;">
                        <div class="card-header bg-primary p-3 text-white">
                            <i class="fas fa-comment me-2"></i>
                            <span><?= $org['title'] ?></span>
                        </div>
                        <div class="card-body p-0 h-100" style="overflow:hidden;">
                            <div class="d-flex flex-column h-100">
                                <div class="p-2 chat-container" style="overflow-y: scroll; max-height: calc(70vh - 114px);">
                                    <?php if($chat ?? false): foreach($chat as $ch): ?>
                                    <?php if($ch['user_id'] == $user_id): ?>
                                    <div class="d-flex justify-content-end align-items-start">
                                        <div class="alert alert-info me-2 p-2">
                                            <div class="small fw-bold text-dark"><?= $ch['user_full_name'] ?></div>
                                            <div><?= str_replace("\n", "<br>", $ch['text']) ?></div>
                                            <div class="small fw-light text-muted text-end"><?= $ch['send_at'] ?></div>
                                        </div>
                                        <img src="<?= $ch['user_avatar'] ?>" class="rounded-circle" width="35px" height="35px">
                                    </div>
                                    <?php else: ?>
                                    <div class="d-flex justify-content-start align-items-start">
                                        <img src="<?= $ch['user_avatar'] ?>" class="rounded-circle" width="35px" height="35px">
                                        <div class="alert alert-secondary ms-2 p-2">
                                            <div class="small fw-bold text-dark"><?= $ch['user_full_name'] ?></div>
                                            <div><?= str_replace("\n", "<br>", $ch['text']) ?></div>
                                            <div class="small fw-light text-muted text-end"><?= $ch['send_at'] ?></div>
                                        </div>
                                    </div>
                                    <?php endif ?>
                                    <?php endforeach; endif; ?>
                                </div>
                                <div class="mt-auto p-2 border-top w-100 bg-light">
                                    <form class="input-group">
                                        <input type="text" name="text" id="text" class="form-control" placeholder="Tulis pesan..." required>
                                        <button type="submit" class="btn btn-outline-primary">
                                            <i class="fas fa-paper-plane"></i> Kirim
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<script>
    var lastPosition;

    function scrollDown(){
        var container = $(".chat-container");
        var position = container.scrollTop();
        var height = container[0].scrollHeight;

        if(position === lastPosition) up = !up;
        lastPosition = position;

        container.scrollTop(height);
    }

    scrollDown();

    $('form').submit(function(){
        var text = $('form input[name=text]').val();
        if(text.length == 0){
            return false;
        }

        $('form input[name=text]').attr('disabled', true);
        $('form button').attr('disabled', true);
        $('form button').html('<i class="fas fa-sync"></i> Mengirim...');
        $.ajax({
            url: "<?= base_url('api/chat/send/'.$org['id'].'?text=') ?>" + text,
            context: document.body
        }).done(function() {
            $('form input[name=text]').val('');
            $('form input[name=text]').attr('disabled', false);
            $('form button').attr('disabled', false);
            $('form button').html('<i class="fas fa-paper-plane"></i> Kirim');
        });

        return false;
    });
</script>
<script>
    // Pusher.logToConsole = true;
    var pusher = new Pusher('ad7b1b8dd25e9cd9038d', {
        cluster: 'ap1'
    });
    var channel = pusher.subscribe("<?= $org['id'] ?>");
    var html = "";
    channel.bind('chat', function(data) {
        console.log(data);
        if(data.user_id == '<?= $user_id ?>'){
            html = '<div class="d-flex justify-content-end align-items-start">';
            html += '<div class="alert alert-info me-2 p-2">';
            html += '<div class="small fw-bold text-dark">' + data.user_full_name + '</div>';
            html += '<div>' + data.text + '</div>';
            html += '<div class="small fw-light text-muted text-end">' + data.send_at + '</div>';
            html += '</div>';
            html += '<img src="' + data.user_avatar + '" class="rounded-circle" width="35px" height="35px">';
            html += '</div>';
        }else{
            html = '<div class="d-flex justify-content-start align-items-start">';
            html += '<img src="' + data.user_avatar + '" class="rounded-circle" width="35px" height="35px">';
            html += '<div class="alert alert-secondary ms-2 p-2">';
            html += '<div class="small fw-bold text-dark">' + data.user_full_name + '</div>';
            html += '<div>' + data.text + '</div>';
            html += '<div class="small fw-light text-muted text-end">' + data.send_at + '</div>';
            html += '</div>';
            html += '</div>';
        }
        $(".chat-container").append(html);
        scrollDown();
    });
</script>
<?= $this->endSection() ?>