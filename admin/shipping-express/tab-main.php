<fieldset class='single-form'>

	<p><label>Zone:</label>
	    <select name="cat_id">
	        <?
				if (!empty($row[cat_id]))
					$cat_id = $row[cat_id];
			?>
			<?=get_combobox_src("tbl_shipping_express_zone", "zone", $cat_id); ?>
        </select>
    </p>

	<p><label>Weight (kg):</label><input type="text" name="weight" value="<?=$row[weight]; ?>"></p>

	<p><label>Shipping Rate ($):</label><input type="text" name="cost" value="<?=$row[cost]; ?>"></p>

</fieldset>