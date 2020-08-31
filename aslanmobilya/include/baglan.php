<?php

try {
	//$db = new PDO("mysql:host=localhost; dbname=akbimbil_bilgianaliz; charset=utf8", "akbimbil_bilgianalizuser", "8E~(-kl9D2FW");
	$db = new PDO("mysql:host=localhost; dbname=aslanmobilya; charset=utf8", "root", "");
} catch ( PDOException $e ){
	print $e->getMessage();
}


?>
