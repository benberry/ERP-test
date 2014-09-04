<?	
## init	
	session_start();
	require_once("../../library/config.func.php");
	require_once("../../library/common.func.php");
	require_once("../../library/main.func.php");
	require_once("../../library/date.func.php");
	require_once("../../library/sql.func.php");
	require_once("../../library/paging.func.php");	
	require_once("../../library/sys-right.func.php");
	require_once("../../library/file-upload.func.php");	

	require_once("../../library/item.func.php");
	require_once("../../library/category.func.php");
	require_once("../../library/member.func.php");
	require_once("../../library/product.func.php");	
	require_once("../../library/order-management.func.php");
	check_system_user_login();		
## request	
extract($_REQUEST);	
$dialog = "";

if(!empty($add_item_id))	///////Add new product
{
	$item_id = $add_item_id;		
	//echo "product id:$item_id <br>";
	//Find Product Detail
	$sql = "SELECT * FROM tbl_erp_product WHERE id = {$item_id}";
	if($rows = mysql_query($sql))
	{	
		$num_rows = mysql_num_rows($rows);	
		if ($num_rows > 0 )
		{	$row = mysql_fetch_array($rows);
			$item_sku = $row[sku];
			$item_name = $row[name];
			//echo "sku:$item_sku <br>";
			//echo "name:$item_name <br>";
			## INSERT		
			$sql="INSERT INTO tbl_order_item (order_id, sku, name) VALUES ({$order_id}, '".addslashes($item_sku)."', '".addslashes($item_name)."');";	
			//echo $sql;
			if (mysql_query($sql)){						
				$insert_id=mysql_insert_id();
				update_order_modify($order_id, $_SESSION['user_id']);				
				$dialog = "Successfully Add New Item.";				
			}else			
				$dialog=$sql;					
		}
	}else
		echo $sql;
}else if($item_edit_type == "delete"){	/////////delete product
	$sql = "UPDATE tbl_order_item SET is_cancel_item = 1 WHERE id = $item_id";
	if (mysql_query($sql))
	{	update_order_modify($order_id, $_SESSION['user_id']);
		update_product_so($item_sku, $qty_ordered, "-", $_SESSION['user_id']);
		$dialog = "Successfully Deleted Item.";		
	}else
		$dialog = $sql;
}else if($item_edit_type == "update"){	///update product
	for($i=0; $i<$cb_counting; $i++)
	{	$item_id = $_POST["cb_".$i."_id"];
		$item_sku = $_POST["cb_".$i."_sku"];
		$unit_price = $_POST["cb_".$i."_unitprice"];
		if(is_numeric($unit_price))
		{	if(ISSET($_POST["cb_".$i."_qty"]) && $_POST["cb_".$i."_qty"] !="")
			{	$qty_ordered = $_POST["cb_".$i."_qty"];
				$sql = "UPDATE tbl_order_item SET subtotal=".$qty_ordered*$unit_price.", unit_price={$unit_price}, qty_ordered={$qty_ordered} WHERE id={$item_id}";
				if(!(is_numeric($qty_ordered) && $qty_ordered>0))
				{	$dialog .= "Warning: number required only in row(s): ".($i+1)."!<br>";
					continue;
				}else
					update_product_so($item_sku, $qty_ordered, "+", $_SESSION['user_id']);
			}else if(!ISSET($_POST["cb_".$i."_qty"]) && $_POST["cb_".$i."_unitprice"]!=""){
				$sql = "UPDATE tbl_order_item SET subtotal=qty_ordered*".$unit_price.", unit_price={$unit_price} WHERE id={$item_id}";
			}else{
				$dialog .= "Warning: Blank Qty Or Unit Price row skipped in row: ".($i+1)."!<br>";
				continue;			
			}
			mysql_query($sql);	
			update_order_modify($order_id, $_SESSION['user_id']);
		}else
			$dialog .= "Warning: number required only in row: ".($i+1)."!<br>";
	}
	$dialog .= "Successfully Update Item.";

}else{
	$dialog = "No Item had selected for adding!";
}

	//*** dialog
	$back_to = '../main/main.php?func_pg=oms.so.items.edit&id='.$order_id.'&order_no='.$order_no;
	include("../main/dialog.php");
	
	## UPDATE modify time
	function update_order_modify($order_id, $user_id)
	{	
		////////////GET order total, shipping charge, surcharge//////////////
		$sql = "SELECT grand_total, base_shipping_incl_tax, base_fooman_surcharge_amount FROM tbl_order WHERE id={$order_id}";
		$rows = mysql_query($sql);
		$row = mysql_fetch_array($rows);
		$grand_total = $row[grand_total];
		$shipping_charge = $row[base_shipping_incl_tax];
		$surcharge = $row[base_fooman_surcharge_amount];
		
		$ERP_total = get_ERP_total($order_id, $shipping_charge, $surcharge);
		//echo "ERP_total:$ERP_total<br>";
		if($ERP_total > $grand_total)		
		{	//echo "ERP_total > grand_total<br>";
			$sql = "UPDATE tbl_order SET payment_check=0, modify_date = ADDDATE(NOW(), INTERVAL 13 HOUR), modify_by={$user_id} WHERE id={$order_id}";
			$INSERT_SQL = "INSERT INTO tbl_order_check_record (order_id, check_type, check_value, create_date, create_by) VALUES ({$order_id}, 'payment', 'un-check by edit item', ADDDATE(NOW(), INTERVAL 13 HOUR), {$user_id})";
			mysql_query($INSERT_SQL);
		}else{
			//echo "ERP_total < grand_total<br>";
			$sql = "UPDATE tbl_order SET modify_date = ADDDATE(NOW(), INTERVAL 13 HOUR), modify_by={$user_id} WHERE id={$order_id}";
		}
		mysql_query($sql);
	}
	## UPDATE product so_qty
	function update_product_so($sku, $qty, $operator, $user_id)
	{	
		$sql = "SELECT so_qty FROM tbl_erp_product WHERE sku='".addslashes($sku)."'";
		if($rows = mysql_query($sql))
		{	$so_qty_sql = "so_qty=";
			$num_rows = mysql_num_rows($rows);	
			if ($num_rows > 0 )
			{	$row = mysql_fetch_array($rows);
				$so_qty = $row[so_qty];
				if($operator == "-" && $so_qty <= $qty)
					$so_qty_sql .= "0";
				else
					$so_qty_sql .= "so_qty".$operator.$qty;
				
				$sql = "UPDATE tbl_erp_product SET modify_date = ADDDATE(NOW(), INTERVAL 13 HOUR), modify_by={$user_id}, ".$so_qty_sql." WHERE sku='".addslashes($sku)."'";
				mysql_query($sql);
				//echo "<br>".$sql."<br>";
			}
		}
	}
	
	function get_ERP_total($order_id, $shipping_charge, $surcharge){	
		$sql = " select * from tbl_order_item where is_cancel_item=0 AND order_id={$order_id} order by id asc ";		
		if ( $result = mysql_query($sql)){
		$product_info = "";
		$sum_subtotal = 0;
		while ($row = mysql_fetch_array($result)){
			$sum_subtotal = $sum_subtotal+$row[subtotal];			
			}
			$erp_total = $sum_subtotal+$shipping_charge+$surcharge;			
			return $erp_total;
		}else
			return $sql;
	}
?>
