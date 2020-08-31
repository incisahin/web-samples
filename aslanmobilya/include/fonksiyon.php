<?php

if(!defined('akbim')){
	exit();
}

function ResimKontrol($resim, $klasor=null){
	if($resim){
		if(file_exists( __DIR__."/../".images."/".$klasor.$resim )){
			return url."/".images."/".$klasor.$resim;
		}else{
			return url."/".images."/varsayilan.jpg";
		}
	}else{
		return url."/".images."/varsayilan.jpg";
	}
}

function getUrlOlustur( $UrlID ){

	$return = "";
	$array = getArray($UrlID);
	if(count($array)>0){

		for ($i=count($array)-1; $i >= 0; $i--) {
			$return .= "/"._seourl_id( $array[$i] );
			//$return .= $i;
		}

		return $return;
	}else{
		return false;
	}
}

function getArray( $UrlID=null ){

	Global $GetIdArray;
	$GetIdArray = array();
	if( $UrlID ){
		return ustIdTara($UrlID);
	}else{
		if($ID = EndGetID()){
			return ustIdTara($ID);
		}else{
			return false;
		}
	}
}

function EndGetID(){
	if(isset($_GET)){
		Global $db;
		$Link = $db->query("SELECT UrlID, UstID FROM sayfa_url WHERE SeoUrl = '".end($_GET)."' LIMIT 1")->fetch(PDO::FETCH_OBJ);
		if($Link){
			return $Link->UrlID;
		}else{
			return false;
		}
	}else{
		return false;
	}
}

function ustIdTara( $UrlID ){
	Global $db;
	Global $GetIdArray;
	if(isset($_GET)){
		$Link = $db->query("SELECT UrlID, UstID FROM sayfa_url WHERE UrlID = '".$UrlID."' LIMIT 1")->fetch(PDO::FETCH_OBJ);
		array_push($GetIdArray, $Link->UrlID);

		if($Link->UstID != '0' ){
			ustIdTara( $Link->UstID );
		}

	}
	return $GetIdArray;
}


function blogSay($KategoriID){
	Global $db;
	$Say = $db->query("SELECT COUNT(*) AS 'x' FROM sayfa_url WHERE UstID = '$KategoriID' ")->fetch(PDO::FETCH_OBJ);
	return $Say->x;
}

function selected($deger1, $deger2){
	if($deger1 == $deger2)
		return " selected ";
	else
		return false;
}

function blogTarih($tarih){

	//örnek gelen tarih 1994-12-31
	//örnek giden tarih 31-12-1994

	//return substr($Tarih,8,2)."-".substr($Tarih,5,2)."-".substr($Tarih,0,4);

	$aylar_TR = array("Ocak","Şubat","Mart","Nisan","Mayıs","Haziran","Temmuz","Ağustos","Eylül","Ekim","Kasım","Aralık");
	$aylar_EN = array("January","February","March","April","May","June","July","August","September","October","November","December");

	$tarih = date("j F Y", strtotime($tarih));
	return str_replace($aylar_EN, $aylar_TR, $tarih);
}

function getBitir($getadi_degeri=null){
	$url = $_SERVER['REQUEST_URI'];
	$metin = explode('?', $url);
	unset($metin['0']);
	if( count($metin)>0 ){
		/** Yukarıda soru işaretinden öncesini sildik eğer halen varsa içeriye giriyoruz **/
		if( $getadi_degeri ){
		//Array ( [1] => Kategori=1&AltKategori=4 )
		//Kategori=1&AltKategori=4

			$metin = implode('&', $metin);
			$sonuc = array();
			$metin = explode('&', $metin);
			$metin = dizi_bos_temizle($metin);

			unset( $metin[array_search( $getadi_degeri, $metin)] );
			$metin = implode('&', $metin);

			// Örnek olarak AltKategori=4&sayfa=1 sonucu çıkacaktır url olarak kullanılması için ? eklemesi yapıldı
			if(strlen($metin)>0)
				return "?".$metin;
			else
				return false;

		}else{
			return false;
		}
	}else{
		return false;
	}
}

function getCekme($getadi=null){
	$url = $_SERVER['REQUEST_URI'];
	$metin = explode('?', $url);
	unset($metin['0']);
	if( count($metin)>0 ){

		$metin = implode('&', $metin);

		$sonuc = array();
		$metin = explode('&', $metin);
		$metin = dizi_bos_temizle($metin);
		for ($i=0; $i < count($metin); $i++) {
			$array = explode('=', $metin[$i]);
			$sonuc[$array['0']] = $array['1'];
		}
		$sonuc = dizi_bos_temizle($sonuc);
		if( count($sonuc) > 0 ){
			if($getadi){
				if( array_key_exists($getadi, $sonuc) )
					return $sonuc[$getadi];
				else
					return false;
			}else{
				return $sonuc;
			}
		}else{
			return false;
		}
	}else{
		return false;
	}
}

