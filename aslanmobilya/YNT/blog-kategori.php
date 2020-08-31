<?php if(!defined('akbim')){ exit(); }?>
<?php
$Dizin = UstID_Bilgileri($url['UstID']);
$UrlID = $url['UrlID'];
$sql_text = "SELECT su.UrlID,su.IcerikTipiID,su.UstID,su.SeoUrl,su.Baslik,su.Keyw,
su.Navbar,su.OlusturmaTarihi,su.GoruntulemeSayisi,sy.Text
FROM sayfa_url su
LEFT JOIN sayfa_yazi sy ON su.UrlID    = sy.UrlID
LEFT JOIN sayfa_galeri sg ON su.UrlID  = sg.UrlID
WHERE su.UrlID = '$UrlID' AND su.IcerikTipiID != '100'";
$Blog = $db->query( $sql_text )->fetch(PDO::FETCH_OBJ);
?>                                                                                                                                                                                 

<main>
  <!-- slider Area Start-->
  <div class="slider-area ">
    <!-- Mobile Menu -->
    <div class="single-slider slider-height2 d-flex align-items-center bilgi-menusu">
      <div class="container">
        <div class="row">
          <div class="col-xl-12">
            <div class="hero-cap text-center">
              <h2 style="text-align: left;"><?=$Blog->Baslik?></h2>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


  <div class="container">
    <div class="row">
      <?php

      $sql_text = "SELECT su.UrlID,su.IcerikTipiID,su.UstID,su.SeoUrl,su.Baslik,su.Desc,su.Keyw,su.Resim,
      su.Navbar,su.OlusturmaTarihi,su.GoruntulemeSayisi,sy.Text
      FROM sayfa_url su
      LEFT JOIN sayfa_yazi sy ON su.UrlID    = sy.UrlID
      LEFT JOIN sayfa_galeri sg ON su.UrlID  = sg.UrlID
      WHERE su.UstID = '$UrlID' ";
      $Bloglar = $db->query( $sql_text )->fetchAll(PDO::FETCH_OBJ);
      if($Bloglar){
        foreach ($Bloglar as $key) {
          ?>
          <div class="col-lg-3 col-md-6 col-sm-12 mt-5">
            <div class="card">
              <div class="blog-kategori">
                <img src="<?=url?>/<?=images?>/<?=$key->Resim?>" class="card-img-top" alt="...">
              </div>
              <div class="card-body">
                <h5 class="card-title"><?=$key->Baslik?></h5>
                <p class="card-text"><?=$key->Desc?></p>
                <a href="<?=url?>/<?=$key->SeoUrl?>.html" class="btn btn-primary">İncele</a>
              </div>
            </div>
          </div>
          <?php
        }
      }else{
        echo "<h2>Henüz bu bölüm hazır değil.</h2>";
      }
      ?>



    </div>
  </div>



  <!-- slider Area End-->
  <section class="sample-text-area">
    <div class="container box_1170">
      <p class="sample-text">
        <?=$Blog->Text?>
      </p>
    </div>
  </section>
</main>
