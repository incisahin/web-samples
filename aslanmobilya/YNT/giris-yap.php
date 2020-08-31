<?php
require_once 'inc.php';
require_once '../include/ayarlar.php';
require_once '../include/fonksiyon.php';
$msg = '';

if(isset($_SESSION['Oturum'])){
  header('location: index.php');
}

if(isset($_POST['Eposta'])){

  $sor = $db->prepare("SELECT * FROM personeller WHERE Eposta = ?");
  $sor->execute(array( trim($_POST['Eposta']) ));
  $say = $sor->rowCount();

  if($say > 0){
    $result = $sor->fetchAll(PDO::FETCH_OBJ);
    foreach ( $result as $key ) {
      //$prl = sha1(md5($_POST['Parola']));
      $parola = substr( sha1(md5($_POST['Parola'])) , 0,32);
      if( $parola == $key->Parola ){
        if($key->Aktifmi == true){



            $msg = '<div class="alert alert-success">Giriş Başarılı</div>';

            $sessions = array(
              'ID'            => $key->ID,
              'Eposta'        => $key->Eposta,
              'Isim_Soyisim'  => $key->Adi." ".$key->Soyadi,
              'YetkiID'       => $key->YetkiID,
              'Oturum'        => true
            );
            session_olustur($sessions);

            //GirisLog( $_SESSION['ID'] );

            go('index.php');

       }else if( $key->Aktifmi == false){
        $msg .= '<div class="alert alert-danger">Hesabınız Kullanıma Kapanmıştır..</div>';
      }
    }else{
      $msg .= '<div class="alert alert-danger">Parola Yanlış</div>';
    }
  }
}else{
  $msg .= '<div class="alert alert-danger">Böyle Bir Kullanıcı Bulunamadı.</div>';
}



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
  <meta name="robots" content="noindex, nofollow" />

  <title>Yönetim Paneli</title>

  <!-- Bootstrap -->
  <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="//library.akbimbilgisayar.com/bayiscripti/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <!-- NProgress -->
  <link href="vendors/nprogress/nprogress.css" rel="stylesheet">
  <!-- Animate.css -->
  <link href="vendors/animate.css/animate.min.css" rel="stylesheet">

  <!-- Custom Theme Style -->
  <link href="build/css/custom.min.css" rel="stylesheet">
</head>

<body class="login">
  <div>
    <a class="hiddenanchor" id="signup"></a>
    <a class="hiddenanchor" id="signin"></a>

    <div class="login_wrapper">
      <div class="animate form login_form">
        <section class="login_content">
          <form method="post">
            <h1>Giriş Formu</h1>
            <div>
              <input type="email" class="form-control" name="Eposta" placeholder="" required="" />
            </div>
            <div>
              <input type="password" class="form-control" name="Parola" placeholder="" required="" />
            </div>
            <div>
              <button class="btn btn-primary">Giriş Yap</button>
            </div>

            <div class="clearfix"></div>

            <div class="separator">

              <span><?php echo $msg; ?></span>
              <div class="clearfix"></div>
              <br />

              <div>
                <h1>Akbim Yazılım</h1>
              </div>
            </div>
          </form>
        </section>
      </div>
    </div>
  </div>
</body>
</html>