function aramaparcalama($string){
	$string = urldecode($string);
	$string = explode(' ', $string);
	return $string;
}
/*
function ziyaretsayisi(){

	$seflink = "";
	if(isset($_GET['alt_urun']))
		$seflink = g('alt_urun');
	else if(isset($_GET['urun']))
		$seflink = g('urun');
	else if(isset($_GET['do']))
		$seflink = g('do');
	else
		$seflink = "anasayfa";

	if( strlen($seflink) > 0 ){
		if( !isset( $_COOKIE[ "z_".$seflink ] ) ){
			Global $db;
			$Hit = $db->prepare( "UPDATE sayfa_url SET hit= hit+1 WHERE seo_url = :seo_url " );
			$Hit = $Hit->execute(array( "seo_url" => $seflink ));
			if($Hit){
				setcookie( "z_".$seflink, true, time()+3600 );
			}
		}else{
			setcookie( "z_".$seflink, true, time()+3600 );
		}
	}
}
*/

function _seourl($seflink, $type=null){
	/************ Type : seo, baslik  ************/
	Global $db;

	$sql_text = "SELECT SeoUrl, GeciciBaslik FROM sayfa_url WHERE SeoUrl = :SeoUrl LIMIT 1";
	$URL = $db->prepare( $sql_text );
	$URL->execute(array( "SeoUrl" => $seflink ));
	$URL = $URL->fetch(PDO::FETCH_OBJ);

	if( $URL && ($type=='seo' || $type==null))
		return $URL->SeoUrl;
	if( $URL && $type=='baslik' )
		return $URL->GeciciBaslik;
}
function _seourl_id($ID, $type=null){
	/************ Type : seo, baslik  ************/
	Global $db;

	$sql_text = "SELECT SeoUrl, GeciciBaslik FROM sayfa_url WHERE ID = :ID LIMIT 1";
	$URL = $db->prepare( $sql_text );
	$URL->execute(array( "ID" => $ID ));
	$URL = $URL->fetch(PDO::FETCH_OBJ);

	if( $URL && ($type=='seo' || $type==null))
		return $URL->SeoUrl;
	if( $URL && $type=='baslik' )
		return $URL->GeciciBaslik;
}


function _count_ustid($ust_id){
	Global $db;

	$sql_text = "SELECT COUNT(ID) AS 'x' FROM sayfa_url WHERE ust_id = :ust_id LIMIT 1";
	$Count = $db->prepare( $sql_text );
	$Count->execute(array( "ust_id" => $ust_id ));
	$Count = $Count->fetch(PDO::FETCH_OBJ);

	if( $Count )
		return $Count->x;
}

function class_color($i=null){
	$array = array('', 'table-primary',  'table-success', 'table-danger', 'table-warning', 'table-info', 'table-primary',  'table-success', 'table-danger', 'table-warning', 'table-info',);
	return $array[$i];
}

function UstID_Bilgileri ($ID){
	Global $db;

	$sql_text = "SELECT * FROM sayfa_url WHERE UrlID = $ID LIMIT 1";
	$Bul = $db->query( $sql_text )->fetch(PDO::FETCH_OBJ);
	if($Bul){
		return $Bul;
	}else{
		return null;
	}
}

function class_active( $ID=null, $ClassID=null ){
	if($ID!=null){
		if($ID==$ClassID)
			return " active ";
	}
}

function baslik(){
	Global $url;
	if(isset($url['Baslik']) && !defined(site_baslik)){
		return $url['Baslik']." - ".site_baslik;
	}
	else if( !isset($url['Baslik']) && !defined(site_baslik))
		return site_baslik;

	else if( isset($url['Baslik']) && defined(site_baslik))
		return $url['Baslik'];
	else
		return false;
}

function dizi_bos_temizle($array){
	$silinsin=array(""," ");
	return $sonuc=array_diff($array,$silinsin);
}


function kontrol_dizi($array, $key){
	if( is_array($array) ){
		if( array_key_exists($key, $array) ){
			return $array[ $key ];
		}else{
			return false;
		}
	}else{
		return false;
	}
}

function kontrol_dizi_mi($array){
	if(is_array($array)){
		return $array;
	}else{
		return false;
	}
}

function title($title=null){
	if($title!=null || $title != ''){
		return $title." | ".site_baslik;
	}else{
		return site_baslik;
	}
}

