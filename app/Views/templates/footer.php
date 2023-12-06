<footer id="footer">

    <div class="footer-top">
        <div class="container">
            <div class="row">

            <div class="col-lg-4 col-md-6 footer-contact">
                <h3><?= strtoupper(getEnv('appName')) ?></h3>
                <p>
                    <?= getEnv('appUniv') ?> <br>
                    Senen, Jakarta Pusat<br>
                    Indonesia<br><br>
                    <strong>Email:</strong> <?= (getEnv('appEmail')) ?><br>
                </p>
            </div>

            <div class="col-lg-4 col-md-6 footer-links">
                <h4>Useful Links</h4>
                <ul>
                    <li>
                        <i class="bx bx-chevron-right"></i>
                        <a href="<?= base_url() ?>">Home</a>
                    </li>
                    <li>
                        <i class="bx bx-chevron-right"></i>
                        <a href="<?= base_url('organizations') ?>">Organisasi</a>
                    </li>
                    <li>
                        <i class="bx bx-chevron-right"></i>
                        <a href="<?= base_url('organizations') ?>">Kebijakan Privasi</a>
                    </li>
                    <li>
                        <i class="bx bx-chevron-right"></i>
                        <a href="<?= base_url('organizations') ?>">Syarat dan Ketentuan</a>
                    </li>
                </ul>
            </div>

            <div class="col-lg-4 col-md-6 footer-newsletter">
                <h4>Join Our Newsletter</h4>
                <p>Dapatkan informasi menarik terkini dari kami!</p>
                <form action="" method="post">
                <input type="email" name="email"><input type="submit" value="Subscribe">
                </form>
            </div>

            </div>
        </div>
    </div>

    <div class="container d-md-flex py-4">

        <div class="me-md-auto text-center text-md-start">
            <div class="copyright">
                &copy; Copyright
                <strong><span><?= strtoupper(getEnv('appName')) ?></span></strong>.
                All Rights Reserved
            </div>
            <div class="credits">
                <!-- All the links in the footer should remain intact. -->
                <!-- You can delete the links only if you purchased the pro version. -->
                <!-- Licensing information: https://bootstrapmade.com/license/ -->
                <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/medilab-free-medical-bootstrap-theme/ -->
                Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
            </div>
        </div>
        <div class="social-links text-center text-md-right pt-3 pt-md-0">
            <a href="https://facebook.com/<?= getEnv('appSocialFacebook') ?? '' ?>" class="facebook"><i class="bx bxl-facebook"></i></a>
            <a href="https://instagram.com/<?= getEnv('appSocialInstagram') ?? '' ?>" class="instagram"><i class="bx bxl-instagram"></i></a>
            <a href="https://wa.me/<?= getEnv('appSocialWhatsapp') ?? '' ?>" class="whatsapp"><i class="bx bxl-whatsapp"></i></a>
        </div>
    </div>
</footer>