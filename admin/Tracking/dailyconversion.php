<table>
	<tr>
        <th width="50"></th>
        <th>Date</th>
        <th>Tracking Name</th>
        <th>Tracking Code</th>
        <th>Product ID</th>
        <th>Number of Clicks</th>
        <th>Number of Orders</th>
        <th>Conversion</th>
	</tr>
	<?

	if ($num_rows > 0)
	{
	
			
		$count=1;
			while ($row = mysql_fetch_array($resultx))
			{
                if($row['clicks']>0 && $row['orders']>0){
                    $conversion = $row['orders']/$row['clicks'] * 100;
                }
                elseif($row['clicks']>0 && $row['orders']<=0){
                    $conversion = 0;
                }
                else{
                    $conversion = 0;
                }
                $conversion = number_format($conversion,2);
				//rows come here
                echo '<tr>';
                echo '<td>'.$count++.'</td>';
                echo '<td>'.date('d-m-Y',strtotime($row['datex'])).'</td>';
                echo '<td align="left">'.$row['tracking_name'].'</td>';
                echo '<td align="left">'.$row['tracking_code'].'</td>';
                echo '<td>'.$row['product_id'].'</td>';
                echo '<td>'.$row['clicks'].'</td>';
                echo '<td>'.$row['orders'].'</td>';
                echo '<td>'.$conversion.'%</td>';
                echo '</tr>';
		
				
	
			}
            
            
	
	}
    else{
        echo '<tr><td colspan="8">No records found</td></tr>';
    }

?>
</table>