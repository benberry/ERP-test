<div id="order-info">
<fieldset>
	<legend>ePayment Info</legend>
	<? if ($row[payment_gateway_ref]!="") { ?>
		<table>
		<tr>
			<td colspan="3">&nbsp;</td>                  
		</tr>
		<tr>
			<td width="200" align="right">Date: </td>
			<td></td>
			<td><?=$row[payment_gateway_date]; ?></td>
		</tr>
	   <tr>
			<td><br></td>
			<td><br></td>                    
			<td><br></td>                    
		</tr>									
		<tr>
			<td align="right">Ref No.: </td>
			<td></td>
			<td><?=$row[payment_gateway_ref]; ?></td>
		</tr>
	   <tr>
			<td><br></td>
			<td><br></td>                    
			<td><br></td>                    
		</tr>									
		<tr>
			<td align="right">Status: </td>
			<td></td>
			<td><?=$row[payment_gateway_status]; ?></td>
		</tr>
	   <tr>
			<td><br></td>
			<td><br></td>                    
			<td><br></td>                    
		</tr>									
		<tr>
			<td align="right">Amount: </td>
			<td></td>
			<td><?=$row[payment_gateway_amt]; ?></td>
		</tr>
	   <tr>
			<td><br></td>
			<td><br></td>                    
			<td><br></td>                    
		</tr>									
		<tr>
			<td align="right">Currency: </td>
			<td></td>
			<td><?=$row[payment_gateway_cur]; ?></td>
		</tr>
	   <tr>
			<td><br></td>
			<td><br></td>                    
			<td><br></td>                    
		</tr>
        <tr>
			<td align="right">Payer Email: </td>
			<td></td>
			<td><?=$row[payment_gateway_payer_email]; ?></td>
		</tr>
	    <tr>
			<td><br></td>
			<td><br></td>                    
			<td><br></td>                    
		</tr>								
		</table>	
	<? } else { ?>																																													
			<div style="margin:30px">No Record</div>
	<? } ?>
</fieldset>
</div>