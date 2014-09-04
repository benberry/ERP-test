<?
//***
	include("../include/tinymce_huge.php");

//*** Default
	$func_name = "Add ERP Order Shipment";
	$curr_folder="oms";
	$tbl = "tbl_order_shipment";
	$prev_page = "oms.so.edit";
	$curr_page = "oms.shipments.add";
	$action_page = "oms.shipments.act";
	
	


//*** Request
extract($_REQUEST);

if (empty($tab))
	$tab = 0;

$existing_shipment = false;

if (!empty($id))	/////////Existing Shipment
{

	$sql = " select *, tosa.id AS shipping_address_id from tbl_order_shipment tos INNER JOIN tbl_order_shipping_address tosa ON tosa.id = tos.shipping_address_id where tos.id = $id ";
	
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
		

		if (act == '1')	//Current Test
		{
			fr.action = '../main/main.php?func_pg=<?=$action_page?>&order_id=<?=$order_id?>'
			
			fr.method = 'post';
			fr.target = '_self';
			fr.submit();
		}

		if (act == '2')	//back
		{
			window.location = '../main/main.php?func_pg=<?=$prev_page?>&id=<?=$order_id?>'
			
			return
			
		}

		if (act == '3')
		{
			fr.deleted.value = 1;
			
			fr.action = '../main/main.php?func_pg=<?=$action_page?>'
			fr.method = 'post';
			fr.target = '_self';
			fr.submit();
			
		}
		
		if (act == '4')	//add
		{
			
			if (fr.id.value=='')
				fr.active[0].checked = true;
		
			fr.action = '../main/main.php?func_pg=<?=$action_page?>'
			fr.method = 'post';
			fr.target = '_self';
			
			//your before submit logic
			//var item1 = "";
			var title = "";
			var qty = "";
			var price = "";
			var Curr = "";
			for(i=1;i<=k;i++)
			{	title = $("#titleEd"+i).val();
				qty = $("#qtyEd"+i).val();
				price = $("#priceEd"+i).val();
				Curr = $("#currEd"+i).val();
				//item1 += qty+"--";
				/////Update Bulk update form value///////
				 $("#new_shipment #btitleid"+i).val(title);
				 $("#new_shipment #bqtyid"+i).val(qty);
				 $("#new_shipment #bpriceid"+i).val(price);
				 $("#new_shipment #bcurrid"+i).val(Curr);
			}
			
			fr.submit();
		
		}	
	
	}

</script>

