<?

//*** default
	$list_page = "wms.po.list";
	$edit_page = "wms.po.edit";


//*** requset	
	$act = $_POST["act"];
	$tbl = $_POST["tbl"];
	$id = $_POST["id"];
	$del_id = $_POST["del_id"];
	$pg_num = $_POST['pg_num'];
	$tab = $_POST["tab"];
	$email_sent = $_POST["email_sent"];
	$cart_id = $id;
	$supplier_id=$_POST["supplier_id"];
	$po_no = $_POST["po_no"];
	$error_msg = "";

	if ($act == "1"){
		
		if(!empty($id)){
			include("../wms/po/wms.po.update-item-check.php");
		}
		if(empty($error_msg)){
			include("../wms/po/wms.po.save.php");
			include("../wms/po/wms.po.update-item.php");
			$dialog 	= "Successfully saved.";
			$back_to 	= "../main/main.php?func_pg=$edit_page&id=$id";
		}else
		{
			$dialog 	= "Save failed.";
			$back_to 	= "../main/main.php?func_pg=$edit_page&id=$id&error_msg=$error_msg";	
		}

		
		
		$sort_no = 0;
		if(count($_POST)>0)
		{ foreach($_POST as $k=>$v)
			{ 
				if(substr($k,0,3) =="cb_")
				{
					$sql = "SELECT *,0-(current_qty + po_qty - so_qty) need_qty FROM `tbl_erp_product` WHERE id=$v";
			  		if ($result=mysql_query($sql))
			  		{
						$num_rows = mysql_num_rows($result);
						if ($num_rows > 0 )
						{
							if ($row = mysql_fetch_array($result))
							{
		$sort_no = $sort_no + 10;
		$sql="insert into tbl_po_item(
				po_id,
				product_id,
				qty,
				balqty,
				sort_no,
				create_date, 
				create_by,
				active
				
			)values(
				{$id},
				{$row[id]},
				{$row[need_qty]},
				{$row[need_qty]},
				{$sort_no},
				NOW(), 
				{$_SESSION['user_id']}, 
				1
	
			)

		";

		if (mysql_query($sql)){
			
			$insert_id=mysql_insert_id();
			
		}else
			echo $sql;
							}		
						}
					}
				} 
			} 
		}

		$cart_id 	= $id;
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
		$back_to = "../main/main.php?func_pg=$list_page&pg_num=$pg_num";
	
	}	


	//*** dialog
	include("../main/dialog.php");

?>