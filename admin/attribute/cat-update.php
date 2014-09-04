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
