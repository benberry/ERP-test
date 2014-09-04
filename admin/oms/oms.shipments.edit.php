<?

//*** Default
	$func_name = "Edit ERP Order Shipment";
	$curr_folder="oms";
	$tbl = "tbl_order_shipment";
	//$prev_page = "oms.so.edit";
	$curr_page = "oms.shipments.edit";
	$list_page = "oms.shipments.list";
	$action_page = "oms.shipments.act";
	
	


//*** Request
extract($_REQUEST);

if (empty($tab))
	$tab = 0;

$existing_shipment = false;

if (!empty($id))	/////////Existing Shipment
{

	$sql = " select *, tosa.id AS shipping_address_id, tos.id AS shipment_id from tbl_order_shipment tos INNER JOIN tbl_order_shipping_address tosa ON tosa.id = tos.shipping_address_id where tos.id = $id ";
	
	if ($rows = mysql_query($sql)){
		$existing_shipment = true;
	}
	
	$row = mysql_fetch_array($rows);
	
}else{		///////////New Shipment

	$sql = " SELECT *, tosa.id AS shipping_address_id FROM tbl_order INNER JOIN tbl_order_shipping_address tosa ON tosa.order_id = tbl_order.id WHERE tbl_order.id = $order_id ";
	
	if ($rows = mysql_query($sql)){
		$existing_shipment = false;
	}
	
	$row = mysql_fetch_array($rows);

}



?>

<script>

	function form_action(act)
	{

		fr = document.frm
		
		fr.act.value = act;
		

		if (act == '1')	//Add new shipment
		{
			if($("input[name=tracking_no]").val() == "")
			{ alert("Tracking Number cannot blank");
			  return false;
			}
			fr.action = '../main/main.php?func_pg=<?=$action_page?>&order_id=<?=$order_id?>';		
			fr.method = 'post';
			fr.target = '_self';
			fr.submit();
		}

		if (act == '2')	//back to order detail page
		{
			window.location = '../main/main.php?func_pg=<?=$prev_page?>&id=<?=$order_id?>';
			
			return
			
		}

		if (act == '3')////Edit shipment
		{
			fr.action = '../main/main.php?func_pg=<?=$action_page?>&id=<?=$id?>'
			
			fr.method = 'post';
			fr.target = '_self';
			fr.submit();
			
		}
		
		if (act == '4')////Back to shipment lists
		{
			if("<?=$prev_page?>" == "oms.so.edit")
			{	window.location = '../main/main.php?func_pg=<?=$prev_page?>&id=<?=$row[order_id]?>';
				
			}else{
				fr.action = '../main/main.php?func_pg=<?=$list_page?>'
				
				fr.method = 'post';
				fr.target = '_self';
				fr.submit();				
			}
			
		}			
	}
	
	function check_md(counting)
	{	var mdbarcode ="";
		var if_all_available=true;
		for(i = 0; i < counting; i++)
		{	mdbarcode = $("input[name=cb_"+i+"_mdbarcode]").val();	
			if($("input[name=shipment_type]").val() == "add"){	////////////in Add new shipment	
				if($("#cb_"+i).is(":checked")){	////find Checked Row					
					if(mdbarcode != ""){  /////////if MD BARCODE NOT BLANK						
						$.ajax({
							url: '../oms/check_shipment_items_ajax.php',
							type: 'POST',
							data: { 
								mdbarcode: mdbarcode, 
								ctype: "check" 
							},
							success: function (result) {
							//alert(msg);
							var msg = result.split(' -- ');
							$( "#cb_"+i+"_duoblecheck" ).html(msg[0]);
								if(msg[0] != "Available"){
									if_all_available = false;
									$("input[name=cb_"+i+"_stockin_id]").val("");
								}else
									$("input[name=cb_"+i+"_stockin_id]").val(msg[1]);
							},
							error: function () {
								$( "#cb_"+i+"_duoblecheck" ).html("Uh oh, something went wrong"); 
							},
							async: false
						});						
					}else
						$( "#cb_"+i+"_duoblecheck" ).html("Skip");
				}
			}else{	////////////in Edit shipment
				if(!$("input[name=cb_"+i+"_mdbarcode]").prop('disabled')){	///Check Enable MDBARCODE
					if(mdbarcode != ""){  /////////if MD BARCODE NOT BLANK	
						$.ajax({
							url: '../oms/check_shipment_items_ajax.php',
							type: 'POST',
							data: { 
								mdbarcode: mdbarcode, 
								ctype: "check" 
							},
							success: function (result) {
							//alert(msg);
							var msg = result.split(' -- ');
							$( "#cb_"+i+"_duoblecheck" ).html(msg[0]);
								if(msg[0] != "Available"){
									if_all_available = false;
									$("input[name=cb_"+i+"_stockin_id]").val("");
								}else
									$("input[name=cb_"+i+"_stockin_id]").val(msg[1]);
							},
							error: function () {
								$( "#cb_"+i+"_duoblecheck" ).html("Uh oh, something went wrong"); 
							},
							async: false
						});	
					}
				}
			}				
		}			
			
		if(if_all_available==true){
			$(".addoredit").show();			
		}else{
			$(".addoredit").hide();
		}
		//$( "#cb_1_duoblecheck" ).html("New mdbarcode:"+mdbarcode);	
		
	}
	
	function release_item(row_num)
	{
		var r = confirm("Confirm to release the MD-Barcode!");
		if (r == true) {
			var mdbarcode="";
			mdbarcode = $("input[name=cb_"+row_num+"_mdbarcode]").val();
			$("input[name=cb_"+row_num+"_mdbarcode]").prop('disabled', false);
			$("input[name=cb_"+row_num+"_mdbarcode]").val("");
			$( "#cb_"+row_num+"_duoblecheck" ).html("Un-check");
			//////////////////////Release MD BARCODE///////////////////////
						$.ajax({
							url: '../oms/check_shipment_items_ajax.php',
							type: 'POST',
							data: { 
								mdbarcode: mdbarcode, 
								ctype: "release" 
							},
							success: function (result) {							
								$("input[name=cb_"+row_num+"_stockin_id]").val(result);
							},
							error: function () {
								$( "#cb_"+row_num+"_duoblecheck" ).html("Uh oh, something went wrong"); 
							},
							async: false
						});			
		} else {
			return false;
		}
	
	
	}

