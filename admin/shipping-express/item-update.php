<?

##*** default
	$list_page = "index";
	$edit_page = "item-edit";


##*** requset	
	extract($_REQUEST);


##*** proceess
	
	## save
	if ($act == "1"){

		include("../main/std_save.php");

		## upload photo 1
		$photo_index=1;
		$icon_size[icon_w]=64;
		$icon_size[icon_h]=64;
		$thu_size[thu_w]=128;
		$thu_size[thu_h]=128;
		$vie_size[vie_w]=300;
		$vie_size[vie_h]=300;
		//table_upload_image("tbl_advertiser_directory", $id, "tmp_photo_$photo_index", $photo_index, $icon_size, $thu_size, $vie_size);
		
		## upload photo 2
		$photo_index=2;
		$icon_size[icon_w]=64;
		$icon_size[icon_h]=64;
		$thu_size[thu_w]=128;
		$thu_size[thu_h]=128;
		$vie_size[vie_w]=300;
		$vie_size[vie_h]=300;
		//table_upload_image("tbl_advertiser_directory", $id, "tmp_photo_$photo_index", $photo_index, $icon_size, $thu_size, $vie_size);		
		
		
		## upload attachment
		//table_upload_file("tbl_advertiser_directory", $id, "tmp_file_1", 1);
		

		$dialog = "Successfully saved.";
		$back_to = "../main/main.php?func_pg=$list_page&id=$id&pg_num=$pg_num&cat_id=$cat_id&tab=$tab";


	}
	
	
	## not use
	if ($act == "2")
	{


	
	}
	
	
	## delete
	if ($act == "3")
	{
		include("../main/std_save.php");
		$dialog = "Successfully deleted.";
		$back_to = "../main/main.php?func_pg=$list_page&pg_num=$pg_num&cat_id=$cat_id&tab=$tab";
	
	}
	
	// delete
	if ($act == "4")
	{
		include("../main/std_del.php");
		$dialog = "Successfully deleted.";
		$back_to = "../main/main.php?func_pg=$list_page&pg_num=$pg_num&cat_id=$cat_id&tab=$tab";
	
	}	


	##*** dialog
	include("../main/dialog.php");
	

?>
