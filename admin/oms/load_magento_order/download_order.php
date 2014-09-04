<?php
	session_start();
	require_once("../../../library/config.func.php");
	require_once("../../../library/common.func.php");
	require_once("../../../library/main.func.php");
	require_once("../../../library/date.func.php");
	require_once("../../../library/sql.func.php");
	require_once("../../../library/paging.func.php");	
	require_once("../../../library/sys-right.func.php");
	require_once("../../../library/file-upload.func.php");	
                    
	require_once("../../../library/item.func.php");
	require_once("../../../library/category.func.php");
	require_once("../../../library/member.func.php");
	require_once("../../../library/product.func.php");	
	require_once("../../../library/order-management.func.php");
	
	$last_id = mysql_result(mysql_query("SELECT magento_order_id FROM tbl_order ORDER BY magento_order_id DESC LIMIT 1"),0);
	$xml = simplexml_load_file("http://www.android-enjoyed.com/export/it/order_export_xml.php?OrderID=".$last_id) 
   or die("Error: Cannot create object");
   
  foreach($xml->children() as $Order_Records) //////////Get Detail of Order_Records
{	$sku_to_so_array = array();
	$status = $Order_Records->status;
	$order_status_id = mysql_result(mysql_query("SELECT id FROM tbl_order_status WHERE code='".$status."'"),0);
	$Order_Info_array = array(
	"magento_order_id" => (int)$Order_Records->magento_order_id,
	"order_no" => $Order_Records->order_no,
	"order_status_id" => (int)$order_status_id,
	"store_id" => (int)$Order_Records->store_id,
	"customer_email" => $Order_Records->customer_email,
	"customer_firstname" => $Order_Records->customer_firstname,
	"customer_lastname" => $Order_Records->customer_lastname,
	"order_currency_code" => $Order_Records->order_currency_code,
	"shipping_method" => $Order_Records->shipping_method,
	"base_shipping_incl_tax" => (double)$Order_Records->base_shipping_incl_tax,
	"base_fooman_surcharge_amount" => (double)$Order_Records->base_fooman_surcharge_amount,
	"fooman_surcharge_description" => $Order_Records->fooman_surcharge_description,
	"base_discount_amount" => (double)$Order_Records->base_discount_amount,
	"base_subtotal" => (double)$Order_Records->base_subtotal,
	"base_grand_total" => (double)$Order_Records->base_grand_total,
	"grand_total" => (double)$Order_Records->grand_total,
	"base_tax_amount" => (double)$Order_Records->base_tax_amount,
	"remote_ip" => $Order_Records->remote_ip,
	"shipping_method" => $Order_Records->shipping_method,
	"payment_method" => $Order_Records->payment_method,
	);
	echo "<br>Order Info<br>";
	foreach($Order_Info_array  as $key => $value)
	{
		echo "$key : $value <br>";
	
	}
	$insert_sql = create_insert_sql("tbl_order", $Order_Info_array);
	if (!mysql_query($insert_sql)){
		echo $insert_sql."<br>";				
	}
	else{
		$erp_order_id = mysql_insert_id();
	}
	////////////////Billing Address/////////////////
	$billing_address = $Order_Records->billing_address;
	$Billing_address_array = array(
	"order_id" => $erp_order_id,
	"first_name" => $billing_address->first_name,
	"last_name" => $billing_address->last_name,
	"country" => $billing_address->country,
	"region" => $billing_address->region,
	"city" => $billing_address->city,
	"street" => $billing_address->street,
	"company" => $billing_address->company,
	"post_code" => $billing_address->post_code,
	"telephone" => $billing_address->telephone,
	);
	echo "<br>Billing Address<br>";
	foreach($Billing_address_array  as $key => $value)
	{
		echo "$key : $value <br>";
	
	}
	$insert_sql = create_insert_sql("tbl_order_billing_address", $Billing_address_array);
	if (!mysql_query($insert_sql)){
		echo $insert_sql."<br>";				
	}
	//$Insert_Billing = "INSERT INTO tbl_order_billing_address (order_id) VALUES ({$id})";
	//if(!mysql_query($Insert_Billing))
	//	$dialog .= "<br>".$Insert_Billing;
	////////////////Shipping Address/////////////////
	$shipping_address = $Order_Records->shipping_address;
	$Shipping_address_array = array(
	"order_id" => $erp_order_id,
	"first_name" => $shipping_address->first_name,
	"last_name" => $shipping_address->last_name,
	"country" => $shipping_address->country,
	"region" => $shipping_address->region,
	"city" => $shipping_address->city,
	"street" => $shipping_address->street,
	"company" => $shipping_address->company,
	"post_code" => $shipping_address->post_code,
	"telephone" => $shipping_address->telephone,
	);
	echo "<br>Shipping Address<br>";
	foreach($Shipping_address_array  as $key => $value)
	{
		echo "$key : $value <br>";
	
	}	
	$insert_sql = create_insert_sql("tbl_order_shipping_address", $Shipping_address_array);
	if (!mysql_query($insert_sql)){
		echo $insert_sql."<br>";				
	}
	//$Insert_Shipping = "INSERT INTO tbl_order_shipping_address (order_id) VALUES ({$id})";
	//if(!mysql_query($Insert_Shipping))
	//	$dialog .= "<br>".$Insert_Shipping;
	
	$item_detail = $Order_Records->item_detail;
	foreach($item_detail->children() as $main_item)
	{	$item_insert_array = array();
		$main_sku = $main_item->main_sku;
		$unit_price = round((double)$main_item->unit_price,2);
		echo "unit_price--$unit_price<br>";
		if(ISSET($main_item->item_options))	//////if product has option(s)
		{	
			$item_options = $main_item->item_options;
			foreach($item_options->children() as $option_detail)
			{	//$main_sku
				$optionTitle = $option_detail->optionTitle;
				$optionSku = $option_detail->optionSku;
				$optionQty = 1;	
				$optionPrice = 0;
				$optionSubTitle = "";
				if(stripos($option_detail->optionValue, " x ") !== false) //// if has ? X ?
				{	$optionValue = $option_detail->optionValue;
					$option_value_array = preg_split('/ [xX] /',$optionValue);
					//echo "qty: ".$option_value_array[0]." ----- name:".$option_value_array[1]."<br>";
					if(is_numeric($option_value_array[0]))
						$optionQty = $option_value_array[0];	///update qty
						
					$optionValue = $option_value_array[1];
				}else
					$optionValue = $option_detail->optionValue;
					
				if(stripos($option_detail->optionValue, " - $") !== false) //// find price
				{	
					$option_value_array = preg_split('/ - \$/',$optionValue);
					$optionSubTitle = $option_value_array[0];
					//echo "name: ".$option_value_array[0]." ----- price:".$option_value_array[1]."<br>";
					if(is_numeric($option_value_array[1]))
						$optionPrice = $option_value_array[1];	///update price
						
				}else
					$optionSubTitle = $optionValue;
				$optionTitle .= "--".$optionSubTitle;
				$unit_price = $unit_price-$optionPrice;
				echo "<br>option_detail<br>";
				echo "optionTitle:$optionTitle -- optionSku:$optionSku -- optionQty:$optionQty -- optionPrice:$optionPrice-- unit_price change to $unit_price <br>";
				$option_unit_price = $optionPrice / $optionQty;
				$option_item_array = array(
					"order_id" => $erp_order_id,
					"main_sku" => $main_sku,				
					"sku" => $option_detail->optionSku,
					"name" => $optionTitle,
					"qty_ordered" => $optionQty,
					"unit_price" => $option_unit_price,
					"subtotal" => $optionPrice,				
					"is_option" => 1,				
				);
				echo "option_detail<br>";
				foreach($option_item_array  as $key => $value)
				{
					echo "$key : $value <br>";
				
				}	
				array_push($item_insert_array, create_insert_sql("tbl_order_item", $option_item_array));
				$sku_to_so_array[strval($option_detail->optionSku)] = $optionQty;
			}
		}
		$subtotal = $unit_price * $main_item->qty_ordered;
		$main_item_array = array(
		"order_id" => $erp_order_id,
		"main_sku" => $main_sku,
		"product_id" => (int)$main_item->product_id,
		"sku" => $main_item->sku,
		"name" => $main_item->name,
		"qty_ordered" => (double)$main_item->qty_ordered,
		"unit_price" => $unit_price,
		"discount" => (double)$main_item->discount,
		"subtotal" => $subtotal,		
		);		
		$sku_to_so_array[strval($main_item->sku)] = (double)$main_item->qty_ordered;
		echo "<br>main_item<br>";
		foreach($main_item_array  as $key => $value)
		{
			echo "$key : $value <br>";
		
		}		
		//////////////////insert order items to database///////////////////
		$insert_sql = create_insert_sql("tbl_order_item", $main_item_array);
		if (!mysql_query($insert_sql)){
			echo $insert_sql."<br>";				
		}
		foreach($item_insert_array as $insert_sql)	///////
		{
			if (!mysql_query($insert_sql)){
				echo $insert_sql."<br>";				
			}
		
		}
		
		//////////////////Update S.O. qty///////////////////
		foreach($sku_to_so_array as $sku => $qty)
		{
			update_product_so($sku, $qty, "+", $_SESSION['user_id']);
		
		}
	}	
}
	
	$dialog .= "New Order Added From Magento Successfully";
	//*** dialog
	$back_to = '../../main/main.php?func_id=143&func_pg=oms.so';
	include("../../main/dialog.php");
	
	
