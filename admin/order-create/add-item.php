<?
	## init
	include("../include/init.php");
	include("../include/html_head.php");
	
	## request
	extract($_REQUEST);
	$item_id = $add_item_id;
	

	## insert
	if ($item_photo_id==''){

		$sql="insert into tbl_cart_item(
				cart_id,
				product_id,
				original_price,
				unit_price,
				unit_weight,
				price_adjustment,
				price_balancer,
				price_profit,				
				qty,
				create_date, 
				create_by,
				active
				
			)values(
				{$id},
				{$item_id},
				".get_price($item_id).",
				".get_price($item_id).",
				".get_field("tbl_product", "weight", $item_id).",
				0,
				0,
				0,
				1,
				NOW(), 
				{$_SESSION['user_id']}, 
				1
	
			)

		";
		
		if (mysql_query($sql)){
			
			$insert_id=mysql_insert_id();
			
		}else
			echo $sql;
		
		## member create date	
		set_field_data("tbl_cart", "member_create_date", $id, date("Y-m-d H:i:s"));
		
		## set currency and exchange rate
		set_field_data("tbl_cart", "currency_id", $id, 1);
		set_field_data("tbl_cart", "exchange_rate", $id, 1);
		
		## set shipping cost
		$shipping_method_id = 2;
		set_field_data("tbl_cart", "shipping_method_id", $id, $shipping_method_id);
		$shipping_country_id = 14;
		set_field_data("tbl_cart", "shipping_country_id", $id, $shipping_country_id);
		
		$shipping_cost = round(shipping_express($id, $shipping_country_id), 2);
		set_field_data("tbl_cart", "shipping_cost", $id, $shipping_cost);
		
		## set payment and surcharge
		$payment_method_id = 1;
		set_field_data("tbl_cart", "payment_method_id", $id, $payment_method_id);
		set_field_data("tbl_cart", "subcharge", $id, 0);
		
		$surcharge_percent = get_field("tbl_payment_method", "subcharge", $payment_method_id);
		$surcharge = round(get_cart_total_amount($id) * ($surcharge_percent/100), 2);
		set_field_data("tbl_cart", "subcharge", $id, $surcharge);
			
	}

?>
<script>
	path="../main/main.php?func_pg=index";
	path+="&id=<?=$id?>";
	path+="&tab=<?=$tab?>";
	window.location=path;
</script>