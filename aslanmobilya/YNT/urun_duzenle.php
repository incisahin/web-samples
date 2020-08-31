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

if(!isset($_GET['DuzenID'])){
  go('urunler.php');
  exit();
}

$UrunID = g('DuzenID');
$AnaKat = "";
$AltKat = "";
$sql_text = SelectSorgusu() . " WHERE uy.ID = '$UrunID' LIMIT 1";
$Urun = $db->query( $sql_text )->fetch(PDO::FETCH_OBJ);

$KategoriID = explode(',', $Urun->KategoriID);
if(count($KategoriID)){
  $AnaKat = $KategoriID['0'];
  $AltKat = $KategoriID['1'];
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
  <!-- Dropzone.js -->
  <link href="<?=cdn?>/YNT/vendors/dropzone/dist/min/dropzone.min.css" rel="stylesheet">

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
            <div class="col-md-6 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2><?=$Urun->Baslik?> <small>- Düzenle</small></h2>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <!-- Sayfa İçeriği -->

                  <?php

                  //print_r($Urun);

                  if(isset($_POST['UrunDuzenle'])){

                    $UrlID      = p('UrunDuzenle');

                    $KategoriID = p('KategoriID');
                    $UrunAdi    = p('UrunAdi');
                    $UrunSeo    = p('UrunSeo');
                    $UrunBilgi  = p('UrunBilgi');
                    $UrunKeyw   = p('Keyw');
                    $UrunFiyat  = p('UrunFiyat');
                    $UrunKur    = p('UrunKur');
                    $UrunKodu   = p('GitipKodu');

                    $Kategori   = explode(',', $KategoriID);
                    $AnaKat     = trim($Kategori['0']);
                    $AltKat     = trim($Kategori['1']);

                    $SeoSor = $db->query("SELECT * FROM sayfa_url WHERE SeoUrl = '$UrunSeo' ")->fetch(PDO::FETCH_OBJ);
                    if(!$SeoSor || $Urun->SeoUrl == $UrunSeo ){
                      $UrlOlustur = $db->prepare("UPDATE sayfa_url SET IcerikTipiID=?, UstID=?, SeoUrl=?, GeciciBaslik=?, GeciciDesc=?, GeciciKeyw=?, OlusturmaTarihi=? WHERE ID=? ");
                      $UrlOlustur = $UrlOlustur->execute(array( '30', '4', $UrunSeo, $UrunAdi, $UrunBilgi, $UrunKeyw, $tarih, $UrlID ));
                      if($UrlOlustur){

                        $UrunOlustur = $db->prepare("UPDATE urun_yapi SET AnaKategoriID=?, KategoriID=?, Baslik=?, Bilgi=?, KisaBilgi=?, KurID=?, Fiyat=?, UrunKodu=? WHERE UrlID=?");
                        $UrunOlustur = $UrunOlustur->execute(array( $AnaKat, $KategoriID, $UrunAdi, $UrunBilgi, $UrunBilgi, $UrunKur, $UrunFiyat, $UrunKodu, $UrlID ));
                        if($UrunOlustur){
                          go('urun_duzenle.php?DuzenID='.$Urun->UrunID);
                        }else{
                          echo "Urün Düzenleme Hatası Meydana Geldi !!!";
                        }

                      }else{
                        echo "Url Guncelleme Hatası Meydana Geldi !!!";
                      }
                    }else{
                      echo "Seo Ürün Adının Benzeri Bulundu Lüften Değişiklik Yapınız.";
                    }
                  }

                  ?>

                  <form method="post" action="" class="form-horizontal form-label-left">

                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Kategori Seçiniz <?=$AltKat?><small>*</small>
                      </label>
                      <div class="col-md-9 col-sm-9 col-xs-12">
                        <select class="form-control col-md-7 col-xs-12" name="KategoriID" required>
                          <option value=""> - Seçiniz - </option>
                          <?php
                          $category_list = $db->query("SELECT * FROM urun_kategori", PDO::FETCH_OBJ)->fetchAll();
                          admin_menu_option_kategoriler( bulidTree( $category_list ), $AltKat );
                          ?>
                        </select>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Ürün Adı <small>*</small>
                      </label>
                      <div class="col-md-9 col-sm-9 col-xs-12">
                        <input type="text" class="form-control col-md-7 col-xs-12" name="UrunAdi" id="UrunAdi" required onkeyup="SefLinkOlustur();" value="<?=$Urun->Baslik?>">
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Ürün Seo Url <small>*</small>
                      </label>
                      <div class="col-md-9 col-sm-9 col-xs-12">
                        <input type="text" class="form-control col-md-7 col-xs-12" name="UrunSeo" id="UrunSeo" required value="<?=$Urun->SeoUrl?>">
                        <small>Ürün adı değişirse otomatik değişecektir.</small>
                      </div>
                    </div>

                    <script type="text/javascript">
                      function SefLinkOlustur(){
                        var MenuAdi       = document.getElementById("UrunAdi").value;
                        $.ajax({
                          type:"post",
                          url:"inc/ajax.php",
                          data:{"MenuAdi":MenuAdi},
                          success:function(e)
                          {
                            document.getElementById('UrunSeo').value = e;
                          }
                        });
                      }
                    </script>

                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Ürün Bilgi <small>*</small>
                      </label>
                      <div class="col-md-9 col-sm-9 col-xs-12">
                        <textarea class="form-control col-md-7 col-xs-12" name="UrunBilgi" placeholder="Ürün hakkında detaylı bilgi yazabilirsiniz." rows="4"><?=$Urun->Bilgi?></textarea>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Anahtar Kelime</label>
                      <div class="col-md-9 col-sm-9 col-xs-12">
                        <input id="tags_1" name="Keyw" type="text" class="tags form-control"  value="<?=$Urun->GeciciKeyw?>" />
                        <small>Bir kaç anahtar kelime yaazdıktan sonra virgül ile ayırınız.</small>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Fiyat
                      </label>
                      <div class="col-md-7 col-sm-7 col-xs-12">
                        <input type="text" class="form-control col-md-2 col-xs-2" name="UrunFiyat" value="<?=$Urun->Fiyat?>">
                      </div>
                      <div class="col-md-2 col-sm-2 col-xs-1">
                        <select class="form-control" name="UrunKur">
                          <?php
                          $kur_list = $db->query("SELECT * FROM urun_kurlari", PDO::FETCH_OBJ)->fetchAll();
                          if($kur_list){
                            foreach ( $kur_list as $key ) {
                              if( $Urun->KurID == $key->ID )
                                echo "<option value='".$key->ID."' selected>".$key->Sembol." ".$key->Kur."</option>";
                              else
                                echo "<option value='".$key->ID."'>".$key->Sembol." ".$key->Kur."</option>";
                            }
                          }
                          ?>
                        </select>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">GİTİP KODU
                      </label>
                      <div class="col-md-9 col-sm-9 col-xs-12">
                        <input type="text" class="form-control col-md-2 col-xs-2" name="GitipKodu" value="<?=$Urun->UrunKodu?>">
                      </div>
                    </div>

                    <div class="ln_solid"></div>
                    <div class="form-group">
                      <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                        <button type="submit" class="btn btn-primary col-md-4" name="UrunDuzenle" value="<?=$Urun->UrlID?>"><i class="fa fa-edit"></i> Düzenle</button>
                        <a class="btn btn-dark col-md-4 pull-right" target="_blank" href="<?=site_tam_url?>/urunler/<?=$Urun->SeoUrl?>"><i class="fa fa-search"></i> Gözat</a>
                      </div>
                    </div>

                  </form>


                  <!-- Sayfa İçeriği -->
                </div>
              </div>
            </div>


            <div class="col-md-6 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Ürün Oluştur</h2>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <!-- Sayfa İçeriği -->

                  <?php


                  if (!empty($_FILES)) {
                    require_once '../include/class.upload.php';

                    $image = new \Verot\Upload\Upload($_FILES['file']);
                    if ( $image->uploaded ) {
                      $image->file_new_name_body = seflink($Urun->Baslik);
                        //$image->file_new_name_body = "urun";
                      $image->allowed = array('image/jpeg','image/jpg','image/gif','image/png');
                      $image->mime_check = true;
                      $image->no_script = true;
                      $image->auto_rename = true;
                      $image->image_convert = 'jpg';
                      $image->image_resize = true;
                      $image->image_x = 800;
                      $image->image_ratio_y = true;
                      $image->Process( '../'.images.'/urunler/'.$UrunID.'' );
                      if (!file_exists('../'.images.'/urunler/'.$UrunID.'/index.html')) { touch('../'.images.'/urunler/'.$UrunID.'/index.html'); }
                      $UrunResim = $UrunID.'/'.$image->file_dst_name;
                      if ($image->processed) {
                        $image->clean();
                        $UrunOlustur = $db->prepare("INSERT INTO urun_galeri SET UrunID=?, Resim=?");
                        $UrunOlustur = $UrunOlustur->execute(array( $UrunID, $UrunResim ));
                      }

                    }
                  }

                  ?>

                  <p>Ürün fotoğraflarını bu alana tıklayıp yükleyebilirsiniz.</p>
                  <p>Yükleme tamamlanınca sayfayı yenileyiniz. <a href="<?=$_SERVER['REQUEST_URI'];?>" class="btn btn-primary btn-xs"><i class="fa fa-refresh"></i> Yenile</a></p>
                  <form action="urun_duzenle.php?DuzenID=<?=g('DuzenID')?>" class="dropzone"></form>
                  <hr>

                  <?php

                  if(isset($_GET['ResimID']) && isset($_GET['type'])){
                    if(g('type')=='Sil'){
                      $Galeri = $db->query("SELECT * FROM urun_galeri WHERE ID = '".g('ResimID')."'")->fetch(PDO::FETCH_OBJ);
                      $GaleriSil = $db->prepare("DELETE FROM urun_galeri WHERE ID=? ");
                      $GaleriSil = $GaleriSil->execute(array( g('ResimID') ));
                      if(file_exists('../img/urunler/'.$Galeri->Resim))
                        unlink('../img/urunler/'.$Galeri->Resim);
                      go('urun_duzenle.php?DuzenID='.$UrunID);
                    }
                    if(g('type')=='Vitrin'){
                      $GaleriGuncelle = $db->prepare("UPDATE urun_galeri SET Varsayilan=? WHERE UrunID=? ");
                      $GaleriGuncelle = $GaleriGuncelle->execute(array( false, $UrunID ));

                      $GaleriGuncelle = $db->prepare("UPDATE urun_galeri SET Varsayilan=? WHERE ID=? ");
                      $GaleriGuncelle = $GaleriGuncelle->execute(array( '1', g('ResimID') ));
                      go('urun_duzenle.php?DuzenID='.$UrunID);
                    }
                  }

                  ?>

                  <form method="post" action="" class="form-horizontal form-label-left">
                    <?php
                    $Galeri = $db->query("SELECT * FROM urun_galeri WHERE UrunID = '$UrunID' ORDER BY ID DESC")->fetchAll(PDO::FETCH_OBJ);
                    if($Galeri){
                      foreach ( $Galeri as $key ) {
                        ?>

                        <div class="col-md-4" style="margin-bottom: 10px;">
                          <div class="thumbnail" style="border: 1px solid #cdf; margin-bottom: 5px;">
                            <div class="col-md-12 view view-first" style="height: 100%;">
                              <img src="../img/<?=urunResimKontrol($key->Resim)?>" alt="image" style="width:100%;height:100%;object-fit:contain;" />
                            </div>
                          </div>
                          <div class="col-md-12">
                            <?php if($key->Varsayilan == 0 ){ ?>
                              <a href="urun_duzenle.php?DuzenID=<?=$UrunID?>&ResimID=<?=$key->ID?>&type=Vitrin" class="btn btn-primary btn-xs col-md-4"><i class="fa fa-camera"></i> Vitrin</a>
                            <?php }else{ ?>
                              <a href="#" class="btn btn-dark btn-xs col-md-5"><i class="fa fa-camera"></i> Varsayılan</a>
                            <?php } ?>
                            <a href="urun_duzenle.php?DuzenID=<?=$UrunID?>&ResimID=<?=$key->ID?>&type=Sil" class="btn btn-danger btn-xs col-md-4 pull-right"><i class="fa fa-remove"></i> Sil</a>
                          </div>
                        </div>

                        <?php
                      }
                    }
                    ?>
                  </form>

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
  <!-- jQuery Tags Input -->
  <script src="<?=cdn?>/YNT/vendors/jquery.tagsinput/src/jquery.tagsinput.js"></script>
  <!-- Dropzone.js -->
  <script src="<?=cdn?>/YNT/vendors/dropzone/dist/dropzone.js"></script>

  <!-- Custom Theme Scripts -->
  <script src="<?=cdn?>/YNT/build/js/custom.js"></script>



</body>
</html>
