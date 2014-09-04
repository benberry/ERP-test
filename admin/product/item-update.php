<?
##*** default
	$list_page = "index";
	$edit_page = "item-edit";

//echo $tbl;
##*** Check Product Code
	if (check_item_code($tbl, "{$_REQUEST['prod_code']}", "{$_REQUEST['id']}")==false && !empty($_REQUEST['prod_code'])){

		echo "<script>";
		echo "	alert('Notice: Duplicate Item Code.')";
		//echo "  window.history.back()";		
		echo "</script>";
		
	}


##*** requset	
	extract($_REQUEST);

//print_r($_REQUEST);
##*** proceess
	
	## save
	if ($act == "1"){

		include("../main/std_save.php");

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
		
		
		## upload photo 4
		$photo_index=4;
		$icon_size[icon_w]=64;
		$icon_size[icon_h]=64;
		$thu_size[thu_w]=300;
		$thu_size[thu_h]=75;
		$vie_size[vie_w]=600;
		$vie_size[vie_h]=120;
		table_upload_image("tbl_product", $id, "tmp_photo_$photo_index", $photo_index, $icon_size, $thu_size, $vie_size);
	

		## upload attachment
		// table_upload_file("tbl_product", $id, "tmp_file_1", 1);
		
		
		## update accessoris
		/*
		function update_accessoris_category($id){
			
			$sql = "select * from tbl_attribute_category where active=1 and deleted=0 order by sort_no ";
			
			if ($result = mysql_query($sql)){
				
				while ($row = mysql_fetch_array($result)){
					
					if ($_REQUEST["product_attribute_category_".$row[id] == 1){
						
						
                    
                    }
					
				}
				
			}else
				echo $sql;
			
		}

		
		function update_accessoris($product_id, $cat_id){
			
			$sql = " select * from tbl_attribute where cat_id=$cat_id and active=1 and deleted=0 order by sort_no"
			
			$sql = "
					insert into tbl_product_attribute
					(
						product_id
					)values(
						
					)
					
				   ";
			
		}
		
		function remove_accessoris($product_id, $cat_id){
			
			$sql = "delete from tbl_product_attribute where product_id=$product_id and attribute_cat_id=$cat_id ";
			
			if (!mysql_query($sql)) echo $sql;
			
		}		
		*/
		
		$dialog = "Successfully saved.";
		$back_to = "../main/main.php?func_pg=$edit_page&id=$id&pg_num=$pg_num&cat_id=$cat_id&tab=$tab";
		

	}
	
	
	## not use
	if ($act == "2")
	{

	
	}
	
	
	## delete
	if ($act == "3")
	{
		include("../main/std_save.php");
		$dialog = "Successfully deleted.";
		$back_to = "../main/main.php?func_pg=$list_page&pg_num=$pg_num&cat_id=$cat_id&tab=$tab";
	
	}
	
	// delete
	if ($act == "4")
	{
		include("../main/std_del.php");
		$dialog = "Successfully deleted.";
		$back_to = "../main/main.php?func_pg=$list_page&pg_num=$pg_num&cat_id=$cat_id&tab=$tab";
	
	}	


	##*** dialog
	include("../main/dialog.php");
	

?>
