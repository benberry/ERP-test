<?
//*** default
	$list_page = "sys_user.list";
	$edit_page = "sys_user.edit";


//*** requset	
	extract($_REQUEST);


	if ($act == "1"){
		$id = system_save($tbl, $id);
		$dialog = "Successfully saved";
		$back_to = "../main/main.php?func_pg=$edit_page&id=$id&pg_num=$pg_num";
	
	}
	
	if ($act == "2"){
	
		/* empty */
	
	}
	
	if ($act == "3"){
	
		include("../main/std_save.php");
		$dialog = "Successfully deleted";
		$back_to = "../main/main.php?func_pg=$list_page&pg_num=$pg_num";
	
	}
	
	if ($act == "4"){
	
		include("../main/std_del.php");
		$dialog = "Successfully deleted";
		$back_to = "../main/main.php?func_pg=$list_page&pg_num=$pg_num";
	
	}	

	
	//*** dialog
	include("../main/dialog.php");
	

?>