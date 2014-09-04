<?

	### include
	// include("../include/init.php");
	
	
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
				cat_id = 5
				or cat_id = 10
				or cat_id = 3
				or cat_id = 8

			)and(
				id <>132
				and id <>67
				and id <>62
				and id <>50
				and id <>129
				and id <>602
				and id <>63
				and id <>606
				and id <>371
				and id <>372
				and id <>376
				and id <>377
				and id <>389
				and id <>401
				and id <>424
				and id <>78
				and id <>153
				and id <>161
				and id <>135
				and id <>134
				and id <>103
				and id <>183
				and id <>185
				and id <>181
				and id <>182
				and id <>189
				and id <>178
				and id <>615
				and id <>607
				and id <>614
				and id <>192
				and id <>225
				and id <>224
				and id <>228
				and id <>229
				and id <>227
				and id <>218
				and id <>217
				and id <>164
				and id <>49
				and id <>58
				and id <>57
				and id <>600
				and id <>80
				and id <>82
				and id <>113
				and id <>139
				and id <>191
				and id <>197
				and id <>193
			)
			
		order by
			cat_id, 
			name_1
	";
	
	if ($result = mysql_query($sql)){
		
		echo "Total: ".mysql_num_rows($result)."<br />";
		
		?><table style="font-size:10px;"><?
		
		while ($row = mysql_fetch_array($result)){
			
			$sql = "update tbl_product set weight=".($row[weight] - 1)." where id = ".$row[id];
			
			?>
            <tr>
            	<td><?=$row[name_1]; ?></td>
            	<td><?=$row[weight]; ?>kg</td>
            	<td><?=$sql; ?>.....
                <?
           			if (!mysql_query($sql))
						echo "error";
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