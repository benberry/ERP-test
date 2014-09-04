<table>
	<tr>
        <th width="50"></th>
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
	mysql_data_seek($result, $pbar[0]);
	
		for($i=0; $i < $page_item ;$i++)
		{
		
			if ($row = mysql_fetch_array($resultx))
			{
	           if(isset($pg_num)){
        $moffset = $page_item*($pg_num-1);
        
    }
    else{
        $moffset = 0;
    }
		$count=$moffset+1;
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
                echo '<td align="left">'.$row['tracking_name'].'</td>';
                echo '<td align="left">'.$row['tracking_code'].'</td>';
                echo '<td>'.$row['product_id'].'</td>';
                echo '<td>'.$row['clicks'].'</td>';
                echo '<td>'.$row['orders'].'</td>';
                echo '<td>'.$conversion.'%</td>';
                echo '</tr>';
		
				
	
			}
            }}
	
	}
    else{
        echo '<tr><td colspan="7">No records found</td></tr>';
    }

?>
</table>