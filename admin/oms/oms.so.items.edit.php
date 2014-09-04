<?
//***
	include("../include/tinymce_huge.php");

//*** Default
	$func_name = "Edit ERP Order Items";
	$curr_folder="oms";
	$tbl = "tbl_order_item";
	$prev_page = "oms.so.edit";
	$curr_page = "oms.so.items.edit";
	$action_page = "oms.so.items.act";
	
	


//*** Request
extract($_REQUEST);

if (empty($tab))
	$tab = 0;

if (!empty($id))	/////////Existing Order
{

	$sql = " select * from $tbl order_id = $id ";
	
	if ($rows = mysql_query($sql)){
		$num_rows = mysql_num_rows($result);	
		if ($num_rows <= 0 )
		{	echo "Order not exist";
			exit;
		}
		
	}
	
}else{		///////////Wrong Order
	echo "Order not exist";
	exit;
	/*$sql = " SELECT *, tosa.id AS shipping_address_id FROM tbl_order INNER JOIN tbl_order_shipping_address tosa ON tosa.order_id = tbl_order.id WHERE tbl_order.id = $order_id ";
	
	if ($rows = mysql_query($sql)){
		$existing_shipment = false;
	}
	
	$row = mysql_fetch_array($rows);*/

}



?>

<script>
function order_details_add_item(){

	fr = document.frm
	fr.action = "../oms/oms.so.items.act.php";
	fr.method = "POST";
	fr.target = "_self";
	fr.submit();

}

function order_details_delete_item(id,qty_ordered,item_sku){
	var result = confirm("Want to delete?");
	if (result==true) {
	if(qty_ordered=="")
		qty_ordered="0";
	fr = document.frm
	fr.action = "../oms/oms.so.items.act.php?item_edit_type=delete&item_id="+id+"&qty_ordered="+qty_ordered+"&item_sku="+item_sku;
	fr.method = "POST";
	fr.target = "_self";
	fr.submit();
	}else
		return false;
}

function form_save(){

	fr = document.frm;	
	fr.action = '../oms/oms.so.items.act.php?item_edit_type=update'
	fr.method = "POST";
	fr.target = "_self";
	fr.submit();

}

function form_back(){

	window.location = '../main/main.php?func_pg=oms.so.edit&id=<?=$id?>'			
	return

}
</script>

<form name="frm" enctype="multipart/form-data">
<input type="hidden" name="order_id" value="<?=$id?>">
<input type="hidden" name="order_no" value="<?=$order_no?>">
<input type="hidden" name="tbl" value="<?=$tbl?>">
<input type="hidden" name="act" value="<?=$action?>">
<input type="hidden" name="pg_num" value="<?=$pg_num?>">
<input type="hidden" name="tab" id="tab_curr" value="<?=$tab?>">
<input type="hidden" name="fid" value="1">

<!-- Search Temp -->
<input type="hidden" name="srh_order_date_from" value="<?=$srh_order_date_from?>">
<input type="hidden" name="srh_order_date_to" value="<?=$srh_order_date_to?>">
<!-- Search Temp -->

<div id="edit">

	<div id="title">
        <table>
            <tr>
                <th>Edit Order(<?=$order_no; ?>) Items 
				&nbsp;&nbsp;&nbsp;Currency:<?=get_field("tbl_order","order_currency_code",$id)?></th>
            </tr>			
        </table>
    </div>
    <div id="tool">       
        	<a class="boldbuttons" href="javascript:form_save()"><span>Save</span></a>
			<a class="boldbuttons" href="javascript:form_back()"><span>Back</span></a>	
	</div>

    <div id="tabs">
        <ul>
            <li><a href="#tabs-1" onclick="$('#tab_curr').val(0)">Main</a></li>           
        </ul>
        <div id="tabs-1">		
		<fieldset>
			<legend>Edit Items(Unship Items only) </legend>
			<div id="list">
				<table cellpadding="8">
				<tr>					
					<th>SKU</th>
					<th>Name</th>
					<th>Quantity</th>
					<th>Unit Price</th>
					<th>Subtotal</th>
					<th>Partial Shipped</th>
					<th>Delete Item</th>
				</tr>
				<?php
				$counting=0;				
					$get_item_sql = " SELECT * FROM tbl_order_item WHERE is_shipped=0 AND is_cancel_item=0 AND order_id = $id ";
					$get_item_rows = mysql_query($get_item_sql);					
					while($item_row = mysql_fetch_array($get_item_rows))
					{?>
						<tr>					
							<input type="hidden" name="cb_<?=$counting?>_id" value="<?=$item_row[id]?>" />
							<input type="hidden" name="cb_<?=$counting?>_sku" value="<?=$item_row[sku]?>" />
							<td><?=$item_row[sku]?></td>
							<td><?=$item_row[name]?></td>
							<? if($item_row[qty_ordered] != null){ ?>	
								<td><input type="text" name="cb_<?=$counting?>_qty" value="<?=round($item_row[qty_ordered])?>" disabled ></td>	
							<? }else{ ?>
								<td><input type="text" name="cb_<?=$counting?>_qty" ></td>
							<? } ?>
							<td><input type="text" name="cb_<?=$counting?>_unitprice" value="<?=$item_row[unit_price]?>" ></td>
							<td><?=$item_row[subtotal]?></td>	
							<td><input type="text" name="cb_<?=$counting?>_partialshippend" value="<?=($item_row[shipped_qty]>0?"Yes":"No")?>" disabled ></td>
							<td><input type="button" value="X" onclick="javascript: order_details_delete_item(<?=$item_row[id]; ?>, <?=round($item_row[qty_ordered]); ?>, '<?=$item_row[sku]; ?>'); " style="margin-right:10px; "></td>
						</tr>	
						
				<?	$counting++;} ?>
				<input type="hidden" name="cb_counting" value="<?=$counting?>" />
				</tr>				
				<tr style="background-color:#eee">
				<td align="left" colspan="7">
            	<? get_lookup("add_item_id", "../lookup/erp_product.php", '', '', "Product Lookup"); ?>
                <input type="button" value="Confirm Add" onclick="javascript: order_details_add_item();" />
				</td>				
				</tr>
				</table>
			</div>
		</fieldset>
		</div>        
    </div>
	<div id="tool">		
        	<a class="boldbuttons" href="javascript:form_save()"><span>Save</span></a>
			<a class="boldbuttons" href="javascript:form_back()"><span>Back</span></a>		
	</div>
    <script>
        $('#tabs').tabs({ selected: <?=$tab?> });
    </script>
</div>

</form>