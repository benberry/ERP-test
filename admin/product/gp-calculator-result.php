<?

	## include
	include("../include/init.php");
	
	
	## request
	extract($_REQUEST);
	
	// echo "cal_unit_cost:".$cal_unit_cost."<br/>";
	// echo "cal_rate:".$cal_rate."<br/>";
	// echo "cal_gp_percent:".$cal_gp_percent."<br/>";
	// echo "cal_weight:".$cal_weight."<br/>";
	
	
	## calculate
	if ($cal_unit_cost > 0 && $cal_rate > 0 && $cal_weight > 0 ){

		## price
		$cal_unit_cost = ($cal_unit_cost + $cal_price_profit + $cal_price_balancer) * 1.03;
		$price_au = ($cal_unit_cost / $cal_rate) *(1 + $cal_gp_percent);
		$price_hk = $cal_unit_cost *(1 + $cal_gp_percent);
		
		if ($cal_price_balancer != 0)
			$cal_price_balancer_hkd = ($cal_price_balancer/$cal_rate);
		else
			$cal_price_balancer_hkd = 0;
		
		## gp
		if ($cal_price_profit != 0){
			$gp_percent = ($cal_price_profit/$cal_unit_cost)*100;

		}else{
			$gp_percent = 0;

		}
		

		## shipping
		$express_shipping_cost_aud	= (item_express_shipping_cost($cal_weight, 1)) - $cal_price_balancer_hkd;
		$express_shipping_cost_hkd 	= (item_express_shipping_cost($cal_weight, 1) *$cal_rate) - $cal_price_balancer;
		$registered_airmail_aud 	= (item_registered_airmail_cost($cal_weight)) - $cal_price_balancer_hkd;
		$registered_airmail_hkd  	= (item_registered_airmail_cost($cal_weight) *$cal_rate) - $cal_price_balancer;

		
		## total_amount
		/*
			$total_amount_express_hkd	= ($express_shipping_cost_hkd + $price_hk) *1.03;
			$total_amount_express_aud	= ($express_shipping_cost_aud + $price_au) *1.03;
			$total_amount_airmail_hkd	= ($registered_airmail_hkd + $price_hk) *1.03;
			$total_amount_airmail_aud	= ($registered_airmail_aud + $price_au) *1.03;
		*/
		
		$total_amount_express_hkd	= ($express_shipping_cost_hkd + $price_hk);
		$total_amount_express_aud	= ($express_shipping_cost_aud + $price_au);
		$total_amount_airmail_hkd	= ($registered_airmail_hkd + $price_hk);
		$total_amount_airmail_aud	= ($registered_airmail_aud + $price_au);		
		
		?>
		<table width="100%" border="1" bordercolor="#ccc" style="border-collapse:collapse; font-size:10px;">
			<tr>
				<td colspan="4"><b>Result</b></td>
			</tr>
			<tr>
				<td></td>
				<td align="center" width="50">HKD</td>
				<td align="center" width="50">AUD</td>
                <td align="center" width="50">Comp.</td>                
			</tr>
            <tr>
				<td>Price</td>
				<td align="right"><?=number_format($price_hk, 2); ?></td>
				<td align="right"><?=number_format($price_au, 2); ?></td>
                <td align="right" style="color:#F30">
					<? echo number_format((get_field("tbl_product", "au_shopping_price", $product_id)), 2);	?>
				</td>
			</tr>
            <tr>
				<td>G/P (%)</td>
				<td align="right" colspan="2"><?=number_format($gp_percent, 2); ?>%</td>
			</tr>
			<tr>
				<td>Express Shipping</td>
				<td align="right"><?=number_format($express_shipping_cost_hkd, 2); ?></td>
                <td align="right"><?=number_format($express_shipping_cost_aud, 2); ?></td>
                <td align="right" rowspan="2" style="color:#F30">
					<? echo number_format(get_field("tbl_product", "au_shopping_shipping", $product_id), 2); ?>
				</td>
			</tr>
			<tr>
				<td>Registered Airmail</td>
				<td align="right"><?=number_format($registered_airmail_hkd, 2); ?></td>
                <td align="right"><?=number_format($registered_airmail_aud, 2); ?></td>
			</tr>
            <tr style="color:#063">
				<td colspan="4"><b>Total Amount</b></td>
			</tr>
            
            <tr>
				<td>Express Shipping</td>
				<td align="right"><?=number_format($total_amount_express_hkd, 2); ?></td>
                <td align="right"><?=number_format($total_amount_express_aud, 2); ?></td>
                <td align="right" style="color:#F30"></td>
			</tr>
            <tr>
				<td>Registered Airmail</td>
				<td align="right"><?=number_format($total_amount_airmail_hkd, 2); ?></td>
                <td align="right"><?=number_format($total_amount_airmail_aud, 2); ?></td>
                <td align="right" style="color:#F30"></td>
			</tr>            
		</table>
        <input type="hidden" name="cal_result_display_price" id="cal_result_display_price" value="<?=round($price_au, 2); ?>">
		<? 

	}else{
		echo "invalid data";
			
	}
	
?>
