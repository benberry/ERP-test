<?php
## init 
include("../include/init.php");
   

## create coupon
function create_coupon($start_date, $end_date, $name_1, $amount){

	$coupon_code = get_coupon_id();

	$sql="
	   insert into tbl_coupon_one_time
	   (
	   	start_date,
		end_date,
		code,
		name_1,
		amount,
		active,
		create_date,
		create_by
	   )
	   values
	   (
	    '$start_date',
		'$end_date',
		".sql_str(name_1).",
		'$amount',
		1,
		NOW(),
		".$_SESSION["user_id"]."		
	   )
	";
}
   
   
## get coupon code
function get_coupon_id(){
	
	$coupon_code = "FP".base64_encode(date("Ymd").get_random_password(10));
	
	$sql = " select * from tbl_coupon_one_time where code = '$coupon_code'";
	
	if ($result =  mysql_query($sql)){

		$num_rows = mysql_num_rows($result);

		if ($num_rows < 1){
			return $coupon_code;
		}

	}else
		echo $sql;

}   
   
?>