<fieldset>
	<p><label>Group:</label>
		<select name="cat_id">
			<option> please select </option>
			<?=get_combobox_src("tbl_email_group", "name_1", $row[cat_id]); ?>
		</select>
	</p>

	<p><label>Title:</label>
		<select name="title_id">
        	<option value=""> -- </option>
			<?=get_combobox_src("tbl_title", "name_1", $row[title_id]); ?>
		</select>
	</p>

	<p><label>First Name:</label><input type="text" name="first_name" value="<?=$row[first_name]; ?>"></p>
	
	<p><label>Last Name:</label><input type="text" name="last_name" value="<?=$row[last_name]; ?>"></p>
	
	<p><label>Company:</label><input type="text" name="company" value="<?=$row[company]; ?>"></p>
	
	<p><label>Email:</label><input type="text" name="email" value="<?=$row[email]; ?>"></p>
	
	<p>
		<label>Available:</label>
		<input type="radio" name="active" value="1" <?=set_checked($row[active], 1); ?>>Yes
		<input type="radio" name="active" value="0" <?=set_checked($row[active], 0); ?>>No
	</p>
	
</fieldset>