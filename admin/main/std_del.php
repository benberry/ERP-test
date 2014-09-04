<?

	$del_id_array = preg_split("/,/", $del_id);
	
	for ($i = 0; $i < count($del_id_array); $i++)
	{
		
		if (!empty($del_id_array[$i]))
		{
			
			$sql = " update $tbl set deleted = 1 where id = $del_id_array[$i] ";
			
			if (!mysql_query($sql))
				echo $sql;
				
			$id = "";
					
		}
	
	}

?>