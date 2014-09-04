<fieldset>
	<!--<legend></legend>-->
	<p><label>Supplier Code:</label><input type="text" name="code" value="<?=$row[code]; ?>"></p>
    
   	<p><label>Supplier Name:</label><input type="text" name="name" value="<?=$row[name]; ?>"></p>
   	<p><label>Details:</label><input type="text" name="detail" value="<?=$row[detail]; ?>"></p>
   	<p><label>Contact Name:</label><input type="text" name="contact_name" value="<?=$row[contact_name]; ?>"></p>
   	<p><label>E-mail:</label><input type="text" name="email" value="<?=$row[email]; ?>"></p>
   	<p><label>Phone:</label><input type="text" name="phone" value="<?=$row[phone]; ?>"></p>  
    
	<p><label>Sort No:</label><input type="text" name="sort_no" value="<?=$row[sort_no]; ?>"></p><br />
	
	<p><label>Available:</label>
		<input type="radio" name="active" value="1" <?=set_checked($row[active], 1); ?>>Yes
		<input type="radio" name="active" value="0" <?=set_checked($row[active], 0); ?>>No
	</p>    
</fieldset>