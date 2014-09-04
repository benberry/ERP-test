<fieldset class='single-form'>

	<p><label>Category:</label>
		<select name="cat_id">
			<option value="">TOP</option>
			<?
				if (!empty($row[cat_id]))
					$cat_id = $row[cat_id];
			?>
			<?=get_category_combo($cat_tbl, 0, 0, $cat_id)?>
		</select></p>

	<p><label>Name:</label><input type="text" name="name_1" value="<?=$row[name_1]; ?>"></p>
    
    <p><label>Photo:</label><? get_image_upload_box($tbl, $row[id], 1, "vie_crop", "", $curr_page); ?></p>
    
	<p><label>Weight(kg):</label><input type="text" name="weight" value="<?=$row[weight]; ?>"></p>

	<p><label>Price($):</label><input type="text" name="price_1" value="<?=$row[price_1]; ?>"></p>
    
    <p><label>Content:</label><textarea class="richeditor" name="content_1"><?=$row[content_1];?></textarea></p>
        
	<p><label>Sort No:</label><input type="text" name="sort_no" value="<?=$row[sort_no]; ?>"></p>
	
	<p><label>Enable/Disable:</label>
		<input type="radio" name="active" value="1" <?=set_checked($row[active], 1); ?>>Enable
		<input type="radio" name="active" value="0" <?=set_checked($row[active], 0); ?>>Disable</p>

</fieldset>