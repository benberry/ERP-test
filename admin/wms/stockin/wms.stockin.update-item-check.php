<?

	extract($_REQUEST);


	foreach($_REQUEST as $k=>$v){
		if(substr($k,0,15)=="row_MD_Barcode_"){
			if(!empty($v)){
				foreach($_REQUEST as $k2=>$v2){
					if(substr($k2,0,15)=="row_MD_Barcode_"){
						if($v == $v2 && $k != $k2){
$error_msg = $error_msg."MD Barcode:  ".$v.". Duplicate input found.<br/>";
						}
					}
				}
			}
		}
	}

	## select
	$sql = "select * from tbl_stockin_item where stockin_id=$id ";

	if ($result = mysql_query($sql)){
		while ($row = mysql_fetch_array($result)){
			$MD_Barcode = $_REQUEST["row_MD_Barcode_".$row[id]];

		if(!empty($MD_Barcode)){
			$sql = "select * from tbl_stockin_item where MD_Barcode='$MD_Barcode' and id <> $row[id] and active = 1 and deleted = 0";
			if($result2 = mysql_query($sql)){
				$num_rows = mysql_num_rows($result2);
				$row2 = mysql_fetch_array($result2);
				if($num_rows> 0){
					$error_msg = $error_msg."MD Barcode:  ".$MD_Barcode.". Already exists in Invoice No:".get_field("tbl_stockin", "supplier_inv_no", $row2[stockin_id]).".<br/>";
				}

			}else{
				echo $sql;
			}
						
		}
		
		if($row[balqty] + $qty- $row[qty] < 0){

				} 

			
		

		}
	
	}else
		echo $sql;
?>
