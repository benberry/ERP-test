<script>
	function form_submit(){

		fr = document.frm

		fr.action = "<?=$_SERVER['PHP_SELF']?>?<?=$_SERVER['QUERY_STRING']?>";
		fr.method = "post";
		fr.target = "_self";
		fr.submit();

	}
	
	function form_download_csv(){

		fr = document.frm
		fr.action = "../erp-product/erp.product.export_csv.php";
		fr.method = "post";
		fr.target = "_self";
		fr.submit();

	}
	
</script>
<h2>ERP product Import & Update Uploader</h2>
<form name="frm" method="post" enctype="multipart/form-data">
<p>CSV FORMAT:  sku, main_category, sub_category, name, actual_weight, dimension_weight</p>
<!-- 			0		1				2			3			4				5		--->
<label for="file">Filename:</label>
<input type="file" name="file" id="file" /> 
<br /><br />
<a class="boldbuttons" href="javascript:form_submit();"><span>Submit</span></a>
<a class="boldbuttons" href="javascript:form_download_csv();"><span>Download CSV</span></a>
</form>
<br>
<?php

if (($_FILES["file"]["type"] == "text/csv")
 || ($_FILES["file"]["type"] == "application/vnd.ms-excel")
 || ($_FILES["file"]["type"] == "application/vnd.msexcel")
 || ($_FILES["file"]["type"] == "application/excel")
 || ($_FILES["file"]["type"] == "text/comma-separated-values"))
 {
  if ($_FILES["file"]["error"] > 0)
    {   echo "Return Code: " . $_FILES["file"]["error"] . "<br />"; exit;    }
 }
else
  {
  exit;
  }

$csvfile = $_FILES["file"]["tmp_name"];

if(!file_exists($csvfile)) {
	echo "File not found.";
	exit;
}

$size = filesize($csvfile);
if(!$size) {
	echo "File is empty.\n";
	exit;
}


if (($handle = fopen($csvfile, "r")) !== FALSE) {
	//CSV FORMAT:  SKU, MAIN_CATEGORY, SUB_CATEGORY, NAME
	//CSV FORMAT:  SKU, Current Qty UPDATE CURRENT QUANTITY mode
	$row = 1;
	$isError = FALSE;
	$error = 0;
	$has_current_qty = FALSE;
	while (($data = fgetcsv($handle)) !== FALSE) {
        if ($row > 1){	
			if(!$has_current_qty)
			{
				if(trim($data[0]) == "") //check SKU
				{echo "row:$row has blank SKU!<BR>";
				$isError = TRUE; 
				$error++;
				//continue;
				}
				
				if(trim($data[3]) == "") //check Name
				{echo "row:$row -- SKU:$data[0] don't has product name<BR>";
				$isError = TRUE; 
				$error++;
				//continue;
				}
				
				if (trim($data[4]) != "" && !is_numeric($data[4])) // check Actual Weight
				{echo "Line $row consisted of an invalid <b>Actual Weight</b>.<br>"; 
				 $isError = TRUE; 
				 $error++;
				}
				//if (!is_numeric($data[5])) // check Dimension Weight
				//{echo "Line $row consisted of an invalid <b>Dimension Weight</b>.<br>"; 
				// $isError = TRUE; 
				// $error++;				 
				//}
			}else{			
				if (!is_numeric($data[1])) // check qty
				{echo "Line $row consisted of an invalid <b>Quantity</b>.<br>"; 
				 $isError = TRUE; 
				 $error++;
				}				
			}
			
		}else{
			if(trim($data[1]) == "Current Qty") //check if add Current Qty
			{	$has_current_qty = TRUE;
				echo "<h3>Quantity Update Mode</h3>";
			}else{	
				//echo "data[0]:$data[0] -- data[1]:$data[1] -- data[2]:$data[2] -- data[3]:$data[3] -- data[4]:$data[4] -- data[5]:$data[5]<br>";
				if(trim($data[0]) == "sku" && trim($data[1]) == "main_category" && trim($data[2]) == "sub_category" && trim($data[3]) == "name" && trim($data[4]) == "actual_weight" && trim($data[5]) == "dimension_weight")
					echo "<h3>Product Import & Update Mode</h3>";
				else{
					echo "<h3>Column Name not correct!!!</h3>";
					exit;
				}
			}
		}
		$row++;
	
	}
	
	if ($isError)
		{
			echo "<br><br><h3>Tolal $error error(s) found, please change and upload again.</h3>\n";
			exit;
		}
	
	
	$row = 1;
	fseek($handle, 0);
	$record = 0;
	$insert_count=0;
	$update_count=0;
	unset($data);
    while (($data = fgetcsv($handle)) !== FALSE) {
        if ($row > 1){		//skip 1st row heading
			if(!$has_current_qty)
			{	$sku = addslashes(trim($data[0]));
				$main_category = addslashes(trim($data[1]));
				if($data[2] != "")
					$sub_category = "'".addslashes(trim($data[2]))."'";
				else
					$sub_category = "null";
				$name = addslashes(trim($data[3]));
				if($data[4] != "")
					$actual_weight = trim($data[4]);
				else
					$actual_weight = "null";
				if($data[5] != "")
					$dimension_weight = trim($data[5]);
				else
					$dimension_weight = "null";
				
				if(check_sku_exist($data[0]))	//Record exist, run Update
				{	$UPDATE_SQL = "";
					$UPDATE_SQL = "UPDATE `tbl_erp_product` SET main_category='{$main_category}', sub_category={$sub_category}, name='{$name}', actual_weight={$actual_weight}, dimension_weight={$dimension_weight}, modify_date=ADDDATE(NOW(), INTERVAL 13 HOUR), modify_by=".sql_num($_SESSION['user_id'])." WHERE sku='{$sku}' ";
					
					if (!mysql_query($UPDATE_SQL))
						echo "Fail to run SQL:".$UPDATE_SQL;
					else
						$update_count++;
				}else{	// New record, run Insert
					$INSERT_SQL = "";
					$INSERT_SQL = "INSERT INTO `tbl_erp_product` (`sku`, `main_category`, `sub_category`, `name`, `actual_weight`, `dimension_weight`, `current_qty`, `so_qty`, `po_qty`, `create_date`, `create_by`, `modify_date`, `modify_by`) VALUES ('{$sku}', '{$main_category}', {$sub_category}, '{$name}', {$actual_weight}, {$dimension_weight}, 0, 0, 0, ADDDATE(NOW(), INTERVAL 13 HOUR), ".sql_num($_SESSION['user_id']).", ADDDATE(NOW(), INTERVAL 13 HOUR), ".sql_num($_SESSION['user_id']).") ";
					
					if (!mysql_query($INSERT_SQL))
						echo "Fail to run SQL:".$UPDATE_SQL;
					else
						$insert_count++;
				}
			}else{		
				$sku = addslashes(trim($data[0]));
				$current_qty = (trim($data[1]));
				$UPDATE_SQL = "";
				if(check_sku_exist($data[0]))	//Record exist, run Update
				{	$UPDATE_SQL = "UPDATE `tbl_erp_product` SET current_qty='{$current_qty}' WHERE sku='{$sku}' ";
				
					if (!mysql_query($UPDATE_SQL))
						echo "Fail to run SQL:".$UPDATE_SQL;
					else
						$update_count++;
					
				}else{	// New record
					echo "sku:$data[0] is not exist, cannot update current quantity<br>";
				}
			}
		
			$record++;
		}
		$row++;
    }
	echo "<br><br><h3>$update_count Record(s) updated, $insert_count Record(s) import</h3>\n";
}

fclose($handle);


?>