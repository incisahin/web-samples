<?php
require_once 'inc.php';
require_once '../include/ayarlar.php';
require_once '../include/fonksiyon.php';
// A list of permitted file extensions
if (!empty($_FILES)) {
	require('../include/class.upload.php');
	$image = new \Verot\Upload\Upload($_FILES["file"]);
	if ( $image->uploaded ) {
		$image->file_new_name_body = sha1(md5(date("1YmdHis")));
		$image->allowed = array('image/jpeg','image/jpg','image/gif','image/png');
		$image->mime_check = true;
		$image->no_script = true;
		$image->auto_rename = true;
		$image->image_convert = 'webp';
		$image->webp_quality = 50;
		$image->image_resize = true;
		$image->image_y = 500;
		$image->image_ratio_x = true;
		$image->Process('../'.images.'/icerik/');

		if($image->processed){

			$tmp =  url.'/'.images.'/icerik/'.$image->file_dst_name;
			echo url.'/'.images.'/icerik/'.$image->file_dst_name;

		}

	}
} //if image uploaded
