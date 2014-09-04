<?

//*** default
	$list_page = "list";
	$edit_page = "edit";


//*** requset	
	extract($_REQUEST);

	
	if ($act == "1")
	{
	
		$id = system_save($tbl, $id);
		$dialog = "Successfully saved";
		$back_to = "../main/main.php?func_pg=$edit_page&id=$id&pg_num=$pg_num&tab=$tab";
				
		## upload photo 1
		/*
		$photo_index = 1;
		$icon_size[icon_w] = 64;
		$icon_size[icon_h] = 64;
		$thu_size[thu_w] = 76;
		$thu_size[thu_h] = 96;
		$vie_size[vie_w] = 200;
		$vie_size[vie_h] = 200;		
		table_upload_image($tbl, $id, "tmp_photo_$photo_index", $photo_index, $icon_size, $thu_size, $vie_size);
		*/

	}
	
	if ($act == "2")
	{
	
		/* empty */
	
	}
	
	if ($act == "3")
	{
	
		include("../main/std_save.php");
		$dialog = "Successfully deleted";
		$back_to = "../main/main.php?func_pg=$list_page&pg_num=$pg_num&tab=$tab";
	
	}
	
	if ($act == "4")
	{
	
		include("../main/std_del.php");
		$dialog = "Successfully deleted";
		$back_to = "../main/main.php?func_pg=$list_page&pg_num=$pg_num&tab=$tab";
	
	}	

	//*** dialog
	include("../main/dialog.php");

?>
