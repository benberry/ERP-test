<?
	### include
	    //include("../include/init.php");
?>
<h1>Product Weight</h1>
<?
	
	### sql
	$sql = "
		select
			*
			
		from 
			tbl_product
			
		where
			active = 1
			and deleted = 0
			and stock_status < 3
			and(
				id =388
				or id =411
				or id =412
				or id =423
				or id =390
				or id =387
				or id =395
				or id =416
				or id =417
				or id =491
				or id =612
				or id =474
				or id =477
				or id =479
				or id =471
				or id =472
				or id =593
				or id =595
				or id =526
				or id =519
				or id =527
				or id =511
				or id =504
				or id =506
				or id =499
				or id =501
				or id =530
				or id =165
				or id =940
				or id =938
				or id =937
				or id =939
			)
		order by
			cat_id,
			name_1

	";
	
	if ($result = mysql_query($sql)){
		
		echo "Total: ".mysql_num_rows($result)."<br />";
		
		?><table style="font-size:10px;"><?
		
		while ($row = mysql_fetch_array($result)){
			
			$sql = "update tbl_product set weight=".($row[weight]+1)." where id = ".$row[id];
			
			?>
            <tr>
            	<td><?=$row[name_1]; ?></td>
            	<td><?=$row[weight]; ?>kg</td>
            	<td><?=$sql; ?>.....
                <?
           			//if (!mysql_query($sql))
					//	echo "ERROR";
					//else
					//	echo "OK";
				?>
                </td>
            </tr>
			<?
			
		}
		
		?></table><?		
		
	}else
		echo $sql;
	

?>