<?php
require_once 'inc.php';
require_once '../include/ayarlar.php';
require_once '../include/fonksiyon.php';
require_once '../include/menu_duzen.php';
require_once 'inc/f_menu_yapi.php';
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
                  <h2>Menu Oluştur</h2>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <!-- Sayfa İçeriği -->

                  <div class="x_content">
                    <br />

                    <?php
                    if(isset( $_POST['MenuOlustur'] )){

                      $UstMenu_ID   = p('UstMenu_ID');
                      $MenuAdi      = p('MenuAdi', true);
                      $Navbar       = p('Navbar');
                      $IcerikTipi   = p('IcerikTipi');
                      $Desc         = p('Desc', true);
                      $Keyw         = p('Keyw', true);
                      if($IcerikTipi != '100'){
                        $MenuLinki  = seflink(p('MenuLinki', true));
                        if( $MenuLinki == '' && $MenuLinki == null )
                          $MenuLinki = "#";
                      }else{
                        $MenuLinki  = p('MenuLinki', true);
                      }

                      if(!$MenuAdi || !$MenuLinki){
                        echo '<div class="alert alert-danger" role="alert">Gerekli Alanları Doldurunuz</div>';
                      }else{

                        $Varmi = $db->query("SELECT * FROM sayfa_url WHERE SeoUrl = '$MenuLinki' LIMIT 1")->fetch(PDO::FETCH_ASSOC);
                        if(!$Varmi){

                          $UrlOlustur = $db->prepare("INSERT INTO sayfa_url SET IcerikTipiID=?, UstID=?, SeoUrl=?, Baslik=?, Keyw=?, Navbar=?, OlusturmaTarihi=? ");
                          $UrlOlustur = $UrlOlustur->execute(array( $IcerikTipi, $UstMenu_ID, $MenuLinki, $MenuAdi, $Keyw, $Navbar, $tarih ));
                          if($UrlOlustur){

                            $URL_ID = $db->lastInsertId();
                            echo '<div class="alert alert-info" role="alert">Menu Başarıyla Oluşturuldu</div>';
                            /********* icerik oluştur *********/
                            yapiKur($URL_ID, $IcerikTipi);
                            /********* icerik oluştur *********/

                            go("menu_olustur.php", 1);
                          }else{
                            echo '<div class="alert alert-danger" role="alert">Veritabanı Hatası</div>';
                          }

                        }else{
                          echo '<div class="alert alert-danger" role="alert">'.$MenuLinki.' olarak bir bağlantı yolu  zaten mevcut..</div>';
                        }

                      }
                    }
                    ?>


                    <form method="post" action="" class="form-horizontal form-label-left">

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Üst Menü
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select class="form-control col-md-7 col-xs-12" name="UstMenu_ID" >
                            <option value="">Üst Menü Seçilmedi.</option>
                            <?php

                            $category_list = $db->query("SELECT * FROM sayfa_url WHERE IcerikTipiID != '30' ORDER BY Sira ASC, UrlID DESC", PDO::FETCH_OBJ)->fetchAll();

                            admin_menu_option( bulidTree( $category_list ) );

                            ?>
                          </select>
                          <small>Gerekli ise kullanınız</small>
                        </div>
                      </div>


                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">İçerik Türü <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select class="form-control col-md-7 col-xs-12" name="IcerikTipi" id="IcerikTipi" >
                            <?php
                            $IcerikTipleri=$db->query("SELECT * FROM sayfa_iceriktipi WHERE ID != '30' AND ID != '20' ", PDO::FETCH_OBJ)->fetchAll();
                            if($IcerikTipleri){
                              foreach ($IcerikTipleri as $key) {
                                ?>
                                <option value="<?=$key->ID?>"><?=$key->Tip?></option>
                                <?php
                              }
                            }
                            ?>
                          </select>
                        </div>
                      </div>


                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Menüde Görünsün mü <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select class="form-control col-md-7 col-xs-12" name="Navbar" id="Navbar" >
                            <option value="1">Evet</option>
                            <option value="0">Hayır</option>
                          </select>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Menu Adı <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" class="form-control col-md-7 col-xs-12" name="MenuAdi" id="MenuAdi" onkeyup="SefLinkOlustur();" required>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Menu Bağlantı Yolu <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" class="form-control col-md-7 col-xs-12" name="MenuLinki" id="MenuLinki" onkeyup="SefLink();" required>
                        </div>
                      </div>


                      <script type="text/javascript">
                        function SefLinkOlustur(){

                          var IcerikTipi  = document.getElementById("IcerikTipi").value;
                          var MenuAdi       = document.getElementById("MenuAdi").value;

                          if( IcerikTipi != '100' ){
                            $.ajax({
                              type:"post",
                              url:"inc/ajax.php",
                              data:{"MenuAdi":MenuAdi},
                              success:function(e)
                              {
                                document.getElementById('MenuLinki').value = e;
                              }
                            });
                          }
                        }

                        function SefLink(){

                          var IcerikTipi  = document.getElementById("IcerikTipi").value;
                          var MenuAdi     = document.getElementById("MenuLinki").value;

                          if( IcerikTipi != '100' ){
                            $.ajax({
                              type:"post",
                              url:"inc/ajax.php",
                              data:{"MenuAdi":MenuAdi},
                              success:function(e)
                              {
                                document.getElementById('MenuLinki').value = e;
                              }
                            });
                          }
                        }
                      </script>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Kısa Açıklama
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" class="form-control col-md-7 col-xs-12" name="Desc" >
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Anahtar Kelime</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="tags_1" name="Keyw" type="text" class="tags form-control" />
                          <small>Bir kaç anahtar kelime yaazdıktan sonra virgül ile ayırınız.</small>
                        </div>
                      </div>


                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          <button type="submit" class="btn btn-success" name="MenuOlustur">Oluştur</button>
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
  <!-- jQuery Tags Input -->
  <script src="<?=cdn?>/YNT/vendors/jquery.tagsinput/src/jquery.tagsinput.js"></script>

  <!-- Custom Theme Scripts -->
  <script src="<?=cdn?>/YNT/build/js/custom.js"></script>

</body>
</html>
