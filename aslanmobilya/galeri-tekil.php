<?php if(!defined('akbim')){ exit(); }?>
<?php

$sql_text = "SELECT *
FROM sayfa_url
WHERE UrlID = '".$url['UrlID']."' LIMIT 1";
$Blog = $db->query( $sql_text )->fetch(PDO::FETCH_OBJ);
if(!$Blog){exit();}

?>
<main id="main" class="mt-5">
  <section id="portfolio" class="section-bg">
    <div class="container" data-aos="fade-up">
      <header class="section-header">
        <h3 class="section-title"><?=$Blog->Baslik?></h3>
      </header>

      <div class="row portfolio-container grid-gallery" data-aos="fade-up" data-aos-delay="200">

        <?php $Galeri = $db->query( "SELECT * FROM sayfa_galeri WHERE UrlID = '$Blog->UrlID' ORDER BY RAND()" )->fetchAll(PDO::FETCH_OBJ); ?>
        <?php if($Galeri){ ?>
          <?php foreach ( $Galeri as $key ) { ?>

            <div class="col-lg-4 col-md-6 portfolio-item filter-app">
              <div class="portfolio-wrap">

                <figure class="galeri">
                  <a href="<?=url?>/<?=images?>/<?=$key->Resim?>">
                    <img src="<?=url?>/<?=images?>/<?=$key->Resim?>" class="img-fluid" alt="" title="<?=$key->Baslik?>">
                  </a>
                </figure>

                <?php if(!empty($key->Baslik)){ ?>
                <div class="portfolio-info">
                  <h4><a href="<?=url?>/<?=images?>/<?=$key->Resim?>"><?=$key->Baslik?></a></h4>
                </div>
                <?php } ?>

              </div>
            </div>
          <?php } ?>
        <?php }else{ ?>
          Bu sayfa hazırlanıyor.
        <?php }?>

      </div>

    </div>
  </section><!-- End Portfolio Section -->
</main>
