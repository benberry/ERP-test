<div id="order-info">
	<fieldset>
		<legend>Order Summary</legend>
		<table style="float:left; margin-left:50px; width:350px; ">
			<tr>
				<td colspan="3">&nbsp;</td>                  
			</tr> 
			<tr>
				<td width="150" align="left">Order Date: </td>
				<td></td>
				<td><?=$row[create_date]?></td>
			</tr>
			<tr>
				<td><br></td>
				<td><br></td>                    
				<td><br></td>                    
			</tr>
			<tr>
				<td align="left">Order No: </td>
				<td></td>
				<td><?=$row[order_no]?></td>
			</tr>
			<tr>
				<td><br></td>
				<td><br></td>                    
				<td><br></td>                    
			</tr>
			<tr>
				<td align="left">Customer: </td>
				<td></td>
				<td>
					<?=$row[customer_firstname]; ?>&nbsp;
                    <?=$row[customer_lastname]; ?>
					<!--
                    <?
						if ($row[member_id] > 0){
							?><div class="notice">( member )</div><?							
						}else{
							?><div class="notice">( non-member )</div><?							
						}                        
					?>-->
				</td>
			</tr>
			<tr>
				<td><br></td>
				<td><br></td>                    
				<td><br></td>                    
			</tr>
            
            <tr>
				<td align="left">Email: </td>
				<td></td>
				<td>
					<?=$row[customer_email]; ?>&nbsp;
				</td>
			</tr>
			<tr>
				<td><br></td>
				<td><br></td>                    
				<td><br></td>                    
			</tr>            
            <tr>
				<td align="left">Shipping Method: </td>
				<td></td>
				<td>
					<?
						echo $row[shipping_method];						
						echo "<br/>";						

					?>
                </td>
			</tr>
			<tr>
				<td><br></td>
				<td><br></td>                    
				<td><br></td>                    
			</tr>
            
			<tr>
				<td align="left">Payment Method: </td>
				<td></td>
				<td><?=$row[payment_method]; ?></td>
			</tr>
			<tr>
				<td><br></td>
				<td><br></td>                    
				<td><br></td>                    
			</tr>            
			
			<tr>
				<td width="150" align="left">Currency: </td>
				<td></td>
				<td><?=$row[order_currency_code]; ?></td>
			</tr>
			<tr>
				<td><br></td>
				<td><br></td>                    
				<td><br></td>                    
			</tr>					
            
			<tr>
				<td align="left">Total Received:</td>
				<td></td>
				<td><?=$row[grand_total]; ?></td>
			</tr>
			<tr>
				<td><br></td>
				<td><br></td>                    
				<td><br></td>                    
			</tr>
         </table>
         
         <table style="float:left; margin-left:50px; width:450px;" cellspacing="15">
			<tr>
				<td colspan="3">&nbsp;</td>                  
			</tr>          
			<!--<tr>
				<td align="left">Shipping Company:</td>
				<td></td>
				<td>
				<select name="shipping_company_id" style="width:200px;" id="shipping_company_id">
                	<option value=""> -- </option>
					<?=get_combobox_src('tbl_shipping_company', 'name_1', $row[shipping_company_id], " name_1 asc ")?>  
				</select>
				</td>
			</tr> -->
			<tr>
				<td colspan="3" style="border-bottom: 1px dotted #222;"><br></td>
			</tr>
			<tr>
				<td colspan="3" align="left"><h2>Shipment:</h2></td>				
			</tr>
			<?php
			$shipment_sql = " select * from tbl_order_shipment where order_id = $id order by id asc";
	
			if ($shipment_rows = mysql_query($shipment_sql)){
				echo '<tr><td><b>Tracking Number</b></td><td><b>Created Date</b></td></tr>';
				while($shipment_row = mysql_fetch_array($shipment_rows))
				{				
				echo '<tr>						
						<td><a href="../main/main.php?func_pg=oms.shipments.edit&id='.$shipment_row[id].'&&prev_page=oms.so.edit">'.$shipment_row[tracking_no].'</a></td>
						<td>'.$shipment_row[create_date].'</td>
					 </tr>';
				}
			}else			
				echo '<tr>
					<td align="left">Read Shipment:</td>					
					<td>Fail with error!</td>
				</tr>';			
			?>
			<tr>
				<td colspan="3" style="border-bottom: 1px dotted #222;"><br></td>
			</tr>
			<tr>				                
				<td colspan="3"><div id="button"><a class="boldbuttons" href="javascript:form_action(2)"><span style="width: 100%;">New Shipment</span></a></td>
			</tr>							
		</table>


         <table style="float:left; margin-left:50px; width:450px;">
			<tr>
				<td colspan="3">&nbsp;</td>                  
			</tr>          
			<tr>
				<td colspan="2" align="left">Current Order Status:</td>				
				<td align="left"><?=get_field('tbl_order_status', 'name', $row[order_status_id]) ?>
				<input type="hidden" name="current_order_status" value="<?=get_field('tbl_order_status', 'id', $row[order_status_id]) ?>" />
				</td>
			</tr>
			<tr>
				<td colspan="3">&nbsp;</td>                  
			</tr>          
			<tr>
				<td colspan="2" align="left">Change Order Status:</td>				
				<td align="left">
					<script>
                       /* function change_order_status_content(id){
                            
                            $.get("../order/get-order-status-content.php", 
                                {id: id}, 
                                function(data){
                                    tinyMCE.activeEditor.setContent(data);
                                });
                            
                        }*/
                    </script>

				<!--<select name="order_status_id" id="order_status_id" onchange="change_order_status_content(this.value)">
					<?=get_combobox_src('tbl_cart_order_status', 'name_1', $row[order_status_id])?>  
				</select>-->
				<select name="order_status_id" id="order_status_id">
					<?=get_combobox_src('tbl_order_status', 'name', $row[order_status_id])?>  
				</select>				
				</td>
			</tr>
			<tr>
				<td><br></td>
				<td><br></td>                    
				<td><br></td>
			</tr>
			<tr>
				<td colspan="3"><input type="checkbox" name="email_sent" value="1" disabled>email to customer</td>
			</tr><tr>
				<td><br></td>
				<td><br></td>                    
				<td><br></td>
			</tr>
			<tr>
				<td align="left">Remarks:</td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td colspan="3" align="left"><textarea name="remarks" id="remarks" class="richeditor"><?=$row[remarks]; ?></textarea></td>
			</tr>            
			<tr>
				<td><br></td>
				<td><br></td>                    
				<td><br></td>
			</tr>							
		</table>
        <br class="clear" />
        <!--
        <table style="margin:50px;">
            <tr>
                <td align="left"><strong>Instructions / Remarks: (customer viewable)</strong></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="3"><textarea name="content_1" id="content_1" style="width: 800px; height: 150px; " ><?=$row[content_1]; ?></textarea></td>
            </tr>
        </table>
        -->
        <br class="clear" />
        
        <table style="margin:50px;">
	        <tr>
                <td align="left"><strong>Source:</strong></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="3">Remote IP: <?=$row[remote_ip]; ?></td>
          	</tr>
        </table>        
        
        <br class="clear" />              
         
	</fieldset>
