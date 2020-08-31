<?php

try {
	$db = new PDO("mysql:host=localhost; dbname=akbimbil_dmereklam; charset=utf8", "akbimbil_dmereklamx", "hqJhJ4WDvLL7");
} catch ( PDOException $e ){
	print $e->getMessage();
}


/*
try {
	$db = new PDO("mysql:host=localhost; dbname=akbimbil_dmereklam; charset=utf8", "root", "");
} catch ( PDOException $e ){
	print $e->getMessage();
}
*/

?>