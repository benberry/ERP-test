<?php
	
	session_start();
	## mysql connection
	$mysql_host = "localhost";
	$mysql_user = "dsadmin_erp";
	$mysql_pwd = "8Gh_NBHIDHv^";
	$mysql_db = "dsadmin_erp";
	
	$mysql_connection = mysql_connect($mysql_host, $mysql_user, $mysql_pwd);
	$mysql_selected = mysql_select_db($mysql_db, $mysql_connection);	
	
	$check_type = $_POST['check_type'];
	$check_value = $_POST['check_value'];
	$order_id = $_POST['order_id'];
	$user_id = $_SESSION['user_id'];
	
	if($check_value == "checked")	
		$sql="UPDATE tbl_order SET modify_date = ADDDATE(NOW(), INTERVAL 13 HOUR), modify_by={$user_id}, ".$check_type."_check = 1 WHERE id = {$order_id}";
	else
		$sql="UPDATE tbl_order SET modify_date = ADDDATE(NOW(), INTERVAL 13 HOUR), modify_by={$user_id}, ".$check_type."_check = 0 WHERE id = {$order_id}";
	
	//tbl_order_check_record	tbl_order
	if(mysql_query($sql))	
		echo "Update Success <br>";
	else
		echo "Update fail <Br>";
	
	$INSERT_SQL = "INSERT INTO tbl_order_check_record (order_id, check_type, check_value, create_date, create_by) VALUES ({$order_id}, '{$check_type}', '{$check_value}', ADDDATE(NOW(), INTERVAL 13 HOUR), {$user_id})";
	mysql_query($INSERT_SQL);
	
	echo "checktype: $check_type,  orderid:$order_id, user_id:$user_id";
?>