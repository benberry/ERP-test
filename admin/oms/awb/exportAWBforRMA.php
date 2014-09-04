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



			$objPHPExcel->getActiveSheet()->SetCellValue('A1', '客户单号');
			$objPHPExcel->getActiveSheet()->SetCellValue('B1', '服务商单号');			
			$objPHPExcel->getActiveSheet()->SetCellValue('C1', '运输方式');
			$objPHPExcel->getActiveSheet()->SetCellValue('D1', '目的国家');
			$objPHPExcel->getActiveSheet()->SetCellValue('E1', '寄件人公司名');
			$objPHPExcel->getActiveSheet()->SetCellValue('F1', '寄件人姓名');
			$objPHPExcel->getActiveSheet()->SetCellValue('G1', '寄件人省');
			$objPHPExcel->getActiveSheet()->SetCellValue('H1', '寄件人城市');
			$objPHPExcel->getActiveSheet()->SetCellValue('I1', '寄件人地址');
			$objPHPExcel->getActiveSheet()->SetCellValue('J1', '寄件人电话');
			$objPHPExcel->getActiveSheet()->SetCellValue('K1', '寄件人邮编');
			$objPHPExcel->getActiveSheet()->SetCellValue('L1', '寄件人传真');
			$objPHPExcel->getActiveSheet()->SetCellValue('M1', '收件人公司名');
			$objPHPExcel->getActiveSheet()->SetCellValue('N1', '收件人姓名');
			$objPHPExcel->getActiveSheet()->SetCellValue('O1', '州 \ 省');
			$objPHPExcel->getActiveSheet()->SetCellValue('P1', '城市');
			$objPHPExcel->getActiveSheet()->SetCellValue('Q1', '联系地址');
			$objPHPExcel->getActiveSheet()->SetCellValue('R1', '收件人电话');
			$objPHPExcel->getActiveSheet()->SetCellValue('S1', '收件人邮箱');
			$objPHPExcel->getActiveSheet()->SetCellValue('T1', '收件人邮编');
			$objPHPExcel->getActiveSheet()->SetCellValue('U1', '收件人传真');
			$objPHPExcel->getActiveSheet()->SetCellValue('V1', '买家ID');
			$objPHPExcel->getActiveSheet()->SetCellValue('W1', '交易ID');
			$objPHPExcel->getActiveSheet()->SetCellValue('X1', '保险类型');
			$objPHPExcel->getActiveSheet()->SetCellValue('Y1', '保险价值');
			$objPHPExcel->getActiveSheet()->SetCellValue('Z1', '订单备注');
			$objPHPExcel->getActiveSheet()->SetCellValue('AA1', '重量');
			$objPHPExcel->getActiveSheet()->SetCellValue('AB1', '是否退件');
			$objPHPExcel->getActiveSheet()->SetCellValue('AC1', '包裹种类');
			$objPHPExcel->getActiveSheet()->SetCellValue('AD1', '海关报关品名1');
			$objPHPExcel->getActiveSheet()->SetCellValue('AE1', '配货信息1');
			$objPHPExcel->getActiveSheet()->SetCellValue('AF1', '申报价值1');
			$objPHPExcel->getActiveSheet()->SetCellValue('AG1', '申报品数量1');
			$objPHPExcel->getActiveSheet()->SetCellValue('AH1', '海关货物编号1');
			$objPHPExcel->getActiveSheet()->SetCellValue('AI1', '配货备注1');
			$objPHPExcel->getActiveSheet()->SetCellValue('AJ1', '海关报关品名2');
			$objPHPExcel->getActiveSheet()->SetCellValue('AK1', '配货信息2');
			$objPHPExcel->getActiveSheet()->SetCellValue('AL1', '申报价值2');
			$objPHPExcel->getActiveSheet()->SetCellValue('AM1', '申报品数量2');
			$objPHPExcel->getActiveSheet()->SetCellValue('AN1', '海关货物编号2');
			$objPHPExcel->getActiveSheet()->SetCellValue('AO1', '配货备注2');
			$objPHPExcel->getActiveSheet()->SetCellValue('AP1', '海关报关品名3');
			$objPHPExcel->getActiveSheet()->SetCellValue('AQ1', '配货信息3');
			$objPHPExcel->getActiveSheet()->SetCellValue('AR1', '申报价值3');
			$objPHPExcel->getActiveSheet()->SetCellValue('AS1', '申报品数量3');
			$objPHPExcel->getActiveSheet()->SetCellValue('AT1', '海关货物编号3');
			$objPHPExcel->getActiveSheet()->SetCellValue('AU1', '配货备注3');
			$objPHPExcel->getActiveSheet()->SetCellValue('AV1', '海关报关品名4');
			$objPHPExcel->getActiveSheet()->SetCellValue('AW1', '配货信息4');
			$objPHPExcel->getActiveSheet()->SetCellValue('AX1', '申报价值4');
			$objPHPExcel->getActiveSheet()->SetCellValue('AY1', '申报品数量4');
			$objPHPExcel->getActiveSheet()->SetCellValue('AZ1', '海关货物编号4');			
			$objPHPExcel->getActiveSheet()->SetCellValue('BA1', '配货备注4');
			$objPHPExcel->getActiveSheet()->SetCellValue('BB1', '海关报关品名5');
			$objPHPExcel->getActiveSheet()->SetCellValue('BC1', '配货信息5');
			$objPHPExcel->getActiveSheet()->SetCellValue('BD1', '申报价值5');
			$objPHPExcel->getActiveSheet()->SetCellValue('BE1', '申报品数量5');
			$objPHPExcel->getActiveSheet()->SetCellValue('BF1', '海关货物编号5');
			$objPHPExcel->getActiveSheet()->SetCellValue('BG1', '配货备注5');
			
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
		$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, 'B1');
		$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, $row[country]);			
		$objPHPExcel->getActiveSheet()->SetCellValue('M'.$i, $row[company]);
		$objPHPExcel->getActiveSheet()->SetCellValue('N'.$i, $row[name]);
		$objPHPExcel->getActiveSheet()->SetCellValue('O'.$i, $row[region]);
		$objPHPExcel->getActiveSheet()->SetCellValue('P'.$i, $row[city]);
		$objPHPExcel->getActiveSheet()->SetCellValue('Q'.$i, $row[street]);
		$objPHPExcel->getActiveSheet()->SetCellValue('R'.$i, 'T: '.$row[telephone]);
		$objPHPExcel->getActiveSheet()->SetCellValue('S'.$i, $row[customer_email]);
		$objPHPExcel->getActiveSheet()->SetCellValue('T'.$i, $row[post_code]);

		if($row[store_id]== "2")
		{
		 $objPHPExcel->getActiveSheet()->SetCellValue('AD'.$i, "Mobile");
		 $objPHPExcel->getActiveSheet()->SetCellValue('AE'.$i, "Phone Accessories");
		}

		if($row[store_id]== "11")
		{
		 $objPHPExcel->getActiveSheet()->SetCellValue('AD'.$i, "Camera");
		 $objPHPExcel->getActiveSheet()->SetCellValue('AE'.$i, "Camera Accessories");
		}

		$objPHPExcel->getActiveSheet()->SetCellValue('AE'.$i, '-');

		if($row[country]== "AU")
		{
		 if($row[value] > 1000)
		 {
		   $objPHPExcel->getActiveSheet()->SetCellValue('AF'.$i, mt_rand(75000,89700)/100*0.9);
		 }else
		 {
		   $objPHPExcel->getActiveSheet()->SetCellValue('AF'.$i, $row[value]);
		 }
		}

		if($row[country]== "NZ")
		{
		 if($row[value] > 300)
		 {
		   $objPHPExcel->getActiveSheet()->SetCellValue('AF'.$i, mt_rand(29000,31800)/100*0.9);
		 }else
		 {
		   $objPHPExcel->getActiveSheet()->SetCellValue('AF'.$i, $row[value]);
		 }
		}

		$objPHPExcel->getActiveSheet()->SetCellValue('AG'.$i, '1');
		$objPHPExcel->getActiveSheet()->SetCellValue('AH'.$i, '1');


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