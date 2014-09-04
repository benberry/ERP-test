<fieldset>
	<!--<legend></legend>-->
    
    <p><label>Country:</label>
    <select name="cat_id">
        <?=get_combobox_src("tbl_country", "name_1", $row[cat_id], " sort_no "); ?>
    </select></p><br />

	<p><label>Name:</label><input type="text" name="name_1" value="<?=$row[name_1]; ?>"></p><br />

    <p><label>Code:</label><input type="text" name="code" value="<?=$row[code]; ?>"></p><br />

	<p>
    	<label>Available:</label>
		<input type="radio" name="active" value="1" <?=set_checked($row[active], 1); ?>> Yes
		<input type="radio" name="active" value="0" <?=set_checked($row[active], 0); ?>> No
	</p>

</fieldset>