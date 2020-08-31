<?php
if(!defined('akbim')){
	exit();
}


function SelectSorgusu(){
	$sql = "SELECT
	(SELECT Resim FROM urun_galeri WHERE UrunID=uy.ID ORDER BY Varsayilan DESC, ID DESC LIMIT 1) AS 'Resim',
	uy.ID AS 'UrunID', uy.KategoriID, uy.Baslik, uy.Fiyat, uy.UrunKodu, uy.Bilgi, uy.KisaBilgi,
	su.ID AS 'UrlID', su.SeoUrl, su.UstID, su.GeciciKeyw, uk.KampFiyat, kur.Sembol AS 'KurSembol', kur.ID AS 'KurID', kat.KategoriAdi
	FROM urun_yapi uy
	LEFT JOIN urun_kurlari kur ON uy.KurID = kur.ID
	LEFT JOIN urun_kampanya uk ON uy.ID = uk.UrunID
	LEFT JOIN urun_kategori kat ON uy.AnaKategoriID = kat.ID
	LEFT JOIN sayfa_url su ON su.ID = uy.UrlID
	";
	return $sql;
}


function WhereSorgusu( $KategoriID ){

	$string = "";

	if(!empty($KategoriID)){
		$string = " WHERE uy.KategoriID IN (".$KategoriID.") ";
	}
	return $string;
}

function OrderBy( $tip=null ){
	$string = " ORDER BY uy.ID DESC ";
	return $string;
}

function Sayfalama( $sql ){
	/***************  Toplam İçerik *************/
	if( !empty($sql) ){

		Global $db;
		$toplam_icerik = $db->prepare( $sql );
		$toplam_icerik->execute(array( ));
		$toplam_icerik = $toplam_icerik->rowCount();
		if( $toplam_icerik > 0 ){
			return $toplam_icerik;
		}else{
			return 0;
		}
	}else{
		return false;
	}
}
?>
