<?

//*** Default
$func_name = "Orders";
$tbl = "tbl_cart";
$prev_page = "order.list";
$curr_page = "order.edit";
$action_page = "order.act";


//*** Request
extract($_REQUEST);

if ($tab=='')
	$tab=0;
	
## TinyMCE
include("../include/tinymce_tiny.php");	
	


if (!empty($id))
{

	$sql = " select * from $tbl where id = $id ";
	
	if ($rows = mysql_query($sql)){
	
		$row = mysql_fetch_array($rows);
	
	}

}



?>

<script>

	function form_action(act){
	
		fr = document.frm;
		
		fr.act.value = act;
		
		if (act == '1'){
			if (fr.id.value=='')
				fr.active[0].checked = true;
		
			fr.action = '../main/main.php?func_pg=<?=$action_page?>'
			fr.method = 'post';
			fr.target = '_self';
			fr.submit();
		
		}		

		/* 
		if (act == '2'){
			window.location = '../main/main.php?func_pg=<?=$curr_page?>'
			return
			
		}

		if (act == '3'){
			fr.deleted.value = 1;
			fr.action = '../main/main.php?func_pg=<?=$action_page?>'
			fr.method = 'post';
			fr.target = '_self';
			fr.submit();
			
		}
		*/

	}

</script>

<form name="frm" enctype="multipart/form-data">
<input type="hidden" name="id" value="<?=$row[id]?>">
<input type="hidden" name="cart_id" value="<?=$row[id]?>">
<input type="hidden" name="deleted" value="<?=$row[deleted]?>">
<input type="hidden" name="tbl" value="<?=$tbl?>">
<input type="hidden" name="act" value="<?=$action?>">
<input type="hidden" name="tab" value="<?=$tab?>">
<input type="hidden" name="pg_num" value="<?=$pg_num?>">

<!-- Search Temp -->
<input type="hidden" name="srh_order_date_from" value="<?=$srh_order_date_from?>">
<input type="hidden" name="srh_order_date_to" value="<?=$srh_order_date_to?>">
<input type="hidden" name="srh_order_no" value="<?=$srh_order_no?>">
<input type="hidden" name="srh_process_type_id" value="<?=$srh_process_type_id?>">
<input type="hidden" name="srh_payment_method_id" value="<?=$srh_payment_method_id?>">
<input type="hidden" name="srh_delivery_method_id" value="<?=$srh_delivery_method_id?>">
<!-- Search Temp -->

<div id="edit">
        <? include("../include/edit_title.php")?>
        <div id="tool">
        	<a class="boldbuttons" href="javascript:form_action(1)"><span>Save</span></a>
			<a class="boldbuttons" href="javascript:go_back('<?=$prev_page?>', '<?=$list_page_num?>')"><span>Back</span></a>
            <a class="boldbuttons" href="../order/invoice.php?cart_id=<?=$id; ?>" target="_blank"><span>Invoice</span></a>
		</div>
		
		<div id="tabs">
			<ul>
				<li><a href="#tabs-1" onclick="$('#tab_curr').val(0)">Main</a></li>
				<? if (!empty($id)) { ?>
					<li><a href="#tabs-2" onclick="$('#tab_curr').val(1)">Billing / Shipping Information</a></li>
					<li><a href="#tabs-3" onclick="$('#tab_curr').val(2)">Payment Gateway Info</a></li>
				<? } ?>
			</ul>
			
			<div id="tabs-1"><? include("tab-main.php") ?></div>
			<? if (!empty($id)) { ?>
				<div id="tabs-2"><? include("tab-billing.php") ?></div>				
				<div id="tabs-3"><? include("tab-payment-gateway.php") ?></div>
			<? } ?>

		</div>
		<script>
			$('#tabs').tabs({ selected: <?=$tab?> });
		</script>		
        
        <div id="order"></div>
        <br class="clear">	
	</div>
</form>