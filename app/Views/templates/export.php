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
    <style>
        .btn-primary{
            background: #1977cc !important;
        }
        .text-center {
            text-align: center!important;
        }
        .fw-bold {
            font-weight: 700!important;
        }
        .mb-5 {
            margin-bottom: 3rem!important;
        }
        .mt-5 {
            margin-top: 3rem!important;
        }
        .w-100 {
            width: 100%!important;
        }
        .border-dark {
            border-color: #000000!important;
        }
        .table {
            width: 100%;
            margin-bottom: 1rem;
            vertical-align: top;
            border-color: #000000;
        }
        .table-bordered, .table-bordered th, .table-bordered td {
            border: 1px solid #000000;
        }
        th, td {
            padding: 5px 7px;
        }
        table {
            caption-side: bottom;
            border-collapse: collapse;
        }
    </style>
    <script src="<?= base_url() ?>assets/vendor/jquery/jquery-3.7.1.min.js"></script>
</head>

<body class="text-dark">
    <?= $this->renderSection('content') ?>

    <?php if($is_print ?? false): ?>
    <script>
        window.print();
        $(document).ready(function(){
            window.print();
            console.log('print');
        });
    </script>
    <?php endif ?>
</body>

</html>