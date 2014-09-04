<fieldset>

	<p><label>Photo:</label><? get_image_upload_box($tbl, $row[id], 1, "thu_crop", "", $curr_page); ?></p>
    
    <p><label>Title</label><input type="text" name="name_1" value="<?=$row[name_1]; ?>" ></p>
	
	<p><label>URL:</label><input type="text" name="url" value="<?=$row[url]; ?>" ></p>
	
	<p><label>Available:</label>
		<input type="radio" name="active" value="1" <?=set_checked($row[active], 1); ?>>Yes
		<input type="radio" name="active" value="0" <?=set_checked($row[active], 0); ?>>No
	</p>

</fieldset>