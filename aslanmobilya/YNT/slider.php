<?php
require_once 'inc.php';
require_once '../include/ayarlar.php';
require_once '../include/fonksiyon.php';
require_once '../include/class.upload.php';
define("admin", true);

if(!isset($_SESSION['Oturum'])){
	header("location: giris-yap.php");
}

if(isset($_GET['sil'])){
	$silID = $_GET['sil'];
	$SliderVarmi = $db->query("SELECT * FROM anasayfa_slider WHERE ID = '$silID' ")->fetch(PDO::FETCH_OBJ);
	if($SliderVarmi){
		$Sil = $db->prepare("DELETE FROM anasayfa_slider WHERE ID = ? ");
		$Sil->execute(array( g('sil') ));
		unlink('../'.images.'/'.$SliderVarmi->Resim);
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
  <link href="<?=cdn?>/YNT/build/css/main.css" rel="stylesheet">


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
									<h2>Slider İşlemleri</h2>
									<div class="clearfix"></div>
								</div>
								<div class="x_content">
									<!-- Sayfa İçeriği -->

									<?php
									if( isset($_POST['SliderYukle']) || isset($_POST['SliderDuzenle']) ){


										$ResimBaslik    		= "Slider";
										$SliderBaslik     	= p('SliderBaslik');
										$SliderYazi      		= p('SliderYazi');
										$SliderClass      	= p('SliderClass', true);
										$SliderSira       	= p('SliderSira', true);

										if(strlen($SliderSira)==0){
											$SliderSira = 100;
										}

										if(isset($_POST['SliderYukle'])){
											/************ Resim Kaydetme Ayarları ***********/
											$image = new \Verot\Upload\Upload($_FILES['SliderResim']);
											if ( $image->uploaded ) {
												$image->file_new_name_body = md5(rand(1000,9999));
												$image->allowed = array('image/jpeg','image/jpg','image/gif','image/png');
												$image->mime_check = true;
												$image->no_script = true;
												$image->auto_rename = true;
												$image->image_convert = 'webp';
												$image->webp_quality = 50;
												$image->image_resize = true;
												$image->image_y = 1000;
												$image->image_ratio_x = true;
												$image->Process( '../'.images.'/slider'.'' );

												if (!file_exists('../'.images.'/slider/index.html')) { touch('../'.images.'/slider/index.html'); }

												if(!empty($image->file_dst_name)){
													$RInsert = $db->prepare("INSERT INTO anasayfa_slider SET Resim=?, Baslik=?, Yazi=?, Sira=?, Class=? ");
													$RInsert->execute(array( 'slider/'.$image->file_dst_name, $SliderBaslik, $SliderYazi, $SliderSira, $SliderClass ));
													go('slider.php');
												}
											}
											/************ Resim Kaydetme Ayarları ***********/
										}else if(isset($_POST['SliderDuzenle'])){
											$RInsert = $db->prepare("UPDATE anasayfa_slider SET Baslik=?, Yazi=?, Sira=?, Class=? WHERE ID=? ");
											$RInsert->execute(array( $SliderBaslik, $SliderYazi, $SliderSira, $SliderClass, p('SliderDuzenle') ));
											go('slider.php');
										}
									}
									?>

									<?php if(isset($_GET['duzenle'])){ ?>
										<?php
										$SliderID = g('duzenle');
										$SliderBilgi = $db->query("SELECT * FROM anasayfa_slider WHERE ID='$SliderID' ")->fetch(PDO::FETCH_OBJ);
										?>
										<form method="post" action="" class="form-horizontal form-label-left" enctype="multipart/form-data">

											<div class="form-group">
												<label class="control-label col-md-3 col-sm-3 col-xs-12">Başlık</label>
												<div class="col-md-6 col-sm-6 col-xs-12">
													<textarea name="SliderBaslik" class="form-control"> <?=$SliderBilgi->Baslik?></textarea>
												</div>
											</div>

											<div class="form-group">
												<label class="control-label col-md-3 col-sm-3 col-xs-12">Açıklama</label>
												<div class="col-md-6 col-sm-6 col-xs-12">
													<textarea name="SliderYazi" class="form-control"> <?=$SliderBilgi->Yazi?></textarea>
												</div>
											</div>

											<div class="form-group">
												<label class="control-label col-md-3 col-sm-3 col-xs-12">Mobil Görünümü</label>
												<div class="col-md-6 col-sm-6 col-xs-12">
													<select class="form-control" name="SliderClass">
														<option value="pozisyon-orta" <?=selected($SliderBilgi->Class,'pozisyon-orta')?>>Ortala</option>
														<option value="pozisyon-sol" <?=selected($SliderBilgi->Class,'pozisyon-sol')?>>Sola Yasla</option>
														<option value="pozisyon-sag" <?=selected($SliderBilgi->Class,'pozisyon-sag')?>>Sağa Yasla</option>
													</select>
												</div>
											</div>

											<div class="form-group">
												<label class="control-label col-md-3 col-sm-3 col-xs-12">Sıra</label>
												<div class="col-md-6 col-sm-6 col-xs-12">
													<input type="number" class="form-control col-md-7 col-xs-12" name="SliderSira" placeholder="Varsayılan: 100" value="<?=$SliderBilgi->Sira?>">
												</div>
											</div>

											<div class="form-group">
												<label class="control-label col-md-3 col-sm-3 col-xs-12">Resim Seç</label>
												<div class="col-md-6 col-sm-6 col-xs-12">
													<img src="<?=ResimKontrol($SliderBilgi->Resim)?>" height="150px">
												</div>
											</div>

											<div class="ln_solid"></div>
											<div class="form-group">
												<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
													<button type="submit" class="btn btn-primary" name="SliderDuzenle" value="<?=$SliderBilgi->ID?>"><i class="fa fa-edit"></i> Değişiklikleri Kaydet</button>
												</div>
											</div>

										</form>
									<?php }else{ ?>
										<form method="post" action="" class="form-horizontal form-label-left" enctype="multipart/form-data">

											<div class="form-group">
												<label class="control-label col-md-3 col-sm-3 col-xs-12">Başlık</label>
												<div class="col-md-6 col-sm-6 col-xs-12">
													<input type="text" class="form-control col-md-7 col-xs-12" name="SliderBaslik">
												</div>
											</div>

											<div class="form-group">
												<label class="control-label col-md-3 col-sm-3 col-xs-12">Açıklama</label>
												<div class="col-md-6 col-sm-6 col-xs-12">
													<textarea name="SliderYazi" class="form-control"></textarea>
												</div>
											</div>

											<div class="form-group">
												<label class="control-label col-md-3 col-sm-3 col-xs-12">Mobil Görünümü</label>
												<div class="col-md-6 col-sm-6 col-xs-12">
													<select class="form-control" name="SliderClass">
														<option value="pozisyon-orta">Ortala</option>
														<option value="pozisyon-sol">Sola Yasla</option>
														<option value="pozisyon-sag">Sağa Yasla</option>
													</select>
												</div>
											</div>

											<div class="form-group">
												<label class="control-label col-md-3 col-sm-3 col-xs-12">Sıra</label>
												<div class="col-md-6 col-sm-6 col-xs-12">
													<input type="number" class="form-control col-md-7 col-xs-12" name="SliderSira" placeholder="Varsayılan: 100">
												</div>
											</div>

											<div class="form-group">
												<label class="control-label col-md-3 col-sm-3 col-xs-12">Resim Seç</label>
												<div class="col-md-6 col-sm-6 col-xs-12">
													<input type="file" class="form-control btn btn-primary col-md-7 col-xs-12" name="SliderResim" required="required" accept="image/png, image/jpeg">
												</div>
											</div>

											<div class="ln_solid"></div>
											<div class="form-group">
												<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
													<button type="submit" class="btn btn-success" name="SliderYukle"><i class="fa fa-plus"></i> Yükle</button>
												</div>
											</div>

										</form>
									<?php } ?>

									<!-- Sayfa İçeriği -->
								</div>
							</div>
						</div>


						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="x_panel">
								<div class="x_title">
									<h2>Slider Düzen</h2>
									<div class="clearfix"></div>
								</div>
								<div class="x_content">
									<!-- Sayfa İçeriği -->

									<div class="x_content">
										<br />
										<form method="post" action="" class="form-horizontal form-label-left">


											<?php
											$Sliders = $db->query("SELECT * FROM anasayfa_slider ORDER BY Sira ASC, ID DESC",PDO::FETCH_OBJ);
											if($Sliders){
												foreach ( $Sliders as $Slider ) {
													?>

													<div class="col-md-4" style="margin-bottom: 10px;">
														<div class="row" style="border: 1px solid #cdf; margin-bottom: 5px;">
															<div class="col-md-12 view view-first img-250px">
																<img src="<?=ResimKontrol($Slider->Resim)?>" alt="image"  style="width:100%;height:100%;object-fit:contain;"  />
															</div>
															<div class="caption">
																<p>Başlık : <?=$Slider->Baslik?></p>
																<p>Açıklama : <?=$Slider->Yazi?></p>
																<a href="slider.php?sil=<?=$Slider->ID?>" class="btn btn-danger btn-xs col-md-3 pull-right"><i class="fa fa-remove"></i> Sil</a>
																<a href="slider.php?duzenle=<?=$Slider->ID?>" class="btn btn-primary btn-xs col-md-3 pull-right"><i class="fa fa-edit"></i> Düzenle</a>
																<p> </p>
															</div>
														</div>
													</div>

													<?php
												}
											}
											?>

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

	<!-- Custom Theme Scripts -->
	<script src="<?=cdn?>/YNT/build/js/custom.js"></script>

</body>
</html>
