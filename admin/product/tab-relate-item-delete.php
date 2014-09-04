<?
	## include
	include("../include/init.php");
	include("../include/html_head.php");


	## request
	extract($_REQUEST);
	

	## init 
	$tbl = "tbl_product_relate_item";
	$prev_page = "item-edit";
	
	## delete record
	$sql = "delete from $tbl where id=$del_relate_item_id";
	
	
	//echo $sql;
	

	
	if (mysql_query($sql)){
		## unlink
		
	}else
		echo $sql;

?>
<script>
	path = "../main/main.php?func_pg=<?=$prev_page?>";
	path += "&id=<?=$id?>";
	path += "&pg_num=<?=$pg_num?>";
	path += "&tab=<?=$tab?>";
	path += "&cat_id=<?=$cat_id?>";			
	window.location=path;
</script>