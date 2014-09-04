<?

	## include
		include("../include/init.php");


	## request
		extract($_REQUEST);


	if($cart_id > 0){
	## save
		$tbl = "tbl_cart_item ";
		$sql = "insert into $tbl
				(
					cart_id,
					product_id,
					unit_price,
					unit_weight,
					qty,
					create_date, 
					create_by, 
					active
					
				)values(
					{$cart_id},
					{$product_id},
					{$unit_price},
					{$unit_weight},
					{$qty},
					NOW(), 
					{$_SESSION['user_id']}, 
					1
		
				)
		";

		if (!mysql_query($sql))
			echo $sql;
		
	}

?>
