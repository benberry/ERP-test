<?
## init
	include("../include/init.php");
	$image_path = get_cfg("company_website_address")."eng/images/";


## request
	extract($_REQUEST);
	
	$id=$cart_id;
	
//echo '<pre>';
//print_r($_REQUEST);
//206887
$updTbl = mysql_query("update tbl_cart_order_tracker set order_status_id='2' where cart_id=$cart_id and order_status_id=$order_status_id");

$updTbl = mysql_query("update tbl_cart set order_status_id='2' where id=$cart_id and order_status_id=$order_status_id");
//die;
/*$sql1="select * from tbl_cart where id='".$id."'";
$res=mysql_query($sql1);
while($row1=mysql_fetch_array($res)){
	$name=$row1['first_name'];
	$email=$row1['email'];	
	}*/
	
	
$to = $email;
$subject = "Order Confirmation";
$message = "Yor order has accepted on Cameraparadise and under proccessing.";
$from = "cameraparadise.com";
$headers = "From:" . $from;
$result= mail($to,$subject,$message,$headers);
	
	//echo $name;
## get member info
	// $member_id = get_field("tbl_cart", "member_id", $id);
	// $title = get_field("tbl_member", "user", $member_id);
	// $first_name = get_field("tbl_member", "first_name", $member_id);
	// $last_name = get_field("tbl_member", "last_name", $member_id);	


## non-member
	$first_name = get_field("tbl_cart", "first_name", $id);
	$last_name = get_field("tbl_cart", "last_name", $id);


## get order record
	$sql = " select * from tbl_cart where id=$id";
		
	if ($result = mysql_query($sql)){
		$row = mysql_fetch_array($result);
	
	}else


