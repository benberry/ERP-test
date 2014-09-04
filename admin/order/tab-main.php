<?php /*?><script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script><?php */?>
<script type="text/javascript">
$(document).ready(function() {
			
	$('#mark_as_shipped').click(function (){
		
		
		//var email = $('input[name=email]');
		//var password = $('input[name=password]');
		$("#shipping_company_id option[value='3']").attr('selected', 'selected'); 
		$("#order_status_id option[value='4']").attr('selected', 'selected'); 
		change_order_status_content(4);
		var data= '';
		
		$.ajax({
			url: "http://cameraparadise.com/admin/order/ajax_mark_as_shipped.php",
			type: "GET",
			data: data,
			cache: false,
			success: function (ajaxResult) 
			{ 
				//alert(ajaxResult); 
				//$("#shipping_tracking_code").val(ajaxResult);
				
			 	//var remarksHtml = getContent(4); 
				//var str = $("#remarksHtmlDB").text();
				//alert(ajaxResult);
				var element = ajaxResult.split('###'); 
				$("#shipping_tracking_code").val(element[0]);
				//alert(element[0]+'=='+element[1]);
				$("#tinymce").text(element[1]);
			} 
		});//end ajax
	});//end id mark_as_shipped button
});	

function getContent(id){ 
	$.get("../order/get-order-status-content.php", 
		{id: id}, 
		function(data){
			//tinyMCE.activeEditor.setContent(data);
			$("#remarksHtmlDB").html(data);
		});
	
}
</script>

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
				<td><?=$row[member_create_date]?></td>
			</tr>
			<tr>
				<td><br></td>
				<td><br></td>                    
				<td><br></td>                    
			</tr>
			<tr>
				<td align="left">Order ID: </td>
				<td></td>
				<td><?=$row[invoice_no]?></td>
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
					<?=$row[first_name]; ?>&nbsp;
                    <?=$row[last_name]; ?>
                    <?
						if ($row[member_id] > 0){
							?><div class="notice">( member )</div><?
							
						}else{
							?><div class="notice">( non-member )</div><?
							
						}

					?>
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
					<?=$row[email]; ?>&nbsp;
				</td>
			</tr>
			<tr>
				<td><br></td>
				<td><br></td>                    
				<td><br></td>                    
			</tr>
            
            <tr>
				<td align="left">Phone: </td>
				<td></td>
				<td>
					<?=$row[phone_1]; ?>
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
						if ($row[shipping_method_id] == 1){
							echo "Registered Airmail";
						}

						if ($row[shipping_method_id] == 2){
							echo "Express Courier";
						}
						
						echo "<br/>";
						
						if ($row[shipping_insurance] > 0){
							echo "Shipping Insurance Added<br/>";
						}
						
						if ($row[priority_handling] > 0){
							echo "Priority Handling Added<br />";
						}						

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
				<td>
                <?=$row[payment_method_id]; ?>
				<?=get_field("tbl_payment_method", "name_1", $row[payment_method_id])?></td>
			</tr>
			<tr>
				<td><br></td>
				<td><br></td>                    
				<td><br></td>                    
			</tr>
            
			<tr>
				<td align="left">Discount Coupon: </td>
				<td></td>
				<td><?=$row[coupon_name]?></td>
			</tr>
            
			<tr>
				<td><br></td>
				<td><br></td>                    
				<td><br></td>                    
			</tr>
            
			<tr>
				<td align="left">Gift Voucher: </td>
				<td></td>
				<td><?=$row[voucher_name]?></td>
			</tr>
            
			<tr>
				<td><br></td>
				<td><br></td>                    
				<td><br></td>                    
			</tr>            
            
			<tr>
				<td width="150" align="left">Currency: </td>
				<td></td>
				<td><?=get_field("tbl_currency", "symbol_1", $row[currency_id]); ?></td>
			</tr>
			<tr>
				<td><br></td>
				<td><br></td>                    
				<td><br></td>                    
			</tr>					
            
			<tr>
				<td align="left">Total Amount:</td>
				<td></td>
				<td><?=number_format(get_total_amount($id) * $row[exchange_rate], 2); ?></td>
			</tr>
			<tr>
				<td><br></td>
				<td><br></td>                    
				<td><br></td>                    
			</tr>
         </table>
         
         <table style="float:left; margin-left:50px; width:400px; border-bottom: 1px dotted #222;">
			<tr>
				<td colspan="3">&nbsp;</td>                  
			</tr>          
			<tr>
				<td align="left">Shipping Company:</td>
				<td></td>
				<td>
				<select name="shipping_company_id" style="width:200px;" id="shipping_company_id">
                	<option value=""> -- </option>
					<?=get_combobox_src('tbl_shipping_company', 'name_1', $row[shipping_company_id], " name_1 asc ")?>  
				</select>
				</td>
			</tr>
			<tr>
				<td><br></td>
				<td><br></td>                    
				<td><br></td>
			</tr>
			<tr>
				<td align="left">Tracking Number:</td>
				<td></td>
				<td><input type="text" name="shipping_tracking_code" id="shipping_tracking_code" value="<?=$row[shipping_tracking_code]; ?>" style="width:200px;"><div id="button"> <a class="boldbuttons" id="mark_as_shipped" href="#"><span style="width: 100%;">Mark as Shipped</span></a> </div>
