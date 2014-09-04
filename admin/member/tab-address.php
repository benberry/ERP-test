<fieldset><legend>Billing Address</legend>

    <p><label>Address:</label><input type="text" name="addr_1" value="<?=$row[addr_1]?>" /></p>
    
    <p><label>Address Line 2:</label><input type="text" name="addr_2" value="<?=$row[addr_2]?>" /></p>
    
    <p><label>City:</label><input type="text" name="addr_3" value="<?=$row[addr_3]?>" /></p>
    
    <p><label>State/Province:</label><input type="text" name="country_state" value="<?=$row[country_state]?>" /></p>
    
    <p><label>Country:</label>
        <select name="country_id">
	        <option value="">--</option>
            <?=get_combobox_src("tbl_country", "name_1", $row[country_id], "sort_no"); ?>
        </select></p>
    
    <p><label>Postal Code</label><input type="text" name="postal_code" value="<?=$row[postal_code]?>" /></p>

</fieldset>

<fieldset><legend>Shipping Address</legend>

    <p><label>Address:</label><input type="text" name="shipping_addr_1" value="<?=$row[shipping_addr_1]?>" /></p>
    
    <p><label>Address Line 2:</label><input type="text" name="shipping_addr_2" value="<?=$row[shipping_addr_2]?>" /></p>
    
    <p><label>City:</label><input type="text" name="shipping_addr_3" value="<?=$row[shipping_addr_3]?>" /></p>
    
    <p><label>State/Province:</label><input type="text" name="shipping_country_state" value="<?=$row[shipping_country_state];?>" /></p>
    
    <p><label>Country:</label>
        <select name="shipping_country_id">
        	<option value="">--</option>
            <?=get_combobox_src("tbl_country", "name_1", $row[shipping_country_id], "sort_no"); ?>
        </select></p>
        

    
    <p><label>Postal Code</label><input type="text" name="shipping_postal_code" value="<?=$row[postal_code]?>" /></p>

</fieldset>