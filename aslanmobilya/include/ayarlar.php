<?php

if (session_status() == PHP_SESSION_NONE) {
	session_start();
}
ob_start("ob_gzhandler");

#######################################
// BAĞLANTI AYARLARI
require_once 'baglan.php';
require_once 'fonksiyon.php';
require_once 'f_ozel.php';


#######################################
setlocale(LC_TIME,"tr_TR");
date_default_timezone_set('Europe/Istanbul');
$tarih = date('Y-m-d H:i:s');

$aylar_TR = array("Ocak","Şubat","Mart","Nisan","Mayıs","Haziran","Temmuz","Ağustos","Eylül","Ekim","Kasım","Aralık");
$aylar_EN = array("January","February","March","April","May","June","July","August","September","October","November","December");


	static $GetIdArray = array();

#######################################
## SABİTLER ##
/*
if(!isset($_COOKIE['Ziyaretci'])){
	$ip = ZiyaretciGirisLog();
	setcookie("Ziyaretci", $ip, time()+36000 );
}
*/

define( 'IkıncilEposta', 'akbimbilgisayar@gmail.com' );

$SabitAyar = $db->prepare("SELECT * FROM site_ayarlar WHERE OnYukleme = :OnYukleme ");
$SabitAyar->execute(array( "OnYukleme" => '1' ));
if( $SabitAyar = $SabitAyar->fetchAll(PDO::FETCH_OBJ) ){
	foreach ( $SabitAyar as $key => $value ) {
		define( $value->Anahtar, $value->Deger );
	}
}
$Sosyal = Array ();
$SosyalHesaplar = $db->query("SELECT * FROM site_sosyalmedya ")->fetchAll(PDO::FETCH_OBJ);
if( $SosyalHesaplar ){
	foreach ( $SosyalHesaplar as $key => $value ) {
		$Sosyal[$value->Anahtar] = $value;
	}
}

#######################################

$url = array();

$seo_url = "anasayfa";
if( isset($_GET['do']) )
	$seo_url = g('do');
if( isset($_GET['urun']) )
	$seo_url = g('urun');
if( isset($_GET['alt_urun']) )
	$seo_url = g('alt_urun');

$Sayfa_URL = $db->query("SELECT * FROM sayfa_url WHERE SeoUrl = '$seo_url' ")->fetch(PDO::FETCH_ASSOC);
if( $Sayfa_URL ){
	$url = $Sayfa_URL;
}else{
	if( g('do') == 'giris-yap' ){
		$url['GeciciBaslik'] = "Giriş Yap";
	}else{

		$url['ID'] = "4";
		$url['GeciciBaslik'] = "404 - Sayfa bulunamadı";

	}
}

if( !empty($url['ID']) ){
	if(!isset($_COOKIE[ 'Hit_'.$url['ID'] ])){
		$HitArttir = $db->prepare("UPDATE sayfa_url SET GoruntulemeSayisi=GoruntulemeSayisi+1 WHERE ID=? ");
		$HitArttir = $HitArttir->execute(array( $url['ID'] ));
		if( $HitArttir ){
			setcookie( 'Hit_'.$url['ID'], true, time()+ (360 * 15) );
		}
	}
}


$_URL = url;
if(isset($_GET['do'])){
	$_URL .= "/".g('do');
	if(isset($_GET['urun'])){
		$_URL .= "/".g('urun');
		if(isset($_GET['alt_urun'])){
			$_URL .= "/".g('alt_urun');
		}
	}
}

define("_URL", $_URL);




?>
