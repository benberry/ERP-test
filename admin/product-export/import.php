<?php

	$file_1 = get_field("tbl_product_import","file_1",$id);

	$source = "../../data/tbl_product_import/file/".$id."_1/".$file_1;//创建对象 

	$data = new Spreadsheet_Excel_Reader(); 

	$data->setOutputEncoding('UTF-8'); 

	$data->read($source); 
	
	function sqlrep($str){
		$str = str_replace("\\","\\\\",$str);
		$str = str_replace("'","\'",$str);
		return $str;
	}
	
	function unsqlrep($str){
		$str = str_replace("\\","",$str);
		$str = str_replace("\'","'",$str);
		return $str;
	}

	for ($i = 2; $i <= $data->sheets[0]['numRows']; $i++) { 

		$code = $data->sheets[0]['cells'][$i][2];
		
		$brand_name = $data->sheets[0]['cells'][$i][3];
		
		$brand_name = sqlrep($brand_name);
		
		if ($brand_name != ""){
	
			$brand_sql = " select id from tbl_brand where name_1 = '{$brand_name}'";
			
			if ($rows = mysql_query($brand_sql)){
			
				$row = mysql_fetch_array($rows);
				
				$brand_id = $row[id];
				
			}else
				echo $brand_sql;
		
		}
	
		$pro_name = $data->sheets[0]['cells'][$i][4];
		
		$pro_name = sqlrep($pro_name);
		
		$sql = "
				insert into tbl_product
				(
					name_1,
					brand_id,
					codeno,
					active,
					create_date,
					create_by,
					modify_date,
					modify_by
					
				)values(
					'{$pro_name}',
					{$brand_id},
					'{$code}',
					1,
					create_date=NOW(),
					create_by=".$_SESSION["user_id"].",						
					modify_date=NOW(),
					modify_by=".$_SESSION["user_id"]."
				)
				";	
				
	    if (mysql_query($sql)){
			
			//$display .= $pro_name." ... OK<br />";
			
		}else{
		
			$display .= "new item - ".$pro_name." ... ERROR ($sql)<br />";
		
		}

	}

	echo $display;

?>


