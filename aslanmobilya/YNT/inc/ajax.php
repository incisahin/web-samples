<?php 
require_once '../inc.php';
require_once '../../include/baglan.php';
require_once '../../include/fonksiyon.php';

if(isset($_POST['MenuAdi'])){
	echo seflink($_POST['MenuAdi']);
}

if(isset($_POST['veriler'])){
	$veriler = $_POST['veriler'];

	for ($i=0; $i < count($veriler); $i++) { 
		$guncelle = $db->prepare("UPDATE sayfa_menuler SET Sira = :S WHERE ID = :ID");
		$ok = $guncelle->execute(array( "S" => ($i + 1), "ID" => $veriler[$i] ));
		if($ok){
			echo "Taşıma işlemi başarılı\n";
		}
	}
}

if( isset($_POST['IcerikTipi']) && isset($_POST['Menu_ID']) && isset($_POST['Islem']) ){
	$Menu_ID = $_POST['Menu_ID'];
	$IslemTuru = $_POST['Islem'];

	if( $IslemTuru == 'ekle' ){
		$Ekle = $db->prepare("INSERT INTO icerik_menuler SET IcerikTipi_ID = ?, SayfaMenu_ID = ?");
		$ok = $Ekle->execute(array( $_POST['IcerikTipi'], $_POST['Menu_ID'] ));
		if($ok){
			echo "Menü Tipi Başarıyla Eklendi\n";
		}
	}else if( $IslemTuru == 'sil' ){
		$query = $db->prepare("DELETE FROM icerik_menuler WHERE ID = :IcerikTipi");
		$delete = $query->execute(array( 'IcerikTipi' => $_POST['IcerikTipi'] ));
		if($delete){
			echo "Menü Tipi Başarıyla Kaldırıldı\n";
		}
	}
}


if( isset($_POST['MenuCek_ID']) ){
	?>
	<div id="avaible" class="col-md-12" style="background-color: #d2d2d2;">
		<i class="fa fa-plus fa-x4"></i>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	</div>
	<?php
	$menuler = querys("SELECT im.ID, it.IcerikAdi
		FROM icerik_menuler im
		LEFT JOIN icerik_tipleri it ON it.ID = im.İcerikTipi_ID
		WHERE im.SayfaMenu_ID = '$_POST[MenuCek_ID]' ");

	if($menuler->rowCount()>0){
		foreach ($menuler as $m) {
			?>
			<div id="<?=$m['ID']?>" class="panel-heading col-md-12" style="border: dotted 1px #212566;">
				<?=$m['IcerikAdi']?>
			</div><br>
			<?php
		}
	}
}

?>