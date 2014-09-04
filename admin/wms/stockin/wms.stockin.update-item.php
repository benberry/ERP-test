<?
	/*## init
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
	check_system_user_login();*/


	## request
	extract($_REQUEST);


	## select
	$sql = "select * from tbl_stockin_item where stockin_id=$id ";

	if ($result = mysql_query($sql)){
		while ($row = mysql_fetch_array($result)){
			$IMEI = $_REQUEST["row_IMEI_".$row[id]];
			$MD_Barcode = $_REQUEST["row_MD_Barcode_".$row[id]];
			$cost = $_REQUEST["row_cost_".$row[id]];

			$update_sql="
				update 
					tbl_stockin_item 
				set 
					IMEI='$IMEI',
					MD_Barcode='$MD_Barcode',
					cost = $cost
				where
					id=".$row[id];

			
			if (!mysql_query($update_sql)){
				echo $update_sql."<br>";
			}
		

		}
	
	}else
		echo $sql;

?>
<script>	
//path="../../main/main.php?func_pg=wms.stockin.edit";	
//path+="&id=<?=$id?>";		
//window.location=path;
</script>