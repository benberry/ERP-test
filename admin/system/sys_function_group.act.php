<?

//*** default
	$list_page = "sys_function_group.list";
	$edit_page = "sys_function_group.edit";


//*** requset	
	$action = $_POST["act"];
	$tbl = $_POST["tbl"];
	$id = $_POST["id"];
	$del_id = $_POST["del_id"];
	$pg_num = $_POST['pg_num'];	
	
	if ($action == "1")
	{
	
		$id = system_save($tbl, $id);
		$dialog = "Successfully saved.";
		$back_to = "../main/main.php?func_pg=$edit_page&id=$id&pg_num=$pg_num";
	
	}
	
	if ($action == "2")
	{
	
		/* empty */
	
	}
	
	if ($action == "3")
	{
	
		include("../main/std_save.php");
		$dialog = "Successfully deleted.";
		$back_to = "../main/main.php?func_pg=$list_page&pg_num=$pg_num";
	
	}
	
	if ($action == "4")
	{
	
		include("../main/std_del.php");
		$dialog = "Successfully deleted.";
		$back_to = "../main/main.php?func_pg=$list_page&pg_num=$pg_num";
	
	}	


	//*** dialog
	include("../main/dialog.php");
	

?>
