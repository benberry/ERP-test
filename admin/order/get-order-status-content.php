<?

	include("../include/init.php");
	
	extract($_REQUEST);
	
	echo get_field("tbl_cart_order_status", "content_1", $id);

?>