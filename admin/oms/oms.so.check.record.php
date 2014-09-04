<div id="order-details">
	<fieldset>
    <legend>Check Process Record</legend>
	<table border="0" style="border-collapse:collapse; ">
	<tr>
		<th>Ref.</th>
		<th>Date</th>
		<th>User</th>                    
		<th>Check Type</th>                    
		<th>Check Action</th>                    
	</tr>
	<?
		
		get_check_record($row[id]);
		
		function get_check_record($order_id){		
			
			$sql = " select * from tbl_order_check_record where order_id={$order_id} order by id asc ";
			$count=1;
			if ($result=mysql_query($sql)){
			  
				while ($row=mysql_fetch_array($result)){
				
					?>		
					<tr>
						<td align="center"><?=$count; ?></td>
						<td align="center"><?=$row[create_date]; ?></td>
						<td align="center"><?=get_sys_user($row[create_by]); ?></td>
						<td align="center"><?=$row[check_type]; ?></td>
						<td align="center"><?=$row[check_value]; ?></td>
					</tr>
					<tr>
						<td><br></td>
						<td><br></td>
						<td><br></td>                    
						<td><br></td>                    
						<td><br></td>                    
					</tr>				
		<?
					$count++;
				}
			
			}else
				echo $sql;
				
		}
		?>
	</table>
	</fieldset>
 
	<br class="clear" />
    
</div>