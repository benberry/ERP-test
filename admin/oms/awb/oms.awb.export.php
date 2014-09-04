<?php
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
	 /** PHPExcel_IOFactory */
	include '../../../library/PHPExcel_1.7.9_doc/Classes/PHPExcel/IOFactory.php';
extract($_REQUEST);

//*** Select SQL
	$sql="
		SELECT 
		tbl_order.id, tbl_order.order_no, tbl_order.order_status_id, tbl_order.ship_status, tbl_order.create_date, tbl_order.awb_check, tbl_order.shipping_method,tbl_order.order_currency_code,tbl_order.store_id,tbl_order.customer_email,
		TOSA.country, TOSA.post_code, order_weight.weight_sum, order_weight.total_qty,IFNULL(order_weight.value,0) as value, TOSA.company,TOSA.street,TOSA.city,TOSA.region,CONCAT(TOSA.first_name,' ',TOSA.last_name) as name,TOSA.telephone
		FROM tbl_order
		LEFT JOIN tbl_order_shipping_address TOSA ON TOSA.order_id = tbl_order.id
		LEFT JOIN 
			(SELECT order_id, SUM(actual_weight*qty_ordered) as weight_sum, SUM(qty_ordered) AS total_qty, sum(subtotal) as value
			FROM tbl_order_item TOI
			LEFT JOIN tbl_erp_product TEP ON TEP.sku = TOI.sku
			WHERE TEP.sku <> '' AND TEP.sku IS NOT null AND TOI.is_cancel_item = 0
			GROUP BY order_id) order_weight 
		ON order_weight.order_id = tbl_order.id
		WHERE
			tbl_order.deleted=0
			AND cs_check=1 AND payment_check=1 AND buyer_check=1 AND invoice_check=1 AND packing_check=1
			";


//*** Search
	if ($srh_order_date_from){
		$sql .= " and tbl_order.create_date >= '$srh_order_date_from'";
	}else{
		//$srh_order_date_from=date("Y-m-d");
		//$sql .= " and create_date >= '$srh_order_date_from'";
	}
	
	if ($srh_order_date_to){
		$sql .= " and tbl_order.create_date <= '$srh_order_date_to'";
	}
	
	if ($srh_order_no){
		$sql .= " and order_no = ".$order_no;
	}

	if ($srh_awb_check == "on"){
		$sql .= " and awb_check = 1";
	}else
		$sql .= " and awb_check = 0";

	if ($srh_weight_sum){
		$sql .= " and weight_sum >= ".$srh_weight_sum;
	}
	
////////////////AWB Carrier Selector//////////////
	if($srh_awb_carrier && $srh_awb_carrier!= "all"){
	//	##1:RMA		2:TOLL		3:4PX EMS		4:TNT
	//	if($srh_awb_carrier == 1){
	//		$sql .= " AND tbl_order.shipping_method = 'Register Air Mail'";
	//	}else if($srh_awb_carrier == 2){
	//		##tbl_region_remote_area not create yet
	//		//$sql .= " AND TOSA.post_code IN (SELECT post_code FROM tbl_region_remote_area";
	//	}else if($srh_awb_carrier == 3){
	//		$sql .= " AND order_weight.weight_sum > 2.5";
	//	}else if($srh_awb_carrier == 4){
	//
	//	}
		$sql .= " and awb_carrier = ".$srh_awb_carrier;
	}
//////////////////////////////////////////////////

//*** Order by start
	if (empty($_POST["order_by"]))
		$order_by = "tbl_order.id"; 
	else
		$order_by = $_POST["order_by"];
	
	if (empty($_POST["ascend"]))
		$ascend = "desc";
	else
		$ascend = $_POST["ascend"];
	
	if (!empty($order_by))
	{
		$sql .="
			order by
				$order_by
				$ascend
		";
	}
//*** Order by end


 echo $sql."<br />";
if($srh_awb_carrier==1)
 include 'exportAWBforRMA.php';

if($srh_awb_carrier==2)
 include 'exportAWBforTOLL.php';

if($srh_awb_carrier==3)
 include 'exportAWBforEMS.php';

if($srh_awb_carrier==4)
 include 'exportAWBforTNT.php';

// This line will force the file to download
$host  = $_SERVER['HTTP_HOST'];
$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
header("Location: http://$host$uri/storefiles/$filename");

function Update_AWB_check($order_id)
{/////////////update security check for AWB///////////////
	$update_sql = "UPDATE tbl_order SET modify_date = ADDDATE(NOW(), INTERVAL 13 HOUR), modify_by={$_SESSION['user_id']}, awb_check = 1 WHERE id = {$order_id}";
	mysql_query($update_sql);
 /////////////add record to check process record/////////////
	$INSERT_SQL = "INSERT INTO tbl_order_check_record (order_id, check_type, check_value, create_date, create_by) VALUES ({$order_id}, 'AWB', 'checked', ADDDATE(NOW(), INTERVAL 13 HOUR), {$_SESSION['user_id']})";
	mysql_query($INSERT_SQL);
}

?>