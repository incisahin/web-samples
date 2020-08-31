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
    "SELECT su.UrlID, su.Baslik, su.UstID, su.Keyw, sy.Text
    FROM sayfa_url su
    LEFT JOIN sayfa_yazi sy ON su.UrlID = sy.UrlID
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

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.css">


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
                  <h2><i class="fa fa-edit"></i> <?=$Blog->Baslik?> Link' ini Düzenle</h2>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <!-- Sayfa İçeriği -->

                  <div class="x_content">
                    <br />

                    <?php
                    if(isset($_POST['Icerik_Kaydet'])){
                      $Yazi = $_POST['Blog'];

                      $SayfaKontrol = $db->query("SELECT * FROM sayfa_yazi WHERE UrlID='$UrlID'")->fetch(PDO::FETCH_OBJ);
                      if($SayfaKontrol){
                        $YaziGuncelle = $db->prepare("UPDATE sayfa_yazi SET Text=? WHERE UrlID=?");
                        $YaziGuncelle = $YaziGuncelle->execute(array( $Yazi, $UrlID ));
                        if($YaziGuncelle){
                          echo '<div class="alert alert-info" role="alert">Yazı başarıyla güncellendi</div>';
                          go("icerik_duzenle.php?UrlID=".$UrlID, 1);
                        }
                      }else{
                        $YaziOlustur = $db->prepare("INSERT INTO sayfa_yazi SET Text=?, UrlID=?");
                        $YaziOlustur = $YaziOlustur->execute(array( $Yazi, $UrlID ));
                        if($YaziOlustur){
                          echo '<div class="alert alert-info" role="alert">Yazı başarıyla oluşturuldu</div>';
                          go("icerik_duzenle.php?UrlID=".$UrlID, 1);
                        }
                      }
                    }
                    ?>

                    <form method="post" enctype="multipart/form-data" class="form-horizontal form-label-left">

                      <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                          <textarea name="Blog" id="ta-1" cols="30" rows="30"><?php if( !empty($Blog->Text) ){print_r($Blog->Text);}?></textarea>
                        </div>
                      </div>

                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                          <button type="submit" class="btn btn-success col-md-2 pull-right" name="Icerik_Kaydet">Kaydet</button><br><br>
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

  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.js"></script>
  <script src="<?=cdn?>/YNT/vendors/summernote/js.js"></script>


</body>
</html>
