<?

//*** request
	//$id = $_REQUEST["id"];
	//$tbl = $_REQUEST[["tbl"];


//*** get tbl field name

	$sql = " select * from $tbl limit 1 ";
	
	if ($result = mysql_query($sql))
	{
	
		$num_fields = mysql_num_fields($result);
		// echo " <p><u> field_num : </u><br> ".$num_fields;
		
		
		//*** do action - add new - start
		
		if (empty($id))
		{
			
			$insert_sql = " insert into $tbl ( ";
				
				for ($i=0; $i < $num_fields; $i++)
				{
					
					if (mysql_field_name($result, $i) == "id"){
						
					}elseif (mysql_field_name($result, $i) == "status"){
						$insert_sql .= mysql_field_name($result, $i);
						
					}elseif (mysql_field_name($result, $i) == "create_date"){
						$insert_sql .= mysql_field_name($result, $i).", ";
	
					}elseif (mysql_field_name($result, $i) == "create_by"){
						$insert_sql .= mysql_field_name($result, $i).", ";				
						
					}elseif (mysql_field_name($result, $i) == "modify_date"){
						$insert_sql .= mysql_field_name($result, $i).", ";	
						
					}elseif (mysql_field_name($result, $i) == "modify_by"){
						$insert_sql .= mysql_field_name($result, $i).", ";					
	
					}elseif (mysql_field_name($result, $i) == "active"){
						$insert_sql .= mysql_field_name($result, $i).", ";				
						
					}else{
						if (!is_null($_POST[mysql_field_name($result, $i)]))
							$insert_sql .= mysql_field_name($result, $i).", ";
	
					}
					
				
				}
				
			$insert_sql .= " )values( ";
	
				for ($i=0; $i < $num_fields; $i++)
				{
					
					if (mysql_field_name($result, $i) == "id"){
	
					}elseif (mysql_field_name($result, $i) == "status"){
						$insert_sql .= set_field(mysql_field_type($result, $i), $_POST[mysql_field_name($result, $i)]);				
										
					}elseif (mysql_field_name($result, $i) == "create_date"){
						$insert_sql .= 'NOW(), ';
	
					}elseif (mysql_field_name($result, $i) == "active"){
						$insert_sql .= '1,';
	
					}elseif (mysql_field_name($result, $i) == "create_by"){
						$insert_sql .= sql_num($_SESSION['user_id']).', ';				
						
					}elseif (mysql_field_name($result, $i) == "modify_date"){
						$insert_sql .= 'NOW(), ';	
						
					}elseif (mysql_field_name($result, $i) == "modify_by"){
						$insert_sql .= sql_num($_SESSION['user_id']).', ';
						
					}else{
						if ( !is_null( $_REQUEST[mysql_field_name($result, $i)] ) )
							$insert_sql .= set_field(mysql_field_type($result, $i), $_REQUEST[mysql_field_name($result, $i)]). ", ";
						
					}
					
				}		
			
			$insert_sql .= " ) ";

			if (!mysql_query($insert_sql)){
				echo $insert_sql;
				
			}else{
				$id = mysql_insert_id();
				$sort_no = $id * 10;
				
			}
			
			//echo get_field("tbl_product", "sort_no", $id)."<br>";
			
			if (datetime_diff('d', date('Y-m-d'), "2011-10-31") < 0){
				
				$sort_sql = " update $tbl set sort_no = $sort_no where id = $id ";
				if (!mysql_query($sort_sql))
					echo $sort_sql;
				
			}	
		}else{
	
		//*** do action - edit - start
			
			$insert_sql = "select * from $tbl where supplier_id = $supplier_id and supplier_inv_no = '$_POST[supplier_inv_no]' and deleted = 0 and active = 1 and id <> $id";
		
			if ( $result_tmp = mysql_query($insert_sql)){

				
				
				if($row = mysql_fetch_array($result_tmp)){

					$insert_sql = "delete from $tbl where id = $id";
					if (!mysql_query($insert_sql))
						echo $insert_sql;

					$max_sort_no = 0;

					$insert_sql = "select max(sort_no) max_sort_no from tbl_stockin_item where stockin_id = $row[id]";

					if ( $result_tmp = mysql_query($insert_sql)){
						if($row2 = mysql_fetch_array($result_tmp)){
							$max_sort_no = $row2[max_sort_no];
						}
					}

					$insert_sql = "update tbl_stockin_item set sort_no = sort_no + $max_sort_no, stockin_id = $row[id] where stockin_id = $id";
//echo $insert_sql;
					if (!mysql_query($insert_sql))
						echo $insert_sql;

					$id = $row[id];
				}

			}
			

			$insert_sql = " update $tbl set ";
				
				for ($i=0; $i < $num_fields; $i++)
				{
					
					if (mysql_field_name($result, $i) == "id"){
						
					}elseif (mysql_field_name($result, $i) == "status"){
						$insert_sql .= mysql_field_name($result, $i) . " = " . set_field(mysql_field_type($result, $i), $_POST[mysql_field_name($result, $i)]) ;
						
					}elseif (mysql_field_name($result, $i) == "create_date"){
						$insert_sql .= '';
	
					}elseif (mysql_field_name($result, $i) == "create_by"){
						$insert_sql .= '';					
						
					}elseif (mysql_field_name($result, $i) == "modify_date"){
						$insert_sql .= mysql_field_name($result, $i) . " = " . 'NOW(), ';
	
					}elseif (mysql_field_name($result, $i) == "modify_by"){
						$insert_sql .= mysql_field_name($result, $i) . " = " . sql_num($_SESSION['user_id']).", ";																			
						
					}else{
						if (!is_null($_POST[mysql_field_name($result, $i)]))
							$insert_sql .= mysql_field_name($result, $i) . " = " . set_field(mysql_field_type($result, $i), $_POST[mysql_field_name($result, $i)]). ", ";
						
					}
					
					// echo mysql_field_name($result, $i).":".mysql_field_type($result, $i)."<br>";
				
				}
				
			$insert_sql .= " where id = $id ";
			
			//echo "<p><u>insert_sql : </u><br> ".$insert_sql;
	//foreach($_POST as $k=>$v){echo $k."=".$v."<br/>";}
			if (!mysql_query($insert_sql))
				echo $insert_sql;

			/*$insert_sql = "delete from tbl_stockin_item where stockin_id = $id and IMEI='' and MD_Barcode =''";
			if (!mysql_query($insert_sql))
				echo $insert_sql;*/
	
		}
	
		//*** do action - edit - end
	
	
	}else
		echo $sql;

?>