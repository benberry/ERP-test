<script>

function order_details_add_item(){

	fr = document.frm
	fr.action = "../order-create/add-item.php";
	fr.method = "POST";
	fr.target = "_self";
	fr.submit();

}

function order_details_update_item(){

	fr = document.frm
	fr.action = "../order-create/update-item.php";
	fr.method = "POST";
	fr.target = "_self";
	fr.submit();

}

function order_details_delete_item(id){

	fr = document.frm
	fr.action = "../order-create/delete-item.php?item_id=" + id;
	fr.method = "POST";
	fr.target = "_self";
	fr.submit();

}

</script>

<div id="order-details">
<fieldset>
	<legend>Order Details</legend>
	<table>
		<tr>
			<th>Item</th>
			<th>Price</th>
            <th>Weight</th>
			<th>QTY</th>
			<th>Subtotal</th>
            <th></th>
		</tr>
		<?
		
		function get_item_list($cart_id){
			
			$rate = get_field("tbl_cart", "exchange_rate", $cart_id);
			
			$sql = " select * from tbl_cart_item where cart_id={$cart_id} order by unit_price desc ";
			
			if ( $result = mysql_query($sql)){
			  
			  while ($row = mysql_fetch_array($result)){
				  
				  $wrap_fees = $row[wrap_fees];
				  $unit_price = $row[unit_price];
				  $option_price = $row[option_price];
				  $item_total_weight = $row[unit_weight] + $row[option_weight];

				  ?>
				  
				  <tr>
					<td style="padding-left:20px; padding-bottom:20px; ">
						<div style="font-size:14px;"><?=get_field("tbl_product", "name_1", $row[product_id]); ?></div>
                        <div style="font-size:10px;">
                        <?
						
						$accessory_price = get_field("tbl_product", "accessory_price", $row[product_id]);
						
                        if ($accessory_price > 0){
							?>ref: accessory price: <?=round($accessory_price / get_rate(), 2); ?><?
						}
						?>
                        </div>
                    </td>
					<td align="center">
                        <input type="text" name="row_price_<?=$row[id]; ?>" value="<?=round($unit_price, 2); ?>" style="width: 100px;" />
					</td>
                    <td align="center">
                    	<input type="text" name="row_weight_<?=$row[id]; ?>" value="<?=$row[unit_weight]; ?>" style="width: 30px;" />&nbsp;kg</td>
					<td align="center">
                    	<input type="text" name="row_qty_<?=$row[id]; ?>" value="<?=$row[qty]; ?>" style="width: 30px;" /></td>                    
					<td align="right" style="padding-right: 20px;">
						<?=number_format( ($unit_price) *$row[qty], 2); ?>
					</td>
                    <td align="right">
						<input type="button" value="X" onclick="javascript: order_details_delete_item(<?=$row[id]; ?>); " style="margin-right:10px; ">
					</td>
				  </tr>
				  
				  <?
			
			  }
			
			}else
				echo $sql;
				
		} //function get_item_list($cart_id){
			
		get_item_list($id);

		?>
        <tr style="background-color:#eee">
        	<td colspan="7">
            	<? get_lookup("add_item_id", "../lookup/product.php", '', '', "Product Lookup"); ?>
                <input type="button" value="Add" onclick="javascript: order_details_add_item();" />
                <input type="button" value="Update" onclick="javascript: order_details_update_item();" style=" float:right; " />
            </td>
          <td align="right"></td>
        </tr>
	</table>

	<div id="order-summary">
		<?
			## currency
				$currency_id 	= get_field("tbl_cart", "currency_id", $id);
				$currency 		= get_field("tbl_currency", "symbol_1", $currency_id);
				$rate 			= get_field("tbl_cart", "exchange_rate", $id);
				$rate_hkd 		= get_rate();

			## subtotal
				$sub_total 		= number_format(get_cart_total_amount($id) * $rate, 2);
	
			## shipping cost	
				$shipping_cost 	= get_field("tbl_cart", "shipping_cost", $id);
				$shipping_cost 	= number_format($shipping_cost * $rate, 2);
				
			## subcharge
				$subcharge 		= number_format(get_field("tbl_cart", "subcharge", $id) * $rate, 2);
				
				if ($row[payment_method_id] == 1){
					$payment_method="Paypal";

				}
				
				if ($row[payment_method_id] == 7){
					$payment_method="WorldPay";

				}					
	
			## total amount	
				$total_amount = number_format(get_total_amount($id) * $rate, 2);
	
		?>
            
        <table style="float:right; width:600px; border: 0px solid #eee; ">
            <tr>
                <td align="left" width="" >Subtotal:</td>
                <td align="right" width="" style="padding-right: 50px"><?=$sub_total; ?></td>
            </tr>
            <tr>
                <td align="left">Express Shipping:</td>
                <td align="right" style="padding-right: 50px"><?=$shipping_cost; ?></td>
            </tr>
            <tr>
                <td align="left">Surcharge(<?=$payment_method; ?>):</td>
                <td align="right" style="padding-right: 50px"><?=$subcharge; ?></td>
            </tr>
            
            <tr>
                <td align="left"><b>Total Amount (<?=$currency; ?>): </b></td>
                <td align="right" style="padding-right: 50px"><b><?=$total_amount; ?></b></td>
            </tr>                        
        </table>
	</div>
</fieldset>
</div>