function ucfirst_tr($metin)
{
	$k_uzunluk = mb_strlen($metin, "UTF-8");
	$ilkKarakter= mb_substr($metin, 0, 1, "UTF-8");
	$kalan = mb_substr($metin, 1, $k_uzunluk - 1, "UTF-8");
	return mb_strtoupper($ilkKarakter, "UTF-8") . mb_strtolower($kalan,"UTF-8");
}


function g($par){
	return strip_tags(trim(addslashes($_GET[$par])));
}

function p($par, $st = false){
	if($st){
		return htmlspecialchars( addslashes(trim($_POST[$par])) );
	}else{
		return addslashes(trim($_POST[$par]));
	}
}

function strip_word_html($text, $allowed_tags = '<a><ul><li><b><i><sup><sub><em><strong><u><br><br/><br /><p><h2><h3><h4><h5><h6>')
{

	mb_regex_encoding('UTF-8');
    //replace MS special characters first
	$search = array('/&lsquo;/u', '/&rsquo;/u', '/&ldquo;/u', '/&rdquo;/u', '/&mdash;/u');
	$replace = array('\'', '\'', '"', '"', '-');
	$text = preg_replace($search, $replace, $text);
    //make sure _all_ html entities are converted to the plain ascii equivalents - it appears
    //in some MS headers, some html entities are encoded and some aren't
    //$text = html_entity_decode($text, ENT_QUOTES, 'UTF-8');
    //try to strip out any C style comments first, since these, embedded in html comments, seem to
    //prevent strip_tags from removing html comments (MS Word introduced combination)
	if(mb_stripos($text, '/*') !== FALSE){
		$text = mb_eregi_replace('#/\*.*?\*/#s', '', $text, 'm');
	}
    //introduce a space into any arithmetic expressions that could be caught by strip_tags so that they won't be
    //'<1' becomes '< 1'(note: somewhat application specific)
	$text = preg_replace(array('/<([0-9]+)/'), array('< $1'), $text);
	$text = strip_tags($text, $allowed_tags);
    //eliminate extraneous whitespace from start and end of line, or anywhere there are two or more spaces, convert it to one
	$text = preg_replace(array('/^\s\s+/', '/\s\s+$/', '/\s\s+/u'), array('', '', ' '), $text);
    //strip out inline css and simplify style tags
	$search = array('#<(strong|b)[^>]*>(.*?)</(strong|b)>#isu', '#<(em|i)[^>]*>(.*?)</(em|i)>#isu', '#<u[^>]*>(.*?)</u>#isu');
	$replace = array('<b>$2</b>', '<i>$2</i>', '<u>$1</u>');
	$text = preg_replace($search, $replace, $text);
    //on some of the ?newer MS Word exports, where you get conditionals of the form 'if gte mso 9', etc., it appears
    //that whatever is in one of the html comments prevents strip_tags from eradicating the html comment that contains
    //some MS Style Definitions - this last bit gets rid of any leftover comments */
	$num_matches = preg_match_all("/\<!--/u", $text, $matches);
	if($num_matches){
		$text = preg_replace('/\<!--(.)*--\>/isu', '', $text);
	}
	$text = preg_replace('/(<[^>]+) style=".*?"/i', '$1', $text);
	return $text;
}

function kisalt($par, $uzunluk = 50){
	//$par = strip_word_html($par);
	//$par = preg_replace('/[^\w]/', '', $par);
	$par = trim($par);
	if( strlen($par) > $uzunluk ){
		$par = mb_substr($par, 0, $uzunluk, "UTF-8");
	}
	return $par;
}

function go($par, $time = 0){
	if($time == 0){
		header("Location: {$par}");
	}else{
		header("Refresh: {$time}; url={$par}");
	}
}

function ss($par){
	return stripslashes($par);
}

function session($par){
	if(isset($_SESSION[$par])){
		return $_SESSION[$par];
	}else{
		return false;
	}
}

function session_olustur($par){
	foreach ($par as $anahtar => $deger) {
		$_SESSION[$anahtar] = $deger;
	}
}

function seflink($text){
	$find = array("/Ğ/","/Ü/","/Ş/","/İ/","/Ö/","/Ç/","/ğ/","/ü/","/ş/","/ı/","/ö/","/ç/");
	$degis = array("G","U","S","I","O","C","g","u","s","i","o","c");
	$text = preg_replace("/[^0-9a-zA-ZÄzÜŞİÖÇğüşıöç]/"," ",$text);
	$text = preg_replace($find,$degis,$text);
	$text = preg_replace("/ +/"," ",$text);
	$text = preg_replace("/ /","-",$text);
	$text = preg_replace("/\s/","",$text);
	$text = strtolower($text);
	$text = preg_replace("/^-/","",$text);
	$text = preg_replace("/-$/","",$text);
	return $text;
}

