<div id="order-details">
<fieldset>
	<legend>History</legend>
	<table>
		<tr style="height:30px">
			<th style="text-align:left">Create date</th>		
			<th style="text-align:left">Create by</th>			
			<th style="text-align:left">Status</th>
			<th style="text-align:left">Remarks</th>
		</tr>
		
		<?
		
		get_order_tracker_list($row[id]);
		
		function get_order_tracker_list($cart_id){		
			
			$sql = " select * from tbl_cart_order_tracker where cart_id={$cart_id} order by create_date desc ";
			
			if ($result=mysql_query($sql)){
			  
				while ($row=mysql_fetch_array($result)){
				
					?>
						<tr style="height:30px">
							<td width="100" align="left" valign="middle"><?=$row[create_date]; ?></td>
							<td width="100" align="left" valign="middle">
								<? 
								   if ($row[create_by]==0){
										echo "system";

								   }else{
										echo get_field("sys_user", "user", $row[create_by]);

								   }
		 
								?>
							
							</td>
							<td width="100" align="left" valign="middle">
								<?
									if ($row[order_status_id] > 0){
										echo get_field("tbl_cart_order_status", "name_1", $row[order_status_id]);

									}

								?>
							</td>
							<td width="300" align="left" valign="middle"><?=$row[remarks]; ?></td>
						</tr>
					<?
			
				}
			
			}else
				echo $sql;
				
		} //function get_item_list($cart_id){

		?>
	</table>
</fieldset>
</div>