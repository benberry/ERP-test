<? include("../include/init.php"); ?>
<? include("../include/html_head.php"); ?>
<?

//*** default
	$list_page = "pop_image_mgnt.list.php";
	$edit_page = "pop_image_mgnt.edit.php";


//*** requset	
	$action = $_POST["act"];
	$tbl = $_POST["tbl"];
	$id = $_POST["id"];
	$del_id = $_POST["del_id"];
	$list_page_num = $_POST['pg_num'];	
	
	if ($action == "1")
	{
	
		include("../main/std_save.php");
		$dialog = "Successfully saved.";
		$back_to = "pop_image_mgnt.list.php?pg_num=$list_page_num";
		
		## upload photo 1
		$photo_index = 1;
		$icon_size[icon_w] = 64;
		$icon_size[icon_h] = 64;
		$thu_size[thu_w] = 128;
		$thu_size[thu_h] = 128;
		$vie_size[vie_w] = 300;
		$vie_size[vie_h] = 300;		
		table_upload_image($tbl, $id, "tmp_photo_1", $photo_index, $icon_size, $thu_size, $vie_size);			
	
	}
	
	if ($action == "2")
	{
	

	
	}
	
	if ($action == "3")
	{
	
		include("../main/std_save.php");
		$dialog = "Successfully deleted.";
		$back_to = "pop_image_mgnt.list.php?pg_num=$list_page_num";
	
	}
	
	if ($action == "4")
	{
	
		include("../main/std_del.php");
		$dialog = "Successfully deleted.";
		$back_to = "pop_image_mgnt.list.php?pg_num=$list_page_num";
	
	}	


	//*** dialog
	include("../main/dialog.php");
?>


