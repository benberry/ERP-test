<?
//*** Default
	$func_name 		= "Coupons to paid customers";
	$tbl 			= "tbl_cart";
	$curr_page 		= "order.list";
	$edit_page 		= "order.edit";
	$action_page 	= "order.act";
	$page_item 		= 50;


//*** Request
	extract($_REQUEST);


//*** Return Path



//*** Select SQL
	$sql="
	    select
			*
		from
			$tbl
		where
			status=0
			and active=1
			and deleted=0
			and order_status_id <> 0
			and order_status_id <> 1
			and order_status_id <> 6";			
			

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
	
	
	function form_export(){

		fr = document.frm

		fr.action = "../coupon-to-paid-customers/index-export.php";
		fr.method = "post";
		fr.target = "_blank";
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
		<h3>Paid Customers</h3>
        Order Date:
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
	       <input type="button" value="SEARCH" onclick="form_search();" />
		   <input type="button" value="RESET" onclick="form_search_reset();" />

		</div>
        <div id="line-2" style="background-color: #ccc; padding: 10px;" >
		   <h3>Coupon generator</h3>
		   <table>
		      <tr>
			     <td>Start Date</td>
			     <td>End Date</td>
			     <td>Coupon Name</td>
			     <td>Discount(AUD)</td>	
				 <td></td>			 				 				 
			  </tr>
		      <tr>
			     <td><input type="text" id="coupon_date_from" name="coupon_date_from" value="<?=date_empty($coupon_date_from)?>" readonly="readonly">
            <a href="#" id="btn_coupon_date_from"><img src="../images/calendar.jpg" border="0"></a>
            <script type="text/javascript">//<![CDATA[
   
   			var cal = Calendar.setup({
   				onSelect: function(cal) { cal.hide(); }
   			});
   			cal.manageFields("btn_coupon_date_from", "coupon_date_from", "%Y-%m-%d");
   
           //]]></script>
		         </td>
			     <td><input type="text" id="coupon_date_to" name="coupon_date_to" value="<?=date_empty($srh_coupon_date_to)?>" readonly="readonly">
           <a href="#" id="btn_coupon_date_to"><img src="../images/calendar.jpg" border="0"></a>
           <script type="text/javascript">//<![CDATA[
   
   			  var cal = Calendar.setup({
   				  onSelect: function(cal) { cal.hide(); }
   			  });
   			  cal.manageFields("btn_coupon_date_to", "coupon_date_to", "%Y-%m-%d");
   
           //]]></script>
		         </td>
			     <td><input type="text" id="coupon_name" name="coupon_name" value="" /></td>
			     <td><input type="text" id="coupon_discount" name="coupon_discount" value="" /></td>
				 <td><input type="button" value="Gen. coupons &amp; export to .csv" onclick="form_export();" onclick="javascript: location='';" /></td>							 				 				 
			  </tr>			  
		   </table>            
		   
		</div>
		<!-- End of Second Line -->
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

	</div>

<table>
	<tr>
    	<th>Email</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Email</th>		
        <th>Total Amount</th>
        <th>Status</th>
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
				
				$rate = get_field("tbl_currency", "rate", $row[currency_id]);
		
				?>
				<tr>
                    <td width="50" valign="top"><input type="checkbox" name="cb_<?=$i?>" value="<?=$row[id]; ?>"></td>
					<td valign="top"><?=$row[first_name]; ?></td>
					<td valign="top"><?=$row[last_name]; ?></td>
					<td valign="top"><?=$row[email]; ?></td>
					<td valign="top"><?=number_format($total_amount * $rate, 2); ?></td>					
                    <td align="center" onclick="goto_page('<?=$edit_page?>', '<?=$row[id]?>');" valign="top" >
                    	<?=get_field("tbl_cart_order_status", "name_1", $row[order_status_id]); ?>
                    </td>
				</tr>
				<?
	
			}
	
		}
	
	}

	?>
</table>
<br class="clear" />
</div>
</form>	
<?
	
}else
	echo $sql;

?>