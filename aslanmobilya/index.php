<?php define("akbim", true); ?>
<?php require_once 'include/ayarlar.php'; ?>
<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title><?=baslik()?></title>
    <meta name="description" content="<?=kontrol_dizi($url, 'Desc')?>" />
    <meta name="keywords" content="<?=kontrol_dizi($url, 'Keyw')?>" />
    <meta name="author" content="Akbim Yazılım" />
    <meta name="google-site-verification" content="<?=kontrol_dizi($url, 'google-site-verification')?>" />

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Montserrat:300,400,500,700"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="<?=url?>/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?=url?>/assets/vendor/icofont/icofont.min.css" rel="stylesheet">
    <link href="<?=url?>/assets/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?=url?>/assets/vendor/ionicons/css/ionicons.min.css" rel="stylesheet">
    <link href="<?=url?>/assets/vendor/animate.css/animate.min.css" rel="stylesheet">
    <link href="<?=url?>/assets/vendor/venobox/venobox.css" rel="stylesheet">
    <link href="<?=url?>/assets/vendor/owl.carousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="<?=url?>/assets/vendor/aos/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="//library.akbimbilgisayar.com/bayiscripti/gallery/baguetteBox.min.css" />

    <!-- Template Main CSS File -->
    <link href="<?=url?>/assets/css/style.css" rel="stylesheet">
    <link href="<?=url?>/assets/css/custom.css" rel="stylesheet">

</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="fixed-top header-transparent">
        <div class="container-fluid">

            <div class="row justify-content-center">
                <div class="col-xl-11 d-flex align-items-center">
                    <a href="<?=url?>" class="logo mr-auto"><img src="<?=url?>/<?=images?>/logo-1.png" alt=""
                            class="img-fluid"></a>

                    <nav class="nav-menu d-none d-lg-block">

                        <?php
            // MENÜ LİSTESİ HAZIRLAMAK İÇİN BURAYI KULLANACAKSIN PHP TAGI BAŞLANGIÇ VE BİTİMİNE KADAR KOMPLE ALACAN NAV TAGLARI ARASINA YAZACAN..
            require_once 'include/menu_duzen.php';
            $category_list = $db->query("SELECT * FROM sayfa_url WHERE Navbar = '1' ORDER BY Sira ASC, UrlID DESC ")->fetchAll(PDO::FETCH_OBJ);
            drawElements(bulidTree( $category_list ));
            ?>

                    </nav><!-- .nav-menu -->
                </div>
            </div>

        </div>
    </header><!-- End Header -->





    <?php
  // URL YAPISINA GÖRE İÇERİK YERLEŞTİRME İÇİN KULLANILACAK.
  require 'yonlendirici.php';
  ?>







    <!-- ======= Footer ======= -->
    <footer id="footer">
        <div class="footer-top">
            <div class="container">
                <div class="row">

                    <div class="col-lg-4 col-md-6 footer-info">
                        <h3><?=site_baslik?></h3>
                        <p><?=site_kisa_bilgi?></p>
                    </div>

                    <div class="col-lg-4 col-md-6 footer-links">
                        <h4>İÇ BAĞLANTILAR</h4>
                        <ul>
                            <?php
              if($category_list){
                foreach ( $category_list as $key ) {
                  if( $key->UstID == 0 && $key->IcerikTipiID != '100' ){
                    ?>
                            <li><a href="<?=url."/".$key->SeoUrl?>.html"><?=$key->Baslik?></a></li>
                            <?php
                  }
                }
              }
              ?>
                        </ul>
                    </div>

                    <div class="col-lg-4 col-md-6 footer-contact">
                        <h4>İLETİŞİM</h4>
                        <p>
                            <?=adres?><br>
                            <strong>Sabit Telefon:</strong> <a href="tel:<?=sabit_tel?>"><?=sabit_tel?></a><br>
                            <strong>Cep Telefon:</strong> <a href="tel:<?=cep_tel?>"><?=cep_tel?></a><br>
                            <strong>E-Posta:</strong> <a href="mailto:<?=eposta?>"><?=eposta?></a><br>
                        </p>

                        <div class="social-links">
                            <?php foreach ($Sosyal as $key) {?>
                            <a href="<?=$key->DegerOnEki?><?=$key->Deger?>"><i class="fa fa-<?=$key->icon?>"></i></a>
                            <?php } ?>
                        </div>

                    </div>


                </div>
            </div>
        </div>

        <div class="container">
            <div class="copyright">
                &copy; Copyright <strong><?=site_baslik?></strong>. Tüm Hakları Saklıdır.
            </div>
            <div class="credits">
                <a href="https://wwww.akbimyazilim.com/">Akbim Yazılım</a> Tarafından Oluşturulmuştur.
            </div>
        </div>
    </footer><!-- End Footer -->

    <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>
    <!-- Uncomment below i you want to use a preloader -->
    <!-- <div id="preloader"></div> -->

    <!-- Vendor JS Files -->
    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/jquery.easing/jquery.easing.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>
    <script src="assets/vendor/waypoints/jquery.waypoints.min.js"></script>
    <script src="assets/vendor/counterup/counterup.min.js"></script>
    <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
    <script src="assets/vendor/venobox/venobox.min.js"></script>
    <script src="assets/vendor/owl.carousel/owl.carousel.min.js"></script>
    <script src="assets/vendor/aos/aos.js"></script>
    <script src="//library.akbimbilgisayar.com/bayiscripti/gallery/baguetteBox.min.js"></script>
    <script>
    baguetteBox.run('.grid-gallery', {
        animation: 'slideIn'
    });
    </script>
    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>

</body>

</html>