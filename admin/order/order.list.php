<?
//*** Default
	$func_name 		= "Orders";
	$tbl 			= "tbl_cart";
	$curr_page 		= "order.list";
	$edit_page 		= "order.edit";
	$action_page 	= "order.act";
	$page_item 		= 9999;


//*** Request
	extract($_REQUEST);

	if ($srh_progress_id == '')
		//$srh_progress_id = 7;


//*** Return Path
 

//echo get_random_no(9);

    echo "";

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
			and order_status_id<>0";


//*** Search
	if ($srh_order_date_from){
		$sql .= " and member_create_date >= '$srh_order_date_from'";
	}else{
		$srh_order_date_from=date("Y-m-d");
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

		fr = document.frm;

		fr.action = "<?=$_SERVER['PHP_SELF']?>?<?=$_SERVER['QUERY_STRING']?>";
		fr.method = "post";
		fr.target = "_self";
		fr.submit();

	}
	
	
	function form_print_select(){

		fr = document.frm

		fr.action = "../order/print_selected.php";
		fr.method = "get";
		fr.target = "_self";
		fr.submit();

	}
	
	function form_export(){

		fr = document.frm

		fr.action = "../order/export_csv.php";
		fr.method = "post";
		fr.target = "_self";
		fr.submit();

	}	form_markshipped
	
	function form_markshipped(){
		fr = document.frm
		fr.action = "../main/main.php?func_pg=mark_shipped";
		fr.method = "post";
		fr.target = "_self";
		fr.submit();

	}
	function form_search_reset(){

		window.location = "<?=$_SERVER['PHP_SELF']?>?<?=$_SERVER['QUERY_STRING']?>";

	}

</script>
<script type="text/javascript">
$(document).ready(function() {
			
	$('#mark_as_shipped').click(function (){
		
		alert('ship me');
	});//end id mark_as_shipped button
});	
</script>
<form name="frm">
<input type="hidden" name="tbl" value="<?=$tbl?>">
<input type="hidden" name="act" value="">
<input type="hidden" name="order_by" value="<?=$order_by?>">
<input type="hidden" name="ascend" value="<?=$ascend?>">
<input type="hidden" name="del_id" value="">
<input type="hidden" name="thispage" value="<?=$_SERVER['QUERY_STRING']?>">
<div id="list">
	<div id="title"><?=$func_name?></div>
    <div id="search">
		<!-- First Line -->
		<div id="line-1">
			
			Order ID:<input type="text" name="srh_order_no" value="<?=$srh_order_no?>">
			<?

				if ($search_member_id>0){
					$display = get_field("tbl_member", "user", $search_member_id);
					$display .= " (".get_field("tbl_member", "first_name", $search_member_id)." ";
					$display .= get_field("tbl_member", "last_name", $search_member_id).")";
				}

			?>
			Status:
			<select name="srh_progress_id">
				<option value="all" <?=set_selected("all", $srh_progress_id); ?>>All</option>
				<?=get_combobox_src("tbl_cart_order_status", "name_1", $_POST['srh_progress_id']); ?>
			</select>

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

		</div>
        <div id="line-2">            
            
            First Name: <input type="text" name="srh_first_name" value="<?=$srh_first_name; ?>">
            Last Name: <input type="text" name="srh_last_name" value="<?=$srh_last_name; ?>">
            Email: <input type="text" name="srh_email" value="<?=$srh_email; ?>">

        <!-- Member: <? get_lookup("search_member_id", "../lookup/member.php", $search_member_id, $display, "Member Lookup"); ?> -->

        <input type="button" value="SEARCH" onclick="form_search()">
        <input type="button" value="RESET" onclick="form_search_reset()">
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
        
        <div id="button"><? //include("../include/list_toolbar.php");	?>
		
		<!-- Berry Add Print Select -->
		<a class="boldbuttons" href="javascript:form_print_select();"><span>Print Selected</span></a>
		<!-- End Berry Add Print Select -->
		<? if ($_SESSION["sys_delete"]) { ?>

			<a class="boldbuttons" href="javascript:del_item('<?=$action_page?>', '<?=$page_item?>')"><span>Delete</span></a> 

        <? } ?>
        
        <? if ($_SESSION["sys_export"]==1){ ?>

			<a class="boldbuttons" href="javascript:form_export();"><span>Export&nbsp;.csv</span></a>

        <? } ?>
		</div>
        <table style="width:630px; float:right;">
        	<tr>
            	
		<?php if((isset($_REQUEST['srh_progress_id']) && $_REQUEST['srh_progress_id']==2) || $srh_progress_id==2){ ?>
		<td><div id="button">
		<a class="boldbuttons" id="mark_as_shipped" href="javascript:form_markshipped();"><span style="width: 100%;">Mark as Shipped</span></a>
		</div></td>
		<?php }?>
            	<!--td><img src="../images/priority_handling.png" alt="priority handling"></td>
                <td align="left">priority handling</td>
				<td><img src="../images/shipping_insurance.png" alt="shipping insurance"></td>
                <td align="left">shipping insurance</td>                
            	<td><img src="../images/order-verification.png" alt="email verified"></td>
                <td align="left">email address verified</td>                
            	<td><img src="../images/gift-box.png" alt="gift box"></td>
                <td align="left">wrapper</td-->
                <?php 
				//if($_REQUEST['srh_progress_id']=='7' || $srh_progress_id=='7'){
			$srh_progress_idx = (isset($_REQUEST['srh_progress_id']))?$_REQUEST['srh_progress_id']:$srh_progress_id;
			?>
                <td>
				    <?php
						if($_SESSION['user_group_id'] != 34){
						
							if($_SESSION['user_group_id'] != 37){
					?>
					<a style="float:left;display:inline;margin-left:5px;" href="../order/print.php?start_date=<?=$srh_order_date_from ?>" target="_blank"><img src="../images/printer.png" border="0" alt="print"></a>
					<?php
					
						}
					
					?>
					<a style="float:right;display:inline;margin-right:5px;" href="../order/print2.php?start_date=<?=$srh_order_date_from ?>" target="_blank"><img src="../images/printer.png" border="0" alt="print"></a>
					</td>
					
					<?php
					
					}
					
					?>
					
                    <?php 
					//}
					?>
                    
        	</tr>            
        </table>
		<br class="clear">
		
	</div>

