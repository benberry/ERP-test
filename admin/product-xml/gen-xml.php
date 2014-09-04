<?

	## include
	include("../include/init.php");
	
	
	## AU
	$url = get_cfg("company_website_address")."admin/product-xml/product-list-aud.php";
	$aud_xml = file_get_contents($url, 1);


	$myFile = "../product-xml/google-merchant-aud.xml";
	$fh = fopen($myFile, 'w') or die("can't open file");
	fwrite($fh, $aud_xml);
	fclose($fh);


?>