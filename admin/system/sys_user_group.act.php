<?
//*** default
	$list_page = "sys_user_group.list";
	$edit_page = "sys_user_group.edit";
	
	
//*** requset	
	$action = $_POST["act"];
	$tbl = $_POST["tbl"];
	$id = $_POST["id"];
	$del_id = $_POST["del_id"];
	$list_page_num = $_POST['pg_num'];
	
	
	if ($action == "1")
	{

			//*** request
			$id = $_POST["id"];
			$tbl = $_POST["tbl"];
			
			//*** get tbl field name
			$sql = " select * from $tbl limit 1 ";
			
			if ($result = mysql_query($sql))
			{
			
				$num_fields = mysql_num_fields($result);
				//echo " <p><u> field_num : </u><br> ".$num_fields;
				
				
				//*** do action - add new - start
				
				if (empty($id))
				{
					
					$insert_sql = " insert into $tbl ( ";
						
						for ($i=0; $i < $num_fields; $i++)
						{
							
							if (mysql_field_name($result, $i) == "id"){
								
							}elseif (mysql_field_name($result, $i) == "status"){
								$insert_sql .= mysql_field_name($result, $i);
			
							}else{
								$insert_sql .= mysql_field_name($result, $i).", ";
			
							}
							
						
						}
						
					$insert_sql .= " ) values (	";
			
						for ($i=0; $i < $num_fields; $i++)
						{
							
							if (mysql_field_name($result, $i) == "id"){
								
							}elseif (mysql_field_name($result, $i) == "status"){
								$insert_sql .= set_field(mysql_field_type($result, $i), $_POST[mysql_field_name($result, $i)]) ;
								
							}elseif (mysql_field_name($result, $i) == "create_date"){
								$insert_sql .= 'NOW(), ';
			
							}elseif (mysql_field_name($result, $i) == "create_by"){
								$insert_sql .= $_SESSION['user_id'].', ';				
								
							}elseif (mysql_field_name($result, $i) == "modify_date"){
								$insert_sql .= 'NOW(), ';	
							}elseif (mysql_field_name($result, $i) == "modify_date"){
								$insert_sql .= $_SESSION['user_id'].', ';																		
								
							}else{
								$insert_sql .= set_field(mysql_field_type($result, $i), $_POST[mysql_field_name($result, $i)]). ", ";
								
							}
						
						}		
					
					$insert_sql .= " ) ";
					
					//echo "<p><u>insert_sql : </u><br> ".$insert_sql;
					
					if (!mysql_query($insert_sql)){
						echo $sql;
					}else
						$id = mysql_insert_id();
						
						
						
					//*** add function right
					$sql_f = " select * from sys_function ";
					
					if ($result_f = mysql_query($sql_f))
					{
					
						while($row_f = mysql_fetch_array($result_f))
						{
						
							$insert_sql = "
							 insert into sys_function_right 
							 (sys_user_group_id, sys_function_id,
							 sys_read, sys_write, sys_delete, sys_print, sys_export,
							 create_date, create_by ,modify_date, modify_by,
							 deleted, active, status)
							 values
							 ( $id, $row_f[id],
							 1,1,1,1,1,
							 NOW(), 1, NOW(), 1,
							 0,1,0)
							 ";
							 
							 mysql_query($insert_sql);
						
						}
					
					}
					else
						echo $sql_f;
						
						
						
					//*** add user_group_right
					$sql_ug = " select * from sys_user_group ";
					
					if ($result_ug = mysql_query($sql_ug))
					{
					
						while($row_ug = mysql_fetch_array($result_ug))
						{
						
							$insert_sql = "
							 insert into sys_user_group_right 
							 (sys_user_group_id, sys_user_group_right_id,
							 sys_read, sys_write, sys_delete, sys_print, sys_export,
							 create_date, create_by ,modify_date, modify_by,
							 deleted, active, status)
							 values
							 ( $id, $row_ug[id],
							 1,1,1,1,1,
							 NOW(), 1, NOW(), 1,
							 0,1,0)
							 ";
							 
							 if (!mysql_query($insert_sql))
								echo $insert_sql."<br><br>";
							 
							 
						
						}
					
					}
					else
						echo $sql_f;						
					
			
				}//if (empty($id))
				
				
					
				
				
				
				//*** do action - add new - end
				
				
				
				//*** do action - edit - start
			
				if (!empty($id))
				{
					
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
								$insert_sql .= mysql_field_name($result, $i) . " = " . $_SESSION['user_id'].", ";																			
								
							}else{
								$insert_sql .= mysql_field_name($result, $i) . " = " . set_field(mysql_field_type($result, $i), $_POST[mysql_field_name($result, $i)]). ", ";
								
							}
						
						}
						
					$insert_sql .= " where id = $id ";
					
					//echo "<p><u>insert_sql : </u><br> ".$insert_sql;
			
					if (!mysql_query($insert_sql))
						echo $sql;
			
				}
			
				//*** do action - add new - end
					
			
			}else
				echo $sql;

	
		$dialog = "Successfully saved.";
		//$back_to = get_field("sys_function_group");
		
		$back_to = "../main/main.php?func_pg=$edit_page&id=$id&pg_num=$list_page_num";
	
	}
	
	if ($action == "2")
	{
	

	
	}
	
	if ($action == "3")
	{
	
		include("../main/std_save.php");
		$dialog = "Successfully deleted.";
		$back_to = "../main/main.php?func_pg=$list_page&pg_num=$list_page_num";
	
	}
	
	if ($action == "4")
	{
	
		include("../main/std_del.php");
		$dialog = "Successfully deleted.";
		$back_to = "../main/main.php?func_pg=$list_page&pg_num=$list_page_num";
	
	}


	//*** dialog
	include("../main/dialog.php");
	

?>
