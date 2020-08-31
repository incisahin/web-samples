<?php 
if(!defined('akbim')){
	exit();
}

function fiyatGoster( $sembol, $fiyat ){

	if(!empty($fiyat)){
		return $sembol." ".$fiyat;
	}else{
		return false;
	}

}

function urunResimKontrol($resimAdi){
	$bos = "unnamed.jpg";
	if(strlen($resimAdi)>0){
		if(file_exists( __DIR__."/../".images."/urunler/".$resimAdi)){
			return $resimAdi;
		}else{
			return $bos;
		}
	}else{
		return $bos;
	}
}

function kampanyaVarmi($UrunID){
	try {
		Global $db;
		Global $tarih;
		$Kampanya = $db->prepare("SELECT * FROM urun_kampanya WHERE UrunID = :UrunID");
		$Kampanya->execute(array( "UrunID" => trim( $UrunID ) ));
		if( $Kampanya = $Kampanya->fetch(PDO::FETCH_OBJ) ){
			if( empty($Kampanya->TarihBaslangic) && empty($Kampanya->TarihBitis) ){
				return $Kampanya->KampFiyat;
			}else if( !empty($Kampanya->TarihBaslangic) && empty($Kampanya->TarihBitis) ){
				if( $Kampanya->TarihBaslangic > $tarih )
					return $Kampanya->KampFiyat;
				else
					return false;
			}else if( empty($Kampanya->TarihBaslangic) && !empty($Kampanya->TarihBitis) ){
				if( $Kampanya->TarihBitis < $tarih )
					return $Kampanya->KampFiyat;
				else
					return false;
			}else if( !empty($Kampanya->TarihBaslangic) && !empty($Kampanya->TarihBitis) ){
				if( $Kampanya->TarihBitis < $tarih && $Kampanya->TarihBaslangic > $tarih )
					return $Kampanya->KampFiyat;
				else
					return false;
			}
			
		}else{
			return false;
		}
	} catch (Exception $e) {
		return false;
	}
}

function kategori_bul($ID){
	try {
		Global $db;
		$kategori = $db->prepare("SELECT * FROM urun_kategori WHERE ID = :ID");
		$kategori->execute(array( "ID" => trim( $ID ) ));
		if( $kategori = $kategori->fetch(PDO::FETCH_OBJ) ){
			return $kategori->KategoriAdi;
		}else{
			return false;
		}
	} catch (Exception $e) {
		return false;
	}
}

function kategori_cek($array){
	$yeni_array = array();
	$array = explode(",", $array);
	$array = dizi_bos_temizle($array);
	if(count($array)>0){
		Global $db;
		foreach ( $array as $key ) {

			$kategori = $db->prepare("SELECT * FROM urun_kategori WHERE ID = :ID");
			$kategori->execute(array( "ID" => trim( $key ) ));
			if( $kategori = $kategori->fetch(PDO::FETCH_OBJ) ){
				array_push($yeni_array, $kategori->KategoriAdi);
			}              

		}
		$yeni_array = dizi_bos_temizle($yeni_array);
		if( count($yeni_array)>0 ){
			$kategoriler = implode(", ", $yeni_array);
			return $kategoriler;
		}else{
			return false;
		}
	}else{
		return false;
	}
}

function kategoriler($UstID='0'){
	Global $db;
	$kategoriler = $db->prepare("SELECT * FROM urun_kategori WHERE UstID = :UstID");
	$kategoriler->execute(array( "UstID" => $UstID ));
	if( $kategoriler = $kategoriler->fetchAll(PDO::FETCH_OBJ) ){
		foreach ( $kategoriler as $key ) {
			echo "<li><button class='btn btn-default btn-xs col-md-12 text-left' type='submit' name='Kategori' value='".$key->ID."'>".$key->KategoriAdi."</button></li>\n";
		}
	} 
}


function alt_kategoriler($UstID){
	Global $db;
	$kategoriler = $db->prepare("SELECT * FROM urun_kategori WHERE UstID = :UstID");
	$kategoriler->execute(array( "UstID" => $UstID ));
	if( $kategoriler = $kategoriler->fetchAll(PDO::FETCH_OBJ) ){
		foreach ( $kategoriler as $key ) {
			echo "<li><button class='btn btn-default btn-xs col-md-12 text-left' type='submit' name='AltKategori' value='".$key->ID."'>".$key->KategoriAdi."</button></li>\n";
		}
	} 
}

function alt_kategoriler_secili($ID){
	Global $db;
	$kategoriler = $db->prepare("SELECT * FROM urun_kategori WHERE ID = :ID");
	$kategoriler->execute(array( "ID" => $ID ));
	if( $kategoriler = $kategoriler->fetch(PDO::FETCH_OBJ) ){
		echo "<li><b>".$kategoriler->KategoriAdi."</b></li>\n";
	} 
}


?>