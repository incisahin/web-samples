<?php if(!defined('akbim')){ exit(); }?>
<?php $Slider = $db->query("SELECT * FROM anasayfa_slider ORDER BY Sira ASC, ID DESC")->fetchAll(PDO::FETCH_OBJ); ?>
<?php if( $Slider ){ ?>
<!-- SLİDER BAŞLANGIÇ -->
<section id="intro">
    <div class="intro-container" id="intro-container">
        <div id="introCarousel" class="carousel  slide carousel-fade" data-ride="carousel">
            <ol class="carousel-indicators"></ol>
            <div class="carousel-inner" role="listbox">

                <?php $active = 1; ?>
                <?php foreach ( $Slider as $Slide ): ?>
                <div class="carousel-item <?php if($active==1){echo "active";} ?>"
                    style="background-image: url('<?=url?>/<?=images?>/<?=$Slide->Resim?>')">
                    <div class="carousel-container">
                        <div class="container">
                            <h2 class="animate__animated animate__fadeInDown"><?=$Slide->Baslik?></h2>
                            <p class="animate__animated animate__fadeInUp"><?=$Slide->Yazi?></p>
                        </div>
                    </div>
                </div>
                <?php $active = 0; ?>
                <?php endforeach; ?>

            </div>
            <a class="carousel-control-prev" href="#introCarousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon ion-chevron-left" aria-hidden="true"></span>
                <span class="sr-only">Önceki</span>
            </a>
            <a class="carousel-control-next" href="#introCarousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon ion-chevron-right" aria-hidden="true"></span>
                <span class="sr-only">Sonraki</span>
            </a>
        </div>
    </div>
</section>
<!-- SLİDER BİTİŞ -->
<?php } ?>