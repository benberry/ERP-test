<fieldset>

    <p><label>Question:</label><textarea class="richeditor" name="name_1"><?=$row[name_1]; ?></textarea></p>
    
    <p><label>Answer:</label><textarea class="richeditor" name="content_1"><?=$row[content_1]; ?></textarea></p>
	
	<p><label>Display:</label>
		<input type="radio" name="active" value="1" <?=set_checked($row[active], 1); ?>>Yes
		<input type="radio" name="active" value="0" <?=set_checked($row[active], 0); ?>>No
	</p>

</fieldset>