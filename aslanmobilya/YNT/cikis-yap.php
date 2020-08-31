<?php 
require_once 'inc.php';
require_once '../include/ayarlar.php';
require_once '../include/fonksiyon.php';
session_destroy();
if(isset($_SESSION['Oturum'])){
	header('location: '.URL);
}
?>