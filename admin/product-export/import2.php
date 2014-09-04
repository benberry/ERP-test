<?php

	$file_1 = get_field("tbl_product_import","file_1",$id);

	$source = "../../data/tbl_product_import/file/".$id."_1/".$file_1;//创建对象 

	$data = new Spreadsheet_Excel_Reader(); 

	$data->setOutputEncoding('UTF-8'); 

	$data->read($source); 

	for ($i = 1; $i <= $data->sheets[0]['numRows']; $i++) { 

		$name = $data->sheets[0]['cells'][$i][1];
		
		$sql = "
			insert into tbl_brand
			(
				name_1,
				active,
				create_date,
				create_by,
				modify_date,
				modify_by
				
			)values(
				'{$name}',
				1,
				create_date=NOW(),
				create_by=".$_SESSION["user_id"].",						
				modify_date=NOW(),
				modify_by=".$_SESSION["user_id"]."
			)
			";
			
		echo $sql."<br />";
		
		if (mysql_query($sql)){
			$updated++;
			$display .= $name." ... OK<br />";
			
		}else{
		
			$display .= "new item - ".$name." ... ERROR ($sql)<br />";
			
		}			

	}

	echo $display;

?>


