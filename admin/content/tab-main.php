<fieldset>
	<table>
		<tr>
			<td width="150" align="right"><br></td>
			<td width="20"><br></td>                    
			<td width="*"><br></td>                    
		</tr>

		<tr>
			<td align="right">Name:</td>
			<td></td>
			<td><input type="text" name="name_1" value="<?=$row[name_1]; ?>"></td>
		</tr>
		<tr>
			<td><br></td>
			<td><br></td>                    
			<td><br></td>
		</tr>
       
		<tr>
			<td align="right">Content 1:</td>
			<td></td>
			<td><textarea name="desc_1" class="richeditor"><?=$row[desc_1]; ?></textarea></td>
		</tr>
		<tr>
			<td><br></td>
			<td><br></td>                    
			<td><br></td>
		</tr>
        
        <?
        	if($row[id] == 11){
				?>
                <tr>
                    <td align="right">Content 2:</td>
                    <td></td>
                    <td><textarea name="desc_2" class="richeditor"><?=$row[desc_2]; ?></textarea></td>
                </tr>
                <tr>
                    <td><br></td>
                    <td><br></td>                    
                    <td><br></td>
                </tr>
                <?
			}
		?>	

		<tr>
			<td align="right">Status: </td>
			<td></td>
			<td align="left">
			<input type="radio" name="active" value="1" <?=set_checked($row[active],1)?>>Enable
			<input type="radio" name="active" value="0" <?=set_checked($row[active],0)?>>Disable
			</td>
		</tr>
		<tr>
			<td><br></td>
			<td><br></td>
			<td><br></td>                    
		</tr>
        
	</table>
</fieldset>