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
	<center>
    	<h1 style="font-size:16px; line-height:30px; text-decoration:underline; ">CHECKLIST OF ITEMS TO BE RETURNED</h1>
    </center>
    <h2 style="font-size:16px; line-height:20px;">REF NO: <?=$row[invoice_no]; ?></h2>
	<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px; color:#666666">
		  <tr>
			<td style="padding-right:20px">
			
			  <table width="100%" border="1" bordercolor="#cccccc" style="border-collapse:collapse; font-family:Arial, Helvetica, sans-serif; font-size:11px; color:#666666">
                <tr bgcolor="#333333"> 
                    <th align="center" colspan="2" style="color:#ffffff">ITEM</th>
                    <th align="center" width="64" style="color:#ffffff"></th>
                </tr>

				<?
					
					$sql = " select * from tbl_cart_item where cart_id=$id order by original_price desc, id ";
					
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
                                        <br class="clear" />
										<?
                                        if ($row[option_details] != ''){
                                            echo $row[option_details];
											
                                        }else{
                                            echo $row[option_details];

                                        }
										
										echo get_field("tbl_product", "content_3", $row[product_id]);
                                        ?>
                                        
                                        
                                    </td>
                                    <td align="center">
                                    	<input type="checkbox" style="background-color:#00C;">
                                    </td>                                    
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