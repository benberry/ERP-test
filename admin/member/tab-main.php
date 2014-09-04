<fieldset>

	<legend>Login</legend>
	
	<p><label>Email(Login ID):</label><input type="text" name="email" value="<?=$row[email]; ?>"></p>
	
	<p><label>Password:</label><input type="password" name="password" value="<?=base64_decode($row[password]); ?>"></p>

</fieldset>
	
<fieldset>

	<p><label>First Name:</label><input type="text" name="first_name" value="<?=$row[first_name]; ?>"></p>
	
	<p><label>Last Name:</label><input type="text" name="last_name" value="<?=$row[last_name]; ?>"></p>	
    
    <p><label>Telephone:</label><input type="text" name="phone_1" value="<?=$row[phone_1]; ?>"></p>
	
	<p>
		<label>Available:</label>
		<input type="radio" name="active" value="1" <?=set_checked($row[active], 1); ?>>Yes
		<input type="radio" name="active" value="0" <?=set_checked($row[active], 0); ?>>No
	</p>		

</fieldset>