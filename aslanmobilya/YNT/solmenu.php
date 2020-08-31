<?php echo !defined("admin") ? die("Hacking") : null?>
<div class="col-md-3 left_col">
	<div class="left_col scroll-view">
		<div class="navbar nav_title" style="border: 0;">
			<a href="index.php" class="site_title"><span>Akbim Yazılım Paneli</span></a>
		</div>

		<div class="clearfix"></div>

		<!-- menu profile quick info -->
		<div class="profile clearfix">
			<div class="profile_pic">
				<img src="img/user.png" alt="..." class="img-circle profile_img">
			</div>
			<div class="profile_info">
				<span>Hoşgeldiniz,</span>
				<h2><?=session('Isim_Soyisim');?></h2>
			</div>
		</div>
		<!-- /menu profile quick info -->

		<br />

		<!-- sidebar menu -->
		<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">


			<div class="menu_section">
				<h3>Genel</h3>
				<ul class="nav side-menu">

					<li><a href="index.php"><i class="fa fa-home"></i> Anasayfa </a></li>
					<li><a href="slider.php"><i class="fa fa-film"></i> Slider </a></li>

					<li><a><i class="fa fa-reorder"></i> Menü Ayarları <span class="fa fa-chevron-down"></span></a>
						<ul class="nav child_menu">
							<li><a href="menuler.php">Menü Listesi</a></li>
							<li><a href="menu_olustur.php">Menü Oluştur</a></li>
						</ul>
					</li>

				</ul>
			</div>

			<?php if(defined('UrunlerUrlID')){ ?>
				<div class="menu_section">
					<h3>Ürün İşlemleri</h3>
					<ul class="nav side-menu">
						<li><a><i class="fa fa-shopping-cart"></i> Ürünler <span class="fa fa-chevron-down"></span></a>
							<ul class="nav child_menu">
								<li><a href="urunler.php">Ürün Listesi</a></li>
								<li><a href="urun_olustur.php">Ürün Oluştur</a></li>
							</ul>
						</li>
						<li><a><i class="fa fa-tags"></i> Ürün Kategorileri <span class="fa fa-chevron-down"></span></a>
							<ul class="nav child_menu">
								<li><a href="kategoriler.php">Kategori Listesi</a></li>
							</ul>
						</li>

					</ul>
				</div>
			<?php } ?>

			<div class="menu_section">
				<h3>Diğer Ayarlar</h3>
				<ul class="nav side-menu">
					<li><a href="personeller.php"><i class="fa fa-users"></i> Kullanıcı İşlemleri</a></li>
					<li><a href="sosyal_medya.php"><i class="fa fa-heart"></i> Sosyal Medya linkleri</a></li>
					<li><a href="ayarlar.php"><i class="fa fa-cogs"></i> Site Ayarları</a></li>
					<li><a href="mail_server.php"><i class="fa fa-envelope-o"></i> Mail Hesabı</a></li>
				</ul>
			</div>

			<div class="menu_section">
				<h3>#</h3>
				<ul class="nav side-menu">
					<li><a target="_blank" href="<?=url?>"><i class="fa fa-dashboard"></i> Siteye Gözat</a></li>
				</ul>
			</div>

		</div>
		<!-- /sidebar menu -->

		<!-- /menu footer buttons -->
		<div class="sidebar-footer hidden-small">
			<a data-toggle="tooltip" data-placement="top" title="Siteyi Gör" href="../" target="_blank">
				<span class="glyphicon glyphicon-new-window" aria-hidden="true"></span>
			</a>
			<a data-toggle="tooltip" data-placement="top" title="Tam Ekran"  id="FullScreen" href="#" onclick="openFullscreen();">
				<span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
			</a>
			<a data-toggle="tooltip" data-placement="top" title="Normal Ekran"  id="FullScreen" href="#" onclick="closeFullscreen();">
				<span class="glyphicon glyphicon-resize-small" aria-hidden="true"></span>
			</a>
			<a data-toggle="tooltip" data-placement="top" title="Çıkış Yap" href="cikis-yap.php">
				<span class="glyphicon glyphicon-off" aria-hidden="true"></span>
			</a>
		</div>

		<script>
			var elem = document.documentElement;
			function openFullscreen() {
				if (elem.requestFullscreen) {
					elem.requestFullscreen();
				} else if (elem.mozRequestFullScreen) { /* Firefox */
					elem.mozRequestFullScreen();
				} else if (elem.webkitRequestFullscreen) { /* Chrome, Safari & Opera */
					elem.webkitRequestFullscreen();
				} else if (elem.msRequestFullscreen) { /* IE/Edge */
					elem.msRequestFullscreen();
				}
			}

			function closeFullscreen() {
				if (document.exitFullscreen) {
					document.exitFullscreen();
				} else if (document.mozCancelFullScreen) {
					document.mozCancelFullScreen();
				} else if (document.webkitExitFullscreen) {
					document.webkitExitFullscreen();
				} else if (document.msExitFullscreen) {
					document.msExitFullscreen();
				}
			}
		</script>
		<!-- /menu footer buttons -->
	</div>
</div>
