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
    "SELECT su.ID, su.GeciciBaslik, su.UstID, su.GeciciKeyw, sy.Text
    FROM sayfa_url su
    LEFT JOIN sayfa_yazi sy ON su.ID = sy.UrlID
    WHERE su.ID = '$UrlID' LIMIT 1")->fetch(PDO::FETCH_OBJ);
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



        <div class="">
          <div class="clearfix"></div>

          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2><i class="fa fa-edit"></i> <?=$Blog->GeciciBaslik?> Link' ini Düzenle</h2>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <!-- Sayfa İçeriği -->

                  <div class="x_content">
                    <br />

                    <form method="post" enctype="multipart/form-data" class="form-horizontal form-label-left">

                      <input type="hidden" name="url_id" value="<?=$_GET['ID']?>">
                      <input type="hidden" name="Baslik" value="<?=$Icerik->Url_Baslik?>">


                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Sayfa Başlık 
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <label><?=$Icerik->Url_Baslik?></label>
                        </div>
                      </div>

                      <?php if($Icerik->resim_yolu){ ?>
                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12">Sayfa Kapak Resmi
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <a href="<?=site_tam_url."/images/icerik/".$Icerik->resim_yolu?>" class="form-control btn btn-primary"><i class="fa fa-eye"></i> Kapak Resmini Gör</a>
                          </div>
                        </div>
                      <?php } ?>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Sayfa Kapak Resmi
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="file" name="KapakResmi" class="form-control" accept="image/png, image/jpeg">
                          <small>Gerekli ise kullanınız</small>
                        </div>
                      </div>

                      <div class="clearfix"></div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Sayfa İçeriği</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <textarea id="editor_classic" name="icerik" rows="100"><?php if($Icerik->icerik){echo $Icerik->icerik;} ?></textarea>
                        </div>
                      </div>

                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          <button  onclick="sun_save()" type="submit" class="btn btn-success" name="Icerik_Kaydet">Kaydet</button><br><br>
                          <small class="dark" style="color: red;"><b>Kaydet Butonuna basmadan önce editördeki metni kaydetmeyi unutmayınız..</b></small>
                        </div>
                      </div>

                    </form>



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