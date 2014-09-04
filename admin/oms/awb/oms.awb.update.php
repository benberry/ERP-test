<?

//*** Default
	$func_name = "AWB Carrier Updater";
	$curr_folder="oms/awb";
	$tbl = "tbl_order";
	//$prev_page = "oms.so.edit";
	$curr_page = "oms.awb.update";
	$list_page = "oms.awb";
	



	$sql = " SELECT * FROM $tbl
	WHERE cs_check=1 AND payment_check=1 AND buyer_check=1 AND invoice_check=1 AND packing_check=1 AND awb_check=0";
	
	if ($rows = mysql_query($sql)){
		//$existing_shipment = false;
		while($row = mysql_fetch_array($rows))
		{	##1:RMA		2:TOLL		3:4PX EMS		4:TNT
			///////////////////find total_weight and if bulky////////////////
			$total_weight = 0;
			$has_bulky = false;
			$item_sql = "SELECT * FROM tbl_order_item TOI 
			LEFT JOIN tbl_erp_product TEP ON TEP.sku = TOI.sku
			WHERE order_id = {$row[id]}";
			if ($item_rows = mysql_query($item_sql)){
				while($item_row = mysql_fetch_array($item_rows))
				{
					$total_weight += $item_row[actual_weight]*$item_row[qty_ordered];
					if($item_row[bulky] == 1)
						$has_bulky = true;
				}
			}else
				$dialog .= $item_sql."<br>";
			///////////////////End find total_weight and if bulky////////////////
			//echo $row[shipping_method]."<br>";
			if($has_bulky){ ///EMS
					$awb_carrier = 3;
			}else if(stripos($row[shipping_method], "Registered Air Mail, Delivery in 10-16 working day") !== false){	///RMA
				$awb_carrier = 1;			
			}else{		
			///////////////////find if remote area////////////////	
				$remote_sql = "SELECT remote_type FROM tbl_order_shipping_address TOSA
				INNER JOIN tbl_remote_area TRA ON TRA.post_code = TOSA.post_code
				WHERE country='AU' AND order_id = {$row[id]}";
				$remote_result=mysql_query($remote_sql);
				//echo $remote_sql."<br>";
				$remote_count = mysql_num_rows($remote_result);
			///////////////////End find if remote area////////////////	
								
				if($remote_count > 0){	///TNT
					$awb_carrier = 4;
					//echo "remote_count:$remote_count<br>";
				}else if($total_weight > 2){	///TNT
					$awb_carrier = 4;
					//echo "total_weight:$total_weight<br>";
				}else{	///TOLL
					$awb_carrier = 2;
				}
			}
			
			//echo "Order No:{$row[order_no]}  with awb_carrier:$awb_carrier<br>";
			$update_sql = "UPDATE $tbl SET awb_carrier = {$awb_carrier}  WHERE id = {$row[id]}";
			if(!mysql_query($update_sql))
				$dialog .= $update_sql."<br>";
		}

	}else		
		$dialog .= $sql."<br>";
		
		$dialog = "Successfully Updated.";
		$back_to = "../main/main.php?func_id=153&func_pg=oms.awb";
		include("../main/dialog.php");
?>
