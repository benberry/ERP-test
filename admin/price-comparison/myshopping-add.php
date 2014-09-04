<?
	## init
	include("../include/init.php");
	include("../include/html_head.php");
	
	
	## request
	extract($_REQUEST);
	
	set_field_data("tbl_product", "display_to_myshopping", $id , 1);
	
?>
<script>
	path="../main/main.php?func_pg=index";
	window.location=path;
</script>