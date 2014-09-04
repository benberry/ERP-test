<table>
	<tr>
        <th width="50"></th>
        <th>Date</th>
        <th>Tracking Name</th>
        <th>Tracking Code</th>
        <th>Number of Clicks</th>
        <th>Number of Orders</th>
        <th>Conversion Rate</th>
	</tr>
	<?

	if ($num_rows > 0)
	{
	   
	         
		$count=1;
			while ($row = mysql_fetch_array($resultx))
			{
                $invoice_number = ($row['invoice_no']=='')?'---':$row['invoice_no'];
				//rows come here
                echo '<tr>';
                echo '<td>'.$count++.'</td>';
                echo '<td>'.date('d-m-Y',strtotime($row['date_created'])).'</td>';
                echo '<td align="left">'.$row['tracking_name'].'</td>';
                echo '<td align="left">'.$row['tracking_code'].'</td>';
                echo '<td align="left">'.$row['clicks'].'</td>';
                echo '<td align="left">'.$row['orders'].'</td>';
                echo '<td align="left">'.$row['Conversion Rate'].'</td>';
                echo '</tr>';
		
				
	
			
        }
	
	}
    else{
        echo '<tr><td colspan="7">No records found</td></tr>';
    }

?>
</table>