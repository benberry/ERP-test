<?

//*** default
	$list_page = "oms.carrier.list";
	$edit_page = "oms.carrier.edit";


//*** requset	
	extract($_REQUEST);
	
	$action = $_POST["act"];
	$list_page_num = $_POST['pg_num'];
	
	if ($action == "1")
	{
		include("../main/std_save.php");
		$dialog = "Successfully saved.";
		$back_to = "../main/main.php?func_pg=$edit_page&id=$id&pg_num=$list_page_num&tab=$tab";
				

	}
	
	if ($action == "2")
	{
	

	
	}
	
	if ($action == "3")
	{
		include("../main/std_save.php");
		$dialog = "Successfully deleted.";
		$back_to = "../main/main.php?func_pg=$list_page&pg_num=$list_page_num&tab=$tab";
	
	}
	
	if ($action == "4")
	{
		include("../main/std_del.php");
		$dialog = "Successfully deleted.";
		$back_to = "../main/main.php?func_pg=$list_page&pg_num=$list_page_num&tab=$tab";
	
	}	

	//*** dialog
	include("../main/dialog.php");

?>
