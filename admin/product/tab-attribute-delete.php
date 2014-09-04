<?

 ## init
 include("../include/init.php");
 $prev_page = "item-edit";


 ## request
 extract($_REQUEST);

 
 ## exe sql
 $sql = " delete from tbl_product_attribute where id=$product_attribute_id ";
	
 if (!mysql_query($sql))
	 echo $sql;

?>
<script>

	path="../main/main.php?func_pg=<?=$prev_page?>";
	path+="&id=<?=$id?>";
	path+="&pg_num=<?=$pg_num?>";
	path+="&tab=<?=$tab?>";
	path+="&cat_id=<?=$cat_id?>";
	window.location=path;

</script>