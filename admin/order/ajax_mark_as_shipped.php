<?php
function get_random_no($len) {
	$random = substr(number_format(time() * rand(), 0, '', ''), 0, $len);
	return $random;
}

$ramNo = get_random_no(9);
$trackingNum = 'RB'.$ramNo.'HK';
//RB463824945HK
$con=mysql_connect("localhost","camerapa" ,"g2#$4EPHxN");
$db=mysql_select_db("camerapa_web",$con);
$sql="select remarks from  tbl_cart where order_status_id='4'";

$res=mysql_query($sql);
while($row=mysql_fetch_array($res)){
$dbContent = $row['remarks'];
}
$dbContent = str_replace('2185010', $trackingNum, $dbContent);

echo $trackingNum.'###'.$dbContent;
?>