<?php


if(!defined('akbim')){
	exit();
}

function bulidTree($elements, $parentId = 0){

	$branch = array();

	foreach ($elements as $element) {

		if($element->UstID == $parentId){

			$children = bulidTree($elements, $element->UrlID);

			if($children){
				$element->children = $children;
			}else{
				$element->children = array();
			}

			$branch[] = $element;

		}

	}

	return $branch;

}

function return_arrayCount($array,$string){
	if(is_array($array)){
		if(count($array)>0)
			return $string;
	}
}

function re_turn($a,$b,$string){
	if($a==$b)
		return $string;
}

function icon( $icon ){
	if(!empty( $icon ))
		return "<i class='nav-icon ".$icon."'></i>";
}

function className ( $tip, $tur, $item=null ){
	Global $url;
	if( $tip == 'ul' ){
		if($tip == "ul" && $tur == 0)
			return ' ';
		if($tip == "ul" && $tur == 1)
			return ' class="submenu"';
	}
	if( $tip == 'li' ){
		if($tip == "li" && $tur == 0 ){
			//return ' class="nav-item  has-treeview"';
		}
		if($tip == "li" && $tur == 1 ){
			//return ' class="nav-item '.return_arrayCount($item->children,'has-treeview').' '.re_turn($item->UrlID,$url->UstID,'menu-open').' "';
		}
	}
	if( $tip == 'a' ){
		if($url['UrlID'] == $item->UrlID )
			return ' active';
	}

}

/*
<ul>
	<li class="active"><a href="#intro">Anasayfa</a></li>
	<li><a href="#urun_hakkinda">REGLSONN COMFORT® HAKKINDA</a></li>
	<li><a href="#contact">İletişim</a></li>

</ul>
*/

function drawElements( $items, $url_ek = '', $tur = 0 ){
	Global $url;

	echo '<ul'.className('ul',$tur).'>';
	echo "\n";

	foreach ( $items as $item ) {

		$_url = url.'/'.$item->SeoUrl;

		if( sizeof($item->children) > 0 ){
			$tur++;

			echo '<li'.className('li',$tur,$item).'>
			<a href="'.$_url.'.html" class="'.className('a',$tur, $item).'">
			'.icon($item->icon).'
			' .$item->Baslik.'
			</a>';
			echo "\n";

			drawElements($item->children, $item->SeoUrl.'/', $tur);

			echo "</li>\n";

		}else{
			echo '<li'.className('li',$tur,$item).'>
			<a href="'.$_url.'.html" class="' .className('a',$tur, $item). ' ">
			'.icon($item->icon).'
			' .$item->Baslik.'
			</a></li>';
			echo "\n";
		}

		$tur=0;
	}

	echo "</ul>\n";


}


function admin_menu_option( $items, $seçilen=null ){

	foreach ( $items as $item ) {

		$ID = $item->UrlID;
		$baslik = $item->Baslik;

		$selected = "";
		$bosluk = "";
		$bosluk_sayisi = intval($item->bosluk_sayisi) - 1;
		for ($i=0; $i < $bosluk_sayisi ; $i++) {
			$bosluk = $bosluk . "---";
		}
		if($bosluk!="")
			$bosluk = $bosluk . "&nbsp;";

		if($seçilen==$ID)
			$selected = " selected ";

		if( sizeof($item->children) > 0 ){

			echo '<option value="'.$ID.'" '.$selected.'>' . $bosluk . $baslik . '</option>';

			admin_menu_option($item->children, $seçilen);


		}else{
			echo '<option value="'.$ID.'" '.$selected.'>' . $bosluk . $baslik . '</option>';
		}

	}

}

function admin_menu_option_kategoriler( $items, $seçilen=null ){

	foreach ( $items as $item ) {

		$AnaKategori = $item->ID;
		if( $item->UstID == 0 ){

			echo '<optgroup label="'. $item->KategoriAdi .'">';
			foreach ( $item->children as $item ) {
				$selected = "";
				if($seçilen==$item->ID){
					$selected = " selected ";
				}
				echo '<option value="'.$AnaKategori.",".$item->ID.'" '.$selected.'>' . $item->KategoriAdi . '</option>';
			}
			echo '</optgroup>';

		}

	}

}

	/*
	<ol class="breadcrumb float-sm-right">
		<li class="breadcrumb-item"><a href="#">Home</a></li>
		<li class="breadcrumb-item active">Dashboard v2</li>
	</ol>
	*/


	function breadcrumb ( ){

		$bread = "";
		$array = kontrol_dizi_mi( getArray() );
		if($array){
			if(count($array)>0){
				$bread .= '<ol class="breadcrumb float-sm-right">';
				$bread .= '<li class="breadcrumb-item"><a href="'.url.'"> Anasayfa</a></li>';
				for ($i=count($array)-1; $i > 0; $i--) {
					$bread .= '<li class="breadcrumb-item"><a href="'.url . getUrlOlustur($array[$i]).'">'._seourl_id( $array[$i], 'baslik' ).'</a></li>';
				}
				$bread .= '<li class="breadcrumb-item active">'._seourl_id( current($array), 'baslik' ).'</li>';
				$bread .= '</ol>';
			}
		}

		echo $bread;
	}
	?>
