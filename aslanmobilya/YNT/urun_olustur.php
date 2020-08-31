<?php
require_once 'inc.php';
require_once '../include/ayarlar.php';
require_once '../include/fonksiyon.php';
require_once '../include/menu_duzen.php';
require_once '../include/class.upload.php';
require_once '../include/f_urunler.php';
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
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Ürün Oluştur</h2>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <!-- Sayfa İçeriği -->
                  <div class="x_content">

                    <?php

                    //print_r($_POST);

                    if(isset($_POST['UrunOlustur'])){
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
                      if(!$SeoSor){
                        $UrlOlustur = $db->prepare("INSERT INTO sayfa_url SET IcerikTipiID=?, UstID=?, SeoUrl=?, GeciciBaslik=?, GeciciDesc=?, GeciciKeyw=?, OlusturmaTarihi=?");
                        $UrlOlustur = $UrlOlustur->execute(array( '30', '4', $UrunSeo, $UrunAdi, $UrunBilgi, $UrunKeyw, $tarih ));
                        if($UrlOlustur){
                          $UrlID = $db->lastInsertId();

                          /***************** Ürün Yapı Kur ******************/
                          $UrunOlustur = $db->prepare("INSERT INTO urun_yapi SET UrlID=?, AnaKategoriID=?, KategoriID=?, Baslik=?, Bilgi=?, KisaBilgi=?, KurID=?, Fiyat=?, UrunKodu=?");
                          $UrunOlustur = $UrunOlustur->execute(array( $UrlID, $AnaKat, $KategoriID, $UrunAdi, $UrunBilgi, $UrunBilgi, $UrunKur, $UrunFiyat, $UrunKodu ));
                          if($UrunOlustur){
                            $UrunID = $db->lastInsertId();
                            go('urun_olustur.php?UrunID='.$UrunID);
                          }else{
                            echo "Urün Oluşturma Hatası Meydana Geldi !!!";
                            $UrlSil = $db->prepare("DELETE FROM sayfa_url WHERE ID = '$UrlID' ");
                            $UrlSil = $UrlSil->execute(array( ));
                          }
                          /***************** Ürün Yapı Kur ******************/

                        }else{
                          echo "Url Oluşturma Hatası Meydana Geldi !!!";
                        }
                      }else{
                        echo "Seo Ürün Adının Benzeri Bulundu Lüften Değişiklik Yapınız.";
                      }
                    }

                    if (!empty($_FILES)) {
                      $UrunID = g('UrunID');
                      $UrunBilgi = $db->query("SELECT Baslik FROM urun_yapi WHERE ID = '$UrunID' ")->fetch(PDO::FETCH_OBJ);
                      require_once '../include/class.upload.php';

                      $image = new \Verot\Upload\Upload($_FILES['file']);
                      if ( $image->uploaded ) {
                        $image->file_new_name_body = seflink($UrunBilgi->Baslik);
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
                          $GaleriGuncelle = $db->prepare("UPDATE urun_galeri SET Varsayilan=? WHERE UrunID=? ");
                          $GaleriGuncelle = $GaleriGuncelle->execute(array( false, $UrunID ));
                          $GaleriOlustur = $db->prepare("INSERT INTO urun_galeri SET UrunID=?, Resim=?, Varsayilan=?");
                          $GaleriOlustur = $GaleriOlustur->execute(array( $UrunID, $UrunResim, '1' ));

                        }


                      }
                    }

                    ?>
                    <?php if(isset($_GET['UrunID'])){ $UrunID = g('UrunID');?>
                    <p>Ürün fotoğraflarını bu alana tıklayıp yükleyebilirsiniz.</p>
                    <p>Yükleme tamamlanınca sayfayı yenileyiniz. <a href="<?=$_SERVER['REQUEST_URI'];?>" class="btn btn-primary btn-xs"><i class="fa fa-refresh"></i> Yenile</a></p>


                    <form action="urun_olustur.php?UrunID=<?=$UrunID?>" class="dropzone"></form>
                    <br />
                    <br />
                    <br />
                    <br />
                    <form method="post" action="" class="form-horizontal form-label-left">
                      <?php
                      $Galeri = $db->query("SELECT * FROM urun_galeri WHERE UrunID = '$UrunID' ORDER BY ID DESC",PDO::FETCH_OBJ);
                      if($Galeri){
                        foreach ( $Galeri as $key ) {
                          ?>

                          <div class="col-md-3" style="margin-bottom: 10px;">
                            <div class="thumbnail" style="border: 1px solid #cdf; margin-bottom: 5px;">
                              <div class="col-md-12 view view-first" style="height: 100%;">
                                <img src="../img/<?=urunResimKontrol($key->Resim)?>" alt="image" style="width:100%;height:100%;object-fit:contain;" />
                              </div>
                            </div>
                            <div class="col-md-12">
                              <?php if($key->Varsayilan == 0){ ?>
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
                  <?php } ?>

                  <?php if(!isset($_GET['UrunID'])){ ?>
                    <form method="post" action="" class="form-horizontal form-label-left">

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Kategori Seçiniz <small>*</small>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select class="form-control col-md-7 col-xs-12" name="KategoriID" required>
                            <option value=""> - Seçiniz - </option>
                            <?php
                            $category_list = $db->query("SELECT * FROM urun_kategori", PDO::FETCH_OBJ)->fetchAll();
                            admin_menu_option_kategoriler( bulidTree( $category_list ) );
                            ?>
                          </select>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Ürün Adı <small>*</small>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" class="form-control col-md-7 col-xs-12" name="UrunAdi" id="UrunAdi" required onkeyup="SefLinkOlustur();">
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Ürün Seo Url <small>*</small>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" class="form-control col-md-7 col-xs-12" name="UrunSeo" id="UrunSeo" required>
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
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <textarea class="form-control col-md-7 col-xs-12" name="UrunBilgi" placeholder="Ürün hakkında detaylı bilgi yazabilirsiniz." rows="4"></textarea>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Anahtar Kelime</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="tags_1" name="Keyw" type="text" class="tags form-control" />
                          <small>Bir kaç anahtar kelime yaazdıktan sonra virgül ile ayırınız.</small>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Fiyat
                        </label>
                        <div class="col-md-5 col-sm-5 col-xs-12">
                          <input type="text" class="form-control col-md-2 col-xs-2" name="UrunFiyat">
                        </div>
                        <div class="col-md-1 col-sm-1 col-xs-1">
                          <select class="form-control" name="UrunKur">
                            <?php
                            $kur_list = $db->query("SELECT * FROM urun_kurlari", PDO::FETCH_OBJ)->fetchAll();
                            if($kur_list){
                              foreach ( $kur_list as $key ) {
                                if( var_kur == $key->ID )
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
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" class="form-control col-md-2 col-xs-2" name="GitipKodu">
                        </div>
                      </div>

                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          <button type="submit" class="btn btn-success" name="UrunOlustur"><i class="fa fa-plus"></i> Oluştur</button>
                        </div>
                      </div>

                    </form>
                  <?php } ?>


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
<!-- jQuery Tags Input -->
<script src="<?=cdn?>/YNT/vendors/jquery.tagsinput/src/jquery.tagsinput.js"></script>
<!-- Dropzone.js -->
<script src="<?=cdn?>/YNT/vendors/dropzone/dist/dropzone.js"></script>

<!-- Custom Theme Scripts -->
<script src="<?=cdn?>/YNT/build/js/custom.js"></script>



</body>
</html>
