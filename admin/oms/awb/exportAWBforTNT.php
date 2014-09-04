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
			$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'CustConRefTX');
			$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Company Name');			
			$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Address 1');
			$objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Address 2');
			$objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Address 3');
			$objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Town');
			$objPHPExcel->getActiveSheet()->SetCellValue('G1', 'State');
			$objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Postal Code');
			$objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Country Code');
			$objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Contact Name');
			$objPHPExcel->getActiveSheet()->SetCellValue('K1', 'Contact Number');
			$objPHPExcel->getActiveSheet()->SetCellValue('L1', 'Special Instructions');
			$objPHPExcel->getActiveSheet()->SetCellValue('M1', 'TotalPackages');
			$objPHPExcel->getActiveSheet()->SetCellValue('N1', 'TotalWeight');
			$objPHPExcel->getActiveSheet()->SetCellValue('O1', 'Value');
			$objPHPExcel->getActiveSheet()->SetCellValue('P1', 'Currency');
			$objPHPExcel->getActiveSheet()->SetCellValue('Q1', 'Quantity');
			$objPHPExcel->getActiveSheet()->SetCellValue('R1', 'Description 1');
			$objPHPExcel->getActiveSheet()->SetCellValue('S1', 'Description 2');
			$objPHPExcel->getActiveSheet()->SetCellValue('T1', 'HS Code');
			
			
	////////Extra data from database///////////			

    // Gets the data from the database
    $result = mysql_query($sql);
	//echo $sql_query;
//$objPHPExcel->getActiveSheet()->SetCellValue('A4', $awb_carrier);	
    $fields_cnt = mysql_num_fields($result);
    $i=2;
    // Format the data
    while ($row = mysql_fetch_array($result))
    {
		//tbl_order.id, tbl_order.order_no, tbl_order.order_status_id, tbl_order.ship_status, tbl_order.create_date, tbl_order.awb_check, tbl_order.shipping_method,TOSA.country, TOSA.post_code, order_weight.weight_sum, order_weight.total_qty 
		// $objPHPExcel->getActiveSheet()->setCellValueExplicit('A'.$i, $website_sku,PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, $row[order_no]);	
		$objPHPExcel->getActiveSheet()->getStyle('A'.$i)->getNumberFormat()->setFormatCode('#');			
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, $row[company]);			
//////////////////////limit address length////////////////
    $shiptoaddress = str_replace(array("\r\n", "\r", "\n", "\""), "",$row[street]);
    $shiptoaddress1 = "";
    $shiptoaddress2 = "";
    $shiptoaddress3 = "";
    if( strlen($shiptoaddress) > 30)
    {  $tempstring = substr($shiptoaddress,0,30);
     $shiptoaddress1 = substr($tempstring,0,strrpos($tempstring," "));
     $pos=strlen($shiptoaddress1);
     $temp_shiptoaddress2 = substr($shiptoaddress, $pos, strlen($shiptoaddress));
     //echo "<br>".$pos."<br>";
      if( strlen($temp_shiptoaddress2) > 30)
     {  $tempstring2 = substr($temp_shiptoaddress2,0,30);
      $shiptoaddress2 = substr($tempstring2,0,strrpos($tempstring2," "));
      $pos2=strlen($shiptoaddress2);
      $shiptoaddress3 = substr($temp_shiptoaddress2, $pos2, strlen($temp_shiptoaddress2));
      if( strlen($shiptoaddress3) > 30)
      {
       $shiptoaddress3 = substr($shiptoaddress3,0,30);
      }
     }else
      $shiptoaddress2 = $temp_shiptoaddress2;
     $shiptoaddress1 = trim($shiptoaddress1);
     $shiptoaddress2 = trim($shiptoaddress2);
     $shiptoaddress3 = trim($shiptoaddress3);
     //echo $shiptoaddress1."<BR>".$shiptoaddress2."<BR>".$shiptoaddress3."<br><br>";
    }else
     $shiptoaddress1 = $shiptoaddress;
   //////////////////////end limit address length////////////////

		$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, $shiptoaddress1);
		$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, $shiptoaddress2);
		$objPHPExcel->getActiveSheet()->SetCellValue('E'.$i, $shiptoaddress3);

		$town = str_replace(array("\r\n", "\r", "\n", "\""), "",$row[city]);
      		if( strlen($town) > 30)
      		{
       		  $town = substr($town,0,30);
      		}
		$objPHPExcel->getActiveSheet()->SetCellValue('F'.$i, $town);

		$state = str_replace(array("\r\n", "\r", "\n", "\""), "",$row[region]);
      		if( strlen($state) > 30)
      		{
       		  $state = substr($state,0,30);
      		}
		$objPHPExcel->getActiveSheet()->SetCellValue('G'.$i, $state);

		$post_code = str_replace(array("\r\n", "\r", "\n", "\""), "",$row[post_code]);
      		if( strlen($post_code) > 9)
      		{
       		  $post_code = substr($post_code,0,9);
      		}
		$objPHPExcel->getActiveSheet()->SetCellValue('H'.$i, $post_code);

		$country = str_replace(array("\r\n", "\r", "\n", "\""), "",$row[country]);
      		if( strlen($country) > 2)
      		{
       		  $country = substr($country,0,2);
      		}
		$objPHPExcel->getActiveSheet()->SetCellValue('I'.$i, $country);

		$name = str_replace(array("\r\n", "\r", "\n", "\""), "",$row[name]);
      		if( strlen($name) > 30)
      		{
       		  $name = substr($name,0,30);
      		}
		$objPHPExcel->getActiveSheet()->SetCellValue('J'.$i, $name);

		$telephone = str_replace(array("\r\n", "\r", "\n", "\""), "","T: ".$row[telephone]);
      		if( strlen($telephone) > 16)
      		{
       		  $telephone = substr($telephone,0,16);
      		}
		$objPHPExcel->getActiveSheet()->SetCellValue('K'.$i, $telephone);

		$objPHPExcel->getActiveSheet()->SetCellValue('L'.$i, "Exceptional Handling of PI967-containing 2 batteries or less");
		$objPHPExcel->getActiveSheet()->SetCellValue('M'.$i, "1");
		$objPHPExcel->getActiveSheet()->SetCellValue('N'.$i, "0.5");

		if($country== "AU")
		{
		 if($row[value] > 1000)
		 {
		   $objPHPExcel->getActiveSheet()->SetCellValue('O'.$i, mt_rand(75000,89700)/100);
		 }else
		 {
		   $objPHPExcel->getActiveSheet()->SetCellValue('O'.$i, $row[value]);
		 }
		}

		if($country== "NZ")
		{
		 if($row[value] > 300)
		 {
		   $objPHPExcel->getActiveSheet()->SetCellValue('O'.$i, mt_rand(29000,31800)/100);
		 }else
		 {
		   $objPHPExcel->getActiveSheet()->SetCellValue('O'.$i, $row[value]);
		 }
		}


		if($country== "AU")
		{
		 $objPHPExcel->getActiveSheet()->SetCellValue('P'.$i, "AUD");
		}
		
		if($country== "NZ")
		{
		 $objPHPExcel->getActiveSheet()->SetCellValue('P'.$i, "NZD");
		}
	
		$objPHPExcel->getActiveSheet()->SetCellValue('Q'.$i, "1");


		if($row[store_id]== "2")
		{
		 $objPHPExcel->getActiveSheet()->SetCellValue('R'.$i, "Mobile");
		}

		if($row[store_id]== "11")
		{
		 $objPHPExcel->getActiveSheet()->SetCellValue('R'.$i, "Camera");
		}

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
	// This line will force the file to download	

?>