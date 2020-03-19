<?php require_once 'ayarlar.php'; ?>
<!DOCTYPE html>
<html lang="tr">

<head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-153096523-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-153096523-1');
    </script>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Title -->
    <title>Bulut Santral | Sanal Santral</title>

    <!-- Favicon -->
    <link rel="icon" href="./img/core-img/favicon.ico">
    <meta name="theme-color" content="#1c66de">

    <!-- jQuery -->
    <script src="//library.akbimbilgisayar.com/bayiscripti/vendors/jquery/dist/jquery.min.js"></script>

    <!-- Stylesheet -->
    <link rel="stylesheet" href="style.css">

</head>

<body>
    <!-- Preloader -->
    <div id="preloader">
        <div class="loader"></div>
    </div>
    <!-- /Preloader -->

    <!-- Header Area Start -->
    <header class="header-area">
        <!-- Top Header Area Start -->
        <div class="top-header-area">
            <div class="container">
                <div class="row">

                    <div class="col-6">
                        <div class="top-header-content">
                            <a href="#"><i class="fa fa-phone" aria-hidden="true"></i> <span>Müşteri Hizmetleri : 0850 420 44 11</span></a>
                            <a href="#"><i class="fa fa-envelope" aria-hidden="true"></i> <span>Email: info@akbimbilgisayar.com</span></a>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="top-header-content">
                            <!-- Login -->
                            <a href="./giris-yap"><i class="fa fa-lock" aria-hidden="true"></i> <span>Giriş Yap</span></a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- Top Header Area End -->

        <!-- Main Header Start -->
        <div class="main-header-area">
            <div class="classy-nav-container breakpoint-off">
                <div class="container">
                    <!-- Classy Menu -->
                    <nav class="classy-navbar justify-content-between" id="hamiNav">

                        <!-- Logo -->
                        <a class="nav-brand" href="./anasayfa"><img src="./img/core-img/logo.png" alt=""></a>

                        <!-- Navbar Toggler -->
                        <div class="classy-navbar-toggler">
                            <span class="navbarToggler"><span></span><span></span><span></span></span>
                        </div>

                        <!-- Menu -->
                        <div class="classy-menu">
                            <!-- Menu Close Button -->
                            <div class="classycloseIcon">
                                <div class="cross-wrap"><span class="top"></span><span class="bottom"></span></div>
                            </div>
                            <!-- Nav Start -->
                            <div class="classynav">
                                <ul id="nav">
                                    <li <?=AktifBaslik( link, 'anasayfa')?>><a href="./anasayfa">Anasayfa</a></li>
                                    <li <?=AktifBaslik( link, 'tarifeler')?>><a href="./tarifeler">Tarifeler</a></li>   
                                    <li <?=AktifBaslik( link, 'iletisim')?>><a href="./iletisim">İletişim</a></li> 
                                </ul>
                            </div>
                            <!-- Nav End -->
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <!-- Header Area End -->