function IsletimSistemiBul() {
	$user_agent 	= $_SERVER['HTTP_USER_AGENT'];
	$os_platform 	= "Bilinmeyen İşletim Sistemi";
	$os_array 		= array(
		'/windows nt 10/i'      =>  'Windows 10',
		'/windows nt 6.3/i'     =>  'Windows 8.1',
		'/windows nt 6.2/i'     =>  'Windows 8',
		'/windows nt 6.1/i'     =>  'Windows 7',
		'/windows nt 6.0/i'     =>  'Windows Vista',
		'/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
		'/windows nt 5.1/i'     =>  'Windows XP',
		'/windows xp/i'         =>  'Windows XP',
		'/windows nt 5.0/i'     =>  'Windows 2000',
		'/windows me/i'         =>  'Windows ME',
		'/win98/i'              =>  'Windows 98',
		'/win95/i'              =>  'Windows 95',
		'/win16/i'              =>  'Windows 3.11',
		'/macintosh|mac os x/i' =>  'Mac OS X',
		'/mac_powerpc/i'        =>  'Mac OS 9',
		'/linux/i'              =>  'Linux',
		'/ubuntu/i'             =>  'Ubuntu',
		'/iphone/i'             =>  'iPhone',
		'/ipod/i'               =>  'iPod',
		'/ipad/i'               =>  'iPad',
		'/android/i'            =>  'Android',
		'/blackberry/i'         =>  'BlackBerry',
		'/webos/i'              =>  'Mobile'
	);
	foreach ( $os_array as $regex => $value ) {
		if ( preg_match($regex, $user_agent ) ) {
			$os_platform = $value;
		}
	}
	return $os_platform;
}
/*
function GirisLog( $Kullanici_ID ){

	Global $db;
	$tarih = date('Y-m-d H:i:s');
	$Ip_Address 		= $_SERVER['REMOTE_ADDR']; // ip adresimizi alıyoruz
	$Geo_Plugin_XML = simplexml_load_file("http://www.geoplugin.net/xml.gp?ip=" . $Ip_Address); //ip adresin bilgilerini alıyoruz

	$IsletimSistemi = IsletimSistemiBul();
	$Tarayici 			= $_SERVER['HTTP_USER_AGENT'];
	$UlkeAdi 				= $Geo_Plugin_XML->geoplugin_countryName;
	$Konum_Enlem 		= $Geo_Plugin_XML->geoplugin_latitude;
	$Konum_Boylam 	= $Geo_Plugin_XML->geoplugin_longitude;

	$Log = $db->insertRow("INSERT INTO site_kullanicilar_log SET
		Kullanici_ID = ?, GirisTarihi = ?, IP_Adresi = ?, IsletimSistemi = ?,
		TarayiciBilgisi = ?, Ulke = ?, Konum_Enlem = ?, Konum_Boylam = ?
		", [$Kullanici_ID, $tarih, $Ip_Address, $IsletimSistemi,
			$Tarayici, $UlkeAdi, $Konum_Enlem, $Konum_Boylam]);


}
*/
function PersonelGirisLog( $PersonelID ){

	Global $db;
	$tarih = date('Y-m-d H:i:s');
	$Ip_Address 		= $_SERVER['REMOTE_ADDR']; // ip adresimizi alıyoruz

	$Log = $db->prepare("INSERT INTO personel_log SET PersonelID = ?, GirisZamani = ?, IpAdres = ?");
	$Log = $Log->execute(array( $PersonelID, $tarih, $Ip_Address ));

}

function GirisDenemesi( $sifirla=null ){

	Global $db;
	$Ip_Address 		= $_SERVER['REMOTE_ADDR']; // ip adresimizi alıyoruz
	$_SESSION['IpAdres'] = $Ip_Address;
	if($sifirla){
		$_SESSION['OturumDenemesi'] = false;
	}
	if(isset($_SESSION['OturumDenemesi'])){
		$_SESSION['OturumDenemesi'] = $_SESSION['OturumDenemesi'] + 1;
		if($_SESSION['OturumDenemesi']=='5'){
			$Log = $db->prepare("INSERT INTO site_block SET IpAdres = ?");
			$Log = $Log->execute(array( $Ip_Address ));
		}
	}else{
		$_SESSION['OturumDenemesi'] = "1";
	}

}

function HataBildir($log){
	Global $db;
	$Log = $db->insertRow("INSERT INTO site_hata_log SET log = ? ", [$log]);

}

function Aktifmi($par){
	if($par == 'a'){
		return 'Aktif';
	}else if($par == 'k'){
		return 'Pasif';
	}
}

?>
