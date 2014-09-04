<?
	## init
	session_start();
	require_once("../../../library/config.func.php");
	require_once("../../../library/common.func.php");
	require_once("../../../library/main.func.php");
	require_once("../../../library/date.func.php");
	require_once("../../../library/sql.func.php");
	require_once("../../../library/paging.func.php");	
	require_once("../../../library/sys-right.func.php");
	require_once("../../../library/file-upload.func.php");	

	require_once("../../../library/item.func.php");
	require_once("../../../library/category.func.php");
	require_once("../../../library/member.func.php");
	require_once("../../../library/product.func.php");	
	require_once("../../../library/order-management.func.php");
	check_system_user_login();


	## request
		extract($_REQUEST);


	## select
		$sql = "update tbl_stockin_item set deleted = 1 where id=$item_id";
		
		if (!mysql_query($sql)){
			echo $sql."<br>";

		}


?>
<script>	
path="../../main/main.php?func_pg=wms.stockin.edit";	
path+="&id=<?=$id?>";		
window.location=path;</script>