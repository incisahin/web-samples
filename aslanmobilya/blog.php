<?php if(!defined('akbim')){ exit(); }?>
<?php
$Dizin = UstID_Bilgileri($url['UstID']);

$sql_text = "SELECT su.UrlID,su.IcerikTipiID,su.UstID,su.SeoUrl,su.Baslik,su.Keyw,
su.Navbar,su.OlusturmaTarihi,su.GoruntulemeSayisi,sy.Text
FROM sayfa_url su
LEFT JOIN sayfa_yazi sy ON su.UrlID    = sy.UrlID
LEFT JOIN sayfa_galeri sg ON su.UrlID  = sg.UrlID
WHERE su.UrlID = '".$url['UrlID']."' AND su.IcerikTipiID != '100'";
$Blog = $db->query( $sql_text )->fetch(PDO::FETCH_OBJ);
?>
<main id="main" class="mt-5">
  <section id="services">
    <div class="container" data-aos="fade-up">

      <header class="section-header wow fadeInUp">
        <h3><?=$Blog->Baslik?></h3>
        <p><?=$Blog->Text?></p>
      </header>

    </div>
</section>
