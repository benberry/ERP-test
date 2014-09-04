<?
##*** Default
	$func_name 		= "Daily Income";
	// $tbl 		= "tbl_report_popular";
	$curr_page 		= "index";
	$edit_page 		= "";
	$action_page 	= "";
	$page_item 		= 9999;


##*** Request
	extract($_REQUEST);
	
	
##*** 
	if ($srh_order_date_from == ''){
		$srh_order_date_from = date("Y-m-1");
	}
	
	if ($srh_order_date_to == ''){
		$srh_order_date_to = datetime_format("Y-m-d", (datetime_add("m", 1, date("Y-m-1"))));
	}

?>
<script>
	function form_search(){

		fr = document.frm

		fr.action = "<?=$_SERVER['PHP_SELF']?>?<?=$_SERVER['QUERY_STRING']?>";
		fr.method = "post";
		fr.target = "_self";
		fr.submit();

	}

	function form_search_reset(){

		window.location = "<?=$_SERVER['PHP_SELF']?>?<?=$_SERVER['QUERY_STRING']?>";

	}

</script>

<form name="frm">
<input type="hidden" name="tbl" value="<?=$tbl?>">
<input type="hidden" name="act" value="">
<input type="hidden" name="order_by" value="<?=$order_by?>">
<input type="hidden" name="ascend" value="<?=$ascend?>">
<input type="hidden" name="del_id" value="">

