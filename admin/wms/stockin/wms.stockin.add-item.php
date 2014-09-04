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
$item_id = $add_item_id;		

$sort_no = 10;

##get sort no
$sql="select max(sort_no)+10 sort_no from tbl_stockin_item where stockin_id = $id";

if ( $result = mysql_query($sql)){

	$row_num = mysql_num_rows($result);
	if($row_num > 0){
		$row = mysql_fetch_array($result);
		if ($row[sort_no]){
			$sort_no = $row[sort_no];
echo $row_num;
		}
		
	}
}else
{
	echo $sql;
}


## insert		
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
active,
shipped							
)values(				
{$id},	
0,			
{$item_id},				
'',				
'',
0,				
{$sort_no},				
NOW(), 				
{$_SESSION['user_id']}, 				
1,
0				
)		";	

			if (mysql_query($sql)){						
$insert_id=mysql_insert_id();		}else			
echo $sql;					
?>
<script>	
path="../../main/main.php?func_pg=wms.stockin.edit";	
path+="&id=<?=$id?>";		
window.location=path;
</script>