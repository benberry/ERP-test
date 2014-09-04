<?

//*** default
	$list_page = "list";
	$edit_page = "edit";


//*** requset	
	extract($_REQUEST);
	
	$action = $_POST["act"];
	$list_page_num = $_POST['pg_num'];
	
	if ($action == "1")
	{
		include("../main/std_save.php");
		$dialog = "Successfully saved.";
		$back_to = "../main/main.php?func_pg=$edit_page&id=$id&pg_num=$edit_page_num&tab=$tab";
				
		## upload photo 1
		$photo_index = 1;
		$icon_size[icon_w] = 64;
		$icon_size[icon_h] = 64;
		$thu_size[thu_w] = 128;
		$thu_size[thu_h] = 128;
		$vie_size[vie_w] = 658;
		$vie_size[vie_h] = 290;		
		table_upload_image($tbl, $id, "tmp_photo_1", $photo_index, $icon_size, $thu_size, $vie_size);

	}
	
	if ($action == "2")
	{
	

	
	}
	
	if ($action == "3")
	{
		include("../main/std_save.php");
		$dialog = "Successfully deleted.";
		$back_to = "../main/main.php?func_pg=$list_page&pg_num=$$edit_page_num&tab=$tab";
	
	}
	
	if ($action == "4")
	{
		include("../main/std_del.php");
		$dialog = "Successfully deleted.";
		$back_to = "../main/main.php?func_pg=$list_page&pg_num=$edit_page_num&tab=$tab";
	
	}	

	//*** dialog
	include("../main/dialog.php");

?>
