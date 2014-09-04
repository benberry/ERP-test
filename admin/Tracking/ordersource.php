<table>
	<tr>
        <th width="50"></th>
        <th>Date</th>
        <th>Tracking Name</th>
        <th>Tracking Code</th>
        <th>Product ID</th>
        <th>Order Number</th>
	</tr>
	<?

	if ($num_rows > 0)
	{
	   //mysql_data_seek($result, $pbar[0]);
	
	//	for($i=0; $i < $page_item ;$i++)
	//	{
		
		//if ($row = mysql_fetch_array($resultx))
		//	{
	           if(isset($pg_num)){
                    $moffset = $page_item*($pg_num-1);
                    
                }
                else{
                    $moffset = 0;
                }
		      $count=$moffset+1;
			while ($row = mysql_fetch_array($resultx))
			{
                $invoice_number = ($row['invoice_no']=='')?'---':$row['invoice_no'];
				//rows come here
                echo '<tr>';
                echo '<td>'.$count++.'</td>';
                echo '<td>'.date('d-m-Y',strtotime($row['time_of_visit'])).'</td>';
                echo '<td align="left">'.$row['tracking_name'].'</td>';
                echo '<td align="left">'.$row['tracking_code'].'</td>';
                echo '<td align="left">'.$row['product_id'].'</td>';
                echo '<td>'.$invoice_number.'</td>';
                echo '</tr>';
		
               
			}
        //}
  // }
	
	}
    else{
        echo '<tr><td colspan="6">No records found</td></tr>';
    }

?>
</table>