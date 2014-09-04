<?
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
			$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'ConnoteNum');
			$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'AccountCardCode');			
			$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'xpoSenderRefCode');
			$objPHPExcel->getActiveSheet()->SetCellValue('D1', 'SenderName');
			$objPHPExcel->getActiveSheet()->SetCellValue('E1', 'SenderAddress1');
			$objPHPExcel->getActiveSheet()->SetCellValue('F1', 'SenderAddress2');
			$objPHPExcel->getActiveSheet()->SetCellValue('G1', 'SenderAddress3');
			$objPHPExcel->getActiveSheet()->SetCellValue('H1', 'SenderLocation');
			$objPHPExcel->getActiveSheet()->SetCellValue('I1', 'SenderState');
			$objPHPExcel->getActiveSheet()->SetCellValue('J1', 'SenderPostcode');
			$objPHPExcel->getActiveSheet()->SetCellValue('K1', 'SenderCountry');
			$objPHPExcel->getActiveSheet()->SetCellValue('L1', 'SenderContact');
			$objPHPExcel->getActiveSheet()->SetCellValue('M1', 'SenderPhone');
			$objPHPExcel->getActiveSheet()->SetCellValue('N1', 'SenderEmail');
			$objPHPExcel->getActiveSheet()->SetCellValue('O1', 'SenderRef1');
			$objPHPExcel->getActiveSheet()->SetCellValue('P1', 'SenderRef2');
			$objPHPExcel->getActiveSheet()->SetCellValue('Q1', 'ReceiverRefCode');
			$objPHPExcel->getActiveSheet()->SetCellValue('R1', 'ReceiverName');
			$objPHPExcel->getActiveSheet()->SetCellValue('S1', 'ReceiverAddress1');
			$objPHPExcel->getActiveSheet()->SetCellValue('T1', 'ReceiverAddress2');
			$objPHPExcel->getActiveSheet()->SetCellValue('U1', 'ReceiverAddress3');
			$objPHPExcel->getActiveSheet()->SetCellValue('V1', 'ReceiverLocation');
			$objPHPExcel->getActiveSheet()->SetCellValue('W1', 'ReceiverState');
			$objPHPExcel->getActiveSheet()->SetCellValue('X1', 'ReceiverPostcode');
			$objPHPExcel->getActiveSheet()->SetCellValue('Y1', 'Australia');
			$objPHPExcel->getActiveSheet()->SetCellValue('Z1', 'ReceiverContact');
			$objPHPExcel->getActiveSheet()->SetCellValue('AA1', 'ReceiverPhone');
			$objPHPExcel->getActiveSheet()->SetCellValue('AB1', 'ReceiverEmail');
			$objPHPExcel->getActiveSheet()->SetCellValue('AC1', 'CustomDeclaceWeight');
			$objPHPExcel->getActiveSheet()->SetCellValue('AD1', 'WeightMeasure');
			$objPHPExcel->getActiveSheet()->SetCellValue('AE1', 'NumOfItem');
			$objPHPExcel->getActiveSheet()->SetCellValue('AF1', 'ServiceType');
			$objPHPExcel->getActiveSheet()->SetCellValue('AG1', 'Weight');
			$objPHPExcel->getActiveSheet()->SetCellValue('AH1', 'CustomValue');
			$objPHPExcel->getActiveSheet()->SetCellValue('AI1', 'CustomCurrencyCode');
			$objPHPExcel->getActiveSheet()->SetCellValue('AJ1', 'ClearanceRef');
			$objPHPExcel->getActiveSheet()->SetCellValue('AK1', 'CubicLength');
			$objPHPExcel->getActiveSheet()->SetCellValue('AL1', 'CubicWidth');
			$objPHPExcel->getActiveSheet()->SetCellValue('AM1', 'CubicHeight');
			$objPHPExcel->getActiveSheet()->SetCellValue('AN1', 'CubicMeasure');
			$objPHPExcel->getActiveSheet()->SetCellValue('AO1', 'Notes');
			$objPHPExcel->getActiveSheet()->SetCellValue('AP1', 'CubicWeight');
			$objPHPExcel->getActiveSheet()->SetCellValue('AQ1', 'CarrierCode');
			$objPHPExcel->getActiveSheet()->SetCellValue('AR1', 'Instruction');
			$objPHPExcel->getActiveSheet()->SetCellValue('AS1', 'GoodDesc');
			$objPHPExcel->getActiveSheet()->SetCellValue('AT1', 'GoodOriginCtryName');
			$objPHPExcel->getActiveSheet()->SetCellValue('AU1', 'ReasonXport');
			$objPHPExcel->getActiveSheet()->SetCellValue('AV1', 'ShipTerm');
			
			
	////////Extra data from database///////////			

    // Gets the data from the database
    $result = mysql_query($sql);
	//echo $sql_query;
