<?

	## include
	//include("../include/init.php");


	$sql = "
		select 
			*
		from 
			tbl_product
		where
			active=1
			and deleted=0
			and stock_status<4			
			and display_to_shopbot=1
		order by
			stock_status,
			sort_no desc
			
	";
	
	if ($result = mysql_query($sql)){
		
		$out .= '"Product Id",';
		$out .= '"MPN",';
		$out .= '"Category",';	
		$out .= '"Product Name",';
		$out .= '"Product URL",';
		$out .= '"Price",';
		$out .= '"Stock Description",';
		$out .= '"Image URL"'.",\n";
		
		while ($row = mysql_fetch_array($result)){
			
			$out .= "\"".$row[id]."\"".",";
			$out .= "\"\",";
			$out .= "\"".$row[shopping_subcat_name]."\"".",";
			$out .= "\"".$row[name_1]."\"".",";
			$out .= "\"".get_cfg("company_website_address").get_mod_rewrite($row[name_1], $row[id])."\"".",";
			$out .= "\"".round($row[price_1], 2)."\"".",";
			$out .= "\"In Stock\",";
			$out .= "\"".get_cfg("company_website_address").str_replace("../../", "", get_item_image_first("tbl_product_photo", $row[id]))."\"".", \n";
	
		}

	}else
		echo $sql;			

	
	

    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Content-Length: " . strlen($out));
    header("Content-type: text/x-csv");
    header("Content-Disposition: attachment; filename=shopbot-".date("Y-m-d").".csv");

	
    echo $out;
    exit;
 
	
?>