</div>
<div id="order-details">
<fieldset>
	<legend>Update History</legend>
	<table border="0" style="border-collapse:collapse; ">
		<tr style="height:30px">
			<th>Date</th>
			<th>Created by</th>	
			<th>Order Remarks</th>
            <th>Email</th>						
			<!--<th>Status</th>-->
			
		</tr>
		
		<?
		
		get_order_tracker_list($row[id]);
		
		function get_order_tracker_list($order_id){		
			
			$sql = " select * from tbl_order_remark where order_id={$order_id} order by create_date desc ";
			
			if ($result=mysql_query($sql)){
			  
				while ($row=mysql_fetch_array($result)){
				
					?>
                    <tr style="height:30px; border-bottom:1px dotted #ccc">   
						<td width="20%" align="center" valign="top"><?=$row[create_date]; ?></td>
                        <td width="20%" align="center" valign="top">
						<? 
                           if ($row[create_by]==0){
                                echo "system";

                           }else{
                                echo get_field("sys_user", "name_1", $row[create_by]);

                           }
 
                        ?>
                        </td>
                       <!-- <td width="100" align="center" valign="top">
						<?
                           // if ($row[order_status_id] > 0){
                           //     echo get_field("tbl_cart_order_status", "name_1", $row[order_status_id]);
                           // }

                        ?>
                        </td>-->
                        <td width="40%" align="left" valign="top"><?=$row[remarks]; ?></td>
                        <td width="20%" align="center" valign="top">
						<?
                            if ($row[email_sent] == 1){
                                echo "Sent";
                            }
                        ?>
                        </td>						
                    </tr>
					<?
			
				}
			
			}else
				echo $sql;
				
		} //function get_item_list($cart_id){

		?>
	</table>
    
