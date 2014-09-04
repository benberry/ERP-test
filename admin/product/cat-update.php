<?

##*** default
	$list_page = "index";
	$edit_page = "cat-edit";	


##*** requset	
	extract($_REQUEST);
	
	if ($act == "1")
	{
		include("../main/std_save.php");
		$dialog = "Successfully saved.";
		$back_to = "../main/main.php?func_pg=$list_page&id=$id&pg_num=$pg_num&cat_id=$cat_id";
		
		## upload photo 1
		$photo_index = 1;
		$icon_size[icon_w] = 64;
		$icon_size[icon_h] = 64;
		$thu_size[thu_w] = 128;
		$thu_size[thu_h] = 128;
		$vie_size[vie_w] = 320;
		$vie_size[vie_h] = 80;		
		table_upload_image($tbl, $id, "tmp_photo_1", $photo_index, $icon_size, $thu_size, $vie_size);
		
		## upload photo 1
		$photo_index = 2;
		$icon_size[icon_w] = 30;
		$icon_size[icon_h] = 30;
		$thu_size[thu_w] = 30;
		$thu_size[thu_h] = 30;
		$vie_size[vie_w] = 30;
		$vie_size[vie_h] = 30;		
		table_upload_image($tbl, $id, "tmp_photo_2", $photo_index, $icon_size, $thu_size, $vie_size);		
	
	}
	
	if ($act == "2")
	{
	

	
	}
	
	if ($act == "3")
	{
		include("../main/std_save.php");
		$dialog = "Successfully deleted.";
		$back_to = "../main/main.php?func_pg=$list_page&pg_num=$pg_num&cat_id=$cat_id";
	
	}
	
	if ($act == "4")
	{
		include("../main/std_del.php");
		$dialog = "Successfully deleted.";
		$back_to = "../main/main.php?func_pg=$list_page&pg_num=$pg_num&cat_id=$cat_id";
	
	}	


##*** dialog
	include("../main/dialog.php");

?>
