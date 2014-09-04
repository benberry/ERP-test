<fieldset>
	<!--<legend></legend>-->
    
	<p><label>Type:</label>
    	<input type="radio" name="type_id" value=1 checked="checked" <? //=set_checked(1, $row[type_id])?>>Discount coupon
    	<input type="radio" name="type_id" value=2 disabled="disabled" <? //=set_checked(2, $row[type_id])?>>Free shipping
        <input type="radio" name="type_id" value=3 disabled="disabled" <? //=set_checked(3, $row[type_id])?>>Free item
    </p><br />    
    
	<p><label>Name:</label><input type="text" name="name_1" value="<?=$row[name_1]; ?>"></p><br />
    
    <p><label>Code:</label><input type="text" name="code" value="<?=$row[code]; ?>"></p><br />
    
    <p><label>Discount($):</label><input type="text" name="amount" value="<?=$row[amount]; ?>"></p><br />
    
<!--    <p><label>Start Date:</label><? get_calendar("start_date", $row[start_date]); ?></p><br />-->
    
    <p><label>Expiry Date:</label><? get_calendar("end_date", $row[end_date]); ?></p><br />
    
	<p><label>Available:</label>
		<input type="radio" name="active" value="1" <?=set_checked($row[active], 1); ?>>Yes
		<input type="radio" name="active" value="0" <?=set_checked($row[active], 0); ?>>No
	</p>    
    
    
</fieldset>