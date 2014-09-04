<?
### Default
	$func_name 		= "Order Details";
	$tbl 			= "tbl_cart";
	$curr_page 		= "order.list";
	$edit_page 		= "order.edit";
	$action_page 	= "order.act";
	$page_item 		= 999;

### Request
	extract($_REQUEST);


### Return Path



### Select SQL
	$sql="
		select
			*
		from
			$tbl
		where
			status=0
			and active=1
			and deleted=0
			and order_status_id<>0
			and order_status_id<>1
			and order_status_id<>6";

### Search
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


### Order by start
	if (empty($_POST["order_by"]))
		$order_by = "member_create_date"; 
	else
		$order_by = $_POST["order_by"];
	
	if (empty($_POST["ascend"]))
		$ascend = "desc";
	else
		$ascend = $_POST["ascend"];
	
	if (!empty($order_by)){
		$sql .=" order by
				$order_by
				$ascend";}

### Order by end
	// echo $sql."<br />";


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
        <input type="button" value="RESET" onclick="form_search_reset()">
		</div>
    </div>
    
	<div id="tool">
		<div id="paging">
			<?	
				echo $pbar[1];
				echo $pbar[2];
				echo $pbar[4];
				echo $pbar[3];
				echo $pbar[5];
			?>
		</div>
		<br class="clear" />
	</div>

<table>
	<tr>
        <th>Inv. No</th>
        <th>Customer</th>
        <th>Total</th>
        <th></th>
	</tr>
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
				<tr>
                    <td align="left" valign="top">
						<a href="main.php?func_pg=order.edit&id=<?=$row[id];?>"><?=$row[invoice_no]; ?></a>
                        <div style="color: #888; font-size:10px;"><?=$row[member_create_date]; ?></div>
                        <div style="color: #888; font-size:10px;"><?=get_field("tbl_cart_order_status", "name_1", $row[order_status_id]); ?></div>
                    </td>
					
                    <td align="left" valign="top">
	                    <?
						$purchase_before_count=get_purchase_before_count($row[email], $row[member_create_date]);
						
						if ($purchase_before_count > 0){
							
							echo $row[first_name]; 
							?>&nbsp;<?
                            echo $row[last_name];
							?>&nbsp;<?
							echo "(".$purchase_before_count.")";

						}else{
							
							echo $row[first_name]; 
							?>&nbsp;<?
                            echo $row[last_name];
							?>&nbsp;<?
							echo "(".$purchase_before_count.")";
							
						}
						
						?> 

                        <br />
                        <? if ($row[member_id] > 0){ ?>
		                        <div style="color:#090; font-size:10px;">member</div>
                        <? }else{ ?>
		                        <div style="color:#F63; font-size:10px;">non-member</div>
                        <? } ?>
                        <div style="color: #888; font-size:10px;"><?=$row[email]?></div>
                        
					</td>
                    <td align="right" valign="top">
	                    <?=get_field("tbl_currency", "symbol_1", $row[currency_id]); ?>
						<?=number_format($total_amount * $rate, 2); ?>
                        <? if ($row[payment_gateway_amt] > 0 && $row[payment_method_id]==1){ ?>
                            <div style="color:#666; font-size: 10px;"><?=get_field("tbl_payment_method", "name_1", $row[payment_method_id]); ?>-<?=$row[payment_gateway_status]; ?></div>
                        <? } ?>
                        <? if ($row[payment_method_id]==7){ ?>
                            <div style="color:#666; font-size: 10px;"><?=get_field("tbl_payment_method", "name_1", $row[payment_method_id]); ?></div>
                        <? } ?>
                    </td>
                    <td>
                    	<?=get_cart_details($row[id]); ?>
                    </td>
				</tr>
				<?
	
			}
	
		}
	
	}

?>
</table>
<?	
	
}
else
	echo $sql;

### count customer buyed be4	
	function get_purchase_before_count($email, $date){
		$sql="select 
				id
			from
				tbl_cart
			where
				email='$email'
				and member_create_date<'$date'
				and order_status_id<>1
				and order_status_id<>6
				and(payment_gateway_status = 'Completed'
					or payment_gateway_status = 'AUTHORISED'
					or payment_gateway_status = 'CAPTURE')";
		
		if ($result = mysql_query($sql)){
			$num_rows = mysql_num_rows($result);
			return $num_rows;
		}else
			echo $sql;

	}

### get cart details
	function get_cart_details($id){
		$sql="select *from tbl_cart_item where cart_id=$id order by unit_price desc ";
		
		if ($result = mysql_query($sql)){
			?><table border="0" style="margin-bottom: 30px;"><?
			while ($row = mysql_fetch_array($result)){
				?>
				<tr>
                	<td width="300" align="left"><?=get_field("tbl_product", "name_1", $row[product_id]); ?></td>
                	<td width="50"><?=$row[qty]; ?></td>
				</tr>
				<?
			}
			?></table><?
		}else
			echo $sql;
		
		
	}
?>