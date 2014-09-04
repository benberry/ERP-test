<div id="order-info">
	<fieldset style="float:left; width:450px;">
    <legend>Billing Information</legend>
	<!-- <span class="notice">notice: display only, can not update</span>-->
	<?
		
		get_order_billing_address($row[id]);
		
		function get_order_billing_address($order_id){		
			$first_name="";$last_name="";$telephone="";$company="";$street="";$city="";$region="";$country="";$post_code="";
			$sql = " select * from tbl_order_billing_address where order_id={$order_id} order by id desc ";
			
			if ($result=mysql_query($sql)){
			  
				while ($row=mysql_fetch_array($result)){
					$first_name = $row[first_name];
					$last_name = $row[last_name];
					$telephone = $row[telephone];
					$company = $row[company];
					$street = $row[street];
					$city = $row[city];
					$region = $row[region];
					$country = $row[country];
					$post_code = $row[post_code];
				}
				
					?>
				<table>
					<tr>
						<td><br></td>
						<td><br></td>                    
						<td><br></td>                    
					</tr>
					<tr>
					<td align="right">First Name: </td>
						<td></td>
						<td>
							<input type="text" name="bill_to_first_name" value="<?=$first_name; ?>" >
						</td>
					</tr>
					<tr>
						<td><br></td>
						<td><br></td>                    
						<td><br></td>                    
					</tr>
					<tr>
					<td align="right">Last Name: </td>
						<td></td>
						<td>
							<input type="text" name="bill_to_last_name" value="<?=$last_name;?>" >
						</td>
					</tr>
					<tr>
						<td><br></td>
						<td><br></td>                    
						<td><br></td>                    
					</tr>
					<tr>
					<td align="right">Phone: </td>
						<td></td>
						<td>
							<input name="bill_to_telephone" type="text" value="<?=$telephone; ?>">
						</td>
					</tr>
					<tr>
						<td><br></td>
						<td><br></td>                    
						<td><br></td>                    
					</tr>
					<tr>
						<td width="200" align="right">Company: </td>
						<td></td>
						<td><input name="bill_to_company" type="text" value="<?=$company; ?>"></td>
					</tr>
					<tr>
						<td><br></td>
						<td><br></td>                    
						<td><br></td>                    
					</tr>
					<tr>
						<td width="200" align="right">Street: </td>
						<td></td>
						<td><input name="bill_to_street" type="text" value="<?=$street; ?>"></td>
					</tr>
					<tr>
						<td><br></td>
						<td><br></td>                    
						<td><br></td>                    
					</tr>
					<tr>
						<td align="right">City: </td>
						<td></td>
						<td>
						<input name="bill_to_city" type="text" value="<?=$city; ?>"></td>
					</tr>
					<tr>
						<td><br></td>
						<td><br></td>                    
						<td><br></td>                    
					</tr>					
					<tr>
						<td align="right">Country: </td>
						<td></td>
						<td>
						<input name="bill_to_country" type="text" value="<?=$country; ?>"></td>
					</tr>
					<tr>
						<td><br></td>
						<td><br></td>                    
						<td><br></td>                    
					</tr>
			
					<tr>
						<td align="right">State / Province: </td>
						<td></td>
						<td>
						<input name="bill_to_region" type="text" value="<?=$region; ?>"></td>
					</tr>
					<tr>
						<td><br></td>
						<td><br></td>                    
						<td><br></td>                    
					</tr>
					<tr>
						<td align="right">Postal Code: </td>
						<td></td>
						<td>
						<input name="bill_to_post_code" type="text" value="<?=$post_code; ?>"></td>
					</tr>
					<tr>
						<td><br></td>
						<td><br></td>                    
						<td><br></td>                    
					</tr>	
				</table>
		<?
			
							
			}else
				echo $sql;
				
		}
		?>
	</fieldset>
    
	<fieldset style="float:left; width:450px;">
    
    <legend>Shipping Information</legend>

   <!-- <span class="notice">notice: display only, can not update</span> -->
    <?
		
		get_order_shipping_address($row[id]);
		
		function get_order_shipping_address($order_id){		
			$first_name="";$last_name="";$telephone="";$company="";$street="";$city="";$region="";$country="";$post_code="";
			$sql = " select * from tbl_order_shipping_address where order_id={$order_id} order by id desc ";
			
			if ($result=mysql_query($sql)){
			  
				while ($row=mysql_fetch_array($result)){
					$first_name = $row[first_name];
					$last_name = $row[last_name];
					$telephone = $row[telephone];
					$company = $row[company];
					$street = $row[street];
					$city = $row[city];
					$region = $row[region];
					$country = $row[country];
					$post_code = $row[post_code];
				}
					?>
				<table>
					<tr>
						<td><br></td>
						<td><br></td>                    
						<td><br></td>                    
					</tr>
					<tr>
					<td align="right">First Name: </td>
						<td></td>
						<td>
							<input type="text" name="ship_to_first_name" value="<?=$first_name; ?>" >
						</td>
					</tr>
					<tr>
						<td><br></td>
						<td><br></td>                    
						<td><br></td>                    
					</tr>
					<tr>
					<td align="right">Last Name: </td>
						<td></td>
						<td>
							<input type="text" name="ship_to_last_name" value="<?=$last_name;?>" >
						</td>
					</tr>
					<tr>
						<td><br></td>
						<td><br></td>                    
						<td><br></td>                    
					</tr>
					<tr>
					<td align="right">Phone: </td>
						<td></td>
						<td>
							<input name="ship_to_telephone" type="text" value="<?=$telephone; ?>">
						</td>
					</tr>
					<tr>
						<td><br></td>
						<td><br></td>                    
						<td><br></td>                    
					</tr>
					<tr>
						<td width="200" align="right">Company: </td>
						<td></td>
						<td><input name="ship_to_company" type="text" value="<?=$company; ?>"></td>
					</tr>
					<tr>
						<td><br></td>
						<td><br></td>                    
						<td><br></td>                    
					</tr>
					<tr>
						<td width="200" align="right">Street: </td>
						<td></td>
						<td><input name="ship_to_street" type="text" value="<?=$street; ?>"></td>
					</tr>
					<tr>
						<td><br></td>
						<td><br></td>                    
						<td><br></td>                    
					</tr>
					<tr>
						<td align="right">City: </td>
						<td></td>
						<td>
						<input name="ship_to_city" type="text" value="<?=$city; ?>"></td>
					</tr>
					<tr>
						<td><br></td>
						<td><br></td>                    
						<td><br></td>                    
					</tr>					
					<tr>
						<td align="right">Country: </td>
						<td></td>
						<td>
						<input name="ship_to_country" type="text" value="<?=$country; ?>"></td>
					</tr>
					<tr>
						<td><br></td>
						<td><br></td>                    
						<td><br></td>                    
					</tr>
			
					<tr>
						<td align="right">State / Province: </td>
						<td></td>
						<td>
						<input name="ship_to_region" type="text" value="<?=$region; ?>"></td>
					</tr>
					<tr>
						<td><br></td>
						<td><br></td>                    
						<td><br></td>                    
					</tr>
					<tr>
						<td align="right">Postal Code: </td>
						<td></td>
						<td>
						<input name="ship_to_post_code" type="text" value="<?=$post_code; ?>"></td>
					</tr>
					<tr>
						<td><br></td>
						<td><br></td>                    
						<td><br></td>                    
					</tr>	
				</table>
			<?
			}else
				echo $sql;
				
		}
		?>
</fieldset>    

	<br class="clear" />
    
</div>