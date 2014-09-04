<fieldset>
	<!--<legend></legend>-->
	<p><label>Order Status Code:</label><input type="text" name="code" value="<?=$row[code]; ?>"></p>
    
   	<p><label>Order Status Name:</label><input type="text" name="name" value="<?=$row[name]; ?>"></p>
	
   	<p><label>Details:</label><input type="text" name="detail" value="<?=$row[detail]; ?>"></p>
   	
	<p><label>Sort No:</label><input type="text" name="sort_no" value="<?=$row[sort_no]; ?>"></p><br />
	
	<p><label>Available:</label>
		<input type="radio" name="active" value="1" <?=set_checked($row[active], 1); ?>>Yes
		<input type="radio" name="active" value="0" <?=set_checked($row[active], 0); ?>>No
	</p>    
</fieldset>