<div id="list">
	<div id="title"><?=$func_name?></div>
        <div id="search">
            <!-- First Line -->
            <div id="line-1">
            <!-- End of First Line </div> -->
            
            <!-- Second Line <div id="line-2"> -->
            Date:
            <input type="text" id="srh_order_date_from" name="srh_order_date_from" value="<?=date_empty($srh_order_date_from)?>" readonly="readonly">
            <a href="#" id="btn_srh_order_date_from"><img src="../images/calendar.jpg" border="0"></a>
            <script type="text/javascript">//<![CDATA[
                    
            var cal = Calendar.setup({
                onSelect: function(cal) { cal.hide() }

            });
            cal.manageFields("btn_srh_order_date_from", "srh_order_date_from", "%Y-%m-%d");
                    
            //]]></script>
            <span> - </span>
            <input type="text" id="srh_order_date_to" name="srh_order_date_to" value="<?=date_empty($srh_order_date_to)?>" readonly="readonly">
            <a href="#" id="btn_srh_order_date_to"><img src="../images/calendar.jpg" border="0"></a>
            <script type="text/javascript">
			//<![CDATA[
                  var cal = Calendar.setup({
                      onSelect: function(cal) { cal.hide() }

                  });
                  cal.manageFields("btn_srh_order_date_to", "srh_order_date_to", "%Y-%m-%d");
                        
            //]]></script>
            
            <input type="button" value="SEARCH" onclick="form_search()">
    
            <input type="button" value="RESET" onclick="form_search_reset()">
            
            </div>
            <!-- End of Second Line -->
            
        </div>
        
        <div id="tool">
            <div id="button"></div>
            <br class="clear"/>
        </div>
    
        <table>
            <tr>
                <th style="width:300px; ">Date</th>
                <th>Orders</th>
                <th>Orders-Non AU</th>                
                <th>Income</th>
                <th>Income/Order</th>
                <th>Discount</th>
                <th>Shipping Insurance</th>
                <th>Priority Handling</th>
            </tr>
			<?
				for($i=datetime_format("d", $srh_order_date_from); $i <= datetime_diff("d", $srh_order_date_from, $srh_order_date_to); $i++){
					$income_date = datetime_format("Y-m-d", datetime_add("d", ($i-1), $srh_order_date_from));
					
					$bg_color = '';
					$today = '';

					if ($income_date == date("Y-m-d")){
						$bg_color = 'style="background-color:#FFC;"';
						$today = ' - TODAY';
					}
					
					### daily record
					$order = get_daily_income_order($income_date);
					$order_non_au = get_daily_income_order_non_au($income_date);
					$total = get_daily_income_total($income_date);
					if ($total > 0){
						$order_income = ($total/$order);
						
					}else{
						$order_income = 0;
						
					}
					$coupon = get_daily_coupon_total($income_date);
					$shipping_insurance = get_daily_shipping_insurance($income_date);
					$priority_handling = get_daily_priority_handling($income_date);

					
					### period record
					$period_order += $order;
					$period_order_non_au += $order_non_au;
					$period_total += $total;
					$period_coupon += $coupon;
					$period_shipping_insurance += $shipping_insurance;
					$period_priority_handling += $priority_handling;
					
					?>
					<tr <?=$bg_color; ?>>
						<td align="left"><?=datetime_format("jS F, Y - D", $income_date); ?><?=$today; ?></td>
						<td align="right"><?=$order; ?></td>
						<td align="right"><?=$order_non_au; ?></td>
						<td align="right"><?=number_format($total, 2); ?></td>
						<td align="right"><?=number_format($order_income, 2); ?></td>
						<td align="right"><?=number_format($coupon, 2); ?></td>
						<td align="right"><?=number_format($shipping_insurance, 2); ?></td>
						<td align="right"><?=number_format($priority_handling, 2); ?></td>                        
					</tr>
					<?

				}

			?>
            <tr style="font-weight:bold; ">
                <td align="left">Total(AUD)</td>
                <td align="right" rowspan="2"><?=$period_order; ?> Orders</td>
                <td align="right" rowspan="2"><?=$period_order_non_au; ?> Non AU Orders</td>
                <td align="right">AUD <?=number_format($period_total, 2); ?></td>
                <td align="right">AUD <?
				if ($period_total > 0){
                	echo number_format($period_total/$period_order, 2);
				}else{
					0;
				}
				?></td>
                <td align="right">AUD <?=number_format($period_coupon, 2); ?></td>
                <td align="right">AUD <?=number_format($period_shipping_insurance, 2); ?></td>
				<td align="right">AUD <?=number_format($period_priority_handling, 2); ?></td>                
            </tr>
            <tr style="font-weight:bold; ">
                <td align="left">Total(HKD rate 7.8)</td>
                <td align="right">HKD <?=number_format($period_total * 7.8, 2); ?></td>
                <td align="right">HKD <?
				if ($period_total > 0){
                	echo number_format($period_total/$period_order * 7.8, 2);
				}else{
					0;
				}
				?></td>
                <td align="right">HKD <?=number_format($period_coupon * 7.8, 2); ?></td>
                <td align="right">HKD <?=number_format($period_shipping_insurance * 7.8, 2); ?></td>
				<td align="right">HKD <?=number_format($period_priority_handling * 7.8, 2); ?></td>                
            </tr>
        </table>
    </div>
</form>
<?

function get_daily_income_order($income_date){
	
	$income_date_from = $income_date;
	$income_date_to = datetime_format("Y-m-d", datetime_add("d", 1, $income_date));

	$sql="
		select 
			*
		from
			tbl_cart
		where
			active=1
			and order_status_id <> 1
			and order_status_id <> 6
			and member_create_date >= '$income_date_from'
			and member_create_date < '$income_date_to'
			and (
				payment_gateway_status = 'Completed'
				or payment_gateway_status = 'AUTHORISED'
				or payment_gateway_status = 'CAPTURE'
			)
			";
	
	if ($result = mysql_query($sql)){

		$num_rows = mysql_num_rows($result);
		
		return $num_rows;

	}else
		echo $sql;
	
}

