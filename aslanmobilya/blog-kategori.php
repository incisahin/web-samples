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
<main id="main" class="mt-5">
  <section id="services">
    <div class="container" data-aos="fade-up">

      <header class="section-header wow fadeInUp">
        <h3><?=$Blog->Baslik?></h3>
        <p><?=$Blog->Text?></p>
      </header>

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
                  <?php if(!empty($key->Resim)){ ?>
                  <div class="blog-kategori">
                    <img src="<?=url?>/<?=images?>/<?=$key->Resim?>" class="card-img-top" alt="...">
                  </div>
                  <?php } ?>
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

    </div>
</section>