</td>
			</tr>
			<tr>
				<td><br></td>
				<td><br></td>                    
				<td><br></td>
			</tr>							
		</table>


         <table style="float:left; margin-left:50px; width:400px;">
			<tr>
				<td colspan="3">&nbsp;</td>                  
			</tr>          
			<tr>
				<td width="150" align="left">Order Status:</td>
				<td></td>
				<td>

					<script>
                        function change_order_status_content(id){
                            
                            $.get("../order/get-order-status-content.php", 
                                {id: id}, 
                                function(data){
                                    tinyMCE.activeEditor.setContent(data);
                                });
                            
                        }
                    </script>

				<select name="order_status_id" id="order_status_id" onchange="change_order_status_content(this.value)">
					<?=get_combobox_src('tbl_cart_order_status', 'name_1', $row[order_status_id])?>  
				</select>

                <div style="float:right; "><input type="checkbox" name="email_sent" value="1">email to customer</div>

				</td>
			</tr>
			<tr>
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
        
        <br class="clear" />
        
        <table style="margin:50px;">
	        <tr>
                <td align="left"><strong>Source(TEMP):</strong></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="3"><?=$row[http_referer]; ?></td>
          	</tr>
            <tr>
                <td colspan="3">VID: <?=$row[visitor_id]; ?></td>
          	</tr>
        </table>        
        
        <br class="clear" />
        
        <?php 
        $this_cart_id = $row['id'];
        $this_visitor_id = $row['visitor_id'];
        
        $sqlcx = "SELECT * FROM tbl_tracking_records
        LEFT JOIN tbl_tracking on tbl_tracking.id= tbl_tracking_records.tracking_code_id        
        WHERE cart_id = $this_cart_id AND visitor_id = $this_visitor_id";
        $resultxxs = mysql_query($sqlcx);
        if(mysql_num_rows($resultxxs)){
            while($this_row=mysql_fetch_object($resultxxs)){
                $this_tracking = $this_row;
            }
        }
        if(isset($this_tracking)){
            ?>
        <table style="margin:50px;">
	        <tr>
                <td align="left"><strong>Tracking Details:</strong></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td align="left">Tracking Name:</td>
                <td colspan="2"><?=$this_tracking->tracking_name; ?></td>
          	</tr>
            <tr>
                <td align="left">Tracking Code:</td>
                <td colspan="2"><?=$this_tracking->tracking_code; ?></td>
          	</tr>
            <tr>
                <td align="left">Tracking Url:</td>
                <td colspan="2"><?php
                if($this_tracking->access_url==''){
                    echo $this_tracking->tracking_url;
                }
                else{
                    echo $this_tracking->access_url;
                }
                
                ?></td>
          	</tr>
            <tr>
                <td align="left">Visitor Id:</td>
                <td colspan="2"><?=$this_tracking->visitor_id; ?></td>
          	</tr>
        </table>        
        
        <br class="clear" />
            
            <?php
        }
        ?>
        
        <table style="margin:50px;">
	        <tr>
                <td align="left"><strong>Checkout:</strong></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="3"><?
        
			if ($row[order_status_id] == 1){ 
			
				$invoice_no_encode = base64_encode($row[invoice_no]);
			
				$your_order = "http://cameraparadise.com/en/cart/?x=$invoice_no_encode";
			
				?><input type="text" value="<?=$your_order; ?>" style="width: 800px;"><?
			
				}?>
                </td>
          	</tr>
        </table>
        

		
         
	</fieldset>