</script>

<form name="frm" id="new_shipment" enctype="multipart/form-data">
<input type="hidden" name="order_id" value="<?=$order_id?>">
<input type="hidden" name="order_no" value="<?=$row[order_no]?>">
<input type="hidden" name="magento_order_id" value="<?=$row[magento_order_id]?>">
<input type="hidden" name="shipping_address_id" value="<?=$row[shipping_address_id]?>">
<input type="hidden" name="shipment_id" value="<?=$row[shipment_id]?>">
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
                <th rowspan="2">Order Shipment for Order <?=$row[order_no]; ?></th>
				<? if($existing_shipment){ ?>
                <td>Last modify date:</td>
                <td><?=$row[modify_date]; ?></td>
                <td>Create date:</td>
                <td><?=$row[create_date]; ?></td>
				<? } ?>
            </tr>
			<? if($existing_shipment){ ?>
            <tr>
				<td>Last modify by:</td>
                <td><?=get_sys_user($row[modify_by])?></td>
                <td>Create by:</td>
                <td><?=get_sys_user($row[create_by])?></td>
            </tr>       
			<? } ?>
        </table>
    </div>
    <div id="tool">
        <? if(!$existing_shipment){ ?>
        	<a class="boldbuttons addoredit" style="display:none" href="javascript:form_action(1)"><span>Add</span></a>
			<a class="boldbuttons" href="javascript:form_action(2)"><span>Back</span></a>
		<? }else{ ?>
			<a class="boldbuttons addoredit" style="display:none" href="javascript:form_action(3)"><span>Edit</span></a>
			<a class="boldbuttons" href="javascript:form_action(4)"><span>Back</span></a>
		<? } ?>
	</div>

    <div id="tabs">
        <ul>
            <li><a href="#tabs-1" onclick="$('#tab_curr').val(0)">Main</a></li>     
        </ul>
        <div id="tabs-1">
		<fieldset>
			<legend>Shipping Address</legend>
			<div style="float:left;">
				<p><label>First Name:</label><?=$row[first_name]; ?></p>
				
				<p><label>Last Name:</label><?=$row[last_name]; ?></p>
				
				<p><label>Company:</label><?=$row[company]; ?>&nbsp;</p>
				
				<p><label>Street:</label><?=$row[street]; ?></p>
				
				<p><label>City:</label><?=$row[city]; ?></p>
				
				<p><label>State/Province:</label><?=$row[region]; ?></p>
				
				<p><label>Country:</label><?=$row[country]; ?></p>
				
				<p><label>Postal Code:</label><?=$row[post_code]; ?></p>
				
				<p><label>Telephone:</label><?=$row[telephone]; ?></p>
				
			</div>
		</fieldset>
		<fieldset>
			<legend>Shipment Information</legend>
			<div style="float:left;">
				<table>				
				<tr>
				<? if(!$existing_shipment){ ?>
					<td>Carrier:</td><td>
					<select name="carrier_id">
					<?=get_combobox_src('tbl_carrier', 'name', '0')?>  
					</select></td>					
					<td>Tracking Number:</td><td><input type="text" name="tracking_no" /></td>
					<td><input type="hidden" name="shipment_type" value="add" /></td>
				<? }else{ ?>
					<td>Carrier:</td><td><input type="text" name="carrier_title" value="<?=get_field('tbl_carrier','name',$row[carrier_id])?>" disabled></td>
					<td>Tracking Number:</td><td><input type="text" name="tracking_no" value="<?=$row[tracking_no]?>" disabled /></td>
					<td><input type="hidden" name="shipment_type" value="edit" /></td>
				
				<? } ?>
				</tr>				
				</table>
			</div>
			<br class="clear" />
			<div id="list">
				<table cellpadding="8">
				<tr>
					<? if(!$existing_shipment){ ?>
					<th width="50"><input type="checkbox" name="select_all" onclick="checkbox_select_all(100)"></th>
					<? } ?>
					<th>SKU:</th>
					<th>Name:</th>
					<th>MD-Barcode:</th>
					<th>Double Check:</th>
				</tr>
				<?php
				$counting=0;
				if(!$existing_shipment){	////add new shipment
					$get_ship_item_sql = " SELECT * FROM tbl_order_item WHERE is_shipped=0 AND is_cancel_item=0 AND order_id = $order_id ";
					$get_ship_item_rows = mysql_query($get_ship_item_sql);					
					while($item_row = mysql_fetch_array($get_ship_item_rows))
					{						
						$qty_ordered = $item_row[qty_ordered];
						$shipped_qty = $item_row[shipped_qty];
						$count_qty_ordered = $qty_ordered - $shipped_qty;
						for($count_qty = 0; $count_qty< $count_qty_ordered; $count_qty++)
						{
							echo "<tr>
									<td width=\"50\" valign=\"top\">
									<input type=\"checkbox\" id=\"cb_".$counting."\" name=\"cb_".$counting."\" value=\"".$item_row[main_sku]."\">
									<input type=\"hidden\" name=\"cb_".$counting."_is_option\" value=\"".$item_row[is_option]."\">
									<input type=\"hidden\" name=\"cb_".$counting."_stockin_id\" >
									</td>
									<td>".$item_row[sku]."<input type=\"hidden\" name=\"cb_".$counting."_sku\" value=\"".$item_row[sku]."\" /></td>
									<td>".$item_row[name]."<input type=\"hidden\" name=\"cb_".$counting."_name\" value=\"".$item_row[name]."\" /></td>
									<td><input type=\"text\" name=\"cb_".$counting."_mdbarcode\" ></td>
									<td><div id=\"cb_".$counting."_duoblecheck\">Un-check</div></td>
								</tr>";	
								
							
							$counting++;
						}					
					}
				}else{		////edit shipment
					$get_ship_item_sql = " SELECT * FROM tbl_order_shipment_item WHERE shipment_id = $id ";
					$get_ship_item_rows = mysql_query($get_ship_item_sql);					
					while($item_row = mysql_fetch_array($get_ship_item_rows))
					{
						echo '<tr>					
									<input type="hidden" name="cb_'.$counting.'_id" value="'.$item_row[id].'" />
									<td>'.$item_row[sku].'<input type="hidden" name="cb_'.$counting.'_sku" value="'.$item_row[sku].'" /></td>
									<td>'.$item_row[name].'<input type="hidden" name="cb_'.$counting.'_name" value="'.$item_row[name].'" /></td>';
						if($item_row[mdbarcode] == "" || $item_row[mdbarcode] == null){
							echo 
								'<td><input type="text" name="cb_'.$counting.'_mdbarcode" ></td>
								<td><div id="cb_'.$counting.'_duoblecheck">Un-check</div></td>';
						}else{	
							echo
								'<td><input type="text" name="cb_'.$counting.'_mdbarcode" value="'.$item_row[mdbarcode].'" disabled ></td>
								<td><div id="cb_'.$counting.'_duoblecheck">Release<input type="button" value="X" onclick="javascript: release_item('.$counting.'); " style="margin-right:10px;" ><input type="hidden" name="cb_'.$counting.'_skip" value="skip" /></div></td>';
						}
						echo '</tr>';	
						$counting++;
					}
				}
				
				?>
				<input type="hidden" name="cb_counting" value="<?=$counting?>" />				
				</table>
				<a class="boldbuttons" href="javascript:check_md(<?=$counting?>)"><span>Double Check</span></a>
				<!--<input type="button" onclick="check_md(9)" value="Double Check"  />-->
			</div>
		</fieldset>
		</div>        
    </div>
	<div id="tool">
		<? if(!$existing_shipment){ ?>
        	<a class="boldbuttons addoredit" style="display:none" href="javascript:form_action(1)"><span>Add</span></a>
			<a class="boldbuttons" href="javascript:form_action(2)"><span>Back</span></a>
		<? }else{ ?>
			<a class="boldbuttons addoredit" style="display:none" href="javascript:form_action(3)"><span>Edit</span></a>
			<a class="boldbuttons" href="javascript:form_action(4)"><span>Back</span></a>
		<? } ?>
	</div>
    <script>
        $('#tabs').tabs({ selected: <?=$tab?> });
    </script>
</div>

</form>