<table>
	<tr>
        <th width="50"><input type="checkbox" name="select_all" onclick="checkbox_select_all(<?=$page_item?>)"></th>
        <th><? set_sequence("Order Number","invoice_no", $order_by, $ascend, $curr_page) ?></th>
        <th>sales</th>
        <th>Total Amount</th>
        <th>Status</th>
		<th>Status2</th>
        <!--th>Shipping</th-->        
        <th>Client/Code</th>
        <th>Source</th>        
        <!--th></th-->
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
				<tr <? if($row["status2"] == 1){ ?> style="background:red;" <? } ?> >
                    <td width="50" valign="top"><input type="checkbox" name="cb_<?=$i?>" value="<?=$row[id]?>"> </td>
                    <td align="left" valign="top">
						<a href="/ph/en/checkout/ygshow.php?yg_cart_id=<?=$row[id];?>" target="_blank"><?=$row[invoice_no]; ?></a>
                        <div style="color: #888; font-size:10px;"><?=$row[member_create_date];?></div>
                    </td>
					
                    <td align="left" valign="top">
	                    
						<?=get_field("tbl_payment_method","name_1",$row["sales_id"]) ?>
                        
					</td>
                    <td align="right" valign="top">
	                    <? //=get_field("tbl_currency", "symbol_1", $row[currency_id]); ?>
						HK$
						<?=number_format($total_amount * $rate, 2)?>
                        <?
							if($row[coupon_discount] > 0){
								?><div style="color:#F33; font-size: 10px;">-<?=number_format($row[coupon_discount] * $rate, 2)?></div><?
							}
                        ?>
                    </td>
                    
                    <td align="center" onclick="goto_page('<?=$edit_page?>', '<?=$row[id]?>')" valign="top">
                    	<?=get_field("tbl_cart_order_status", "name_1", $row[order_status_id]); ?><br />
                    </td>
					
					<td align="center" onclick="goto_page('<?=$edit_page?>', '<?=$row[id]?>')" valign="top">
                    	<?=get_field("tbl_cart_order_status", "name_1", $row[order_status_id2]); ?><br />
                    </td>
                    
                    <!--td align="left" valign="top">
                        
                        <table>
                        	<tr>
                            	<td align="left" valign="top" rowspan="2" style="border:0px">
                                        
						<span style="color: #888; font-size:10px;"><span style="color:#363; font-size:10px;">shipping country-</span> <?=get_field("tbl_country", "name_1", $row[shipping_country_id]);?></span><br />
                        <span style="color: #888; font-size:10px;"><span style="color:#363; font-size:10px;">shipping through-</span> <?=get_field("tbl_shipping_company", "name_1", $row[shipping_company_id]);?></span><br />
                        <span style="color: #888; font-size:10px;"><span style="color:#363; font-size:10px;">
			tracking number-</span>
			<?php
			if($row[order_status_id]==2 && $row[shipping_tracking_code]==''){
				?>
				<input type="hidden" name="order_cart_id[]" value="<?=$row['id']?>"/>
				<input type="text" name="shipping_tracking_code[]" value="" style="width: 80px;" size="5"/>
				<?php
			}else{
				echo $row[shipping_tracking_code];
			}
			?>
			</span>
                        
		                        </td>
                                <td style="border:0px" width="24">
                                	<? if ($row[priority_handling] > 0){?>
                                    	<img src="../images/priority_handling.png" alt="priority handling">
                                    <? } ?>
                                </td>
                                <td style="border:0px" width="24">
                                    <? if ($row[shipping_insurance] > 0){?>
                                    	<img src="../images/shipping_insurance.png" alt="shipping insurance">
                                    <? } ?>
                                </td>
								<td style="border:0px" width="24">
                                	<? if ($row[order_verification] > 0){?>
                                    	<img src="../images/order-verification.png" alt="email verified">
                                    <? } ?>                                
                                </td>                            
                            	<td style="border:0px" width="24">
                                	<? if (get_cart_wrapper_amount($row[id]) > 0){?>
                                    	<img src="../images/gift-box.png" alt="gift box">
                                    <? } ?>
                                </td>
                            </tr>
						</table>
                        
                    </td-->
                                       
                    <td align="right" valign="top">
                    	<?=get_field("tbl_currency","name_1",$row["client_id"]) ?> / <?=get_field("tbl_currency","symbol_1",$row["client_id"]) ?>
                    </td>
                    <td align="right" valign="top">
                    	<?
                        
						$ip = get_field("tbl_visitor", "ip", $row[visitor_id]);
						
						?>
                        
                        <!--<div style="color: #888; font-size:10px;"><?//=gethostbyaddr($ip);?></div>-->

                        <div style="color: #888; font-size:10px;"><?
						
                        $referer_domain = $row[http_referer];

						$referer_domain = str_replace("http://", "", $referer_domain);
						
						echo substr($referer_domain, 0, strpos($referer_domain, "/"));
						
						?></div>
                        <div style="color: #888; font-size:10px;">IP:<?=$ip; ?></div>
						<div style="color: #888; font-size:10px;">vID:<?=$row[visitor_id]; ?></div>
                    </td>
                    <!--td valign="top">
                   <?php
                   if($row[order_status_id]=='2'){
				   
				   ?>
                    
                    	<a href="../order/invoice.php?cart_id=<?=$row[id]; ?>&order_status_id=<?=$row[order_status_id]?>&visitor_id=<?=$row[visitor_id]?>" target="_blank"><img src="../images/printer.png" border="0" alt="print"></a>
                       <?php }?>
                        
                          <?php /*$sql="update tbl_cart_order_tracker set order_status_id='2' where id='".$row[id]."'";
						  echo $sql;
						  mysql_query($sql)
						  or die("query failed" . mysql_error());*/
						  ?>
                        <a href="../order/checklist.php?cart_id=<?=$row[id]; ?>" target="_blank"><img src="../images/checklist.png" border="0" width="36" alt="checklist"></a>
                         <?php
						 if($row['remarks']!='' && $row['order_status_id']=='7'){
							 echo '<img src="../images/t-icon.png" border="0" height="36">';
							 
							 }
						 
						 
						 ?>
						 </td-->
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
			and
			(
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
?>