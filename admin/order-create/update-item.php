<?
	## init
	include("../include/init.php");
	include("../include/html_head.php");


	## request
	extract($_REQUEST);


	## select
	$sql = "select * from tbl_cart_item where cart_id=$id ";

	if ($result = mysql_query($sql)){

		while ($row = mysql_fetch_array($result)){

			$qty = $_REQUEST["row_qty_".$row[id]];
			$unit_price = $_REQUEST["row_price_".$row[id]];
			$unit_weight = $_REQUEST["row_weight_".$row[id]];

			### qty
			if ($qty < 1){
				// $update_sql = "delete from tbl_cart_item where id=".$row[id];						

			}else{
				$update_sql="
					update 
						tbl_cart_item 
					set 
						qty=$qty, 
						unit_price=$unit_price, 
						unit_weight=$unit_weight 
					where
						id=".$row[id];

			}
			
			if (!mysql_query($update_sql)){
				echo $update_sql."<br>";
			}
			
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
	
	}else
		echo $sql;

?>
<script>
	path="../main/main.php?func_pg=index";
	path+="&id=<?=$id?>";
	path+="&tab=<?=$tab?>";
	window.location=path;
</script>