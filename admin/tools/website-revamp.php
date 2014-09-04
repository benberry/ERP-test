<?

	### include
	// include("../include/init.php");
	
	
	### retrieve data
	$sql = "
			select
				*
				
			from
				tbl_member
				
			where
				active=1
				and deleted=0
				
			order by
				first_name
				

	";


	if ($result = mysql_query($sql)){
		
		while ($row = mysql_fetch_array($result)){
			
			$insert_sql="
						insert into tbl_email_list(
							cat_id,
							first_name,
							last_name,
							email,
							active
						)values(
							1,
							".sql_str($row[first_name]).",
							".sql_str($row[last_name]).",
							".sql_str($row[email]).",
							1
						)
						";
						
			if (!mysql_query($insert_sql)){
				$insert_sql."........Error <br/><br/>";

			}else{
				$insert_sql."........OK <br/><br/>";
				
			}
		
		}
		
	}else
		echo $sql;

?>