<script>

function order_details_add_item(){

	fr = document.frm
	fr.action = "../wms/stockin/wms.stockin.add-item.php";
	fr.method = "POST";
	fr.target = "_self";
	fr.submit();

}

function order_details_update_item(){

	fr = document.frm
	fr.action = "../wms/stockin/wms.stockin.update-item.php";
	fr.method = "POST";
	fr.target = "_self";
	fr.submit();

}

function order_details_delete_item(id){

	fr = document.frm
	fr.action = "../wms/stockin/wms.stockin.delete-item.php?item_id=" + id;
	fr.method = "POST";
	fr.target = "_self";
	fr.submit();

}

function form_save_stockin(){




	fr = document.frm;

	if(fr.supplier_inv_no.value == ""){
		window.alert("Please input supplier Invoice #!");
		return;
	}

	if(fr.supplier_id.value == 0){
		window.alert("Please select supplier!");
		return;
	}

	if(checkDuplicateBarcode()){
		fr.act.value = 1;
		//fr.action = "../wms/stockin/wms.stockin.save.php";
		fr.action = '../main/main.php?func_pg=wms.stockin.act'
		fr.method = "POST";
		fr.target = "_self";
		fr.submit();
	}
}

function form_delete_stockin(){

	if (confirm("Ok to delete?"))
	{
		fr = document.frm;
		fr.act.value = 4;
		//fr.action = "../wms/stockin/wms.stockin.save.php";
		fr.action = '../main/main.php?func_pg=wms.stockin.act'
		fr.method = "POST";
		fr.target = "_self";
		fr.submit();
	}

}

function checkDuplicateBarcode() {
	var form = document.getElementById("frm");

	// Start by looping through each text element one by one
	for (i = 0; i < form.elements.length; i++) {

		// For each element, check if it is a text box element
		if (form.elements[i].type == "text" && form.elements[i].name.match(/row_MD_Barcode_.*/)) {

			// If so, get its value
			var text1 = form.elements[i].value;
			
			// now loop through remaining elements, checking if they are text and get their value
			for (j = i + 1; j < form.elements.length; j++) {
				if (form.elements[j].type == "text" && form.elements[j].name.match(/row_MD_Barcode_.*/)) {

					var text2 = form.elements[j].value;
//window.alert(form.elements[i].name + ": " text1 + "<br/> " + form.elements[j].name  + ": " +text2);		
					// If the value being compared is equal to any other text elements, show an alert
					if (text1 == text2 && text1 != "") {
						window.alert("Duplicate input found! MD Barcode: " + text1);
return false;
					}
				}
			}
		}
	}
return true;
}
</script>

<?
$tbl 			= "tbl_stockin";
$func_name		= "Stock In";
$prev_page 		= "wms.stockin.list";
?>

<?
if(!empty($_GET["error_msg"])){
?>

<div style=" font-size:20px; color:red;">
Error found while saving the order: <br/>
<?=$_GET["error_msg"];?>
</div>

<?}?>

<div id="order-details">
	<? 
	   $id = $_GET["id"];
	   $sql = " select * from tbl_stockin where id={$id} ";
	
	   if ( $result = mysql_query($sql)){
		$row = mysql_fetch_array($result);
	   }
	?>

	<form name="frm" enctype="multipart/form-data" id="frm">
<div id="edit">
	<? include("../include/edit_title.php")?>
        <div id="tool">
		<a class="boldbuttons" href="javascript:form_save_stockin();" ><span>Save</span></a>
		<? if ($_SESSION["sys_delete"]) { ?>

			<a class="boldbuttons" href="javascript:form_delete_stockin();"><span>Delete</span></a>

        <? } ?>
			<a class="boldbuttons" href="javascript:go_back('<?=$prev_page?>', '<?=$list_page_num?>')"><span>Back</span></a>
	</div>

	<input type="hidden" name="act" value="">
	<input type="hidden" name="tbl" value="<?=$tbl?>">
	<input type="hidden" name="del_id" value="<?=$_GET["id"]?>">
	<!--<input type="hidden" name="supplier_id" value="<?=$row["supplier_id"]?>">-->
	<table>
	<tr>
		<td align="left" width="10%">Invoice #:</td>
		<td align="left" width="40%"><input type="text" name="supplier_inv_no" value="<?=$row[supplier_inv_no]?>">
		</td>
		<td align="left" width="10%">Supplier:</td>
		<td>
		<select name="supplier_id" style="width:200px;" id="supplier_id">
                <option value=""> -- </option>
		<?=get_combobox_src('tbl_supplier', 'name', $row[supplier_id], " sort_no asc ")?>  
		</select>
		</td>
		</td>
	</tr>
	</table>
</div>

		<?
		
		function get_item_list($stockin_id){
			

			
			$sql = " select * from tbl_stockin_item where stockin_id={$stockin_id} and deleted = 0 and active = 1  order by product_id,sort_no asc ";
			
			if ( $result = mysql_query($sql)){
			  
			  $last_product_id = '';

			  while ($row = mysql_fetch_array($result)){
				
				if($last_product_id <> $row[product_id]){
					if($last_product_id <> ''){
		?>
        		<tr style="background-color:#eee">
        		<td colspan="7">

            		</td>
          		<td align="right"></td>
        		</tr>
	
	
			</table>	
		<?			}?>	
		<?		
					$last_product_id = $row[product_id];
		?>

			<table>
				<tr>
					<td>SKU#: </td>
					<td  colspan="4"><?=get_field("tbl_erp_product","sku",$row[product_id]) ?></td>						</tr>
				<tr>
					<td>Product Name: </td>
					<td  colspan="4"><?=get_field("tbl_erp_product","name",$row[product_id]) ?></td>						</tr>

		<?		}?>



				
			<tr>

			<td>IMEI: </td>
			<td align="center">
				<input type="text" name="row_IMEI_<?=$row[id]; ?>" value="<?=$row[IMEI]; ?>" style="width: 350px;" <? if($row[shipped] ==1){ ?> readonly <?}?>/>
			</td>

			<td>MD Barcode: </td>
			<td align="center">
				<input type="text" name="row_MD_Barcode_<?=$row[id]; ?>" value="<?=$row[MD_Barcode]; ?>" style="width: 350px;" <? if($row[shipped] ==1){ ?> readonly <?}?> />
			</td>
			<td>Cost: </td>
			<td align="center">
				<input type="text" name="row_cost_<?=$row[id]; ?>" value="<?=$row[cost]; ?>" style="width: 100px;" <? if($row[shipped] ==1){ ?> readonly <?}?> />
			</td>
                        <td align="center" style="width: 100px;">

<? if($row[shipped] ==0){ ?>			
						<input type="button" value="X" onclick="javascript: order_details_delete_item(<?=$row[id]; ?>); " style="margin-right:10px; ">
<? }else{ ?>
Shipped
<?}?>
</td>




			
			</tr>
				  
			<?
			
			  }
			
			}else
				echo $sql;
				
		} //function get_item_list($po_id){
		//$id = $_GET["id"];			
		get_item_list($id);
		?>
        <tr style="background-color:#eee">
        	<td colspan="7">
            	<? get_lookup("add_item_id", "../lookup/erp_product.php", '', '', "Product Lookup"); ?>
                <input type="button" value="Add" onclick="javascript: order_details_add_item();" />
            </td>
          <td align="right"></td>
        </tr>
	
	
	</table>


   <input type="hidden" name="id" value="<?=$id?>">

   
</form>

	</div>
</div>