//$objPHPExcel->getActiveSheet()->SetCellValue('A6', $sql);	
    $fields_cnt = mysql_num_fields($result);
    $i=2;
    // Format the data
    while ($row = mysql_fetch_array($result))
    {
		//tbl_order.id, tbl_order.order_no, tbl_order.order_status_id, tbl_order.ship_status, tbl_order.create_date, tbl_order.awb_check, tbl_order.shipping_method,TOSA.country, TOSA.post_code, order_weight.weight_sum, order_weight.total_qty 
		// $objPHPExcel->getActiveSheet()->setCellValueExplicit('A'.$i, $website_sku,PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, "13037");				
		$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, "13037");			
		$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, "Android Enjoyed");
		$objPHPExcel->getActiveSheet()->SetCellValue('E'.$i, "Flat 06 20/F Kowloon Plaza");
		$objPHPExcel->getActiveSheet()->SetCellValue('F'.$i, "485 Castle Peak Road");
		$objPHPExcel->getActiveSheet()->SetCellValue('G'.$i, "Lai Chi Kok");
		$objPHPExcel->getActiveSheet()->SetCellValue('H'.$i, "Hong Kong");
		$objPHPExcel->getActiveSheet()->SetCellValue('J'.$i, ".");
		$objPHPExcel->getActiveSheet()->SetCellValue('K'.$i, "Hong Kong");
		$objPHPExcel->getActiveSheet()->SetCellValue('L'.$i, "-");
		$objPHPExcel->getActiveSheet()->SetCellValue('M'.$i, "22510703");

		$objPHPExcel->getActiveSheet()->SetCellValue('O'.$i, $row[order_no]);
		$objPHPExcel->getActiveSheet()->getStyle('O'.$i)->getNumberFormat()->setFormatCode('#');

		if(empty($row[company])){
		 $objPHPExcel->getActiveSheet()->SetCellValue('R'.$i, $row[name]);
		}else{
 		 $objPHPExcel->getActiveSheet()->SetCellValue('R'.$i, $row[company]);
		}


		$objPHPExcel->getActiveSheet()->SetCellValue('S'.$i, $row[street]);
		$objPHPExcel->getActiveSheet()->SetCellValue('V'.$i, $row[city]);
		$objPHPExcel->getActiveSheet()->SetCellValue('W'.$i, $row[region]);
		$objPHPExcel->getActiveSheet()->SetCellValue('X'.$i, $row[post_code]);

		if($row[country] == "AU")
		 $objPHPExcel->getActiveSheet()->SetCellValue('Y'.$i, "Australia");

		if($row[country] == "NZ")
		 $objPHPExcel->getActiveSheet()->SetCellValue('Y'.$i, "New Zealand");

		$objPHPExcel->getActiveSheet()->SetCellValue('Z'.$i, $row[name]);

		$objPHPExcel->getActiveSheet()->SetCellValue('AA'.$i, "T: ".$row[telephone]);

		$objPHPExcel->getActiveSheet()->SetCellValue('AC'.$i, "0.5");
		$objPHPExcel->getActiveSheet()->SetCellValue('AD'.$i, "Kgs");
		$objPHPExcel->getActiveSheet()->SetCellValue('AE'.$i, "1");
		$objPHPExcel->getActiveSheet()->SetCellValue('AF'.$i, "EN");
		$objPHPExcel->getActiveSheet()->SetCellValue('AG'.$i, "0.5");

		if($row[country]== "AU")
		{
		 if($row[value] > 1000)
		 {
		   $objPHPExcel->getActiveSheet()->SetCellValue('AH'.$i, mt_rand(75000,89700)/100);
		 }else
		 {
		   $objPHPExcel->getActiveSheet()->SetCellValue('AH'.$i, $row[value]);
		 }
		}

		if($row[country]== "NZ")
		{
		 if($row[value] > 300)
		 {
		   $objPHPExcel->getActiveSheet()->SetCellValue('AH'.$i, mt_rand(29000,31800)/100);
		 }else
		 {
		   $objPHPExcel->getActiveSheet()->SetCellValue('AH'.$i, $row[value]);
		 }
		}

		if($row[country]== "AU")
		{
		 $objPHPExcel->getActiveSheet()->SetCellValue('AI'.$i, "AUD");
		}
		
		if($row[country]== "NZ")
		{
		 $objPHPExcel->getActiveSheet()->SetCellValue('AI'.$i, "NZD");
		}

		$objPHPExcel->getActiveSheet()->SetCellValue('AK'.$i, "0");
		$objPHPExcel->getActiveSheet()->SetCellValue('AL'.$i, "0");
		$objPHPExcel->getActiveSheet()->SetCellValue('AM'.$i, "0");
		$objPHPExcel->getActiveSheet()->SetCellValue('AN'.$i, "Kgs");
		$objPHPExcel->getActiveSheet()->SetCellValue('AP'.$i, "0");
		$objPHPExcel->getActiveSheet()->SetCellValue('AQ'.$i, "HK218");
		$objPHPExcel->getActiveSheet()->SetCellValue('AR'.$i, "Li' ion Batteries comply with PI 967 S2");



		if($row[store_id]== "2")
		{
		 $objPHPExcel->getActiveSheet()->SetCellValue('AS'.$i, "Mobile");
		}

		if($row[store_id]== "11")
		{
		 $objPHPExcel->getActiveSheet()->SetCellValue('AS'.$i, "Camera");
		}

		$objPHPExcel->getActiveSheet()->SetCellValue('AT'.$i, "HONG KONG");
		$objPHPExcel->getActiveSheet()->SetCellValue('AU'.$i, "Purchase");
		$objPHPExcel->getActiveSheet()->SetCellValue('AV'.$i, "DDU");

		Update_AWB_check($row[id]);
		
		$i++;
    }// end while	
	
	##1:RMA		2:TOLL		3:4PX EMS		4:TNT
	if($_POST['awb_carrier'] == 1 || $srh_awb_carrier == 1)
		$main_name = "RMA";
	else if($_POST['awb_carrier'] == 2 || $srh_awb_carrier == 2)
		$main_name = "TOLL";
	else if($_POST['awb_carrier'] == 3 || $srh_awb_carrier == 3)
		$main_name = "4PX EMS";
	else if($_POST['awb_carrier'] == 4 || $srh_awb_carrier == 4)
		$main_name = "TNT";
	else 
		$main_name = "Show All";
		
		
		
	$filename = $main_name.date("Y-m-d").".xls";
	//$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);   //  (I want the output for 2003)
	// Save Excel 2007 file			
	//$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
	//$objWriter->save(str_replace('.php', '.xls', __FILE__));
	$objWriter->save("./storefiles/".$filename);
	//od_end_clean();    	


?>