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




        <div class="">
          <div class="clearfix"></div>

          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Personel İşlemleri  </h2>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <!-- Sayfa İçeriği -->

                  <div class="x_content">

                    <?php

                    if(isset($_GET['ID']) && isset($_GET['type'])){
                      if(g('type')=='sil'){
                        $YetkiSorgula = $db->query("SELECT * FROM personeller WHERE ID = ".g('ID')." ")->fetch(PDO::FETCH_OBJ);
                        if( $YetkiSorgula->YetkiID < $_SESSION['YetkiID'] ){
                          $PersonelSil = $db->prepare("DELETE FROM personeller WHERE ID = :ID AND YetkiID < :YetkiID");
                          $PersonelSil = $PersonelSil->execute(array( "ID" => g('ID'), "YetkiID" => $_SESSION['YetkiID'] ));
                          if($PersonelSil){

                            echo '<div class="alert alert-info" role="alert">Personel Başarıyla Silindi</div>';
                            go("personeller.php", 1);
                          }else{
                            echo '<div class="alert alert-danger" role="alert">Hay Aksi Birşeyler Ters Gitti Tekrar Dene.</div>';
                          }
                        }else{
                          echo '<div class="alert alert-danger" role="alert">Personel Yetkiniz Dışında.</div>';
                        }

                      }
                    }

                    ?>


                    <div class="col-md-2 pull-right">
                      <a href="personel_olustur.php" class="btn btn-primary col-md-12">
                        <i class="fa fa-plus"></i> Personel Oluştur
                      </a>
                    </div>


                    <table class="table jambo_table bulk_action" id="iskelet">
                      <thead>
                        <th>ID</th>
                        <th>Eposta</th>
                        <th>Isim Soyisim</th>
                        <th>Yetki</th>
                        <th>Son Giriş</th>
                        <th>#</th>
                      </thead>
                      <tbody id="liste">
                          <?php
                          $sql_text = "SELECT
                          (SELECT GirisZamani FROM personel_log WHERE PersonelID = p.ID ORDER BY ID DESC LIMIT 1) AS 'SonGiris',
                          p.ID, p.Eposta, CONCAT(p.Adi, p.Soyadi) AS 'PersonelAdi', p.Aktifmi, py.YetkiAdi
                          FROM personeller p
                          LEFT JOIN personel_yetkiler py ON p.YetkiID = py.ID
                          WHERE p.ID != '1'
                          ORDER BY p.ID ASC";

                          $personeller = $db->query( $sql_text , PDO::FETCH_ASSOC);
                          if( $personeller->rowCount()>0 ){
                            foreach ( $personeller as $p ) {
                              ?>
                              <form method="post">
                                <tr id="veriler_<?=$p['ID']?>">
                                  <td class="dark" style="width: 100px;">
                                    <button class="btn btn-dark btn-xs col-md-12"><?=$p['ID']?></button>
                                  </td>
                                  <td class="dark"><b><?=$p['Eposta']?></b></td>
                                  <td class="dark"><b><?=$p['PersonelAdi']?></b></td>
                                  <td class="dark"><b><?=$p['YetkiAdi']?></b></td>
                                  <td class="dark"><b>Son Giriş : <?=$p['SonGiris']?><br><small><?=Aktifmi($p['Aktifmi'])?></small></b></td>
                                  <td style="width: 250px;" >
                                    <a href="personeller.php?ID=<?=$p['ID']?>&type=sil" class="btn btn-danger col-md-12">
                                      <i class="fa fa-close"></i> Personel Sil
                                    </a>
                                  </td>
                                </tr>
                              </form>
                              <?php
                            }
                          }else{
                            ?>
                            <tr>
                              <td colspan="10">Personel Bulunamadı.</td>
                            </tr>
                            <?php
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
