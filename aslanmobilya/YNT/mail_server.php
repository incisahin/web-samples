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
                  <h2>Mail Hesabı Ayarları</h2>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                 <!-- Sayfa İçeriği -->

                 <div class="x_content">
                  <br />

                  <?php
                  if(isset( $_POST['AyarlariKaydet'] )){
                    $Host         = p('Host', true);
                    $Port         = p('Port', true);
                    $Username     = p('Username', true);
                    $Username_2   = p('Username_2', true);
                    $Password     = p('Password', true);
                    $SetFromName  = p('SetFromName', true);


                    $AyarVer = $db->prepare("UPDATE site_mailserver SET
                       Host = ?, Port = ?, Username = ?, Username_2 = ?, Password = ?, SetFromName = ?
                      ");
                    $AyarVer = $AyarVer->execute(array(
                       $Host, $Port, $Username, $Username_2, $Password, $SetFromName
                    ));
                    if($AyarVer){
                      echo '<div class="alert alert-info" role="alert">Ayarlar Başarıyla Kaydedildi</div>';
                      go("mail_server.php", 1);
                    }else{
                      echo '<div class="alert alert-danger" role="alert">Veritabanı Hatası</div>';
                    }

                    unset($_POST);
                  }
                  ?>

                  <?php

                  $mail = $db->query("SELECT * FROM site_mailserver WHERE ID = '1' ")->fetch(PDO::FETCH_OBJ);

                  ?>


                  <form method="post" action="" class="form-horizontal form-label-left">

                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Host</label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" class="form-control col-md-7 col-xs-12" name="Host" value="<?=$mail->Host?>">
                        <small>Sunucu tarafından tanımlı mail server adresi</small>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Gönderen Mail Adresi</label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" class="form-control col-md-7 col-xs-12" name="Username" value="<?=$mail->Username?>">
                        <small>Mailleri gönderen adres olarak görünecektir.</small>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Gönderen Mail Parolası</label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" class="form-control col-md-7 col-xs-12" name="Password" value="<?=$mail->Password?>">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Port</label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" class="form-control col-md-7 col-xs-12" name="Port" value="<?=$mail->Port?>">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Mail Otomatik Başlığı</label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" class="form-control col-md-7 col-xs-12" name="SetFromName" value="<?=$mail->SetFromName?>">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">İkincil Mail Adresi <small>2. mail iletilecek adres</small> </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" class="form-control col-md-7 col-xs-12" name="Username_2" value="<?=$mail->Username_2?>">
                        <small>Mailleri gönderen adres olarak görünecektir.</small>
                      </div>
                    </div>

                    <div class="ln_solid"></div>
                    <div class="form-group">
                      <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                        <button type="submit" class="btn btn-success" name="AyarlariKaydet">Kaydet</button>
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
