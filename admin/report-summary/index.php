<?
//*** Default
	$func_name 		= "Order Summary";
	$tbl 			= "tbl_cart";
	$curr_page 		= "index";
	$edit_page 		= "index";
	$action_page 	= "index";
	$page_item 		= 999;

//*** Request
	extract($_REQUEST);


//*** Return Path


//*** Select SQL
	$sql="select
			*
		from
			$tbl
		where
			status=0
			and active=1
			and deleted=0
			and order_status_id<>0";

//*** Search
	if ($srh_order_date_from){
		$sql .= " and member_create_date >= '$srh_order_date_from'";
	}else{
		$srh_order_date_from=date("Y-m-1");
		$sql .= " and member_create_date >= '$srh_order_date_from'";
	}
	
	if ($srh_order_date_to){
		$sql .= " and member_create_date <= '$srh_order_date_to'";
	}
	
	if ($srh_order_no){
		$sql .= " and invoice_no like '%$srh_order_no%'";
	}

	if ($srh_progress_id != '' && $srh_progress_id!='all'){
		$sql .= " and order_status_id = $srh_progress_id";
	}
	
	if ($srh_payment_method_id){
		$sql .= " and payment_method_id = $srh_payment_method_id";
	}
	
	if ($srh_delivery_method_id){
		$sql .= " and shipping_location_id = $srh_delivery_method_id";
	}
	
	if ($search_member_id > 0){
		$sql .= " and member_id = $search_member_id";
	}
	
	if ($srh_first_name !=''){
		$sql .= " and first_name like '%$srh_first_name%'";
	}
	
	if ($srh_last_name !=''){
		$sql .= " and last_name like '%$srh_last_name%'";
	}
	
	if ($srh_email !=''){
		$sql .= " and email like '%$srh_email%'";
	}		


//*** Order by start
	if (empty($_POST["order_by"]))
		$order_by = "member_create_date"; 
	else
		$order_by = $_POST["order_by"];
	
	if (empty($_POST["ascend"]))
		$ascend = "desc";
	else
		$ascend = $_POST["ascend"];
	
	if (!empty($order_by))
	{
		$sql .="
			order by
				$order_by
				$ascend
		";
	}

