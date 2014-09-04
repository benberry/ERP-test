<?
	## include
	require_once("../include/init.php");

	$url = get_cfg("company_website_address")."data-feed/shopbot.php";
	$aud_xml = file_get_contents($url, 1);
    
	$myFile = "../../data-feed/shopbot.com.xml";
	$fh = fopen($myFile, 'w') or die("can't open file");

	fwrite($fh, $aud_xml);
	fclose($fh);
	

?>