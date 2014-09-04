<?
## init
	include("../include/init.php");
	
## request
	extract($_REQUEST);
	
?>
<h1><?=get_field("tbl_product", "name_1", $id); ?></h1>
<table width="1000" border="1" bordercolor="#eee" 
	style="border-collapse:collapse; font-family:Verdana, Geneva, sans-serif; font-size: 10px; line-height:24px;">
	<tr>
    	<th align="center">Date</th>
        <th align="center">By</th>
    	<th align="center">Stock Status</th>
    	<th align="center">Rate</th>
    	<th align="center">Unit Cost</th>
    	<th align="center">Profit(+/-)</th>
    	<th align="center">balancer(+/-)</th>
    	<th align="center">Weight</th>
        <th align="center">Price</th>
        <th align="center">Shipping</th>
        <th align="center">Total</th>
    </tr>
	<?
    ## sql
        $sql="select *from tbl_product_price_history where product_id=$id order by modify_date desc ";

        if ($result = mysql_query($sql)){

            while ($row = mysql_fetch_array($result)){

				$price	  = ($row[unit_cost] / $row[rate])+$row[product_profit]+$row[product_balancer];

				$shipping = item_express_shipping_cost($row[weight],1)-($row[price_balancer]/$row[rate]);

                ?>
                <tr>
                    <td align="center"><?=datetime_format("Y-m-d H:i:s",$row[modify_date]); 	?></td>                
                    <td align="center"><?=get_field("sys_user","user",$row[modify_by]); 		?></td>
                    <td align="center"><?=get_stock_status($row[stock_status]);				?></td>
                    <td align="right"><?=number_format($row[rate], 2); 			?></td>
                    <td align="right"><?=number_format($row[unit_cost], 2); 	?></td>
                    <td align="right"><?=number_format($row[price_profit], 2); 	?></td>
                    <td align="right"><?=number_format($row[price_balancer], 2);?></td>
                    <td align="right"><?=number_format($row[weight], 2); 		?></td>
                    <td align="right"><?=number_format($price, 2); 				?></td>
                    <td align="right"><?=number_format($shipping, 2); 			?></td>
                    <td align="right"><?=number_format($price+$shipping, 2); 	?></td>

                    
                </tr>
                <?
    
            }
    
        }else
			echo $sql;
        
    ?>
</table>