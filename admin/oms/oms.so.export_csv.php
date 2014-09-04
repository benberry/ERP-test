<?php
 
include("../include/init.php");
 /** PHPExcel_IOFactory */
include '../../library/PHPExcel_1.7.9_doc/Classes/PHPExcel/IOFactory.php';
	
$ids = "";
	foreach ( $_POST as $key => $value ) 
	{
		if(substr($key,0,3) == "cb_")
			$ids .= $value.",";
		//echo 'Index : ' . $key . ' & Value : ' . $value;
	}
$ids = substr($ids, 0, -1);

## request
	extract($_REQUEST);
	
//*** Select SQL
	$sql="
		select
			*
		from
			$tbl
		where
			id IN ($ids)
			AND deleted=0";


//*** Search
	if ($srh_order_date_from){
		$sql .= " and create_date >= '$srh_order_date_from'";
	}else{
		$srh_order_date_from=date("Y-m-01");
		$sql .= " and create_date >= '$srh_order_date_from'";
	}
	
	if ($srh_order_date_to){
		$sql .= " and create_date <= '$srh_order_date_to'";
	}
	
	if ($srh_order_no){
		$sql .= " and order_no like '%$srh_order_no%'";
	}
	
	
	if ($order_status && $order_status != "all"){
		$sql .= " and order_status_id = $order_status";
	}
		
	if ($srh_first_name !=''){
		$sql .= " and customer_firstname like '%$srh_first_name%'";
	}
	
	if ($srh_last_name !=''){
		$sql .= " and customer_lastname like '%$srh_last_name%'";
	}
	
	if ($srh_email !=''){
		$sql .= " and customer_email like '%$srh_email%'";
	}	
	
	if ($srh_sku){

		$sql .= " and exists(select sku from tbl_order_item item where item.order_id = $tbl.id AND item.is_shipped = 0 AND item.sku = '".$srh_sku."')";
	}
//////////////Security Check////////////
	$security_check_array = array(
	"cs_check" => "CS",
	"payment_check" => "Payment",
	"buyer_check" => "Buyer",
	"invoice_check" => "Invoice",
	"packing_check" => "Packing",
	"awb_check" => "AWB",
	"all_check" => "All checked",
	"all_uncheck" => "All un-check",
	);
	if($srh_security_check){
		if($srh_security_check == 'all_uncheck'){
			foreach($security_check_array as $key => $value)
			{
				if($key != "all_check" && $key != "all_uncheck")
					$sql .= " and $key = 0";		
			}
		}else if($srh_security_check == 'all_check'){
			foreach($security_check_array as $key => $value)
			{	
				if($key != "all_check" && $key != "all_uncheck")
					$sql .= " and $key = 1";				
			}		
		}else if($srh_security_check != 'all'){		
			foreach($security_check_array as $key => $value)
			{
				
				
				if($srh_security_check == $key){	
						$sql .= " and $key = 0";
						break;
				}else
					$sql .= " and $key = 1";
				
			}	
		
		}
	}
	

//*** Order by start
	if (empty($_POST["order_by"]))
		$order_by = "id"; 
	else
		$order_by = $_POST["order_by"];
	
	if (empty($_POST["ascend"]))
		$ascend = "desc";
	else
		$ascend = $_POST["ascend"];
	
	if (!empty($order_by))
	{
		$sql .="
			order by
				$order_by
				$ascend
		";
	}

//*** Order by end



//echo $sql."<br />";
 
exportMysqlToCsv($sql);

