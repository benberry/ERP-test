<?

//*** default
	$list_page = "search-item.list";
	$edit_page = "search-item.edit";

	
//*** Check Product Code
	if (chk_prod_code("{$_REQUEST['prod_code']}", "{$_REQUEST['id']}")==false && !empty($_REQUEST['prod_code'])){
		echo "<script>";
		echo "	alert('Notice : Product Code Duplication.')";
		echo "</script>";

	}	

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
		$dialog = "Successfully saved.";
		$back_to = "../main/main.php?func_pg=$edit_page&id=$id&pg_num=$list_page_num";
		
		
		## upload photo 1
		$photo_index=1;
		$icon_size[icon_w]=64;
		$icon_size[icon_h]=64;
		$thu_size[thu_w]=128;
		$thu_size[thu_h]=128;
		$vie_size[vie_w]=300;
		$vie_size[vie_h]=300;
		table_upload_image("tbl_product", $id, "tmp_photo_$photo_index", $photo_index, $icon_size, $thu_size, $vie_size);


		## upload photo 2
		$photo_index=2;
		$icon_size[icon_w]=64;
		$icon_size[icon_h]=64;
		$thu_size[thu_w]=128;
		$thu_size[thu_h]=128;
		$vie_size[vie_w]=300;
		$vie_size[vie_h]=300;
		table_upload_image("tbl_product", $id, "tmp_photo_$photo_index", $photo_index, $icon_size, $thu_size, $vie_size);		


		## upload photo 3
		$photo_index=3;
		$icon_size[icon_w]=64;
		$icon_size[icon_h]=64;
		$thu_size[thu_w]=128;
		$thu_size[thu_h]=128;
		$vie_size[vie_w]=300;
		$vie_size[vie_h]=300;
		table_upload_image("tbl_product", $id, "tmp_photo_$photo_index", $photo_index, $icon_size, $thu_size, $vie_size);		

	
	}
	
	if ($action == "2")
	{
	

	
	}
	
	if ($action == "3")
	{
	
		include("../main/std_save.php");
		$dialog = "Successfully deleted.";
		$back_to = "../main/main.php?func_pg=$list_page&pg_num=$list_page_num";
	
	}
	
	if ($action == "4")
	{
	
		include("../main/std_del.php");
		$dialog = "Successfully deleted.";
		$back_to = "../main/main.php?func_pg=$list_page&pg_num=$list_page_num";
	
	}	


	//*** dialog
	include("../main/dialog.php");
	

?>
