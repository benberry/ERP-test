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
						$insert_sql .= mysql_field_name($result, $i).", ";
						
					}elseif (mysql_field_name($result, $i) == "create_date"){
						$insert_sql .= mysql_field_name($result, $i).", ";
	
					}elseif (mysql_field_name($result, $i) == "create_by"){
						$insert_sql .= mysql_field_name($result, $i).", ";				
						
					}elseif (mysql_field_name($result, $i) == "modify_date"){
						$insert_sql .= mysql_field_name($result, $i).", ";	
						
					}elseif (mysql_field_name($result, $i) == "modify_by"){
						$insert_sql .= mysql_field_name($result, $i).", ";					
	
					}else{
						if (!is_null($_POST[mysql_field_name($result, $i)]))
							$insert_sql .= mysql_field_name($result, $i).", ";
	
					}
					
				
				}
			$insert_sql = substr($insert_sql,0,-2);	
			$insert_sql .= " )values( ";
	
				for ($i=0; $i < $num_fields; $i++)
				{
					
					if (mysql_field_name($result, $i) == "id"){
	
					}elseif (mysql_field_name($result, $i) == "status"){
						$insert_sql .= set_field(mysql_field_type($result, $i), $_POST[mysql_field_name($result, $i)]).", ";								
					}elseif (mysql_field_name($result, $i) == "create_date"){
						$insert_sql .= 'ADDDATE(NOW(), INTERVAL 13 HOUR), ';
	
					}elseif (mysql_field_name($result, $i) == "create_by"){
						$insert_sql .= sql_num($_SESSION['user_id']).', ';				
						
					}elseif (mysql_field_name($result, $i) == "modify_date"){
						$insert_sql .= 'ADDDATE(NOW(), INTERVAL 13 HOUR), ';	
						
					}elseif (mysql_field_name($result, $i) == "modify_by"){
						$insert_sql .= sql_num($_SESSION['user_id']).', ';
						
					}else{
						if ( !is_null( $_REQUEST[mysql_field_name($result, $i)] ) )
							$insert_sql .= set_field(mysql_field_type($result, $i), $_REQUEST[mysql_field_name($result, $i)]). ", ";
						
					}					
					// echo mysql_field_name($result, $i)." : ".mysql_field_type($result, $i)."<br>";
					// echo mysql_field_name($result, $i)." : ".$_REQUEST[mysql_field_name($result, $i)]."<br />";
				}		
			$insert_sql = substr($insert_sql,0,-2);
			$insert_sql .= " ) ";
			
			// echo "<p><u>insert_sql : </u><br> ".$insert_sql;
			
			if (!mysql_query($insert_sql)){
				echo $insert_sql;				
			}
			else{
				$id = mysql_insert_id();
				//$sort_no = $id * 10;
				
			}
			
			//echo get_field("tbl_product", "sort_no", $id)."<br>";
			
			//if (datetime_diff('d', date('Y-m-d'), "2011-10-31") < 0){
			//	
			//	$sort_sql = " update $tbl set sort_no = $sort_no where id = $id ";
			//	if (!mysql_query($sort_sql))
			//		echo $sort_sql;
			//	
			//}				
				
			//echo $sort_sql."<br>";
			
			//echo get_field("tbl_product", "sort_no", $id)."<br>";
				
			//echo "add new<br>";
			//echo "$sql;";		
			
		//*** do action - add new - end
	
		}else{
	
		//*** do action - edit - start
			
			$update_sql = " update $tbl set ";
				
				for ($i=0; $i < $num_fields; $i++)
				{
					
					if (mysql_field_name($result, $i) == "id"){
						
					}elseif (mysql_field_name($result, $i) == "status"){
						$update_sql .= mysql_field_name($result, $i) . " = " . set_field(mysql_field_type($result, $i), $_POST[mysql_field_name($result, $i)]). ", " ;
						
					}elseif (mysql_field_name($result, $i) == "custom_url"){
						$custom_url = $_POST[mysql_field_name($result, $i)];
						$to_replace = array(" ", "/", "\\", "*", "&", "#", "@", "'", "+");
						$custom_url = str_replace($to_replace, "-", $custom_url);
						$update_sql .= mysql_field_name($result, $i) . " = " . set_field(mysql_field_type($result, $i), $custom_url). ", " ;
						
					}elseif (mysql_field_name($result, $i) == "password"){
						$update_sql .= mysql_field_name($result, $i) . " = " . set_field(mysql_field_type($result, $i), base64_encode($_POST[mysql_field_name($result, $i)])). ", ";					
					
					/*
					}elseif (mysql_field_name($result, $i) == "member_create_date"){
						$update_sql .= '';
	
					}elseif (mysql_field_name($result, $i) == "member_create_by"){
						$update_sql .= '';				
						
					}elseif (mysql_field_name($result, $i) == "member_modify_date"){
						$update_sql .= '';	
						
					}elseif (mysql_field_name($result, $i) == "member_modify_date"){
						$update_sql .= '';	
					*/					
	
					}elseif (mysql_field_name($result, $i) == "create_date"){
						$update_sql .= '';
	
					}elseif (mysql_field_name($result, $i) == "create_by"){
						$update_sql .= '';					
						
					}elseif (mysql_field_name($result, $i) == "modify_date"){
						$update_sql .= mysql_field_name($result, $i) . " = " . 'ADDDATE(NOW(), INTERVAL 13 HOUR), ';
	
					}elseif (mysql_field_name($result, $i) == "modify_by"){
						$update_sql .= mysql_field_name($result, $i) . " = " . sql_num($_SESSION['user_id']).", ";																			
						
					}else{
						if (!is_null($_POST[mysql_field_name($result, $i)]))
							$update_sql .= mysql_field_name($result, $i) . " = " . set_field(mysql_field_type($result, $i), $_POST[mysql_field_name($result, $i)]). ", ";
						
					}
					
					// echo mysql_field_name($result, $i).":".mysql_field_type($result, $i)."<br>";
				
				}
			$update_sql = substr($update_sql,0,-2);
			$update_sql .= " where id = $id ";
			
			//echo "<p><u>update_sql : </u><br> ".$update_sql;
	
			if (!mysql_query($update_sql))
				echo $update_sql;
	
		}
	
		//*** do action - edit - end
	
	
	}else
		echo $sql;

?>