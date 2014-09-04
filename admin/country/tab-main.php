<fieldset>
	<!-- <legend> </legend> -->
    
	<p><label>Name:</label><input type="text" name="name_1" value="<?=$row[name_1]; ?>"></p><br />
    
    <p><label>ISO:</label><input type="text" name="iso_code_2" value="<?=$row[iso_code_2]; ?>"></p><br />
     
    <p><label>Codes:</label><input type="text" name="iso_code_3" value="<?=$row[iso_code_3]; ?>"></p><br />
    
    <p><label>Zone:</label><input type="text" name="zone" value="<?=$row[zone]; ?>"></p><br />
    
    <p><label>VAT (FIX):</label>
	    <select name="currency_id">
            <option value="">CURRENCY</option>
            <?=get_combobox_src("tbl_currency", "name_1", $row[currency_id]); ?>
        </select>
    	$<input type="text" name="vat_fix" value="<?=$row[vat_fix]; ?>" style="width: 150px;"></p><br />

		<!--<p>
            <label>Postal Code:</label>
            <input type="radio" name="postal_code" <?=set_checked(1, $row[postal_code]);?> value="1">Active
            <input type="radio" name="postal_code" <?=set_checked(0, $row[postal_code]);?> value="0">Disable
            </p>
            <br />-->
        
    <p><label>VAT%:</label><input type="text" name="vat" value="<?=$row[vat]; ?>">%</p><br />   

    <p><label>Registered Airmail:</label>
    	<input type="radio" name="airmail" <?=set_checked(1, $row[airmail]);?> value="1">Active
        <input type="radio" name="airmail" <?=set_checked(0, $row[airmail]);?> value="0">Disable</p><br />
    
    <p><label>Express Shipping:</label>
    	<input type="radio" name="express" <?=set_checked(1, $row[express]);?> value="1">Active
        <input type="radio" name="express" <?=set_checked(0, $row[express]);?> value="0">Disable</p><br />
    
    <p><label>Estimated Delivery Time:</label>
    	<input type="text" name="express_est_time"  value="<?=$row['express_est_time'];?>" size="35"/></p><br />
	<p><label>Available:</label>
		<input type="radio" name="active" value="1" <?=set_checked($row[active], 1); ?>>Yes
		<input type="radio" name="active" value="0" <?=set_checked($row[active], 0); ?>>No</p><br />  
    
    
</fieldset>