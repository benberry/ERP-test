<?
## init
	include("../include/init.php");
	$image_path = get_cfg("company_website_address")."eng/images/";

## request
	extract($_REQUEST);
	$id=$cart_id;

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
		echo $sql;

?>
<div style="width:750px">
    <h1 style="font-size: 16px; line-height:20px;">Order Details (Order ID: <?=$row[invoice_no]; ?>)</h1>
	
	<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px; color:#666666">
		  <tr>
			<td style="padding-right:20px">
			
			  <table width="100%" border="1" bordercolor="#cccccc" style="border-collapse:collapse; font-family:Arial, Helvetica, sans-serif; font-size:11px; color:#666666">
                <tr bgcolor="#333333"> 
                    <!--<th align="center" style="color:#ffffff">Wrapped</th>-->
                    <th align="center" colspan="2" style="color:#ffffff">Item</th>
                    <th align="center" style="color:#ffffff">Price</th>
                    <th align="center" style="color:#ffffff">Qty</th>
                    <th align="center" style="color:#ffffff">Total</th>
                </tr>

				<?
					
					$sql = " select * from tbl_cart_item where cart_id=$id order by id ";
					
					if ($result = mysql_query($sql)){
					
						while ($row = mysql_fetch_array($result)){
						
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
                                        <?=get_field("tbl_product", "name_1", $row[product_id]); ?>
                        				<span style="font-size:10px; font-weight:normal; color:#333">(AUD$ <?=$row[unit_price]?>, <?=$row[unit_weight];?> kg )</span>
                                        <br />
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
			</td>
		</tr>
	</table>
</div>
<script>
	// window.print();
</script>