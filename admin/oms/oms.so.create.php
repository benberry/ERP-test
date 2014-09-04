<?

//*** Default
	$func_name = "Create ERP Order";
	$curr_folder="oms";
	$tbl = "tbl_order";
	$prev_page = "oms.so";
	$curr_page = "oms.so.create";
	$action_page = "oms.so.act";
	
//*** Request
extract($_REQUEST);

?>

<script>

	function form_action(act)
	{

		fr = document.frm
		
		fr.act.value = act;
		

		if (act == '2')	//Create Order
		{
			if($("input[name=order_no]").val() == "")
			{
				alert("Order Number Cannot be Blank!");
				return flase;
			}
			fr.action = '../main/main.php?func_pg=<?=$action_page?>&act=2';			
			fr.method = 'post';
			fr.target = '_self';
			fr.submit();
		}

		if (act == '1')	//back
		{
			window.location = '../main/main.php?func_pg=<?=$prev_page?>&pg_num=<?=$pg_num?>';
			
			return
			
		}

		if (act == '3')
		{
			fr.deleted.value = 1;
			
			fr.action = '../main/main.php?func_pg=<?=$action_page?>';
			fr.method = 'post';
			fr.target = '_self';
			fr.submit();
			
		}
		
	}

</script>

<form name="frm" enctype="multipart/form-data">
<input type="hidden" name="tbl" value="<?=$tbl?>">
<input type="hidden" name="act" value="<?=$action?>">
<input type="hidden" name="pg_num" value="<?=$pg_num?>">
<input type="hidden" name="tab" id="tab_curr" value="<?=$tab?>">
<input type="hidden" name="fid" value="1">

<!-- Search Temp -->
<input type="hidden" name="srh_order_date_from" value="<?=$srh_order_date_from?>">
<input type="hidden" name="srh_order_date_to" value="<?=$srh_order_date_to?>">
<input type="hidden" name="srh_tracking_no" value="<?=$srh_tracking_no?>">
<!-- Search Temp -->

<div id="edit">

	<div id="title">
        <table>
            <tr>
                <th>Create New Order</th>                
            </tr>            
        </table>
    </div>
    <div id="tool">      
        <a class="boldbuttons" href="javascript:form_action(2)"><span>Add</span></a>
		<a class="boldbuttons" href="javascript:form_action(1)"><span>Back</span></a>		
	</div>

    <div id="tabs">        
        <div id="tabs-1">
		<fieldset>
			<legend>Required Order Info</legend>
			<div style="float:left;">
				<p><label>Magento/Custom Order No.:</label><input type="text" name="order_no" /></p>
				<p><label>Magento Order ID.:</label><input type="text" name="magento_order_id" /></p>
				<p><label>Customer Email:</label><input type="text" name="customer_email" /></p>
				<p><label>Customer First Name:</label><input type="text" name="customer_firstname" /></p>
				<p><label>Customer Last Name:</label><input type="text" name="customer_lastname" /></p>
				<p><label>Currency:</label><input type="text" name="order_currency_code" value="AUD" /></p>
				<p><label>Shipping Method:</label><input type="text" name="shipping_method" /></p>
				<p><label>Payment Method:</label><input type="text" name="payment_method" /></p>
				<p><label>Shipping Charge:</label><input type="text" name="base_shipping_incl_tax" value="0" /></p>
				<p><label>Payment Surcharge:</label><input type="text" name="base_fooman_surcharge_amount" value="0" /></p>
				<p><label>Grand Total:</label><input type="text" name="grand_total" value="0" /></p>
			</div>
		</fieldset>		
		</div>        
    </div>
	<div id="tool">      
        <a class="boldbuttons" href="javascript:form_action(2)"><span>Add</span></a>
		<a class="boldbuttons" href="javascript:form_action(1)"><span>Back</span></a>		
	</div>    
</div>

</form>