function exportMysqlToCsv($sql)
{
	$ref=1;
	
ob_start();
class TextValueBinder implements PHPExcel_Cell_IValueBinder
{
    public function bindValue(PHPExcel_Cell $cell, $value = null) {
        $cell->setValueExplicit($value, PHPExcel_Cell_DataType::TYPE_STRING);
        return true;
    }
}
	///////////////////////////////////excel writer///////////////////////////
	// Create new PHPExcel object
			//echo date('H:i:s') . " Create new PHPExcel object\n";
			$objPHPExcel = new PHPExcel();
			
			// Set properties
			//echo date('H:i:s') . " Set properties\n";
			$objPHPExcel->getProperties()->setCreator("Berry Lai");
			$objPHPExcel->getProperties()->setLastModifiedBy("Berry Lai");
			$objPHPExcel->getProperties()->setTitle("Office XLS Document");
			$objPHPExcel->getProperties()->setSubject("Office XLS Document");
			$objPHPExcel->getProperties()->setDescription("");
						
			// Add some data
			//echo date('H:i:s') . " Add some data\n";
			$objPHPExcel->setActiveSheetIndex(0);
			$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Date');
			$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Transaction Type');			
			$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Order No.');
			$objPHPExcel->getActiveSheet()->SetCellValue('D1', 'SKU');
			$objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Company Name');
			$objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Item Description');
			$objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Qty');
			$objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Unit Price');
			$objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Amount');
			$objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Balance');
			
			
	////////Extra data from database///////////			

    // Gets the data from the database
    $result = mysql_query($sql);
//$objPHPExcel->getActiveSheet()->SetCellValue('A4', $awb_carrier);	
    $fields_cnt = mysql_num_fields($result);
    $i=2;
	$balance = 0;
    // Format the data
    while ($row = mysql_fetch_array($result))
    {
		//id, order_no, create_date,grand_total, grand_total AS erp_total, order_currency_code, base_shipping_incl_tax AS shipping_charge, base_fooman_surcharge_amount AS surcharge
		// $objPHPExcel->getActiveSheet()->setCellValueExplicit('A'.$i, $website_sku,PHPExcel_Cell_DataType::TYPE_STRING);
		if($row['cs_check'] == 1)
			$transaction_type = "CS";
		if($row['payment_check'] == 1)
			$transaction_type = "Payment";
		if($row['buyer_check'] == 1)
			$transaction_type = "Buyer";
		if($row['invoice_check'] == 1)
			$transaction_type = "Invoice";
		if($row['packing_check'] == 1)
			$transaction_type = "Packing";
		if($row['awb_check'] == 1)
			$transaction_type = "AWB";
		
		///Shipping method
		if($row[base_shipping_incl_tax] > 0){
			$balance += $row[base_shipping_incl_tax];
			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, $row[create_date]);				
			$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, $transaction_type);				
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, $row[order_no]);
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, 'No');	
			$objPHPExcel->getActiveSheet()->SetCellValue('E'.$i, 'Digital Skies Group  PTY Limited');	
			$objPHPExcel->getActiveSheet()->SetCellValue('F'.$i, $row[shipping_method]);	
			$objPHPExcel->getActiveSheet()->SetCellValue('G'.$i, '1');	
			$objPHPExcel->getActiveSheet()->SetCellValue('H'.$i, $row[base_shipping_incl_tax]);	
			$objPHPExcel->getActiveSheet()->SetCellValue('I'.$i, $row[base_shipping_incl_tax]);	
			$objPHPExcel->getActiveSheet()->SetCellValue('J'.$i, $balance);	
			$i++;
		}
		
		///Payment method
		if($row[base_fooman_surcharge_amount] > 0){
			$balance += $row[base_fooman_surcharge_amount];
			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, $row[create_date]);				
			$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, $transaction_type);				
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, $row[order_no]);
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, 'No');	
			$objPHPExcel->getActiveSheet()->SetCellValue('E'.$i, 'Digital Skies Group  PTY Limited');	
			$objPHPExcel->getActiveSheet()->SetCellValue('F'.$i, $row[payment_method]);	
			$objPHPExcel->getActiveSheet()->SetCellValue('G'.$i, '1');	
			$objPHPExcel->getActiveSheet()->SetCellValue('H'.$i, $row[base_fooman_surcharge_amount]);	
			$objPHPExcel->getActiveSheet()->SetCellValue('I'.$i, $row[base_fooman_surcharge_amount]);	
			$objPHPExcel->getActiveSheet()->SetCellValue('J'.$i, $balance);	
			$i++;
		}
		
		////////////get order item/////////////
		$item_sql = "SELECT * FROM tbl_order_item WHERE order_id = {$row[id]}";
		$item_result = mysql_query($item_sql);
		 while ($item_row = mysql_fetch_array($item_result))
		{	
			$balance += $item_row[subtotal];
			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, $row[create_date]);				
			$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, $transaction_type);				
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, $row[order_no]);
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, $item_row[sku]);	
			$objPHPExcel->getActiveSheet()->SetCellValue('E'.$i, 'Digital Skies Group  PTY Limited');	
			$objPHPExcel->getActiveSheet()->SetCellValue('F'.$i, $item_row[name]);	
			$objPHPExcel->getActiveSheet()->SetCellValue('G'.$i, $item_row[qty_ordered]);	
			$objPHPExcel->getActiveSheet()->SetCellValue('H'.$i, $item_row[unit_price]);	
			$objPHPExcel->getActiveSheet()->SetCellValue('I'.$i, $item_row[subtotal]);	
			$objPHPExcel->getActiveSheet()->SetCellValue('J'.$i, $balance);	
			$i++;			
		}
		
    }// end while	
		
	//$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	if($_POST['order_export_type'] == "csv")
		$objWriter = new PHPExcel_Writer_CSV($objPHPExcel);		// save CSV
	else if($_POST['order_export_type'] == "xls")
		$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);   //  (I want the output for 2003)
	else
		$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);	// Save Excel 2007 file		
	
	//$objWriter->save(str_replace('.php', '.xls', __FILE__));
	//$filename = "order-export-".date("Y-m-d").".xls";
	$filename = "order-export.".$_POST['order_export_type'];
	$objWriter->save("./storefiles/".$filename);
	//od_end_clean();
	// This line will force the file to download
	$host  = $_SERVER['HTTP_HOST'];
	$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	header("Location: http://$host$uri/storefiles/$filename");

}
 
?>