<form name="frm" id="new_shipment" enctype="multipart/form-data">
<input type="hidden" name="order_id" value="<?=$order_id?>">
<input type="hidden" name="order_no" value="<?=$row[order_no]?>">
<input type="hidden" name="shipping_address_id" value="<?=$row[shipping_address_id]?>">
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
                <!--<td>Last modify date:</td>
                <td><?=$row[modify_date]; ?></td>
                <td>Create date:</td>
                <td><?=$row[create_date]; ?></td>-->
            </tr>
            <tr>
              <!--  <td>Last modify by:</td>
                <td><?=get_sys_user($row[modify_by])?></td>
                <td>Create by:</td>
                <td><?=get_sys_user($row[create_by])?></td> -->
            </tr>            
        </table>
    </div>
    <div id="tool">
        <? if(!$existing_shipment){ ?>
        	<a class="boldbuttons" href="javascript:form_action(1)"><span>Add</span></a>
			<a class="boldbuttons" href="javascript:form_action(2)"><span>Back</span></a>
		<? }else{ ?>
			<a class="boldbuttons" href="javascript:form_action(1)"><span>Edit</span></a>
			<a class="boldbuttons" href="javascript:form_action(2)"><span>Back</span></a>
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
					<td>Carrier:</td><td><input type="text" name="carrier_title" ></td>
					<td>Carrier Code:</td><td><input type="text" name="carrier_code" ></td>
					<td>Tracking Number:</td><td><input type="text" name="tracking_no" ></td>
				<? }else{ ?>
					<td>Carrier:</td><td><input type="text" name="carrier_title" value="<?=$row[carrier_title]?>" disabled></td>
					<td>Carrier Code:</td><td><input type="text" name="carrier_code" value="<?=$row[carrier_code]?>" disabled></td>
					<td>Tracking Number:</td><td><input type="text" name="tracking_no" value="<?=$row[tracking_no]?>" disabled></td>
					
				
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
					<th>IMEI:</th>
					<th>MD-Barcode:</th>
				</tr>
				<?php
				$counting=0;
				if(!$existing_shipment){
					$get_ship_item_sql = " SELECT * FROM tbl_order_item WHERE is_shipped=0 AND order_id = $order_id ";
					$get_ship_item_rows = mysql_query($get_ship_item_sql);					
					while($item_row = mysql_fetch_array($get_ship_item_rows))
					{
						if($item_row[is_shipped] != 0)
							continue;
							
						$qty_ordered = $item_row[qty_ordered];
						$shipped_qty = $item_row[shipped_qty];
						$count_qty_ordered = $qty_ordered - $shipped_qty;
						for($count_qty = 0; $count_qty< $count_qty_ordered; $count_qty++)
						{
							echo "<tr>
									<td width=\"50\" valign=\"top\"><input type=\"checkbox\" name=\"cb_".$counting."\" value=\"".$item_row[main_sku]."\"> <input type=\"hidden\" name=\"cb_".$counting."_is_option\" value=\"".$item_row[is_option]."\"> </td>
									<td>".$item_row[sku]."<input type=\"hidden\" name=\"cb_".$counting."_sku\" value=\"".$item_row[sku]."\" /></td>
									<td>".$item_row[name]."<input type=\"hidden\" name=\"cb_".$counting."_name\" value=\"".$item_row[name]."\" /></td>
									<td><input type=\"text\" name=\"cb_".$counting."_imei\" name=\"IMEI\" ></td>
									<td><input type=\"text\" name=\"cb_".$counting."_mdbarcode\" name=\"mdbarcode\" ></td>
								</tr>";	
								
							
							$counting++;
						}					
					}
				}else{
					$get_ship_item_sql = " SELECT * FROM tbl_order_shipment_item WHERE shipment_id = $id ";
					$get_ship_item_rows = mysql_query($get_ship_item_sql);					
					while($item_row = mysql_fetch_array($get_ship_item_rows))
					{
						echo "<tr>					
									<input type=\"hidden\" name=\"cb_".$counting."_id\" value=\"".$item_row['id']."\" />
									<td>".$item_row[sku]."<input type=\"hidden\" name=\"cb_".$counting."_sku\" value=\"".$item_row[sku]."\" /></td>
									<td>".$item_row[name]."<input type=\"hidden\" name=\"cb_".$counting."_name\" value=\"".$item_row[name]."\" /></td>
									<td><input type=\"text\" name=\"cb_".$counting."_imei\" name=\"IMEI\" value=\"$item_row[imei]\" ></td>
									<td><input type=\"text\" name=\"cb_".$counting."_mdbarcode\" value=\"$item_row[mdbarcode]\" name=\"mdbarcode\" ></td>
							</tr>";	
						$counting++;
					}
				}
				
				?>
				<input type="hidden" name="cb_counting" value="<?=$counting?>" />
				</table>
			</div>
		</fieldset>
		</div>        
    </div>
	<div id="tool">
		<? if(!$existing_shipment){ ?>
        	<a class="boldbuttons" href="javascript:form_action(1)"><span>Add</span></a>
			<a class="boldbuttons" href="javascript:form_action(2)"><span>Back</span></a>
		<? }else{ ?>
			<a class="boldbuttons" href="javascript:form_action(1)"><span>Edit</span></a>
			<a class="boldbuttons" href="javascript:form_action(2)"><span>Back</span></a>
		<? } ?>
	</div>
    <script>
        $('#tabs').tabs({ selected: <?=$tab?> });
    </script>
</div>

</form>