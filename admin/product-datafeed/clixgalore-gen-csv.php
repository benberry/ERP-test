<?

	## include
	include("../include/init.php");

	$url = get_cfg("company_website_address")."data-feed/clixgalore.php";
	$aud_xml = file_get_contents($url, 1);
	
	$myFile = get_cfg("company_website_address")."data-feed/clixgalore.csv";
	$fh = fopen($myFile, 'w') or die("can't open file");
	fwrite($fh, $aud_xml);
	fclose($fh);

?>