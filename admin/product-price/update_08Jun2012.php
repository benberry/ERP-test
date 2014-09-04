<?
	### init
		include("../include/init.php");
	
	### request 
		extract($_REQUEST);
	
		if ($_SESSION["sys_write"]){
		
			### sql
			$sql="update
					tbl_product
				set
					unit_cost=$unit_cost,
					price_profit=$price_profit,
					price_balancer=$price_balancer,
					accessory_price=$accessory_price,
					stock_status=$stock_status,
					vat_option=$vat_option,
					modify_date=NOW(),
					modify_by=".$_SESSION["user_id"]."
				where
					id=$product_id";
		
		
			if (mysql_query($sql)){
				
				get_total_amount_result($product_id);
				
				### insert into price history
				$sql="insert into
						tbl_product_price_history(
						product_id,
						rate,
						unit_cost,
						price_profit,
						price_balancer,
						accessory_price,
						stock_status,
						weight,
						modify_date,
						modify_by
					)values(
						$product_id,
						".get_rate().",
						$unit_cost,
						$price_profit,
						$price_balancer,
						$accessory_price,
						$stock_status,
						".get_field("tbl_product", "weight", $product_id).",
						NOW(),
						".$_SESSION["user_id"].")";
					
				if (!mysql_query($sql))
					echo $sql;
				
			}else{
				echo $sql;
				
			}
		
		}else{
			get_total_amount_result($product_id);
			
		}
	

	### Display Result
	function get_total_amount_result($product_id){
		
		$rate = get_rate();
		
		$sql = "select *from tbl_product where id=$product_id";
		
		if ($result = mysql_query($sql)){
			$row = mysql_fetch_array($result);
		
		}else
			echo $sql;
			
		if ($row[price_balancer]!=0){
									
			$express_shipping = item_express_shipping_cost($row[weight], 1) - ($row[price_balancer] / $rate);
			$registered_airmail = item_registered_airmail_cost($row[weight]) - ($row[price_balancer] / $rate);
			
		}else{
			
			$express_shipping = item_express_shipping_cost($row[weight], 1);
			$registered_airmail = item_registered_airmail_cost($row[weight]);
		
		}
		
		$price = get_price($row[id]);
		
		$total_amount_express = $express_shipping+$price;
		$total_amount_airmail = $registered_airmail+$price;
	
		?>
		<table width="100%" style="margin:0;">
			<tr>
				<td width="100" style="border:0px">
				<?=number_format(get_price($row[id]), 2);?>
                <?
                    $accessory_price = get_field("tbl_product", "accessory_price", $row[id]);
                    
                    if ($accessory_price > 0){
        
                        ?><div style="color:#BBB; ">acc: <?=number_format(get_field("tbl_product", "accessory_price", $row[id]) / get_rate(), 2);?></div><?
        
                    }

                ?>
                </td>
				<td width="100" style="border:0px"><?=number_format($express_shipping, 2); ?></td>
				<td width="100" style="border:0px"><?=number_format($registered_airmail, 2); ?></td>
				<td width="100" style="border:0px"><?=number_format($total_amount_express, 2); ?></td>
				<td width="100" style="border:0px"><?=number_format($total_amount_airmail, 2); ?></td>
			</tr>
		</table>
		<?
	
	}

?>
<div class="notice">updated</div>