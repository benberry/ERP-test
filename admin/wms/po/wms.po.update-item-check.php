<?

	extract($_REQUEST);


	## select
	$sql = "select * from tbl_po_item where po_id=$id ";

	if ($result = mysql_query($sql)){
		while ($row = mysql_fetch_array($result)){
			$qty = $_REQUEST["row_qty_".$row[id]];
			$cost = $_REQUEST["row_cost_".$row[id]];
			$sku = get_field("tbl_erp_product", "sku", $row[product_id]);
$tmpqty = $row[balqty] + $qty- $row[qty];
			### qty
			if ($qty < 1){
				// $update_sql = "delete from tbl_cart_item where id=".$row[id];						

			}else{
				if($row[balqty] + $qty- $row[qty] < 0){
					$error_msg = $error_msg."SKU: ".$sku." pending qty is ".$row[balqty].". Order qty cannot be deducted more than pending qty.<br/>";
				}

			}
		

		}
	
	}else
		echo $sql;

?>