//*** Order by end
if ($result=mysql_query($sql))
{

	$num_rows = mysql_num_rows($result);
	
	if ($num_rows > 0 )
		$pbar = paging_bar($page_item, $num_rows);

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
			<?
				if ($search_member_id>0){
					$display = get_field("tbl_member", "user", $search_member_id);
					$display .= " (".get_field("tbl_member", "first_name", $search_member_id)." ";
					$display .= get_field("tbl_member", "last_name", $search_member_id).")";
				}
			?>
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
        <script type="text/javascript">//<![CDATA[

			  var cal = Calendar.setup({
				  onSelect: function(cal) { cal.hide() }
			  });
			  cal.manageFields("btn_srh_order_date_to", "srh_order_date_to", "%Y-%m-%d");

        //]]></script>
			<input type="button" value="SEARCH" onclick="form_search()">
		</div>
    </div>
<table>

	<?

	if ($num_rows > 0)
	{
	
		$order_count = 0;

		mysql_data_seek($result, $pbar[0]);
	
		for($i=0; $i < $page_item ;$i++)
		{
		
			if ($row = mysql_fetch_array($result))
			{

				$total_amount = get_total_amount($row[id]);
				
				if ($row[order_status_id] != 1 && 
					$row[order_status_id] != 6 && 
					(
						$row[payment_gateway_status] == 'Completed'
						or $row[payment_gateway_status] == 'AUTHORISED'
						or $row[payment_gateway_status] == 'CAPTURE'
					
					)){
					
					$order_total += $total_amount;
					$order_count++;
					$total_discount += $row[coupon_discount];
					if ($row[coupon_discount] > 0){
						$total_discount_count++;
					}
					
					if ($row[member_id] > 0)
						$member++; 
					else
						$non_member++;
					
					if ($row[shipping_country_id]==31){
						$off_order_total += $total_amount;
						$off_order_count++;
						$off_total_discount += $row[coupon_discount];
					}

				}
				
				$rate = get_field("tbl_currency", "rate", $row[currency_id]);
		
				?>
				
				<?
	
			}
	
		}
	
	}

?>
</table>

<br class="clear" />

<? if ($order_total > 0) { ?>
    <h2>Order Summary ( <?=$srh_order_date_from; ?> to <? if ($srh_order_date_to!='') echo "$srh_order_date_to"; else echo "current"; ?> ) </h2>
    <table style="width:300px; text-align:left; float:left; ">
        <tr>
            <td>Total Amount:</td>
            <td>
                AU$ <?=round($order_total, 2); ?><br /> 
            </td>
        </tr>
        <tr>
            <td></td>
            <td>HK$ <?=round($order_total*8, 2); ?>
            <div style=" font-size: 10px">rate=8</div></td>
        </tr>
        
        <tr>
            <td>Orders: </td>
            <td>
				<?=$order_count; ?>
            </td>
        </tr>
        <tr>
            <td>Member: </td>
            <td><?=$member; ?> - 
				<? if ($member > 0) { ?>
                	(<?=round($member/$order_count*100, 2); ?>%)
                <? } ?>
            </td>
        </tr>
        <tr>
            <td>Non-member:</td>
            <td><?=$non_member; ?> - 
				<? if ($non_member > 0) { ?>
                	(<?=round($non_member/$order_count*100, 2); ?>%)
                <? } ?>            
            </td>
        </tr>
        <tr>
            <td>Value Per Order : </td>
            <td>AU$<?=round($order_total/$order_count, 2); ?></td>
        </tr>
		<tr>
            <td><br /></td>
            <td></td>
        </tr>
		<tr>
            <td>Total Amount (Brazil)</td>
            <td>AU$<?=round($off_order_total, 2); ?></td>
        </tr>
		<tr>
            <td>Orders (Brazil)</td>
            <td><?=round($off_order_count); ?></td>
        </tr>
        
    </table>

<? } ?>

	<?
	
		function get_cart_item_in_cat($cat_id, $srh_order_date_from, $srh_order_date_to){
	
			$sql="
				select
					count(p.cat_id) as total_item
	
				from
					tbl_cart_item ci
					left join tbl_cart c on ci.cart_id=c.id
					left join tbl_product p on ci.product_id=p.id
	
				where
					c.active=1 
					and c.deleted=0
					and c.order_status_id != 1
					and c.order_status_id != 6
					and c.payment_gateway_status = 'Completed'
	
				";

			if ($cat_id > 0 ){
				$sql .= " and p.cat_id = $cat_id";
	
			}	
	
			if ($srh_order_date_from  != ''){
				$sql .= " and c.member_create_date >= '$srh_order_date_from'";
	
			}
			
			if ($srh_order_date_to  != ''){
				$sql .= " and c.member_create_date <= '$srh_order_date_to'";
	
			}
			
			if ($result = mysql_query($sql)){
				
				$row = mysql_fetch_array($result);
				
				return $row[total_item];
				
			}

		}


		function get_cart_item_in_cat_value($cat_id, $srh_order_date_from, $srh_order_date_to){
	
			$sql="
				select
					sum(ci.unit_price + ci.option_price) as total_price
	
				from
					tbl_cart_item ci
					left join tbl_cart c on ci.cart_id=c.id
					left join tbl_product p on ci.product_id=p.id
	
				where
					c.active=1 
					and c.deleted=0
					and c.order_status_id != 1
					and c.order_status_id != 6
					and c.payment_gateway_status = 'Completed'
	
				";

			if ($cat_id > 0){
				$sql .= " and p.cat_id = $cat_id";
	
			}	
	
			if ($srh_order_date_from != ''){
				$sql .= " and c.member_create_date >= '$srh_order_date_from'";
	
			}
			
			if ($srh_order_date_to  != ''){
				$sql .= " and c.member_create_date <= '$srh_order_date_to'";
	
			}
			
			if ($result = mysql_query($sql)){
				
				$row = mysql_fetch_array($result);
				
				return $row[total_price];
				
			}

		}

    ?>

<? if ($order_total > 0) {
	
	$total_count_item = get_cart_item_in_cat($row[id], $srh_order_date_from, $srh_order_date_to);
	
	?>
    <table style="width:350px; text-align:left; float:left; margin-left:30px;">
    	<tr>	
            <td align="center">Categories</td>
            <td align="center">Count</td>
            <td align="center">%</td>
            <td align="center">Amount (AU$)</td>
        </tr>
    	<?

		$sql=" select *from tbl_product_category where active=1 and deleted=0 order by sort_no ";

		if ($result=mysql_query($sql)){
			while ($row=mysql_fetch_array($result)){
				
				$total_cat = get_cart_item_in_cat($row[id], $srh_order_date_from, $srh_order_date_to);

				?>
                <tr>	
                    <td><?=$row[name_1]; ?></td>
                    <td align="right"><?=$total_cat;?></td>
                    <td align="right">
						<?
                            if ($total_cat > 0){
                                echo round($total_cat / $total_count_item * 100, 2)."%";
                            }else{
								echo "0.00%";
							}
                        ?>
                    </td>
                    <td align="right">
						<?=number_format(get_cart_item_in_cat_value($row[id], $srh_order_date_from, $srh_order_date_to),2); ?>
                    </td>
                </tr>
				<?
			}
		}

		?>
    </table>

<? } ?>

	<table style="width:350px; text-align:left; float:left; margin-left:30px;">
	    <tr>	
            <td colspan="2" align="center"><strong>Coupon Summary</strong></td>
        </tr>
    	<tr>	
            <td align="center">Total Discount: </td>
            <td align="center">AU$ <?=$total_discount; ?></td>
        </tr>
        <tr>	
            <td align="center">Discount Coupon was used</td>
            <td align="center"><?=$total_discount_count; ?> order(s)</td>
        </tr>
    	
    </table>
	<br class="clear" />
    <br class="clear" />
</div>
</form>	
<?	
	
}
else
	echo $sql;
	
function get_purchase_before_count($email, $date){
	
	$sql="
		select 
			id
		from
			tbl_cart
		where
			email='$email'
			and member_create_date<'$date'
			and order_status_id<>1
			and order_status_id<>6
			and(
				payment_gateway_status = 'Completed'
				or payment_gateway_status = 'AUTHORISED'
				or payment_gateway_status = 'CAPTURE')";
	
	if ($result = mysql_query($sql)){
		
		$num_rows = mysql_num_rows($result);
		
		return $num_rows;
		
	}else
		echo $sql;
	
	
}

?>