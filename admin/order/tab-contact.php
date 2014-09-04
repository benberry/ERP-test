<div id="order-info">
                <fieldset><legend>Contact Information</legend>
                    <table>
                    <tr>
                        <td colspan="3">&nbsp;</td>                  
                    </tr>                
                    <tr>
                        <td width="200" align="right">Title: </td>
                        <td></td>
                        <td><?=$row[title]; ?></td>
                    </tr>
                    <tr>
                        <td><br></td>
                        <td><br></td>                    
                        <td><br></td>                    
                    </tr>					
                    <tr>
                        <td align="right">Name: </td>
                        <td width=""></td>
                        <td><?=$row[first_name]; ?> <?=$row[last_name]; ?></td>
                    </tr>
                    <tr>
                        <td><br></td>
                        <td><br></td>                    
                        <td><br></td>                    
                    </tr>
                    <tr>
                        <td align="right">Tel: </td>
                        <td></td>
                        <td><?=$row[phone_1]; ?></td>
                    </tr>
                    <tr>
                        <td><br></td>
                        <td><br></td>                    
                        <td><br></td>                    
                    </tr>
                    <tr>
                        <td align="right">Mobile: </td>
                        <td></td>
                        <td><?=$row[phone_2]; ?></td>
                    </tr>
                    <tr>
                        <td><br></td>
                        <td><br></td>                    
                        <td><br></td>                    
                    </tr>					
                    <tr>
                        <td width="150" align="right">Email: </td>
                        <td width="20"></td>
                        <td><a href="mailto:<?=$row[email]; ?>"><?=$row[email]; ?></a></td>
                    </tr>
                    <tr>
                        <td><br></td>
                        <td><br></td>                    
                        <td><br></td>                    
                    </tr>
                    </table>
				</fieldset>
            </div>