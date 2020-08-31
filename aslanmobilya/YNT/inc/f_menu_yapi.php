<?php 
if(!defined('akbim')){
	exit();
}

function yapiKur($UrlID, $IcerikTipiID){
	Global $db;

	if( $IcerikTipiID == '10' ){
		/*********** Blog Sayfası Yapısı Kur ***********/
		$IcerikOlustur = $db->prepare("INSERT INTO sayfa_yazi SET UrlID=?, Text=? ");
		$IcerikOlustur = $IcerikOlustur->execute(array( $UrlID, ' ' ));
	}
	if( $IcerikTipiID == '50' ){
		/*********** Resimlerin grup halde olmadığı tekli galeri sayfası ***********/
		/*$IcerikOlustur = $db->prepare("INSERT INTO sayfa_yazi SET UrlID=?, Text=? ");
		$IcerikOlustur = $IcerikOlustur->execute(array( $UrlID, ' ' ));*/
	}
	if( $IcerikTipiID == '60' ){
		/*********** Resimlerin grup halde olduğu galeri sayfası ***********/
		/*$IcerikOlustur = $db->prepare("INSERT INTO sayfa_yazi SET UrlID=?, Text=? ");
		$IcerikOlustur = $IcerikOlustur->execute(array( $UrlID, ' ' ));*/
	}
}

?>