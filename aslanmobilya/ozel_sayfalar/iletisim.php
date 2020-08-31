<?php if(!defined('akbim')){ exit(); }?>
<?php

$sql_text = "SELECT *
FROM sayfa_url
WHERE UrlID = '".$url['UrlID']."' LIMIT 1";
$Blog = $db->query( $sql_text )->fetch(PDO::FETCH_OBJ);
if(!$Blog){exit();}

?>
<main id="main" class="mt-5">
    <section id="contact" class="section-bg">
        <div class="container" data-aos="fade-up">

            <div class="section-header">
                <h3><?=$Blog->Baslik?></h3>
            </div>

            <div class="row contact-info">

                <div class="col-md-4">
                    <div class="contact-address">
                        <i class="ion-ios-location-outline"></i>
                        <h3>Adres</h3>
                        <address><?=adres?></address>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="contact-phone">
                        <i class="ion-ios-telephone-outline"></i>
                        <h3>İletişim Numaralarımız</h3>
                        <p><a href="tel:<?=cep_tel?>"><?=cep_tel?></a></p>
                        <p><a href="tel:<?=sabit_tel?>"><?=sabit_tel?></a></p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="contact-email">
                        <i class="ion-ios-email-outline"></i>
                        <h3>E-Posta</h3>
                        <p><a href="mailto:<?=eposta?>"><?=eposta?></a></p>
                    </div>
                </div>

            </div>

            <div class="form">

                <div class="row">
                    <div class="col-12">
                        <?php
            if(isset($_POST['MesajGonder'])){
              if(!isset($_COOKIE['Eposta'])){
                require_once __DIR__.'/../include/mail/mail_gonder.php';
                $GonderenMail = p('email', false);
                $GonderenAdi  = p('name');
                $Mesaj        = p('message');
                $Gonder       = MailGonder($GonderenMail, $GonderenAdi, $Mesaj );
                if( $Gonder == 'ok'){
                  echo '<div class="alert alert-success" role="alert">Mesajınız Başarıyla İletildi</div>';
                  setcookie( 'Eposta', true, time()+ (360 * 15) );
                }else{
                  echo '<div class="alert alert-danger" role="alert">'.$Gonder.'</div>';
                }

              }else{
                echo '<div class="alert alert-warning" role="alert">15 dakika içerisinde zaten mail gönderdiniz.</div>';
              }
            }
            ?>
                    </div>
                </div>

                <form method="post" role="form" class="php-email-form">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <input type="text" name="name" class="form-control" id="name" placeholder="İsim Soyisim"
                                data-rule="minlen:4" data-msg="Lütfen en az 4 karakter giriniz." />
                            <div class="validate"></div>
                        </div>
                        <div class="form-group col-md-6">
                            <input type="email" class="form-control" name="email" id="email"
                                placeholder="Mail Adresiniz" data-rule="email"
                                data-msg="Lütfen geçerli bir eposta adresi giriniz." />
                            <div class="validate"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" name="message" rows="5" data-rule="required"
                            placeholder="İletmek istedikleriniz" data-msg="Lütfen bizim için bir şeyler yaz"></textarea>
                        <div class="validate"></div>
                    </div>
                    <div class="mb-3">
                        <div class="loading">Loading</div>
                        <div class="error-message"></div>
                        <div class="sent-message">Your message has been sent. Thank you!</div>
                    </div>
                    <div class="text-center"><button type="submit" name="MesajGonder">Mesaj Gönder</button></div>
                </form>
            </div>

            <div class="row">
                <div class="col-12">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3218.1347494940956!2d36.18022291462267!3d36.23622050694296!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1525eb5433ff4691%3A0x1d174ac0cef48454!2sASLAN%20MOB%C4%B0LYA%20VE%20DEKARASYON!5e0!3m2!1sen!2str!4v1598363373937!5m2!1sen!2str"
                        width="1110" height="450" frameborder="0" style="border:0;" allowfullscreen=""
                        aria-hidden="false" tabindex="0"></iframe>
                </div>
            </div>

        </div>
    </section><!-- End Contact Section -->
</main>