</fieldset>
</div>

<div id="order-details">
<fieldset>
	<legend>Order details</legend>
	<table>
		<tr>
			<th>SKU</th>
			<th>Item</th>
			<th>Unit Price</th>
			<th>QTY</th>
            <th>Is Main Product</th>            
			<th>Subtotal</th>
            <th></th>
		</tr>
		<?
		
		$sum_subtotal = get_item_list($row[id]);
		
		function get_item_list($order_id){
			
			//$rate = get_field("tbl_cart", "exchange_rate", $order_no);
			
			$sql = " select * from tbl_order_item where is_cancel_item=0 AND order_id={$order_id} order by id asc ";
			
			if ( $result = mysql_query($sql)){
			  $sum_subtotal = 0;
			  while ($row = mysql_fetch_array($result)){

				  $unit_price = $row[unit_price];
				  $sum_subtotal = $sum_subtotal+$row[subtotal];
				  ?>
				  
				  <tr>		
					<td align="left">
	                    <?=$row[sku]; ?>
                    </td> 
					<td align="left">
	                    <?=$row[name]; ?>
                    </td> 
					<td align="center">                    	
                    	<?=$unit_price; ?>
					</td>
					<td align="center">
	                    <?=$row[qty_ordered]; ?>
                    </td>                    
                    <td align="center">
                    	<? echo $row[is_option]==0?"yes":"no" ?>
					</td>
					 <td align="center">
                    	<?=$row[subtotal]; ?>
					</td>
				  </tr>
				  
				  <?
			
			  }
				return $sum_subtotal;
			}else
				echo $sql;
				
		} //function get_item_list($order_no){

		?>
		<tr>
		<td colspan="7"><div id="button"><a class="boldbuttons" href="javascript:form_action(4)"><span style="width: 100%;">Edit Items</span></a></td>		
		</tr>
        <tr style="background-color:#eee">
        	<td colspan="7">
            
            <script>
				function order_details_add_item(){
					
					fr = document.frm;
					
					$.get("../order/tab-details-add-item.php",
					{

						cart_id: <?=$id?>,
						product_id: fr.order_details_add_item_id.value,
						unit_price: fr.order_details_add_item_unit_price.value,
						unit_weight: fr.order_details_add_item_unit_weight.value,
						qty: fr.order_details_add_item_qty.value,
						active: 1

					}, 
					function(data){

						window.location = 'main.php?func_pg=order.edit&id=<?=$id;?>&tab=1';
						// $('#order-details-add-item-panel-result').html(data);

					});

				}
				
				
				function order_details_details(id){
					
					fr = document.frm;
					
					ans = confirm("OK to delete?")

					if (ans){
						
						$.get("../order/tab-details-delete.php",
						{
							item_id: id
	
						}, 
						function(data){

							window.location = 'main.php?func_pg=order.edit&id=<?=$id;?>&tab=1';
							// $('#order-details-add-item-panel-result').html(data);
	
						});
			
					}

				}
			</script>
            
           <!--<input type="button" value="Add item" onclick="$('#order-details-add-item-panel').slideDown(); $(this).slideUp() ">-->
            <div id="order-details-add-item-panel" style="display:none">
            	<? //get_lookup("order_details_add_item_id", "../lookup/product.php", $search_member_id, $display, "Product Lookup"); ?>

            Unit Price:<input 
                type="text" 
                name="order_details_add_item_unit_price"

                value="0"
                style="width:100px;" />
                
                
            Unit Weight:<input 
                type="text" 
                name="order_details_add_item_unit_weight"
                value="0"
                style="width:100px;" />                
                
                
            Qty:<input 
                type="text" 
                id=""
                name="order_details_add_item_qty" 
                value="1"
                style="width:50px;" />

                <input type="button" value="Add" onclick="order_details_add_item();" />

	            <div id="order-details-add-item-panel-result"></div>
            </div>

            </td>
          <td align="right"><!--<input type="button" value="Update">--></td>
        </tr>
	</table>

	<div id="order-summary">
		<?
			## currency
			
				$rate = 1;//get_field("tbl_cart", "exchange_rate", $id);
				$rate_hkd = 7.1;

			## subtotal
				$sub_total = number_format($row[base_subtotal] * $rate, 2);
				$sub_total_hkd = number_format($row[base_subtotal] * $rate_hkd, 2);
	
			## shipping cost
				$shipping_cost = number_format($row[base_shipping_incl_tax] * $rate, 2);
				$shipping_cost_hkd = number_format($row[base_shipping_incl_tax] * $rate_hkd, 2);
			
			## discount
				//$coupon_discount = number_format($row[coupon_discount] * $rate, 2);
				//$coupon_discount_hkd = number_format($row[coupon_discount] * $rate_hkd, 2);					
				
			## subcharge  
				$subcharge = number_format($row[base_fooman_surcharge_amount] * $rate, 2);
				$subcharge_hkd = number_format($row[base_fooman_surcharge_amount] * $rate_hkd, 2);
				
			## Mangeto total amount	
				$total_amount = number_format($row[grand_total] * $rate, 2);
				$total_amount_hkd = number_format($row[grand_total] * $rate_hkd, 2);
		
			## ERP total amount	
				$sum_subtotal += $shipping_cost+$subcharge;
				$EEP_total_amount = number_format($sum_subtotal * $rate, 2);
				$ERP_total_amount_hkd = number_format($sum_subtotal * $rate_hkd, 2);
	
		?>
        <table style="float:right; width:600px; border: 0px solid #eee; ">
        	<tr>
            	<td></td>
                <td align="center" width="" ><b>AUD</b></td>
                <td align="right" width="" style="padding-right: 50px"><b>HKD(current rates: <?=$rate_hkd; ?>)</b></td>
            </tr>
            <tr>
                <td align="left"  width="" >Sub-Total:</td>
                <td align="right" width="" style="padding-right: 50px"><?=$sub_total; ?></td>
                <td align="right" width="" style="padding-right: 50px"><?=$sub_total_hkd; ?></td>
            </tr>
            <tr>
                <td align="left">Shipping:</td>
                <td align="right" style="padding-right: 50px"><?=$shipping_cost; ?></td>
                <td align="right" style="padding-right: 50px"><?=$shipping_cost_hkd; ?></td>
            </tr>                         
            <tr>
                <td align="left">Surcharge(fooman):</td>
                <td align="right" style="padding-right: 50px"><?=$subcharge; ?></td>
                <td align="right" style="padding-right: 50px"><?=$subcharge_hkd; ?></td>
            </tr>
            <!--<tr>
                <td align="left">Coupon Discount:</td>
                <td align="right" style="color:#F00; padding-right: 50px">-<?//=$coupon_discount?></td>
                <td align="right" style="color:#F00; padding-right: 50px">-<?//=$coupon_discount_hkd?></td>
            </tr>-->
            <tr>
                <td align="left"><b>Magento Total Amount</b></td>
                <td align="right" style="padding-right: 50px"><b><?=$total_amount; ?></b></td>
                <td align="right" style="padding-right: 50px"><b><?=$total_amount_hkd; ?></b></td>
            </tr>    
			<tr>
                <td align="left"><b>ERP Total Amount</b></td>
                <td align="right" style="padding-right: 50px"><b><?=$EEP_total_amount; ?></b></td>
                <td align="right" style="padding-right: 50px"><b><?=$ERP_total_amount_hkd; ?></b></td>
            </tr>                        
        </table>
	</div>
</fieldset>
</div>

<div id="remarksHtmlDB"></div>
