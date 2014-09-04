<?

	## include
		include("../include/init.php");


	## request
		extract($_REQUEST);


	if($item_id > 0){
	## save
		$tbl = " tbl_cart_item ";
		$sql = " delete from $tbl where id=$item_id ";

		if (!mysql_query($sql))
			echo $sql;

	}

?>
