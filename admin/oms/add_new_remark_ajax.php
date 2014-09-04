<?php
	
	session_start();
	require_once("../../library/config.func.php");
	require_once("../../library/common.func.php");
	require_once("../../library/main.func.php");
	require_once("../../library/date.func.php");
	require_once("../../library/sql.func.php");
	require_once("../../library/paging.func.php");	
	require_once("../../library/sys-right.func.php");
	require_once("../../library/file-upload.func.php");	

	require_once("../../library/item.func.php");
	require_once("../../library/category.func.php");
	require_once("../../library/member.func.php");
	require_once("../../library/product.func.php");	
	require_once("../../library/order-management.func.php");
	## mysql connection
	//$mysql_host = "localhost";
	//$mysql_user = "dsadmin_erp";
	//$mysql_pwd = "8Gh_NBHIDHv^";
	//$mysql_db = "dsadmin_erp";
	
	//$mysql_connection = mysql_connect($mysql_host, $mysql_user, $mysql_pwd);
	//$mysql_selected = mysql_select_db($mysql_db, $mysql_connection);	
	
	$new_remark = $_POST['new_remark'];
	$order_id = $_POST['order_id'];
	$user_id = $_SESSION['user_id'];
	
	$INSERT_SQL = "INSERT INTO tbl_order_remark (order_id, remarks, create_date, create_by) VALUES ({$order_id}, '".addslashes($new_remark)."', ADDDATE(NOW(), INTERVAL 13 HOUR), {$user_id})";	
	
	if(!mysql_query($INSERT_SQL))
		echo $INSERT_SQL."<Br>";
	
	echo '<table style="font-size:8pt;">';
	echo get_remark_record($order_id);
	echo "</table>";
	
	function get_remark_record($order_id)
{
	$remark = '';
	
	$sql = " select * from tbl_order_remark where order_id={$order_id} order by create_date desc ";			
	if ($result=mysql_query($sql)){	  
		while ($row=mysql_fetch_array($result)){
			$remark .= '<tr>';
			$remark .= "<td width='160'>".$row[create_date]."</td>";
			if ($row[create_by]==0)
				$remark .= "<td width='80'>system</td>";
			else
				$remark .= "<td width='80'>".get_field("sys_user", "name_1", $row[create_by])."</td>";
				
			$remark .= "<td width='250'>".$row[remarks]."</td>";									
            $remark .= "</tr>";
		}		
		return $remark;
	}else
		return $sql;
}	
?>