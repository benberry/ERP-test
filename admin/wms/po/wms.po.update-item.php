<?

	extract($_REQUEST);


	## select
	$sql = "select * from tbl_po_item where po_id=$id ";

	if ($result = mysql_query($sql)){
		while ($row = mysql_fetch_array($result)){
			$qty = $_REQUEST["row_qty_".$row[id]];
			$cost = $_REQUEST["row_cost_".$row[id]];

			### qty
			if ($qty < 1){
				// $update_sql = "delete from tbl_cart_item where id=".$row[id];						

			}else{
				$update_sql="
					update 
						tbl_po_item 
					set 
						balqty=balqty+$qty-qty,
						qty=$qty, 
						cost=$cost
					where
						id=".$row[id];

			}
			if (!mysql_query($update_sql)){
				echo $update_sql."<br>";
			}
		

		}
	
	}else
		echo $sql;

?>
<script>	
//path="../../main/main.php?func_pg=wms.po.edit";	
//path+="&id=<?=$id?>";		
//window.location=path;
</script>