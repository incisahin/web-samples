<?php
define("akbim", true);
require_once 'include/ayarlar.php';
header('Content-type: text/xml');
echo '<?xml version="1.0" encoding="UTF-8"?>';
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">';

echo "
<url>
<loc>https:".url."</loc>
<lastmod>".date("Y")."-".date("m")."-".date("d")."T".date("H:i:s")."+03:00</lastmod>
<changefreq>always</changefreq>
<priority>1</priority>
</url>
";

$category_list  = $db->query("SELECT * FROM sayfa_url WHERE UrlID != '4' AND UrlID != '1' ORDER BY OlusturmaTarihi DESC", PDO::FETCH_OBJ)->fetchAll();
foreach ( $category_list as $key ) {
	if( $key->IcerikTipiID != '100' ){
		echo "
		<url>
		<loc>https:".url."/".$key->SeoUrl.".html</loc>
		<lastmod>".date( 'Y-m-d', strtotime($key->OlusturmaTarihi) )."T".date( 'H:i:s', strtotime($key->OlusturmaTarihi) )."+03:00</lastmod>
		<changefreq>always</changefreq>
		<priority>0.9</priority>
		</url>
		";
	}
}
echo "</urlset>";
?>
