<?
	## init
	include("../include/init.php");
	include("../include/html_head.php");

	
	## request
	extract($_REQUEST);
	$item_id = $id;
	$name_1 = $_REQUEST['item_photo_name_1'];
	$name_2 = $_REQUEST['item_photo_name_2'];
	$name_3 = $_REQUEST['item_photo_name_3'];
	$content_1 = $_REQUEST['item_photo_content_1'];
	$content_2 = $_REQUEST['item_photo_content_2'];
	$content_3 = $_REQUEST['item_photo_content_3'];	

	
	##default
	$tbl = "tbl_product_photo";
	$prev_page = "item-edit";
	$photo_index		= 1;
	$icon_size[icon_w]	= 64;
	$icon_size[icon_h]	= 64;
	$thu_size[thu_w]	= 128;
	$thu_size[thu_h]	= 128;
	$vie_size[vie_w]	= 300;
	$vie_size[vie_h]	= 300;	

	
	## insert
	if ($item_photo_id==''){
		$sql="insert into $tbl(
				parent_id,
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
			
			
			## upload photo 1
			table_upload_image($tbl, $insert_id, "temp_item_photo_1", $photo_index, $icon_size, $thu_size, $vie_size);

			## set sort no			
			$sort_no = $insert_id * 10;
			$sort_sql = "update $tbl set sort_no = $sort_no where id=$insert_id";
			if (!mysql_query($sort_sql))
				echo $sort_sql;
			
		}else
			echo $sql;
			
	}else{ ## edit
	
		$sql = " update $tbl set";
		$sql .= " name_1 	= '{$name_1}',";
		$sql .= " name_2 	= '{$name_2}',";
		$sql .= " name_3 	= '{$name_3}',";		
		$sql .= " content_1 = '{$content_1}',";
		$sql .= " content_2 = '{$content_2}',";
		$sql .= " content_3 = '{$content_3}'";
		$sql .= " where id=$item_photo_id";				
	
		if (mysql_query($sql)){
			## upload photo 1
			table_upload_image($tbl, $item_photo_id, "temp_item_photo_1", $photo_index, $icon_size, $thu_size, $vie_size);
		
		}else
			echo $sql;
	
	}

?>
<script>
	path="../main/main.php?func_pg=<?=$prev_page?>";
	path+="&id=<?=$item_id?>";
	path+="&pg_num=<?=$pg_num?>";
	path+="&tab=<?=$tab?>";
	path+="&cat_id=<?=$cat_id?>";
	window.location=path;
</script>