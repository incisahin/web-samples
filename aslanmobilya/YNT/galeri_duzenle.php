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

if(isset($_GET['UrlID'])){
  $UrlID = g('UrlID');
  $Blog = $db->query(
    "SELECT su.UrlID, su.Baslik, su.UstID, su.Keyw
    FROM sayfa_url su
    WHERE su.UrlID = '$UrlID' LIMIT 1")->fetch(PDO::FETCH_OBJ);
}else{
  go('menuler.php');
  exit();
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

  <link href="//fonts.googleapis.com/css?family=Lato:300,300i,400,400i" rel="stylesheet">
  <!-- jQuery -->
  <script src="<?=cdn?>/YNT/vendors/jquery/dist/jquery.min.js"></script>
  <!-- Bootstrap -->
  <link href="<?=cdn?>/YNT/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
  <!-- NProgress -->
  <link href="<?=cdn?>/YNT/vendors/nprogress/nprogress.css" rel="stylesheet">

  <link href="<?=cdn?>/YNT/build/css/custom.min.css" rel="stylesheet">
  <link href="<?=cdn?>/YNT/build/css/main.css" rel="stylesheet">


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
                  <h2><i class="fa fa-edit"></i> <?=$Blog->Baslik?> <small>Link' ini Düzenle</small></h2>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <!-- Sayfa İçeriği -->


                  <?php

                  if(isset($_GET['sil'])){
                    $ResimID = g('sil');
                    $ResimSor = $db->query("SELECT * FROM sayfa_galeri WHERE ID='$ResimID'")->fetch(PDO::FETCH_OBJ);
                    if($ResimSor){
                      $ResimSil = $db->prepare("DELETE FROM sayfa_galeri WHERE ID=? ");
                      $ResimSil->execute(array( $ResimID ));
                      unlink('../'.images.'/galeri/'.$ResimSor->Resim);
                      go('galeri_duzenle.php?UrlID='.$UrlID);
                    }
                  }


                  if(isset($_POST['ResimYukle'])){
                    $ResimAdi = p('ResimAdi');

                    /******** RESİM YÜKLEME İŞLEMLERİ *******/
                    $resimler = array();
                    foreach ($_FILES['Resim'] as $k => $l) {
                      foreach ($l as $i => $v) {
                        if (!array_key_exists($i, $resimler))
                          $resimler[$i] = array();
                        $resimler[$i][$k] = $v;
                      }
                    }
                    $YuklenenResimler ='';
                    foreach ($resimler as $resim){
                      $image = new \Verot\Upload\Upload($resim);
                      if ($image->uploaded) {
                        $image->file_new_name_body = sha1(md5(date("1YmdHis")));
                        $image->allowed = array('image/jpeg','image/jpg','image/gif','image/png');
                        $image->mime_check = true;
                        $image->no_script = true;
                        $image->auto_rename = true;
                        $image->image_convert = 'webp';
                        $image->webp_quality = 50;
                        $image->image_resize = true;
                        $image->image_y = 500;
                        $image->image_ratio_x = true;
                        $image->Process( '../'.images.'/galeri' );
                        if (!file_exists('../'.images.'/galeri/index.html')) { touch('../'.images.'/galeri/index.html'); }
                      }
                      $YuklenenResimler.=$image->file_dst_name;

                      if(!empty($image->file_dst_name) && !empty($_FILES['Resim'])){
                        $ResimOlustur = $db->prepare("INSERT INTO sayfa_galeri SET Baslik=?, Resim=?, UrlID=? ");
                        $ResimOlustur = $ResimOlustur->execute(array( $ResimAdi, "galeri/".$image->file_dst_name, $UrlID ));
                      }
                    }

                    echo '<div class="alert alert-info" role="alert">Resim başarıyla oluşturuldu</div>';
                    go("galeri_duzenle.php?UrlID=".$UrlID, 1);
                    /******** RESİM YÜKLEME İŞLEMLERİ *******/

                  }
                  ?>

                  <form method="post" action="" class="form-horizontal form-label-left" enctype="multipart/form-data">

                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Başlık</label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" class="form-control col-md-7 col-xs-12" name="ResimAdi" placeholder="Resim Başlığı">
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Resim Seç</label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="file" class="form-control btn btn-primary col-md-7 col-xs-12" name="Resim[]" required="required" accept="image/png, image/jpeg" multiple="">
                      </div>
                    </div>

                    <div class="ln_solid"></div>
                    <div class="form-group">
                      <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                        <button type="submit" class="btn btn-success" name="ResimYukle"><i class="fa fa-plus"></i> Resim Ekle</button>
                      </div>
                    </div>

                  </form>



                  <!-- Sayfa İçeriği -->
                </div>
              </div>
            </div>

            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2><i class="fa fa-edit"></i> <?=$Blog->Baslik?> <small> Sayfasının Resimleri</small></h2>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <!-- Sayfa İçeriği -->

                  <form method="post" action="" class="form-horizontal form-label-left">
                    <div class="row">
                      <?php
                      $Galeri = $db->query("SELECT * FROM sayfa_galeri WHERE UrlID = '$UrlID' ORDER BY UrlID DESC")->fetchAll(PDO::FETCH_OBJ);
                      if($Galeri){
                        foreach ( $Galeri as $key ) {
                          ?>
                          <div class="col-md-3" style="margin-bottom: 10px;">
                            <div class="row">
                              <div class="col-md-12 view view-first img-250px">
                                <img src="../<?=images?>/<?=$key->Resim?>" alt="image"  />
                              </div>
                              <div class="caption">
                                <p>Başlık : <?=$key->Baslik?></p>
                                <a href="galeri_duzenle.php?UrlID=<?=$Blog->UrlID?>&sil=<?=$key->ID?>" class="btn btn-danger btn-xs col-md-4 pull-right"><i class="fa fa-remove"></i> Sil</a>
                                <p> </p>
                              </div>
                            </div>
                          </div>
                          <?php
                        }
                      }else{
                        echo "Hiç resim bulunamadı.";
                      }
                      ?>
                    </div>
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

  <!-- Custom Theme Scripts -->
  <script src="<?=cdn?>/YNT/build/js/custom.js"></script>


</body>
</html>
