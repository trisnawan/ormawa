<?php 
    $request = \Config\Services::request();
    $session = session();
?>

<div id="topbar" class="d-flex align-items-center fixed-top">
    <div class="container d-flex justify-content-between">
        <div class="contact-info d-flex align-items-center">
            <i class="bi bi-envelope"></i>
            <a href="mailto:<?= getEnv('appEmail') ?>"><?= getEnv('appEmail') ?></a>
        </div>
        <div class="d-none d-lg-flex social-links align-items-center">
            <a href="https://facebook.com/<?= getEnv('appSocialFacebook') ?? '' ?>" class="facebook"><i class="bi bi-facebook"></i></a>
            <a href="https://instagram.com/<?= getEnv('appSocialInstagram') ?? '' ?>" class="instagram"><i class="bi bi-instagram"></i></a>
            <a href="https://wa.me/<?= getEnv('appSocialWhatsapp') ?? '' ?>" class="whatsapp"><i class="bi bi-whatsapp"></i></i></a>
        </div>
    </div>
</div>

<header id="header" class="fixed-top">
    <div class="container d-flex align-items-center">

        <h1 class="logo me-auto">
            <a href="<?= base_url() ?>">
                <?= strtoupper(getEnv('appName')) ?>
            </a>
        </h1>

        <nav id="navbar" class="navbar order-last order-lg-0">
            <ul>
                <li>
                    <a class="nav-link scrollto <?= !$request->uri->getSegment(1) ? 'active' : '' ?>" href="<?= base_url() ?>">Home</a>
                </li>
                <li>
                    <a class="nav-link scrollto <?= $request->uri->getSegment(1) == 'organizations' ? 'active' : '' ?>" href="<?= base_url('organizations') ?>">Organisasi</a>
                </li>
            </ul>
            <i class="bi bi-list mobile-nav-toggle"></i>
        </nav>

        <?php if($session->get('id') ?? false): ?>
        <a href="<?= base_url('profile') ?>" class="appointment-btn scrollto">
            <i class="bi bi-person"></i>
            <span class="d-none d-md-inline">My Profile</span>
        </a>
        <?php else: ?>
        <a href="<?= base_url('login') ?>" class="appointment-btn scrollto">
            <i class="bi bi-person"></i>
            <span class="d-none d-md-inline">Masuk</span>
        </a>
        <?php endif ?>
    </div>
</header>