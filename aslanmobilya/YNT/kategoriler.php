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

  <link href="<?=cdn?>/YNT/build/css/custom.min.css" rel="stylesheet">
  <link href="<?=cdn?>/YNT/build/tasarim.css" rel="stylesheet">

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
                  <h2>Kategoriler <small>Ana kategori ve kategori olarak 2 katmanlıdır.</small>  </h2>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <!-- Sayfa İçeriği -->

                  <div class="x_content">


                    <?php  

                    if(isset($_GET['AnaKatSil'])){
                      $AnaKatSil = $db->prepare("DELETE FROM urun_kategori WHERE ID = :ID");
                      $AnaKatSil = $AnaKatSil->execute(array( "ID" => g('AnaKatSil') ));
                      if($AnaKatSil){
                        echo '<div class="alert alert-info" role="alert">Ana Kategori Başarıyla Silindi</div>';
                        go("kategoriler.php", 1);
                      }else{
                        echo '<div class="alert alert-danger" role="alert">Hay Aksi Birşeyler Ters Gitti Tekrar Dene.</div>';
                      }
                    }

                    if(isset($_GET['AltKatSil'])){
                      $AltKatSil = $db->prepare("DELETE FROM urun_kategori WHERE ID = :ID");
                      $AltKatSil = $AltKatSil->execute(array( "ID" => g('AltKatSil') ));
                      if($AltKatSil){
                        echo '<div class="alert alert-info" role="alert">Alt Kategori Başarıyla Silindi</div>';
                        go("kategoriler.php", 1);
                      }else{
                        echo '<div class="alert alert-danger" role="alert">Hay Aksi Birşeyler Ters Gitti Tekrar Dene.</div>';
                      }
                    }

                    if(isset($_POST['AltKatOlustur'])){

                      $UstID    = p('AltKatOlustur');
                      $KatAdi   = p('AltKategori');

                      if(!empty($KatAdi)){

                        $Varmi = $db->query("SELECT * FROM urun_kategori WHERE KategoriAdi = '$KatAdi' LIMIT 1")->fetch(PDO::FETCH_ASSOC);
                        if(!$Varmi){

                          $AltKatOlustur = $db->prepare("INSERT INTO urun_kategori SET KategoriAdi=?, UstID=?");
                          $AltKatOlustur = $AltKatOlustur->execute(array( $KatAdi, $UstID ));
                          if($AltKatOlustur){
                            echo '<div class="alert alert-info" role="alert">Alt Kategori Başarıyla Oluşturuldu</div>';
                            go("kategoriler.php", 1);
                          }else{
                            echo '<div class="alert alert-danger" role="alert">Veritabanı Hatası</div>';
                          }

                        }else{
                          echo '<div class="alert alert-danger" role="alert">'.$KatAdi.' olarak bir kategori adı zaten mevcut..</div>';
                        }
                      }else{
                        echo '<div class="alert alert-danger" role="alert">Lütfen Boş alanları doldurunuz.</div>';
                      }
                    }

                    if(isset($_POST['AnaKatOlustur'])){

                      $KatAdi   = p('AnaKatAdi');

                      if(!empty($KatAdi)){

                        $Varmi = $db->query("SELECT * FROM urun_kategori WHERE KategoriAdi = '$KatAdi' LIMIT 1")->fetch(PDO::FETCH_ASSOC);
                        if(!$Varmi){

                          $AltKatOlustur = $db->prepare("INSERT INTO urun_kategori SET KategoriAdi=?, UstID=?");
                          $AltKatOlustur = $AltKatOlustur->execute(array( $KatAdi, '0' ));
                          if($AltKatOlustur){
                            echo '<div class="alert alert-info" role="alert">Ana Kategori Başarıyla Oluşturuldu</div>';
                            go("kategoriler.php", 1);
                          }else{
                            echo '<div class="alert alert-danger" role="alert">Veritabanı Hatası</div>';
                          }

                        }else{
                          echo '<div class="alert alert-danger" role="alert">'.$KatAdi.' olarak bir kategori adı zaten mevcut..</div>';
                        }
                      }else{
                        echo '<div class="alert alert-danger" role="alert">Lütfen Boş alanları doldurunuz.</div>';
                      }
                    }

                    ?>



                    <?php 
                    $kategoriler = $db->query("SELECT * FROM urun_kategori WHERE UstID = '0' ORDER BY ID DESC", PDO::FETCH_OBJ)->fetchAll();
                    ?>


                    <table class="table table-bordered">
                      <thead>
                        <th style="width: 40%;">Ana Kategori Adı</th>
                        <th>Alt Kategoriler</th>
                      </thead>
                      <tbody >

                        <form method="post">
                          <tr>
                            <td class="dark"><input type="text" class="form-control form-control-sm" placeholder="Yeni Ana Kategori Adı Giriniz" name="AnaKatAdi" required="" autocomplete="off"></td>
                            <td class="dark">
                              <button type="submit" class="btn btn-success" name="AnaKatOlustur"><i class="fa fa-plus"></i> Yeni Ana Kategori Oluştur</button>
                            </td>
                          </tr>
                        </form>

                        <tr>
                          <td>
                            <div class="col-md-12">
                              <!-- required for floating -->
                              <!-- Nav tabs -->
                              <ul class="nav nav-tabs tabs-left">
                                <?php foreach ( $kategoriler as $key ) { ?>
                                  <li class=" <?=class_active( max($kategoriler)->ID, $key->ID )?>">
                                    <a class="col-md-10" href="#<?=seflink($key->KategoriAdi)?>" data-toggle="tab"><?=$key->KategoriAdi?></a>
                                  </li>
                                  <a class="btn btn-danger" href="kategoriler.php?AnaKatSil=<?=$key->ID?>"><i class="fa fa-remove"></i> Sil</a>
                                  <hr>
                                <?php } ?>
                              </ul>
                            </div>
                          </td>
                          <td>
                            <div class="col-md-12">
                              <!-- Tab panes -->
                              <div class="tab-content">
                                <?php foreach ( $kategoriler as $key ) { ?>
                                  <div class="tab-pane <?=class_active( max($kategoriler)->ID, $key->ID )?>" id="<?=seflink($key->KategoriAdi)?>">
                                    <table>
                                      <form method="post">
                                        <tr>
                                          <td><input type="text" class="form-control" name="AltKategori" placeholder="Alt Kategori Adı Giriniz" required="" autocomplete="off"></td>
                                          <td>&nbsp;&nbsp;</td>
                                          <td><button type="submit" class="btn btn-primary" name="AltKatOlustur" value="<?=$key->ID?>"> <i class="fa fa-plus"></i> Oluştur</button></td>
                                        </tr>
                                      </form>
                                      <tr>
                                        <td colspan="10"><hr></td>
                                      </tr>
                                      <?php 
                                      $kategoriler = $db->query("SELECT * FROM urun_kategori WHERE UstID = '$key->ID' ORDER BY ID DESC", PDO::FETCH_OBJ)->fetchAll();
                                      if( $kategoriler ){
                                        foreach ( $kategoriler as $key ) {
                                          ?>
                                          <tr>
                                            <td><?=$key->KategoriAdi?></td>
                                            <td>&nbsp;&nbsp;</td>
                                            <td><a href="kategoriler.php?AltKatSil=<?=$key->ID?>" class="btn btn-danger btn-xs"><i class="fa fa-remove"></i> Sil</a></td>
                                          </tr>
                                          <?php 
                                        }
                                      }else{
                                        echo "<tr><td colspan='10'><b> - Alt Kategori Bulunamadı - </b></td></tr>";
                                      }
                                      ?>
                                    </table>
                                  </div>
                                <?php } ?>
                              </div>
                            </div>
                          </td>
                        </tr>

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
