<?php
$con=mysql_connect("localhost","camerapa" ,"g2#$4EPHxN");
$db=mysql_select_db("camerapa_web",$con);

function get_random_no($len) {
	$random = substr(number_format(time() * rand(), 0, '', ''), 0, $len);
	return $random;
}

// Select all processing records
//------------------------------
$sql="select * from tbl_cart where order_status_id='2'";
$res=mysql_query($sql);
$output = '';
while($row=mysql_fetch_assoc($res)){
	
	// Generate the Tracking Number
	//-----------------------------
	$ramNo = get_random_no(9);
	$trackingNum = 'RB'.$ramNo.'HK';
	
	// Get the remarks content and replace "2185010" string from generated Tracking Number
	//------------------------------------------------------------------------------------
	$sql_1="select * from tbl_cart_order_status where id='4'";
	$row_1=mysql_fetch_assoc(mysql_query($sql_1));
	$oldRemarks = $row_1['content_1'];
	$newRemarks = str_replace('2185010', $trackingNum, $oldRemarks);
	
	// Update the tbl_cart table
	//--------------------------
	$sql_2="update tbl_cart set order_status_id='4', shipping_company_id='3', shipping_tracking_code='".$trackingNum."', remarks='".$newRemarks."'  where order_status_id='2' and id='".$row['id']."'";
	//$res_2=mysql_query($sql_2);
}

//echo $sql_2;

?>