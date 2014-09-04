<?
	## init
	include("../include/init.php");
	include("../include/html_head.php");

	
	## request
	extract($_REQUEST);
	$parent_id = $id;
	$item_id = $relate_item_id;

	
	##default
	$tbl = "tbl_product_relate_item";
	$prev_page = "item-edit";

	
	## insert
	if ($item_id!=''){
	
		$sql = "insert into $tbl
		(
			parent_id,
			item_id,
			name_1, 
			name_2,
			name_3,		
			content_1, 
			content_2,
			content_3,		
			create_date, 
			create_by, 
			active
		)values(
			{$parent_id}, 
			{$item_id}, 
			'{$name_1}', 
			'{$name_2}',
			'{$name_3}',		
			'{$content_1}', 
			'{$content_2}',
			'{$content_3}',		
			NOW(), 
			{$_SESSION['user_id']}, 
			1
		)
		";
		
		if (mysql_query($sql)){
			
			$insert_id=mysql_insert_id();

			## set sort no			
			$sort_no = $insert_id * 10;
			$sort_sql = " update $tbl set sort_no = $sort_no where id=$insert_id ";
			if (!mysql_query($sort_sql))
				echo $sort_sql;
			
		}else
			echo $sql;
			
	}

?>
<script>
	path="../main/main.php?func_pg=<?=$prev_page?>";
	path+="&id=<?=$parent_id?>";
	path+="&pg_num=<?=$pg_num?>";
	path+="&tab=<?=$tab?>";
	path+="&cat_id=<?=$cat_id?>";
	window.location=path;
</script>
