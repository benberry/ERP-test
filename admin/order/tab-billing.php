<div id="order-info">
	<fieldset style="float:left; width:450px;">
    <legend>Billing Information</legend>
	<span class="notice">notice: display only, can not update</span>
	<table>
		<tr>
			<td><br></td>
			<td><br></td>                    
			<td><br></td>                    
		</tr>
        <tr>
		<td align="right">Name: </td>
            <td></td>
            <td>
            	<input type="text" value="<?=$row[first_name]; ?> <?=$row[last_name]; ?>">
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
            	<input type="text" value="<?=$row[phone_1]; ?>">
			 </td>
        </tr>
        <tr>
            <td><br></td>
            <td><br></td>                    
            <td><br></td>                    
        </tr>
		<tr>
			<td width="200" align="right">Address: </td>
			<td></td>
			<td><input type="text" value="<?=$row[addr_1]; ?>"></td>
		</tr>
        <tr>
			<td width="200" align="right">Address line 2: </td>
			<td></td>
			<td><input type="text" value="<?=$row[addr_2]; ?>"></td>
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
			<input type="text" value="<?=$row[addr_3]; ?>"></td>
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
			<input type="text" value="<?=get_field("tbl_country", "name_1", $row[country_id]); ?>"></td>
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
			<input type="text" value="<?=$row[country_state]; ?>"></td>
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
			<input type="text" value="<?=$row[postal_code]; ?>"></td>
		</tr>
		<tr>
			<td><br></td>
			<td><br></td>                    
			<td><br></td>                    
		</tr>	
	</table>
	</fieldset>
    
	<fieldset style="float:left; width:450px;">
    
    <legend>shipping Information</legend>

    <span class="notice">notice: display only, can not update</span>
    <table>
        <tr>
            <td><br></td>
            <td><br></td>                    
            <td><br></td>                    
        </tr>					
        <tr>
            <td align="right">Name: </td>
            <td></td>
            <td>
            <input type="text" value="<?=$row[shipping_first_name]; ?> <?=$row[shipping_last_name]; ?>" />
            </td>
        </tr>
        <tr>
            <td><br></td>
            <td><br></td>                    
            <td><br></td>                    
        </tr>					
        <tr>
            <td width="200" align="right">Address: </td>
            <td></td>
            <td>
            <input type="text" value="<?=$row[shipping_addr_1]; ?>" />
            </td>
        </tr>
        <tr>
            <td width="200" align="right">Address line 2: </td>
            <td></td>
            <td>
            <input type="text" value="<?=$row[shipping_addr_2]; ?>" />
            </td>
        </tr>    
        <tr>
            <td><br></td>
            <td><br></td>                    
            <td><br></td>                    
        </tr>
        <tr>
            <td align="right">City: </td>
            <td></td>
            <td><input type="text" value="<?=$row[shipping_addr_3]; ?>" /></td>
        </tr>
        <tr>
            <td><br></td>
            <td><br></td>                    
            <td><br></td>                    
        </tr>					
        <tr>
            <td align="right">Country: </td>
            <td></td>
            <td><input type="text" value="<?=get_field("tbl_country", "name_1", $row[shipping_country_id]) ?>" /></td>
        </tr>
        <tr>
            <td><br></td>
            <td><br></td>                    
            <td><br></td>                    
        </tr>
    
        <tr>
            <td align="right">State / Province: </td>
            <td></td>
            <td><input type="text" value="<?=$row[shipping_country_state]; ?>" /></td>
        </tr>
        <tr>
            <td><br></td>
            <td><br></td>                    
            <td><br></td>                    
        </tr>
        <tr>
            <td align="right">Postal Code: </td>
            <td></td>
            <td><input type="text" value="<?=$row[shipping_postal_code]; ?>" /></td>
        </tr>
    </table>
</fieldset>    

	<br class="clear" />
    
</div>