<?

//*** default
	$list_page = "";
	$edit_page = "index";


//*** requset	
	$act = $_POST["act"];
	$tbl = $_POST["tbl"];
	$id = $_POST["id"];
	$del_id = $_POST["del_id"];
	$pg_num = $_POST['pg_num'];
	$tab = $_POST["tab"];
	$email_sent = $_POST["email_sent"];
	$cart_id = $id;
	
	if ($act == "1"){
		
		include("../main/std_save.php");

		$dialog 	= "Successfully saved.";
		$back_to 	= "../main/main.php?func_pg=$edit_page&id=$id&pg_num=$pg_num&tab=$tab";
		
		## order tracker
			$cart_id 	= $id;
			$tbl = "tbl_cart_order_tracker";
			include("../main/std_save.php");

	}
	
	if ($act == "2")
	{
	

	
	}
	
	if ($act == "3")
	{
	
		include("../main/std_save.php");
		$dialog = "Successfully deleted.";
		$back_to = "../main/main.php?func_pg=$list_page&pg_num=$pg_num&tab=$tab";
	
	}
	
	if ($act == "4")
	{
	
		include("../main/std_del.php");
		$dialog = "Successfully deleted.";
		$back_to = "../main/main.php?func_pg=$list_page&pg_num=$pg_num&tab=$tab";
	
	}	


	//*** dialog
	include("../main/dialog.php");
?>