</div>
<div id="order-details">
<fieldset>
	<legend>Update History</legend>
	<table border="0" style="border-collapse:collapse; ">
		<tr style="height:30px">
			<th>Create date</th>		
			<th>Create by</th>			
			<th>Status</th>
			<th>Remarks</th>
            <th>Email</th>
		</tr>
		
		<?
		
		get_order_tracker_list($row[id]);
		
		function get_order_tracker_list($cart_id){		
			
			$sql = " select * from tbl_cart_order_tracker where cart_id={$cart_id} order by create_date desc ";
			
			if ($result=mysql_query($sql)){
			  
				while ($row=mysql_fetch_array($result)){
				
					?>
                    <tr style="height:30px; border-bottom:1px dotted #ccc">
                        <td width="100" align="center" valign="top"><?=$row[create_date]; ?></td>
                        <td width="100" align="center" valign="top">
						<? 
                           if ($row[create_by]==0){
                                echo "system";

                           }else{
                                echo get_field("sys_user", "user", $row[create_by]);

                           }
 
                        ?>
                        </td>
                        <td width="100" align="center" valign="top">
						<?
                            if ($row[order_status_id] > 0){
                                echo get_field("tbl_cart_order_status", "name_1", $row[order_status_id]);
                            }

                        ?>
                        </td>
                        <td width="300" align="left" valign="top"><?=$row[remarks]; ?></td>
                        <td width="50" align="center" valign="top">
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
			<th>Item</th>
			<th>Price</th>
			<th>QTY</th>
            <th>Weight</th>            
			<th>Subtotal</th>
            <th></th>
		</tr>
		<?
		
		get_item_list($row[id]);
		
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
                             <div style="font-size:10px; color:#333">AUD: <?=round($row[unit_price], 2); ?> - <?=number_format($row[unit_weight] ,2); ?>kg</div>
                        <br />
                        <span style="font-size:10px; font-weight:normal; color:#333">
                        <!--
                        [price (HKD): <?=round($row[unit_price]*get_rate(), 2); ?>][current rates: <?=get_rate();?>]<br />--><!--[unit_cost (HKD): <?=round(get_field("tbl_product", "unit_cost", $row[product_id]), 2); ?>]</span></b>
                        <br />
                        -->
                        <?
						if ($row[option_details_admin] != ''){
							echo $row[option_details_admin];
							
						}else{
							echo $row[option_details];
							
						}
						
						?>
                        <? if ($row[wrap_fees] > 0){ ?>
                            <div class="notice">*** with wrapper (+<?=number_format($row[wrap_fees] * $rate, 2); ?>)</div>
                        <? } ?>
                        <? if (check_accessory_update($cart_id, $row[purchase_with_id]) == true){ ?>
	                        <div class="notice">bought with <?=get_field("tbl_product", "name_1", $row[purchase_with_id]); ?> offer price</div>
                        <? } ?>

                    </td>
					<td align="center">
                    	<? if (check_accessory_update($cart_id, $row[purchase_with_id]) == true){ ?>
	                        	<span class="original_price" style="text-decoration:line-through"><?=number_format($row[original_price], 2); ?></span><br />
						<? } ?>
                    	<?=round(($unit_price + $option_price) * $rate, 2); ?>
					</td>
					<td align="center">
	                    <?=$row[qty]; ?>
                    </td>                    
                    <td align="center">
                    	<?=$item_total_weight * $row[qty]; ?>&nbsp;kg
					</td>
					<td align="right" style="padding-right: 20px;">
						<?=number_format(($unit_price+$option_price+$wrap_fees) * $rate * $row[qty], 2);?>
					</td>
                    <td align="right">
						<!-- <input type="button" value="X" onclick="javascript: order_details_details(<?=$row[id]; ?>); " style="margin-right:10px; "> -->
					</td>
				  </tr>
				  
				  <?
			
			  }
			
			}else
				echo $sql;
				
		} //function get_item_list($cart_id){

		?>
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
				$currency_id = get_field("tbl_cart", "currency_id", $id);
				$currency = get_field("tbl_currency", "symbol_1", $currency_id);
				$rate = get_field("tbl_cart", "exchange_rate", $id);
				$rate_hkd = get_rate();

			## subtotal
				$sub_total = number_format(get_cart_total_amount($id) * $rate, 2);
				$sub_total_hkd = number_format(get_cart_total_amount($id) * $rate_hkd, 2);				
	
			## shipping cost	
				$shipping_cost = get_field("tbl_cart", "shipping_cost", $id);
				$shipping_cost_hkd = number_format($shipping_cost * $rate_hkd, 2);
				$shipping_cost = number_format($shipping_cost * $rate, 2);
				
			## priority_handling
				$priority_handling = get_field("tbl_cart", "priority_handling", $id);
				$priority_handling_hkd = number_format($priority_handling * $rate_hkd, 2);
				$priority_handling = number_format($priority_handling * $rate, 2);
	
			## shipping insurance
				$shipping_insurance = get_field("tbl_cart", "shipping_insurance", $id);
				$shipping_insurance_hkd = number_format($shipping_insurance * $rate_hkd, 2);
				$shipping_insurance = number_format($shipping_insurance * $rate, 2);

			## VAT
				$vat_cost = number_format(get_field("tbl_cart", "shipping_vat", $id) * $rate, 2);
				$vat_cost_hk = number_format(get_field("tbl_cart", "shipping_vat", $id) * $rate_hkd, 2);

			## discount
				$coupon_discount = number_format($row[coupon_discount] * $rate, 2);
				$coupon_discount_hkd = number_format($row[coupon_discount] * $rate_hkd, 2);					
				
			## subcharge
				$subcharge = number_format(get_field("tbl_cart", "subcharge", $id) * $rate, 2);	
				$subcharge_hkd = number_format(get_field("tbl_cart", "subcharge", $id) * $rate_hkd, 2);	 
				
				if ($row[payment_method_id] == 1){
					$payment_method="Paypal";
				}
				
				if ($row[payment_method_id] == 7){
					$payment_method="WorldPay";
				}					
	
			## total amount	
				$total_amount = number_format(get_total_amount($id) * $rate, 2);
				$total_amount_hkd = number_format(get_total_amount($id) * $rate_hkd, 2);
				
				
	
		?>
        <table style="float:right; width:600px; border: 0px solid #eee; ">
        	<tr>
            	<td></td>
                <td align="center" width="" ><?=$currency; ?></td>
                <td align="right" width="" style="padding-right: 50px">HKD(current rates: <?=get_rate(); ?>)</td>
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
                <td align="left">Priority Handling:</td>
                <td align="right" style="padding-right: 50px"><?=$priority_handling; ?></td>
                <td align="right" style="padding-right: 50px"><?=$priority_handling_hkd; ?></td>
            </tr>
            <tr>
                <td align="left">Shipping Insurance:</td>
                <td align="right" style="padding-right: 50px"><?=$shipping_insurance; ?></td>
                <td align="right" style="padding-right: 50px"><?=$shipping_insurance_hkd; ?></td>
            </tr>
            <tr>
                <td align="left">VAT:</td>
                <td align="right" style="padding-right: 50px"><?=$vat_cost; ?></td>
                <td align="right" style="padding-right: 50px"><?=$vat_cost_hk; ?></td>
            </tr>                
            <tr>
                <td align="left">Surcharge(<?=$payment_method; ?>):</td>
                <td align="right" style="padding-right: 50px"><?=$subcharge; ?></td>
                <td align="right" style="padding-right: 50px"><?=$subcharge_hkd; ?></td>
            </tr>
            <tr>
                <td align="left">Coupon Discount:</td>
                <td align="right" style="color:#F00; padding-right: 50px">-<?=$coupon_discount?></td>
                <td align="right" style="color:#F00; padding-right: 50px">-<?=$coupon_discount_hkd?></td>
            </tr>
            <tr>
                <td align="left"><b>Total Amount (<?=$currency; ?>): </b></td>
                <td align="right" style="padding-right: 50px"><b><?=$total_amount; ?></b></td>
                <td align="right" style="padding-right: 50px"><b><?=$total_amount_hkd; ?></b></td>
            </tr>                        
        </table>
	</div>
</fieldset>
</div>

<div id="remarksHtmlDB"></div>
