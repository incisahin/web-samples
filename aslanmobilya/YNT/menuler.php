<?php
require_once 'inc.php';
require_once '../include/ayarlar.php';
require_once '../include/fonksiyon.php';
require_once '../include/menu_duzen.php';
require_once '../include/class.upload.php';
define("admin", true);

if(!isset($_SESSION['Oturum'])){
  header("location: giris-yap.php");
}


$sql_text = "SELECT COUNT(UrlID) AS 'adet' FROM sayfa_url WHERE IcerikTipiID != '30' ";

$sayfada  = '15';
$limit    = '0';
if(isset($_GET['sayfaadet'])){
  $sayfada = $_GET['sayfaadet'];
}

$toplam_icerik = $db->prepare( $sql_text );
$toplam_icerik->execute(array( ));
if( $toplam_icerik = $toplam_icerik->fetch(PDO::FETCH_OBJ) ){

  $toplam_icerik = $toplam_icerik->adet;
  $toplam_sayfa = ceil(intval($toplam_icerik) / intval($sayfada));

  if(!isset($_GET['sayfa'])) $sayfa = 1;
  if(isset($_GET['sayfa']))  $sayfa = $_GET['sayfa'];

  if($sayfa < 1) $sayfa = 1;
  if($sayfa > $toplam_sayfa && $toplam_sayfa != 0) $sayfa = $toplam_sayfa;
  $limit = intval( ($sayfa - 1) ) * $sayfada ;
}

$sql_text = "SELECT * FROM sayfa_url WHERE IcerikTipiID != '30' ORDER BY UstID ASC";

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

  <link href="<?=cdn?>/YNT/build/css/custom.min.css" rel="stylesheet">

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

        <?php if(!isset($_GET['ID'])){ ?>
          <div class="">
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Menu Düzenle <small>Menü sırası için sürükleyerek taşıyın.</small>  </h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <!-- Sayfa İçeriği -->

                    <div class="x_content">

                      <?php
                      if( isset($_POST['MenuSil']) ){
                        $Silq = $db->prepare("DELETE FROM sayfa_url WHERE UrlID = :ID");
                        $Silex = $Silq->execute(array( "ID" => $_POST['Menu_ID'] ));
                        if($Silex){
                          echo '<div class="alert alert-info" role="alert">Menu Başarıyla Silindi</div>';
                          go("menuler.php", 1);
                        }else{
                          echo '<div class="alert alert-danger" role="alert">Menu Silinemedi</div>';
                        }
                      }
                      ?>


                      <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                        <form>
                          <?php
                          if($toplam_sayfa>0){
                            echo '<button name="sayfa" class="btn btn-default" value="1">&laquo; İlk</button>';
                            for($s = $sayfa-3; $s <= $sayfa+3; $s++) {
                              if($sayfa == $s && $s != 0) {
                                echo '<button name="sayfa" class="btn btn-primary" value="'.$s . '">'.$s . '</button>';
                              }else if($s>=1 && $s<=$toplam_sayfa){
                                echo '<button name="sayfa" class="btn btn-default" value="' . $s . '">' . $s . '</a>';
                              }
                            }
                            echo '<button name="sayfa" class="btn btn-default" value="' . $toplam_sayfa . '">Son &raquo;</button>';
                          }
                          ?>
                        </form>
                      </div>

                      <table class="table jambo_table bulk_action" id="iskelet">
                        <thead>
                          <th>Menü ID</th>
                          <th>Menü Adı</th>
                          <th>Seo Url Linki</th>
                          <th>Url Yapısı Düzenle</th>
                          <th>Url Sil</th>
                          <th>İçerik Düzenleme</th>
                        </thead>
                        <tbody id="liste">
                          <?php

                          $menuler = $db->query( $sql_text . " LIMIT ". $limit . ', ' . $sayfada, PDO::FETCH_OBJ);
                          if( $menuler ){
                            foreach ( $menuler as $m ) {
                              ?>
                              <form method="post">
                                <tr id="veriler_<?=$m->ID?>">
                                  <td class="dark" style="width: 100px;">
                                    <button class="btn btn-default btn-xs col-md-12"><?=$m->UrlID?></button>
                                  </td>
                                  <td class="dark" style="width: 200px"><b><?=$m->Baslik?></b></td>
                                  <td class="dark" style="width: 200px"><b><?=$m->SeoUrl?></b></td>
                                  <td style="width: 100px;">
                                    <a class="btn btn-primary btn-xs col-md-12" href="menu_duzenle.php?UrlID=<?=$m->UrlID?>&type=url">Düzenle</a>
                                  </td>
                                  <td style="width: 100px;">
                                    <button class="btn btn-danger btn-xs col-md-12" name="MenuSil"><i class="fa fa-close"></i> Sil</button>
                                  </td>
                                  <td style="width: 100px;">
                                    <input type="hidden" name="Menu_ID" value="<?=$m->UrlID?>">
                                    <?php
                                    if( $m->IcerikTipiID == '10' ){
                                      ?>
                                      <a class="btn btn-dark btn-xs col-md-12" href="icerik_duzenle.php?UrlID=<?=$m->UrlID?>"> <i class="fa fa-edit"></i> İçerik Düzenle</a>
                                      <?php
                                    }
                                    if( $m->IcerikTipiID == '50' ){
                                      ?>
                                      <a class="btn btn-dark btn-xs col-md-12" href="galeri_duzenle.php?UrlID=<?=$m->UrlID?>"> <i class="fa fa-photo"></i> Galeri Düzenle</a>
                                      <?php
                                    }
                                    if( $m->IcerikTipiID == '70' ){
                                      ?>
                                      <a class="btn btn-dark btn-xs col-md-12" href="referans_duzenle.php?UrlID=<?=$m->UrlID?>"> <i class="fa fa-photo"></i> Referans Düzenle</a>
                                      <?php
                                    }
                                    ?>
                                  </td>
                                </tr>
                              </form>
                              <?php
                            }
                          }
                          ?>
                        </tbody>
                      </table>


                    </div>
                    <!-- Sayfa İçeriği -->
                  </div>
                </div>
              </div>
            </div>
          </div>
        <?php } ?>



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
