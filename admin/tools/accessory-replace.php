<?
	### include
		// include("../include/init.php");

	$sql="
		select
			*
		from
			tbl_product_accessory
		where
			accessory_id=928";
	
	if($result=mysql_query($sql)){
		
		?><table border="1" cellpadding="3" style="border-collapse:collapse; font-size:10px;"><?
		
		while($row=mysql_fetch_array($result)){
			
			?>
            <tr>
            	<td><?=get_field("tbl_product", "name_1", $row[product_id]); ?></td>
	            <td><?=get_field("tbl_product", "name_1", $row[accessory_id]); ?></td>
	            <td><?=get_field("tbl_product", "price_1", $row[accessory_id]); ?></td>
	            <td><?=$row[price_1]; ?></td>
	            <td><?=$row[weight]; ?></td>
                <td><? 
						$sql="delete from tbl_product_accessory where accessory_id=1136 ";
						
						/*
						$sql="
						insert into tbl_product_accessory(
							product_id,
							accessory_id,
							cat_id,
							active
						)values(
							".$row[product_id].",
							1136,
							11,
							1
						)";
						*/
						
						if (!mysql_query($sql))
							echo $sql;
						else
							echo "OK";

					?>
                </td>
            </tr>
			<?
			
		}
		
		?></table><?
		
	}else
		echo $sql;

?>