?>
<div style="width:750px">
    <h1 style="font-size: 16px; line-height:20px;">Invoice (Order ID: <?=$row[invoice_no]; ?>)</h1>
	<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px; color:#666666">
      <tr>
        <td width="50%">
          <h2 style="font-size: 14px; line-height:20px; border-bottom:1px solid #ccc; margin-right: 20px; margin-top:20px; border-left: 5px #ccc solid; padding-left: 10px;">Billing Information</h2>
          <table width="100%" style="font-family:Arial, Helvetica, sans-serif; font-size:11px; color:#666666">
            <tr>
                <td width="100">Name:</td>
                <td><?=$row[first_name]; ?>&nbsp;<?=$row[last_name]; ?></td>
            </tr>
            <tr>
                <td valign="top">Street Address:</td>
                <td><?=$row[addr_1]; ?>
                <? if ($row[addr_2] != ''){?>
						<br /><?=$row[addr_2]; ?>
	            <? } ?>
                </td>                                
            </tr>
            <tr>
                <td>City:</td>
                <td><?=$row[addr_3]; ?></td>                                
            </tr>
            <tr>
                <td>State/Province:</td>
                <td><?=$row[country_state]; ?></td>
            </tr>
			<tr>
                <td>Country:</td>
                <td><?=get_field("tbl_country", "name_1", $row[country_id]); ?></td>
            </tr>            
            <tr>
                <td>Post/Zip Code:</td>
                <td><?=$row[postal_code]; ?></td>                                
            </tr>                            
        </table>

		</td>
        <td width="50%" valign="top">
	        <h2 style="font-size: 14px; line-height:20px; border-bottom:1px solid #ccc; margin-right: 20px; margin-top:20px; border-left: 5px #ccc solid; padding-left: 10px;">Shipping Information</h2>
            <table width="100%" style="font-family:Arial, Helvetica, sans-serif; font-size:11px; color:#666666">
                <tr>
                    <td width="100">Name:</td>
                    <td><?=$row[shipping_first_name]; ?>&nbsp;<?=$row[shipping_last_name]; ?></td>
                </tr>
                <tr>
                    <td valign="top">Street Address:</td>
                    <td><?=$row[shipping_addr_1]; ?>
						<? if ($row[shipping_addr_2] != ''){?>
                            <br /><?=$row[shipping_addr_2]; ?>
                        <? } ?>
                    </td>                                
                </tr>
                <tr>
                    <td>City:</td>
                    <td><?=$row[shipping_addr_3]; ?></td>                                
                </tr>
                <tr>
                    <td>Country:</td>
                    <td><?=get_field("tbl_country", "name_1", $row[shipping_country_id]); ?></td>
                </tr>
                <tr>
                    <td>State/Province:</td>
                    <td><?=$row[shipping_country_state]; ?></td>
                </tr>
                <tr>
                    <td>Post/Zip Code:</td>
                    <td><?=$row[shipping_postal_code]; ?></td>                                
                </tr>                            
            </table>
          
		</td>
      </tr>
      <tr>
        <td valign="top">
        	<h2 style="font-size: 14px; line-height:20px; border-bottom:1px solid #ccc; margin-right: 20px; margin-top:20px; border-left: 5px #ccc solid; padding-left: 10px;">Contact Information</h2>
            <table style="font-family:Arial, Helvetica, sans-serif; font-size:11px; color:#666666">
                <tr>
                    <td width="100">Email Address:</td>
                    <td><?=$row[email];?></td>
                </tr>
                <tr>
                    <td>Telephone:</td>
                    <td><?=$row[phone_1];?></td>                                
                </tr>
            </table>
			
            
		</td>
        <td valign="top">
        	<h2 style="font-size: 14px; line-height:20px; border-bottom:1px solid #ccc; margin-right: 20px; margin-top:20px; border-left: 5px #ccc solid; padding-left: 10px;">Shipping Information</h2>
            
            <? if ($row[shipping_method_id]==1){ ?>
    
                <div id="airmail" style="margin-top:10px">
                    <div style="float:left; width:150px">Registered Airmail</div>
                    <div style="float:left">
        			<!-- <span id="shipping_method_1" style="font-size:14px"><?=$currency_symbol; ?><?=number_format(shipping_airmail($_SESSION["cart_id"], $row[shipping_country_id]), 2); ?></span> -->
                    
                    </div>
                    <br class="clear" />
                    1-4 weeks delivery
                </div>
            
            <? } ?>
            
            <? if ($row[shipping_method_id]==2){ ?>
            
                <div id="express" style="margin-top:10px">
                    <div style="float:left; width:150px">Express Courier</div>
                    <div style="float:left">
        <!--           <span id="shipping_method_1" style="font-size:14px"><?=$currency_symbol; ?><?=number_format(shipping_express($_SESSION["cart_id"], $row[shipping_country_id]), 2); ?></span>-->
                    </div>
                    <br class="clear" />
                    <?php $shipping_express_est_time=get_field("tbl_country", "express_est_time", $row[shipping_country_id]);
                            echo $shipping_express_est_time;
                     ?>
                </div>
            
            <? } ?>
            
            <? if ($row[priority_handling] > 0) { ?>
            
                <div>Priority handling added</div>
                
            <? } ?>
            
            <? if ($row[shipping_insurance] > 0) { ?>
            
                <div>Shipping insurance added</div>
                
            <? } ?>
                    
		</td>
      </tr>
      <tr>
        <td valign="top">
        	<h2 style="font-size: 14px; line-height:20px; border-bottom:1px solid #ccc; margin-right: 20px; margin-top:20px; border-left: 5px #ccc solid; padding-left: 10px;">Payment Method</h2>
            <table width="100%" style="font-family:Arial, Helvetica, sans-serif; font-size:11px; color:#666666">
            <?
            
            ### PayPal selected
            
            if ($row[payment_method_id] == 1){
                ?>
                <tr>
                    <td>
                        <img src="<?=$image_path?>icon/paypal.jpg" border="0" alt="PayPal">
                    </td>
                </tr>
                <?
            }
            
            
            ### WorldPay selected
            
            if ($row[payment_method_id] == 7){
                ?>
                <tr>
                    <td><img src="<?=$image_path?>icon/rbs-worldpay.jpg" border="0" alt="WorldPay"></td>
                </tr>
                <?
            
            } //if ($row[payment_method_id] == 7){
            
            ?>
            </table>
		</td>
        
        <td valign="top" colspan="2">
        	<h2 style="font-size: 14px; line-height:20px; border-bottom:1px solid #ccc; margin-right: 20px; margin-top:20px; border-left: 5px #ccc solid; padding-left: 10px;">Discount Coupon / Gift Voucher</h2>
            <? if ($row[coupon_id] > 0){ ?>
		           -&nbsp;<?=$row[coupon_name]?><br />
            <? } ?>
            <? if ($row[voucher_id] > 0){ ?>
			       -&nbsp;<?=$row[voucher_name]?><br />
            <? } ?>            
		</td>
        
      </tr>
      <? if ($row[content_1] != ''){ ?>
      <tr>
        <td valign="top" colspan="2">
        	<h2 style="font-size: 14px; line-height:20px; border-bottom:1px solid #ccc; margin-right: 20px; margin-top:20px; border-left: 5px #ccc solid; padding-left: 10px;">Instructions</h2>
            <?=$row[content_1];?>
		</td>
      </tr>      
      <? } ?>
    </table>
	
	<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px; color:#666666">
		  <tr>
			<td><h2 style="font-size: 14px; line-height:20px; border-bottom:1px solid #ccc; margin-right: 20px; margin-top:20px; border-left: 5px #ccc solid; padding-left: 10px;">Order Details</h2></td>
		  </tr>
		  <tr>
			<td style="padding-right:20px">
			
			  <table width="100%" border="1" bordercolor="#cccccc" style="border-collapse:collapse; font-family:Arial, Helvetica, sans-serif; font-size:11px; color:#666666">
                <tr bgcolor="#333333"> 
                    <!--<th align="center" style="color:#ffffff">Wrapped</th>-->
                    <th align="center" colspan="2" style="color:#ffffff">Item Name</th>
                    <th align="center" style="color:#ffffff">Price</th>
                    <th align="center" style="color:#ffffff">Qty</th>
                    <th align="center" style="color:#ffffff">Total</th>
                </tr>

				<?
					
					$sql = " select * from tbl_cart_item where cart_id=$id order by unit_price desc ";
					
					if ($result = mysql_query($sql)){
					
						while ($row = mysql_fetch_array($result)){
					//	print_r($row);
							## get cart item data
								$exchange_rate = get_field("tbl_cart", "exchange_rate", $id);
								
								$wrap_fees = $row[wrap_fees];
								$unit_price = $row[unit_price] + $row[option_price] + $wrap_fees;
								$qty = $row[qty];
								$sub_total = ($row[unit_price] + $row[option_price] + $wrap_fees) * $row[qty];
								
							?>
							
								<tr>
                                	<!--
                                    <td align="center">
                                        <? if ($row[wrap] == 0){ echo "-"; } ?>
                                        <? if ($row[wrap] == 1){ echo "YES"; } ?>                    
                                    </td>
                                    -->
                                    <td align="center" valign="top">
										<?
										## images
										$photo_src = get_prod_img_first_src($row[product_id], "icon_crop");
										
										$photo_src = str_replace("../../", get_cfg("company_website_address"), $photo_src);
										
										if ($photo_src==""){
											?><img src="" border="0" width=""><?
	
										}else{
											?><img src="<?=$photo_src?>" border="0"><?
	
										}
										
										?>
                                    </td>
                                    <td style="padding-left:20px">
                                        <div style="font-size:14px;"><?=get_field("tbl_product", "name_1", $row[product_id]); ?></div>
                                        <div style="font-size:10px; color:#333">AUD: <?=round($row[unit_price], 2); ?> - <?=number_format($row[unit_weight] ,2); ?>kg</div>
										<?
                                        if ($row[option_details_admin] != ''){
                                            echo $row[option_details_admin];
                                            
                                        }else{
                                            echo $row[option_details];
                                            
                                        }
                                        ?>
                                        <? if ($row[wrap_fees] > 0){ ?>
                                            <div class="notice" style="color:#060;">*** with wrapper (+<?=number_format($row[wrap_fees]*$exchange_rate, 2); ?>)</div>
                                        <? } ?>
                                        <? if (check_accessory_update($id, $row[purchase_with_id]) == true){ ?>
                                            <div class="notice">bought with <?=get_field("tbl_product", "name_1", $row[purchase_with_id]); ?> offer price</div>
                                        <? } ?>
                                    </td>
                                    <td align="center">
                                        <? if (check_accessory_update($id, $row[purchase_with_id]) == true){ ?>
                                               <span class="original_price" style="text-decoration:line-through; "><?=number_format($row[original_price], 2); ?></span><br />
                                        <? } ?>
                                        
                                        <?=number_format(($unit_price * $exchange_rate), 2); ?>
                                        
                                    </td>
                                    <td align="center"><?=$row[qty]; ?></td>
                                    <td align="center"><?=number_format(($unit_price * $exchange_rate) * $row[qty], 2); ?></td>
                                </tr>
							
							<?
						
						}
					
					}else
						echo $sql;
			
				
				?>
			  </table>
              
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
					$coupon_discount = number_format(get_field("tbl_cart", "coupon_discount", $id) * $rate, 2);
					$coupon_discount_hkd = number_format(get_field("tbl_cart", "coupon_discount", $id) * $rate_hkd, 2);					
					
				## subcharge
					$subcharge = number_format(get_field("tbl_cart", "subcharge", $id) * $rate, 2);	
					$subcharge_hkd = number_format(get_field("tbl_cart", "subcharge", $id) * $rate_hkd, 2);	 
					
					if (get_field("tbl_cart", "payment_method_id", $id) == 1){
						$payment_method="Paypal";
				
					}
					
					if (get_field("tbl_cart", "payment_method_id", $id) == 7){
						$payment_method="WorldPay";
				
					}					
				
				## total amount	
					$total_amount = number_format(get_total_amount($id) * $rate, 2);
					$total_amount_hkd = number_format(get_total_amount($id) * $rate_hkd, 2);
		
		
			?>
            <br /><br />
            <table border="1" bordercolor="#eee" style="font-family:Arial, Helvetica, sans-serif; font-size:11px; color:#666666; border-collapse:collapse; " align="right">
            	<tr>
                    <!--
                    <td></td>
                    <td align="right" width=""><?=$currency; ?></td>
                    <td align="right" width="">HKD(rates: <?=get_rate(); ?>)</td>
                    -->
                </tr>
                <tr>
                    <td align="right" width="200">Sub-Total:</td>
                    <td align="right" width="100"><?=$sub_total; ?></td>
                    <!--<td align="right" width="100"><?=$sub_total_hkd; ?></td>-->
                </tr>
                <?
					if ($coupon_discount > 0){
						?>
						<tr>
							<td align="right">Coupon Discount:</td>
							<td align="right" style="color:#F00">-<?=$coupon_discount; ?></td>
                            <!--<td align="right" style="color:#F00">-<?=$coupon_discount_hkd; ?></td>-->
						</tr>
						<?
					}
				?> 
                <tr>
                    <td align="right">Shipping:</td>
                    <td align="right"> <?=$shipping_cost; ?></td>
                    <!--<td align="right"> <?=$shipping_cost_hkd; ?></td>-->
                </tr>
                <?
					if ($priority_handling > 0){
						?>
						<tr>
							<td align="right">Priority Handling:</td>
							<td align="right"><?=$priority_handling; ?></td>
                            <!--<td align="right"><?=$priority_handling_hkd; ?></td>-->
						</tr>
						<?
					}
				?>
				<?
					if ($shipping_insurance > 0){
						?>
                        <tr>
                            <td align="right">Shipping Insurance:</td>
                            <td align="right"><?=$shipping_insurance; ?></td>
                           <!-- <td align="right"><?=$shipping_insurance_hkd; ?></td>-->
                        </tr>
						<?
					}
				?>
                <tr>
                    <td align="right">VAT:</td>
                    <td align="right"><?=$vat_cost; ?></td>
                </tr>
				<tr>
					<td align="right">Surcharge(<?=$payment_method; ?>):</td>
					<td align="right"><?=$subcharge; ?></td>
                    <!--<td align="right"><?=$subcharge_hkd; ?></td>-->
				</tr>
				
                <tr>
                    <td align="right"><b>Total Amount (<?=$currency; ?>):</b></td>
                    <td align="right"><b><?=$total_amount; ?></b></td>
                    <!--<td align="right"><b><?=$total_amount_hkd; ?></b></td>-->
                </tr>                        
            </table>
		  </td>
        </tr>
      </table>
	<!-- Billing & Shipping -->
	<!--<p>For any enquiry, please contact <a href="mailto:info@cameraparadise.com">info@cameraparadise.com</a></p>-->
</div>
<script>
	window.print();
</script>