<?
	## include
		include("../include/init.php");


	## request
		extract($_REQUEST);
		
		
	if ($id>0 && $tbl != ''){
		
	
		## unlink
			@unlink(get_file_src($tbl, $id, $idx));
			
		## update 
			$sql=" update $tbl set file_{$idx} = '' where id = $id ";
	
			if (!mysql_query($sql))
				echo $sql;
	
	
	}

	$path ="../main/main.php?func_pg=".$page;
	$path.="&id=".$id;
	$path.="&cat_id=".$cat_id;
	$path.="&pg_num=".$pg_num;
	$path.="&order_by=".$order_by;
	$path.="&ascend=".$ascend;
	$path.="&search_cat_id=".$search_cat_id;	
	
	header("Location: ".$path);

?>
<script>
	//window.location = "../main/main.php?func_pg=<?=$page?>&pg_num=<?=$pg_num?>&id=<?=$id?>&cat_id=<?=$cat_id?>";
</script>