<?

include("init-without-login.php");

$sql = " select
			*

		 from
		 	tbl_product

		 where
		 	active=1
			and deleted=0

		 order by
		 	cat_id, stock_status desc

		 ";

if ($result = mysql_query($sql)){
	
	?><ul><?
	
	while ($row = mysql_fetch_array($result)){
		
		?><li><?=$row["name_1"];?></li><?
		
	}
	
	?></ul><?
	
}else
	echo $sql;

?>