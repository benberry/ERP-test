<?

##*** default
	$list_page = "index";
	$edit_page = "cat-edit";


##*** requset	
	extract($_REQUEST);
	
	$sql = " update $tbl set deleted=1 where id={$id}";
	
	if (!mysql_query($sql))
		echo $sql;
	
	$dialog = "Successfully deleted.";
	$back_to = "../main/main.php?func_pg=$list_page&pg_num=$pg_num&cat_id=$cat_id";

##*** dialog
	include("../main/dialog.php");
	

?>
