<?

//*** default
	$list_page = "wms.stockin.list";
	$edit_page = "wms.stockin.edit";


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
	$po_item_id = $_POST["po_item_id"];

	if ($act == "1"){

		if(!empty($id)){
			include("../wms/stockin/wms.stockin.update-item-check.php");
		}

		if(empty($error_msg)){
		if (!empty($id)){
			include("../wms/stockin/wms.stockin.update-item.php");
		}
		include("../wms/stockin/wms.stockin.save.php");
		

		$dialog 	= "Successfully saved.";
		$back_to 	= "../main/main.php?func_pg=$edit_page&id=$id";
		
		$sql = "SELECT * FROM `tbl_po_item` WHERE id=$po_item_id";
		if ($result=mysql_query($sql))
		{
			if($row = mysql_fetch_array($result)){

				$sort_no = 0;
				for ($i = 1; $i <= $row[balqty]; $i++) {
    					$sort_no = $sort_no + 10;
					$sql="insert into tbl_stockin_item(
						stockin_id,
						po_item_id,
						product_id,
						IMEI,
						MD_Barcode,
						cost,
						sort_no,
						create_date, 
						create_by,
						active
				
					)values(
						{$id},
						{$row[id]},
						{$row[product_id]},
						'',
						'',
						0,
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
		}else{
			$dialog 	= "Save failed.";
			$back_to 	= "../main/main.php?func_pg=$edit_page&id=$id&error_msg=$error_msg";
		}


		

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