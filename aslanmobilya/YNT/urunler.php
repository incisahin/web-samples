<?php 
require_once 'inc.php';
require_once '../include/ayarlar.php';
require_once '../include/fonksiyon.php';
require_once '../include/menu_duzen.php';
require_once '../include/class.upload.php';
require_once '../include/f_urunler.php';
require_once '../include/f_urunler_where.php';
define("admin", true);

if(!isset($_SESSION['Oturum'])){
  header("location: giris-yap.php");
}


$Kategori       = "";
if(getCekme('Kategori'))
  $Kategori       = getCekme('Kategori');
if(getCekme('AltKategori'))
  $Kategori    = getCekme('AltKategori');
$sql_sayfada    = '25';
if(kontrol_dizi(getCekme(), 'sayfaadet')){
  $sql_sayfada = getCekme('sayfaadet');
}
$sql_sayfa      = '0';
if(kontrol_dizi(getCekme(), 'sayfa')){
  $sql_sayfa = getCekme('sayfa');
}


$sql = SelectSorgusu().WhereSorgusu($Kategori);

/************* Sayfa Hesaplamaları *************/
$toplam_icerik  = Sayfalama( $sql, getCekme() );
$toplam_sayfa   = ceil(intval($toplam_icerik) / intval($sql_sayfada));
if($sql_sayfa < 1) $sql_sayfa = 1; 
if($sql_sayfa > $toplam_sayfa && $toplam_sayfa != 0) $sql_sayfa = $toplam_sayfa;
$sql_limit = intval( ($sql_sayfa - 1) ) * $sql_sayfada ;
/************* Sayfa Hesaplamaları *************/

$sql .= OrderBy()." LIMIT ". $sql_limit . ', ' . $sql_sayfada;




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
                    <h2>Ürünler</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <!-- Sayfa İçeriği -->

                    <div class="x_content">

                      <?php 
                      if( isset($_GET['UrunSil']) ){

                        $Urun = $db->query("SELECT ID FROM urun_yapi WHERE UrlID = '".g('UrunSil')."'")->fetch(PDO::FETCH_OBJ);
                        $Galeri = $db->query("SELECT * FROM urun_galeri WHERE UrunID = '".$Urun->ID."'")->fetchAll(PDO::FETCH_OBJ);
                        foreach ( $Galeri as $key ) {
                          if(file_exists('../img/urunler/'.$key->Resim))
                            unlink('../img/urunler/'.$key->Resim);
                        }
                        $GaleriSil = $db->prepare("DELETE FROM urun_galeri WHERE UrunID=? ");
                        $GaleriSil = $GaleriSil->execute(array( $Urun->ID ));

                        $Silq = $db->prepare("DELETE FROM sayfa_url WHERE ID = :ID");
                        $Silex = $Silq->execute(array( "ID" => $_GET['UrunSil'] ));
                        if($Silex){
                          echo '<div class="alert alert-info" role="alert">Ürün Başarıyla Silindi</div>';
                          go("urunler.php", 3);
                        }else{
                          echo '<div class="alert alert-danger" role="alert">Ürün Silinemedi</div>';
                        }
                      }
                      ?>


                      <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                        <form class="text-center">
                          <?php if( getCekme('Kategori') ){ ?>
                            <input type="hidden" name="Kategori" value="<?=getCekme('Kategori')?>">
                          <?php } ?>
                          <?php if( getCekme('AltKategori') ){ ?>
                            <input type="hidden" name="AltKategori" value="<?=getCekme('AltKategori')?>">
                          <?php } ?>
                          <?php
                          if($toplam_sayfa>0){
                            echo '<button name="sayfa" class="btn btn-default" value="1">&laquo; İlk</button>'; 
                            for($s = $sql_sayfa-3; $s <= $sql_sayfa+3; $s++) {
                              if($sql_sayfa == $s && $s != 0) { 
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
                          <th>Urun ID</th>
                          <th>GITIP KODU</th>
                          <th>Ürün Resim</th>
                          <th>Menü Adı</th>
                          <th>Kategori</th>
                          <th>Fiyat</th>
                          <th>Seo Url Linki</th>
                          <th>Düzenle</th>
                          <th>#</th>
                          <th>#</th>
                        </thead>
                        <tbody>
                          <?php 

                          $menuler = $db->query( $sql , PDO::FETCH_OBJ);
                          if( $menuler ){
                            foreach ( $menuler as $m ) {
                              ?>
                              <form method="post">
                                <tr>
                                  <td class="dark" style="width: 100px;"><button class="btn btn-default btn-xs col-md-12"><?=$m->UrunID?></button></td>
                                  <td class="dark" style="width: 100px;"><button class="btn btn-default btn-xs col-md-12"><?=$m->UrunKodu?></button></td>
                                  <td>
                                    <ul class="list-inline">
                                      <li>
                                        <img src="../img/<?=urunResimKontrol($m->Resim)?>" class="avatar" alt="Avatar">
                                      </li>
                                    </ul>
                                  </td>
                                  <td class="dark" style="width: 200px">
                                    <b><?=$m->Baslik?></b>                                    
                                  </td>
                                  <td class="dark"><b><?=kategori_cek($m->KategoriID)?></b></td>
                                  <td class="dark">
                                    <b>
                                      <?php 
                                      if( kampanyaVarmi( $m->UrunID ) ){
                                        echo "Kampanyalı : " . $m->KurSembol . $m->KampFiyat;
                                        echo "<br><small>Normal : " . $m->KurSembol . $m->Fiyat . "</span>";
                                      }else if( !empty( $m->Fiyat ) ){
                                        echo $m->KurSembol . $m->Fiyat;
                                      }else{
                                        echo "-";
                                      }
                                      ?>
                                    </b>
                                  </td>
                                  <td class="dark" style="width: 200px"><b><?=$m->SeoUrl?></b></td>
                                  <td style="width: 100px;">
                                    <a class="btn btn-primary btn-xs col-md-12" href="urun_duzenle.php?DuzenID=<?=$m->UrunID?>"><i class="fa fa-edit"></i> Düzenle</a>
                                  </td>
                                  <td style="width: 100px;">
                                    <a class="btn btn-danger btn-xs col-md-12" href="urunler.php?UrunSil=<?=$m->UrlID?>"><i class="fa fa-close"></i> Sil</a>
                                  </td>
                                  <td style="width: 100px;">
                                    <a class="btn btn-dark btn-xs col-md-12" target="_blank" href="<?=site_tam_url?>/urunler/<?=$m->SeoUrl?>"><i class="fa fa-search"></i> Gözat</a>
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
