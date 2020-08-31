<?php
require_once 'inc.php';
require_once '../include/ayarlar.php';
require_once '../include/fonksiyon.php';
define("admin", true);

if(!isset($_SESSION['Oturum'])){
  header("location: giris-yap.php");
}


?>
<!DOCTYPE html>
<html lang="tr">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title><?=site_baslik?> - Yönetim Paneli</title>


  <!-- jQuery -->
  <script src="<?=cdn?>/YNT/vendors/jquery/dist/jquery.min.js"></script>
  <!-- Bootstrap -->
  <link href="<?=cdn?>/YNT/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="//library.akbimbilgisayar.com/bayiscripti/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <!-- NProgress -->
  <link href="<?=cdn?>/YNT/vendors/nprogress/nprogress.css" rel="stylesheet">

  <link href="<?=cdn?>/YNT/vendors/jquery-ui/jquery-ui.css" rel="stylesheet" type="text/css" >
  <script src="<?=cdn?>/YNT/vendors/jquery-ui/jquery-ui.js"></script>

  <!-- Custom Theme Style -->
  <link href="<?=cdn?>/YNT/build/css/custom.min.css" rel="stylesheet">
  <link href="<?=cdn?>/YNT/build/css/stil.css" rel="stylesheet">

  <style type="text/css">
    body{
      margin: 0;
      padding: 0;
    }
    #iskelet{
      margin-left: auto;
      margin-right: auto;
    }
    #liste li{
      list-style: none;
      background-color: #dddddd;
      margin-top: 5px;
      border: dotted 1px #000;
    }
  </style>


</head>

<body class="nav-md">
  <div class="container body">
    <div class="main_container">

      <?php require_once "solmenu.php"; ?>

      <!-- top navigation -->
      <?php require_once "ustmenu.php"; ?>
      <!-- /top navigation -->

      <!-- page content -->
      <div class="right_col" role="main">










        </div>
        <!-- /page content -->

        <!-- footer content -->
        <footer>
          <div class="pull-right">
            <?=site_baslik?> | Design by <a href="https://www.akbimbilgisayar.com" target="_blank"> Akbim Bilgisayar</a>
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div>

    <!-- Bootstrap -->
    <script src="<?=cdn?>/YNT/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="<?=cdn?>/YNT/vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="<?=cdn?>/YNT/vendors/nprogress/nprogress.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="<?=cdn?>/YNT/build/js/custom.js"></script>

  </body>
  </html>
