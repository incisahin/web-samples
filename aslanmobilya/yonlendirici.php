<?php
if(!defined('akbim')){ exit(); }

if( site_durum == 'Açık' ){

	/*$Yonlendirmeler = array(
		"Bulut-Santral" 	=>	"https://bulut-santral.akbimbilgisayar.com/",
	);*/

	$Seo="";
	if(isset($_GET['alt_urun'])){
		$Seo = g('alt_urun');
	}else if(isset($_GET['urun'])){
		$Seo = g('urun');
	}else if(isset($_GET['do'])){
		$Seo = g('do');
	}else{
		require_once 'ozel_sayfalar/anasayfa.php';
	}

	if(strlen($Seo)>0){

		$Sayfa = $db->query("SELECT IcerikTipiID FROM sayfa_url WHERE SeoUrl = '$Seo' ")->fetch(PDO::FETCH_OBJ);
		if( $Sayfa ){
			if( $Sayfa->IcerikTipiID == '1' ){
				if( file_exists( 'ozel_sayfalar/'.$Seo.".php" ) ){
					require_once 'ozel_sayfalar/'.$Seo.'.php';
				}else{
					require_once 'yapim-asamasinda.php';
				}
			}else if( $Sayfa->IcerikTipiID == '5' ){
				require_once 'blog-kategori.php';
			}else if( $Sayfa->IcerikTipiID == '10' ){
				require_once 'blog.php';
			}else if( $Sayfa->IcerikTipiID == '20' ){
				require_once 'urunler.php';
			}else if( $Sayfa->IcerikTipiID == '30' ){
				require_once 'urun.php';
			}else if( $Sayfa->IcerikTipiID == '50' ){
				require_once 'galeri-tekil.php';
			}else if( $Sayfa->IcerikTipiID == '60' ){
				require_once 'galeri-coklu.php';
			}else if( $Sayfa->IcerikTipiID == '70' ){
				require_once 'neler-yaptik.php';
			}
		}else{
			if( file_exists($Seo.".php") ){
				require_once $Seo.".php";
			}else{
				if( array_key_exists( $Seo, $Yonlendirmeler ) ){
					// EĞER URL YÖNELNDİRMELER ADLI DİZİ İÇERİSİNDE MEVCUT İSE O DİZİDEKİ KEY İN VALUE SUNA YÖNLENSİN.
					go($Yonlendirmeler[$Seo]);
				}else{
					require_once 'hata.php';
				}

			}

		}
	}

}else{
	echo "Site geçici olarak kullanıma kapalıdır. En kısa sürede tekrar hizmete devam edeceğiz.";
}
?>