function get_daily_income_order_non_au($income_date){
	
	$income_date_from = $income_date;
	$income_date_to = datetime_format("Y-m-d", datetime_add("d", 1, $income_date));

	$sql="
		select 
			*
		from
			tbl_cart
		where
			active=1
			and order_status_id <> 1
			and order_status_id <> 6
			and member_create_date >= '$income_date_from'
			and member_create_date < '$income_date_to'
			and shipping_country_id <> 14
			and (
				payment_gateway_status = 'Completed'
				or payment_gateway_status = 'AUTHORISED'
				or payment_gateway_status = 'CAPTURE'
			)
			";
	
	if ($result = mysql_query($sql)){

		$num_rows = mysql_num_rows($result);
		
		return $num_rows;

	}else
		echo $sql;
	
}

function get_daily_income_total($income_date){
	
	$income_date_from = $income_date;

	$income_date_to = datetime_format("Y-m-d", datetime_add("d", 1, $income_date));

	$sql="
		select 
			*
		from
			tbl_cart
		where
			active=1
			and order_status_id <> 1
			and order_status_id <> 6
			and member_create_date >= '$income_date_from'
			and member_create_date < '$income_date_to'
			and (
				payment_gateway_status = 'Completed'
				or payment_gateway_status = 'AUTHORISED'
				or payment_gateway_status = 'CAPTURE'
			)
			";
	
	if ($result=mysql_query($sql)){

		$num_rows=mysql_num_rows($result);
		
		while($row=mysql_fetch_array($result)){
			
			$total += get_total_amount($row[id]);
			
		}
		
		return $total;

	}else
		echo $sql;
	
}

function get_daily_coupon_total($income_date){
	
	$income_date_from = $income_date;

	$income_date_to = datetime_format("Y-m-d", datetime_add("d", 1, $income_date));

	$sql="
		select 
			*
		from
			tbl_cart
		where
			active=1
			and order_status_id <> 1
			and order_status_id <> 6
			and member_create_date >= '$income_date_from'
			and member_create_date < '$income_date_to'
			and (
				payment_gateway_status = 'Completed'
				or payment_gateway_status = 'AUTHORISED'
				or payment_gateway_status = 'CAPTURE'
			)
			";
	
	if ($result=mysql_query($sql)){

		$num_rows=mysql_num_rows($result);
		
		while($row=mysql_fetch_array($result)){
			
			$total += $row[coupon_discount];
			
		}
		
		return $total;

	}else
		echo $sql;
	
}

function get_daily_shipping_insurance($income_date){
	
	$income_date_from = $income_date;

	$income_date_to = datetime_format("Y-m-d", datetime_add("d", 1, $income_date));

	$sql="
		select 
			*
		from
			tbl_cart
		where
			active=1
			and order_status_id <> 1
			and order_status_id <> 6
			and member_create_date >= '$income_date_from'
			and member_create_date < '$income_date_to'
			and (
				payment_gateway_status = 'Completed'
				or payment_gateway_status = 'AUTHORISED'
				or payment_gateway_status = 'CAPTURE'
			)
			";
	
	if ($result=mysql_query($sql)){

		$num_rows=mysql_num_rows($result);
		
		while($row=mysql_fetch_array($result)){
			
			$total += $row[shipping_insurance];
			
		}
		
		return $total;

	}else
		echo $sql;
	
}

function get_daily_priority_handling($income_date){
	
	$income_date_from = $income_date;

	$income_date_to = datetime_format("Y-m-d", datetime_add("d", 1, $income_date));

	$sql="
		select 
			*
		from
			tbl_cart
		where
			active=1
			and order_status_id <> 1
			and order_status_id <> 6
			and member_create_date >= '$income_date_from'
			and member_create_date < '$income_date_to'
			and (
				payment_gateway_status = 'Completed'
				or payment_gateway_status = 'AUTHORISED'
				or payment_gateway_status = 'CAPTURE'
			)
			";
	
	if ($result=mysql_query($sql)){

		$num_rows=mysql_num_rows($result);
		
		while($row=mysql_fetch_array($result)){
			
			$total += $row[priority_handling];
			
		}
		
		return $total;

	}else
		echo $sql;
	
}

?>

