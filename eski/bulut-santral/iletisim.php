<?php define("link", "iletisim"); ?>
<?php require_once 'header.php'; ?>


<!-- Price Plan Area Start -->
<section class="hami-price-plan-area mt-50">
    <div class="container">
        <div class="row">
            <!-- Section Heading -->
            <div class="col-12">
                <div class="section-heading text-center">
                    <h2>İletişim Formu</h2>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">



            <!-- Single Price Plan -->
            <div class="col-12 col-md-8 col-lg-8">
                <div class="single-price-plan mb-50">

                    <form method="post">

                        <div class="col-12 col-md-12 col-lg-12 price-plan-title">
                            <input type="text" class="form-control" name="adi_soyadi" placeholder="Adınız Soyadınız" required>
                        </div>
                        <div class="col-12 col-md-12 col-lg-12 price-plan-title">
                            <input type="text" class="form-control" name="iletisim_no" placeholder="İletişim Numaranız" required id="iletisim">
                        </div>

                        <div class="col-12 col-md-12 col-lg-12 price-plan-title">
                            <button class="btn btn-primary col-md-4 pull-right" name="gonder">Gönder</button>
                        </div>      

                    </form>              

                </div>
            </div>

            <!-- Single Price Plan -->
            <div class="col-12 col-md-4 col-lg-4">
                <div class="single-price-plan mb-50">
                    <!-- Title -->
                    <div class="price-plan-title">
                        <h4>0850 420 44 11</h4>
                        <p>İletişim Numarası</p>
                    </div>
                    <div class="price-plan-title">
                        <h4>info@akbimbilgisayar.com</h4>
                        <p>E-Posta</p>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>
<!-- Price Plan Area End -->


<!-- Support Area Start -->
<section class="hami-support-area">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="support-text">
                    <h2>Aklınızda Hala Soru İşaretleri mi Var ? O Halde Arayın : 0850 420 44 11</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Support Pattern -->
    <div class="support-pattern" style="background-image: url(img/core-img/support-pattern.png);"></div>
</section>
<!-- Support Area End -->

<!-- Call To Action Area Start -->
<section class="hami-cta-area">
    <div class="container">
        <div class="cta-text">
            <h2><span class="counter">23,812</span> Mutlu Müşteri <i class="fa fa-smile-o" aria-hidden="true"></i></h2>
        </div>
    </div>
</section>
<!-- Call To Action Area End -->



<?php require_once 'footer.php'; ?>

<script type='text/javascript'>
    $("#iletisim").inputmask("09999999999");
</script>

<?php 

if(isset($_POST['gonder'])){





}


?>