//////////////////function/////////////////
	function create_insert_sql($tbl, $detail_array)
{
	
	$sql = " select * from $tbl limit 1 ";
	
	if ($result = mysql_query($sql))
	{
	
		$num_fields = mysql_num_fields($result);
		$insert_sql = " insert into $tbl ( ";
			
			for ($i=0; $i < $num_fields; $i++)
			{
				
				if (mysql_field_name($result, $i) == "id"){
					
				}elseif (mysql_field_name($result, $i) == "status"){
					$insert_sql .= mysql_field_name($result, $i).", ";
					
				}elseif (mysql_field_name($result, $i) == "create_date"){
					$insert_sql .= mysql_field_name($result, $i).", ";
		
				}elseif (mysql_field_name($result, $i) == "create_by"){
					$insert_sql .= mysql_field_name($result, $i).", ";				
					
				}elseif (mysql_field_name($result, $i) == "modify_date"){
					$insert_sql .= mysql_field_name($result, $i).", ";	
					
				}elseif (mysql_field_name($result, $i) == "modify_by"){
					$insert_sql .= mysql_field_name($result, $i).", ";					
		
				}else{
					if (!is_null($detail_array[mysql_field_name($result, $i)]))
						$insert_sql .= mysql_field_name($result, $i).", ";
		
				}
				
			
			}
		$insert_sql = substr($insert_sql,0,-2);	
		$insert_sql .= " )values( ";
		
			for ($i=0; $i < $num_fields; $i++)
			{
				
				if (mysql_field_name($result, $i) == "id"){
		
				}elseif (mysql_field_name($result, $i) == "status"){
					$insert_sql .= set_field(mysql_field_type($result, $i), $detail_array[mysql_field_name($result, $i)]).", ";								
				}elseif (mysql_field_name($result, $i) == "create_date"){
					$insert_sql .= 'ADDDATE(NOW(), INTERVAL 13 HOUR), ';
		
				}elseif (mysql_field_name($result, $i) == "create_by"){
					$insert_sql .= sql_num($_SESSION['user_id']).', ';				
					
				}elseif (mysql_field_name($result, $i) == "modify_date"){
					$insert_sql .= 'ADDDATE(NOW(), INTERVAL 13 HOUR), ';	
					
				}elseif (mysql_field_name($result, $i) == "modify_by"){
					$insert_sql .= sql_num($_SESSION['user_id']).', ';
					
				}else{
					if ( !is_null( $detail_array[mysql_field_name($result, $i)] ) )
						$insert_sql .= set_field(mysql_field_type($result, $i), $detail_array[mysql_field_name($result, $i)]). ", ";
					
				}					
				// echo mysql_field_name($result, $i)." : ".mysql_field_type($result, $i)."<br>";
				// echo mysql_field_name($result, $i)." : ".$_REQUEST[mysql_field_name($result, $i)]."<br />";
			}		
		$insert_sql = substr($insert_sql,0,-2);
		$insert_sql .= " ) ";
		return $insert_sql;		
	}
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
?>