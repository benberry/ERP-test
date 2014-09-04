<?
	## init
		include("../include/init.php");
		include("../include/html_head.php");


	## request
		extract($_REQUEST);


	## select
		$sql = "delete from tbl_cart_item where id=$item_id";
		
		if (!mysql_query($sql)){
			echo $sql."<br>";

		}

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
			$surcharge = round(get_cart_total_amount($id) * ($surcharge_percent / 100), 2);
			set_field_data("tbl_cart", "subcharge", $id, $surcharge);

?>
<script>
	path="../main/main.php?func_pg=index";
	path+="&id=<?=$id?>";
	path+="&tab=<?=$tab?>";
	window.location=path;
</script>