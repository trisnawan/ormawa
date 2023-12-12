<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title><?= ($title ?? false) ? $title.' | ' : '' ?><?= getEnv('appName') ?></title>
    <meta content="<?= $description ?? '' ?>" name="description">
    <meta content="<?= $keywords ?? '' ?>" name="keywords">
    <link href="<?= base_url() ?>assets/img/favicon.png" rel="icon">
    <link href="<?= base_url() ?>assets/img/apple-touch-icon.png" rel="apple-touch-icon">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
    <link href="<?= base_url() ?>assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="<?= base_url() ?>assets/vendor/animate.css/animate.min.css" rel="stylesheet">
    <link href="<?= base_url() ?>assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url() ?>assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="<?= base_url() ?>assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="<?= base_url() ?>assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="<?= base_url() ?>assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="<?= base_url() ?>assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
    <link href="<?= base_url() ?>assets/css/style.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        .btn-primary{
            background: #1977cc !important;
        }
    </style>
    <script src="<?= base_url() ?>assets/vendor/jquery/jquery-3.7.1.min.js"></script>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
</head>

<body>

    <?= $this->include('templates/header') ?>
    <?= $this->renderSection('content') ?>
    <?= $this->include('templates/footer') ?>

    <div id="preloader"></div>
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="<?= base_url() ?>assets/vendor/purecounter/purecounter_vanilla.js"></script>
    <script src="<?= base_url() ?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url() ?>assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="<?= base_url() ?>assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <!-- Template Main JS File -->
    <script src="<?= base_url() ?>assets/js/main.js"></script>
    <script>
        AOS.init();
    </script>
</body>

</html>