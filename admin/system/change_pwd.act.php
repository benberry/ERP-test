<?

//*** default
	$list_page = "change_pwd.edit";
	$edit_page = "change_pwd.edit";


//*** requset	
	$action = $_POST["act"];
	$tbl = $_POST["tbl"];
	$id = $_POST["id"];

	$curr_pwd = $_POST["curr_pwd"];
	
	$pwd = get_field("sys_user", "password", $id);
	
	
	if ($action == "1")
	{

		if (base64_encode($curr_pwd) == $pwd)
		{
			include("../main/std_save.php");
			$dialog = "Successfully saved";
			$back_to = "../main/main.php?func_pg=$edit_page&id=$id&pg_num=$list_page_num";
			
		}
		else
		{
			$dialog = "Old password does not correct.";
			$back_to = "../main/main.php?func_pg=$edit_page&id=$id&pg_num=$list_page_num";
		
		}
	
	}


	//*** dialog
	include("../main/dialog.php");
	

?>
