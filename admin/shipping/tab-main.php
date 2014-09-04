<fieldset>
	<!--<legend></legend>-->
	<p><label>Name:</label><input type="text" name="name_1" value="<?=$row[name_1]; ?>"></p><br />

    <p><label>Description:</label><input type="text" name="content_1" value="<?=$row[content_1]; ?>"></p><br />

	<p><label>Shipping Cost per Unit ($): </label><input type="text" name="cost" value="<?=$row[cost]; ?>"></p><br />
    
	<p><label>Handling Fee ($):</label><input type="text" name="handling_fee" value="<?=$row[handling_fee]; ?>"></p><br />

	<p><label>Available:</label>
		<input type="radio" name="active" value="1" <?=set_checked($row[active], 1); ?>>Yes
		<input type="radio" name="active" value="0" <?=set_checked($row[active], 0); ?>>No
	</p>

</fieldset>