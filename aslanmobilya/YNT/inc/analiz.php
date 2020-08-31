<?php

function toplam_personel(){

	Global $db;
	$sor = $db->query("SELECT COUNT(ID) AS 'x' FROM personeller WHERE ID != '1' ")->fetch(PDO::FETCH_OBJ);
	return $sor->x;

}

function toplam_sayfa(){

	Global $db;
	$sor = $db->query("SELECT COUNT(UrlID) AS 'x' FROM sayfa_url ")->fetch(PDO::FETCH_OBJ);
	return $sor->x;

}
/*
function toplam_ziyaretci(){

	Global $db;
	$sor = $db->query("SELECT COUNT(ID) AS 'x' FROM ziyaretci_log ")->fetch(PDO::FETCH_OBJ);
	return $sor->x;

}
*/

 ?>
