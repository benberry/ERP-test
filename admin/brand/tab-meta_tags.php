<fieldset><legend>Category Meta Data</legend>
                <form name="frm" method ="post"  action="">
                    <input type="hidden" name="custom" value="custom"/>
			
			<table>
            
                <tr>
                    <td width="150"  align="right">Meta Title: </td>
                    
                    <td width="200">
						<textarea name="meta_title" rows="3" cols="50"><?=$row[meta_title]?></textarea>
					</td>
                </tr>
                <tr>
                    <td><br></td>
                    <td><br></td>                   
                </tr>
                <tr>
                    <td align="right">Meta Description: </td>
                    
                    <td>
						<textarea name="meta_description" rows="3" cols="50"><?=$row[meta_description]?></textarea>
					</td>
                </tr>
                <tr>
                    <td><br></td>
                    <td><br></td>                   
                </tr>
                <tr>
                    <td align="right">Meta Keywords: </td>
                    
                    <td>
						<textarea name="meta_keywords" rows="3" cols="50"><?=$row[meta_keywords]?></textarea>
					</td>
                </tr>
                <tr>
                    <td><br></td>
                    <td><br></td>                   
                </tr>
                
			</table>	
			</form>
			</fieldset>