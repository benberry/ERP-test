<?
	## include
	require_once("../include/init.php");

	$url = get_cfg("company_website_address")."data-feed/shopping.com.php";
	
	// echo "URL-> $url <br />";
	
	$aud_xml = file_get_contents($url, 1);
	
	

	//$myFile = get_cfg("company_website_address")."data-feed/shopping.com.xml";
	$myFile = "../../data-feed/shopping.com.xml";
	
	// echo "MyFile-> $myFile <br />";
		
	$fh = fopen($myFile, 'w') or die("can't open file");
	
	// echo "Fh: $fh <br />";
	
	// echo "fwrite->".fwrite($fh, $aud_xml);
	
	fclose($fh);

?>