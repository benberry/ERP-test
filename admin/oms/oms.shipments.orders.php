<table>
	<tr>
        <th width="50"></th>
        <th>Date</th>
        <th>Order Number</th>
        <th>Carrier</th>
        <th>Tracking Number</th>
        <th>Shipment Qty</th>
        <th>Action</th>
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
		      //$count=$moffset+1;
			  $count=1;
			
			while ($row = mysql_fetch_array($resultx))
			{	$subsql = "SELECT count(*) FROM tbl_order_shipment_item WHERE shipment_id = ".$row[id];
                //$invoice_number = ($row['invoice_no']=='')?'---':$row['invoice_no'];
				//rows come here
                echo '<tr>';
                echo '<td>'.$count++.'</td>';
                //echo '<td>'.date('Y-m-d',strtotime($row['create_date'])).'</td>';
                echo '<td>'.$row[create_date].'</td>';
                echo '<td>'.$row[order_no].'</td>';
                echo '<td>'.$row[carrier_title].'</td>';
                echo '<td>'.$row[tracking_no].'</td>';
                echo '<td>'.mysql_result(mysql_query($subsql), 0).'</td>';
                echo '<td><a href="./main.php?func_pg=oms.shipments.edit&id='.$row[id].'&prev_page=oms.shipments.list">Edit</a></td>';
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