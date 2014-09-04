<?

//*** default
	$list_page = "edit";
	$edit_page = "edit";
	


//*** requset	
	$action = $_POST["act"];
	$tbl = $_POST["tbl"];
	
	if ($action == "1")
	{
		include("../main/std_save.php");

		## upload file 1
		$photo_index = 1;
		table_upload_file($tbl, $id, "temp_file_1", $photo_index);
		
		include("../product-export/import.php");

		$dialog = "Successfully saved";
		$back_to = "../main/main.php?func_pg=$edit_page&id=$id&pg_num=$list_page_num";
		
	}
	
	if ($action == "5")
	{
		include("../main/std_save.php");

		## upload file 1
		$photo_index = 1;
		
		table_upload_file($tbl, $id, "temp_client_file_1", $photo_index);
		
		include("../product-export/import2.php");

		$dialog = "Successfully saved";
		$back_to = "../main/main.php?func_pg=$edit_page&id=$id&pg_num=$list_page_num";
		
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
	// include("../main/dialog.php");
	

?>
