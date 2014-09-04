<?
	### include
	include("../include/init.php");
	
	// $sql = "delete from tbl_product_accessory where accessory_id=1088 and active=1 and deleted=0 ";

	$sql="select *from tbl_product where(
	brand_id=5
	or cat_id=10
	or cat_id=3
	or cat_id=8
	or cat_id=35 ) and active=1 and deleted=0 ";
	
	if($result=mysql_query($sql)){
		
		?><table border="1" cellpadding="3" style="border-collapse:collapse; font-size:10px;"><?
		
		while($row=mysql_fetch_array($result)){
			
			?>
            <tr>
            	<td><?=$row[name_1]; ?></td>
				<td><?=$row[unit_cost]; ?></td>
                <td><? 
					$sql="insert into tbl_product_accessory(
						product_id,
						cat_id,
						accessory_id,
						active
					)values(
						".$row[id].",
						25,
						1088,
						1)";
					if (!mysql_query($sql))
						echo $sql;
					?></td>
            </tr>
			<?
			
		}
		
		?></table><?
		
	}else
		echo $sql;

?>