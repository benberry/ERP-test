<?

include("../../function/conn.php");

$sql = " select * from tbl_product_category order by id ";

if ($result = mysql_query($sql))
{

	while ($row = mysql_fetch_array($result)){
	
		$sort_no = $row[id]*10;
	
		$update = " update tbl_product_category set sort_no=$sort_no where id = {$row[id]} ";
		
		//mysql_query($update);
	
	}

}else
	echo $sql;



?>