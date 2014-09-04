<?

//*** default
	$list_page = "oms.shipments.list";
	$edit_page = "oms.shipments.edit";
	$add_page_edit = "oms.so.edit";


//*** requset	
	$act = $_POST["act"];
	//$tbl = $_POST["tbl"];
	$tbl = "tbl_order_shipment";
	$order_id = $_POST["order_id"];
	$order_no = $_POST["order_no"];
	$magento_order_id = $_POST["magento_order_id"];
	$shipping_address_id = $_POST["shipping_address_id"];
	$shipment_id = $_POST["shipment_id"];
	$shipment_type = $_POST["shipment_type"];
	$pg_num = $_POST['pg_num'];
	$tab = $_POST["tab"];
	$email_sent = $_POST["email_sent"];
	$cb_counting = $_POST["cb_counting"];
	$carrier_id = $_POST["carrier_id"];
	$tracking_no = $_POST["tracking_no"];
	//$cart_id = $id;

	
	if ($act == "1")
	{	$dialog="";		
		
		$add_shipment_sql = "INSERT INTO tbl_order_shipment (order_id, order_no, shipping_address_id, create_date, create_by, modify_date, modify_by, carrier_id, tracking_no) VALUES (".$order_id.", '".$order_no."', ".$shipping_address_id.", ADDDATE(NOW(), INTERVAL 13 HOUR), ".sql_num($_SESSION['user_id']).", ADDDATE(NOW(), INTERVAL 13 HOUR), ".sql_num($_SESSION['user_id']).", ".$carrier_id.",  '".$tracking_no."')";
		
		if (!mysql_query($add_shipment_sql)){
				$dialog .= $add_shipment_sql;				
		}else{
			$shipment_id = mysql_insert_id();
			//echo "new shipment id:$shipment_id<br>";
			$main_sku_array = array();
			for($i=0; $i<$cb_counting; $i++)
			{	if(ISSET($_POST["cb_".$i]) && ISSET($_POST["cb_".$i."_sku"]))
				{	$main_sku = $_POST["cb_".$i];
					$sku = $_POST["cb_".$i."_sku"];
					$name = $_POST["cb_".$i."_name"];
					$mdbarcode = $_POST["cb_".$i."_mdbarcode"];					
					$is_option = $_POST["cb_".$i."_is_option"];
					
					/////////////////////////check CURRENT STOCK///////////////
					$sql = "SELECT current_qty, so_qty FROM tbl_erp_product WHERE sku = '".addslashes($sku)."'";
					$results = mysql_query($sql);
					$result = mysql_fetch_array($results);
					$current_qty = $result[current_qty];
					$so_qty = $result[so_qty];
					//if($current_qty < 1)
					//{
					//	$dialog .= "sku:$sku no current stock available!<br>";
					//	continue;
					//}
					array_push($main_sku_array, $main_sku);
					if(ISSET($_POST["cb_".$i."_mdbarcode"])){		////////MD-BARCODE EXIST
					$mdbarcode = $_POST["cb_".$i."_mdbarcode"];	
					////////////////INSERT INTO shipment item table///////////////
					$add_item_sql = "INSERT INTO tbl_order_shipment_item (shipment_id, sku, name, mdbarcode, main_sku, is_option) VALUES (".$shipment_id.", '".addslashes($sku)."', '".addslashes($name)."', '".addslashes($mdbarcode)."', '".$main_sku."', ".$is_option.")";
					if (!mysql_query($add_item_sql))
						$dialog .= $add_item_sql."<br>";		
					///////////////////////////Update Stock in Item table///////////////////
					$update_stockin_sql = "UPDATE tbl_stockin_item SET shipped=1 WHERE MD_Barcode = '".$mdbarcode."'";
					if (!mysql_query($update_stockin_sql))
						$dialog .= $update_stockin_sql."<br>";	
					}else{		////////MD-BARCODE NOT EXIST
					////////////////INSERT INTO shipment item table///////////////
					$add_item_sql = "INSERT INTO tbl_order_shipment_item (shipment_id, sku, name, main_sku, is_option) VALUES (".$shipment_id.", '".addslashes($sku)."', '".addslashes($name)."', '".$main_sku."', ".$is_option.")";
					if (!mysql_query($add_item_sql))
						$dialog .= $add_item_sql."<br>";		
					}
					///////////////////////////Update current_qty and $so_qty///////////////////
					if($so_qty == 0)
						$so_qty_sql = "so_qty=0";
					else
						$so_qty_sql = "so_qty=so_qty-1";
					$update_currenty_stock_sql = "UPDATE tbl_erp_product SET modify_date = ADDDATE(NOW(), INTERVAL 13 HOUR), modify_by=".$_SESSION['user_id'].", current_qty=current_qty-1, ".$so_qty_sql." WHERE sku = '".addslashes($sku)."'";
					if (!mysql_query($update_currenty_stock_sql))
						$dialog .= $update_currenty_stock_sql."<br>";						
					///////////////////////CHECK IF ITEM CAN MARK AS SHIPPED///////////////////
					$sql = "SELECT qty_ordered, shipped_qty FROM tbl_order_item WHERE order_id = ".$order_id." AND sku = '".addslashes($sku)."'";
					$results = mysql_query($sql);
					$result = mysql_fetch_array($results);
					$shipped_qty = $result[shipped_qty];
					$qty_ordered = $result[qty_ordered];	
					if(($shipped_qty+1) == $qty_ordered)					
						$update_ship_qty_sql = "UPDATE tbl_order_item SET shipped_qty=shipped_qty+1,  is_shipped=1 WHERE order_id = ".$order_id." AND sku = '".addslashes($sku)."'";
					else
						$update_ship_qty_sql = "UPDATE tbl_order_item SET shipped_qty=shipped_qty+1 WHERE order_id = ".$order_id." AND sku = '".addslashes($sku)."'";
					if (!mysql_query($update_ship_qty_sql))
						$dialog .= $update_ship_qty_sql."<br>";			
					//echo "shipped_qty :$shipped_qty -- qty_ordered:$qty_ordered";
					////////////////////////check if all item have been shipped////////////////////
					//echo "sku:$sku -- name:$name -- mdbarcode:$mdbarcode <br>";				
				}
			
			}
			
			////////////////Update Magento////////////////
			if($magento_order_id != null && $magento_order_id != "" && $magento_order_id != 0){
				$unique_main_sku_array = array_unique($main_sku_array);
				$main_sku_list =  implode(",",$unique_main_sku_array);
				$carrier_code = get_field('tbl_carrier','code',$carrier_id);
				$shipment_url = "http://www.android-enjoyed.com/export/it/add_update_shipment.php?OrderID=".$magento_order_id."&main_sku=".$main_sku_list."&carrier_code=".$carrier_code."&trackingNum=".$tracking_no."&Order_Status=partial";			
				$xml = simplexml_load_file($shipment_url);
				foreach($xml->children() as $return_status){
					$dialog .= "Magento return msg:".$return_status->message."<br>";
				}
			}
		//////////////////////////////////check if fully Shipped////////////////////////
			$sql = "SELECT is_shipped FROM tbl_order_item WHERE is_cancel_item=0 AND order_id={$order_id}";
			$ship_status="";
			$had_no_shipment = false;
			if ($result=mysql_query($sql)){						
				while ($row=mysql_fetch_array($result)){
					if($row[is_shipped] != 1)						
						$had_no_shipment = true;
				}
			}
			if(!$had_no_shipment){///////fully shipped
				$update_status_sql = "UPDATE tbl_order SET ship_status='Fully Shipped', order_status_id=3 WHERE id={$order_id}";
					if (!mysql_query($update_status_sql))
						$dialog .= $update_status_sql."<br>";
						
				////////////////Update Magento Order Status////////////////
				//if($magento_order_id != null && $magento_order_id != "" && $magento_order_id != 0){
				//	$sql = "SELECT code, detail FROM tbl_order_status WHERE id = 3";
				//	//$dialog .= "<br>".$sql;
				//	$rows = mysql_query($sql);
				//	$row = mysql_fetch_array($rows);
				//	$status_url = "http://www.android-enjoyed.com/export/it/update_order_status.php?OrderID={$magento_order_id}&status={$row[code]}&state={$row[detail]}&comment=";			
				//	$xml = simplexml_load_file($status_url);
				//	foreach($xml->children() as $return_status){
				//		$dialog .= "<br>Magento return msg:".$return_status->message."<br>";
				//	}
				//}
			}			
			
		}
		//include("../main/erp_save.php");
		$dialog .= "Successfully saved.";
		$back_to = "../main/main.php?func_pg=$add_page_edit&id=$order_id&pg_num=$pg_num&tab=$tab";

		
		
		//## email to customer
		//if ($email_sent==1){
        //
		//	
		//	#### get_cart_id - end
		//	$to = get_field("tbl_cart", "email", $cart_id);
		//	$from = get_cfg("company_email");
		//	$subject = "[ORDER STATUS] Order Update #".get_field("tbl_cart", "invoice_no", $cart_id);
		//	
		//	$url = get_cfg("company_website_address")."email-template/";
		//	$email_template_content = "order/status.php?cart_id=".$cart_id."&tracker_id=".$tracker_id."act=1";
		//	
		//	$email_template = "template-1/";
		//	$mail_header = file_get_contents("{$url}{$email_template}header.php", 1);
		//	$mail_footer = file_get_contents("{$url}{$email_template}footer.php", 1);					
		//	$mail_content = file_get_contents("{$url}{$email_template_content}", 1);	
		//	$message = $mail_header.$mail_content.$mail_footer;
		//	
		//	send_email($from , $from, $subject, $to, $to, $message);
        //
        //
        //
		//	### get email content
		//	$to = get_cfg("company_email");
		//	$from = get_cfg("company_email");
		//	$subject = "[ORDER STATUS] Order Update #".get_field("tbl_cart", "invoice_no", $cart_id)." (Admin Copy)";
		//	
		//	$url = get_cfg("company_website_address")."email-template/";
		//	$email_template_content = "order/status.php?cart_id=".$cart_id."&tracker_id=".$tracker_id."act=1";
		//	
		//	$email_template = "template-1/";
		//	$mail_header = file_get_contents("{$url}{$email_template}header.php", 1);
		//	$mail_footer = file_get_contents("{$url}{$email_template}footer.php", 1);					
		//	$mail_content = file_get_contents("{$url}{$email_template_content}", 1);	
		//	$message = $mail_header.$mail_content.$mail_footer;
		//	
		//	send_email($from, $from, $subject, $to, $to, $message);
		//	
		//}
	
	}
	
	if ($act == "2")
	{
	

	
	}
	
	if ($act == "3")
	{
		for($i=0; $i<$cb_counting; $i++)
		{	if(ISSET($_POST["cb_".$i."_id"]))
			{	$item_id = $_POST["cb_".$i."_id"];
				$sku = $_POST["cb_".$i."_sku"];
				$name = $_POST["cb_".$i."_name"];
				$mdbarcode = $_POST["cb_".$i."_mdbarcode"];
				
				if($_POST["cb_".$i."_skip"] == "skip")
					continue;
				
				if($mdbarcode != "" && $mdbarcode != null){
					$UPDATE_ITEM_SQL = "UPDATE tbl_order_shipment_item SET mdbarcode='".addslashes($mdbarcode)."' WHERE id=$item_id";
					if (!mysql_query($UPDATE_ITEM_SQL))
						$dialog .= $UPDATE_ITEM_SQL."<br>";		
					///////////////////////////Update Stock in Item table///////////////////
					$update_stockin_sql = "UPDATE tbl_stockin_item SET shipped=1 WHERE MD_Barcode = '".addslashes($mdbarcode)."'";
					if (!mysql_query($update_stockin_sql))
						$dialog .= $update_stockin_sql."<br>";	
				}else{
					$UPDATE_ITEM_SQL = "UPDATE tbl_order_shipment_item SET mdbarcode=null WHERE id=$item_id";
					if (!mysql_query($UPDATE_ITEM_SQL))
						$dialog .= $UPDATE_ITEM_SQL."<br>";		
				}
			}
		}
		
		$UPDATE_TIME_SQL = "UPDATE tbl_order_shipment SET modify_date=ADDDATE(NOW(), INTERVAL 13 HOUR), modify_by=".sql_num($_SESSION['user_id'])." WHERE id=$shipment_id";
				if (!mysql_query($UPDATE_TIME_SQL))
						$dialog .= $UPDATE_ITEM_SQL."<br>";	
		
		$dialog = "Successfully Updated.";
		$back_to = "../main/main.php?func_pg=$edit_page&id=$shipment_id&pg_num=$pg_num";
	
	}
	
	if ($act == "4")
	{	
		include("../main/erp_save.php");
		$dialog = "Successfully saved.";
		$back_to = "../main/main.php?func_pg=$add_page_edit&id=$id&pg_num=$pg_num&tab=$tab";
	
	}	


	//*** dialog
	include("../main/dialog.php");
	

?>
