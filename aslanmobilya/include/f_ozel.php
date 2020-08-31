<?php

if(!defined('akbim')){
	exit();
}


function sliderStyle($Resim, $Class=null){
	if(file_exists(__DIR__."/../img/slider/".$Resim)){
		$Class = trim($Class);
		if(strlen($Class)>0){
			if($Class=="pozisyon-orta")
				$stil = " background-position: center center;";
			if($Class=="pozisyon-sol")
				$stil = " background-position: left left;";
			if($Class=="pozisyon-sag")
				$stil = " background-position: right center;";
		}
		$style = "background-image: url('img/slider/".$Resim."');background-repeat: no-repeat;background-size: cover;".$stil;
		return $style;
	}
}


function fiyatTablosu_Basvur($fiyat){
		if($fiyat)
			return '<a href="<?=site_tam_url?>/#" class="tema-butonu">Satın Al</a>';
			//return '<button type="button" name="button" class="btn btn-primary"><i class="fa fa-paper-plane"></i> Satın Al</button>';
		else {
			return '<button type="button" name="button" class="btn btn-green"><i class="fa fa-paper-plane"></i> Başvur</button>';
		}
}
function fiyatTablosu_FiyatGor($fiyat){
		if($fiyat)
			return "<span>".$fiyat." <i class='fa fa-turkish-lira'></i></span>";
		else {
			return "<span class='ucretsiz'>Ücretsiz</span>";
		}
}

 ?>
