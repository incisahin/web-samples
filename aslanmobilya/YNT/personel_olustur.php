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
                  <h2>Personel Oluştur  </h2>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <!-- Sayfa İçeriği -->

                  <div class="x_content">


                    <div id="alert_placeholder"></div>

                    <form method="post" class="form-horizontal form-label-left input_mask">

                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Personel Adı <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input class="form-control" type="text" name="PersonelAdi" placeholder="Personel Adı Giriniz" required>
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Personel Soyadi <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input class="form-control" type="text" name="PersonelSoyadi" placeholder="Personel Soyadı Giriniz" required>
                        </div>
                      </div>

                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Telefon No <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input class="form-control" type="text" name="PersonelTelefon" required data-inputmask="'mask' : '09999999999'" placeholder="Başına 0 Ekleyerek Giriniz Lütfen. Ör:05xxxxxxxxx">
                        </div>
                      </div>

                      <hr>

                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kullaniciadi">Eposta <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input class="form-control col-md-7 col-xs-12 has-feedback-left" data-validate-length-range="6" data-validate-words="2" name="kullaniciadi" id="kullaniciadi" placeholder="Kullanıcı Adı" required="required" type="email">
                          <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="parola">Parola <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input class="form-control col-md-7 col-xs-12 has-feedback-left" data-validate-length-range="6" data-validate-words="2" name="parola" id="parola" placeholder="Parola" required="required" type="password">
                          <span class="fa fa-key form-control-feedback left" aria-hidden="true"></span>
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="parola2">Parola Tekrar <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input class="form-control col-md-7 col-xs-12 has-feedback-left" data-validate-length-range="6" data-validate-words="2" name="parola2" id="parola2" placeholder="Parola" required="required" type="password">
                          <span class="fa fa-key form-control-feedback left" aria-hidden="true"></span>
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="parola2">Yetki Tipi <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select class="form-control col-md-7 col-xs-12 has-feedback-left" name="YetkiID" required>
                            <option value=""> - Seçiniz - </option>
                            <?php 
                            $yetkiler = $db->query( "SELECT * FROM personel_yetkiler WHERE ID <= '".$_SESSION['YetkiID']."'" , PDO::FETCH_ASSOC);
                            if( $yetkiler ){
                              foreach ( $yetkiler as $y ) {
                                echo '<option value="'.$y['ID'].'">'.$y['YetkiAdi'].'</option>';
                              }
                            }
                            ?>
                          </select>
                          <span class="fa fa-bookmark form-control-feedback left" aria-hidden="true"></span>
                        </div>
                      </div>

                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-md-offset-3">
                          <button id="send" name="PersonelOlustur" type="submit" class="btn btn-success"><i class="fa fa-plus"></i> Personel Oluştur</button>
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
  <!-- jquery.inputmask -->
  <script src="//library.akbimbilgisayar.com/bayiscripti/vendors/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js"></script>


  <!-- Custom Theme Scripts -->
  <script src="<?=cdn?>/YNT/build/js/custom.js"></script>


</body>
</html>

<script>
  function showalert(message,alerttype) {

    $('#alert_placeholder').append('<div id="alertdiv" class="alert alert-'+alerttype+'  alert-dismissible"><a class="close" data-dismiss="alert">×</a><span>'+message+'</span></div>')
  }
</script>​
<?php

if(isset($_POST['PersonelOlustur']) && $_SESSION['ID'] != null){

  if($_POST['parola'] == $_POST['parola2']){

    if( strlen($_POST['parola']) >= 4 ){

      $kAdiKontrol = $db->prepare("SELECT * FROM personeller 
        WHERE Eposta = '$_POST[kullaniciadi]'");
      $kAdiKontrol->execute();
      $say = $kAdiKontrol->fetchColumn();

      $sfr = sha1(md5(trim($_POST['parola'])));
      $mdsfr = substr($sfr, 0,32);


      $Eposta           = p( 'kullaniciadi' );
      $PersonelAdi      = p( 'PersonelAdi' );
      $PersonelSoyadi   = p( 'PersonelSoyadi' );
      $TelefonNo        = str_replace('_','',$_POST['PersonelTelefon']);
      $YetkiID          = p( 'YetkiID' );

      if( strlen($PersonelAdi) < 3 ){
        $msg[0] = "danger";
        $msg[1] = "<i class='fa fa-close'></i> ";
        $msg[2] = "Personel Adı 3 Karakterden Büyük Olmalı !."; 
        echo '<script> showalert("'.$msg[1].$msg[2].'","'.$msg[0].'"); </script>'; 
      }else if( strlen($TelefonNo) < 11 && substr($TelefonNo, 0,2) == '05' ){
        $msg[0] = "danger";
        $msg[1] = "<i class='fa fa-close'></i> ";
        $msg[2] = "İletişim numarasının başında 0 yazarak 11 karakterden oluşmalı !."; 
        echo '<script> showalert("'.$msg[1].$msg[2].'","'.$msg[0].'"); </script>'; 
      }else{     

        if($say==0){

          try {

            $personelolustur = $db->prepare("INSERT INTO personeller SET
              Eposta=?,
              Parola=?,
              Adi=?,
              Soyadi=?,
              CepTelefonu=?,
              YetkiID=?,
              Aktifmi=?,
              OlusturmaTarihi=?
              ");

            $bas = $personelolustur->execute(array(
              $Eposta,
              $mdsfr,
              $PersonelAdi,
              $PersonelSoyadi,
              $TelefonNo,
              $YetkiID,
              '1',
              $tarih
            ));

            if($bas){
              $Personel_ID = $db->lastInsertId();
              $msg[0] = "success";
              $msg[1] = "<i class='fa fa-user'></i> ";
              $msg[2] = "Personel başarılı bir şekilde oluşturuldu.";
              echo '<script> showalert("'.$msg[1].$msg[2].'","'.$msg[0].'"); </script>';  
              go("personel_olustur.php", 1);

            }else{
              echo '<script> showalert("HATA : Veritabanına Kaydı Sağlanamadı.","danger"); </script>';

              echo "\nPDO::errorCode(): ";
              print $db->errorCode();        
            }

          } catch (Exception $e) {
            echo $e->getMessage();
          }

        }else{
          $msg[0] = "danger";
          $msg[1] = "<i class='fa fa-close'></i> ";
          $msg[2] = "HATA : Başka E Posta Deneyiniz.";
          echo '<script> showalert("'.$msg[1].$msg[2].'","'.$msg[0].'"); </script>'; 
        }

      }
    }else{
      $msg[0] = "danger";
      $msg[1] = "<i class='fa fa-close'></i> ";
      $msg[2] = "Parola için yetersiz karakter. 4 karakterden fazla olmalı.";
      echo '<script> showalert("'.$msg[1].$msg[2].'","'.$msg[0].'"); </script>'; 
    }

  }else{
    $msg[0] = "danger";
    $msg[1] = "<i class='fa fa-close'></i> ";
    $msg[2] = "Şifreler Uyuşmuyor.";
    echo '<script> showalert("'.$msg[1].$msg[2].'","'.$msg[0].'"); </script>'; 
  }
}


?>
