<?

//*** default
	$list_page = "image_mngt.list";
	$edit_page = "image_mngt.edit";


//*** requset	
	$action = $_POST["act"];
	$tbl = $_POST["tbl"];
	$id = $_POST["id"];
	$del_id = $_POST["del_id"];
	$list_page_num = $_POST['pg_num'];	
	
	if ($action == "1")
	{
	
		include("../main/std_save.php");
		table_upload_image($tbl, $id, "tmp_photo_1", 1, 100, 300, array());
		$dialog = "成功儲存";
		$back_to = "../main/main.php?func_pg=$edit_page&id=$id&pg_num=$list_page_num";
	
	}
	
	if ($action == "2")
	{
	

	
	}
	
	if ($action == "3")
	{
	
		include("../main/std_save.php");
		$dialog = "成功刪除";
		$back_to = "../main/main.php?func_pg=$list_page&pg_num=$list_page_num";
	
	}
	
	if ($action == "4")
	{
	
		include("../main/std_del.php");
		$dialog = "成功刪除";
		$back_to = "../main/main.php?func_pg=$list_page&pg_num=$list_page_num";
	
	}	


	//*** dialog
	include("../main/dialog.php");
	

?>
