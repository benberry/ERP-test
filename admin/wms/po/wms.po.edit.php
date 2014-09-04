<script>

function order_details_add_item(){

	fr = document.frm
	fr.action = "../wms/po/wms.po.add-item.php";
	fr.method = "POST";
	fr.target = "_self";
	fr.submit();

}

function order_details_update_item(){

	fr = document.frm
	fr.action = "../wms/po/wms.po.update-item.php";
	fr.method = "POST";
	fr.target = "_self";
	fr.submit();

}

function order_details_delete_item(id){

	fr = document.frm
	fr.action = "../wms/po/wms.po.delete-item.php?item_id=" + id;
	fr.method = "POST";
	fr.target = "_self";
	fr.submit();

}

function form_save_po(){

	fr = document.frm;
	fr.act.value = 1;
	//fr.action = "../wms/po/wms.po.save.php";
	fr.action = '../main/main.php?func_pg=wms.po.act'
	fr.method = "POST";
	fr.target = "_self";
	fr.submit();

}

function form_delete_po(){

	if (confirm("Ok to delete?"))
	{
		fr = document.frm;
		fr.act.value = 4;
		//fr.action = "../wms/po/wms.po.save.php";
		fr.action = '../main/main.php?func_pg=wms.po.act'
		fr.method = "POST";
		fr.target = "_self";
		fr.submit();
	}

}

</script>
 
<?
$tbl 			= "tbl_po";
$func_name		= "PO";
$prev_page = "wms.po.list";
$action_page 		= "wms.po.act";
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
	   $sql = " select * from tbl_po where id={$id}";
	
	   if ( $result = mysql_query($sql)){
		$row = mysql_fetch_array($result);
	   }
	?>
	
	<form name="frm" enctype="multipart/form-data">
<div id="edit">
	<? include("../include/edit_title.php")?>
        <div id="tool">
		<a class="boldbuttons" href="javascript:form_save_po();" ><span>Save</span></a>
		<? if ($_SESSION["sys_delete"]) { ?>

			<a class="boldbuttons" href="javascript:form_delete_po();"><span>Delete</span></a>

        <? } ?>
	<a class="boldbuttons" href="javascript:go_back('<?=$prev_page?>', '<?=$list_page_num?>')"><span>Back</span></a>	
</div>

	<input type="hidden" name="act" value="">
	<input type="hidden" name="tbl" value="<?=$tbl?>">
	<input type="hidden" name="po_no" value="<?=$row[po_no]?>">
	<input type="hidden" name="del_id" value="<?=$_GET["id"]?>">
	<table>
	<tr>
		<td align="left" width=20%>PO NO:</td>
		<td><?=$row[po_no];?>
		</td>
	</tr>
	<tr>
		<td align="left" width=20%>Shipping Company:</td>
		<td>
		<select name="supplier_id" style="width:200px;" id="supplier_id">
                <option value=""> -- </option>
		<?=get_combobox_src('tbl_supplier', 'name', $row[supplier_id], " sort_no asc ")?>  
		</select>
		</td>
	</tr>
	</table>
</div>
	<table>
		<tr>
			<th>SKU</th>
			<th>Name</th>
			<th>QTY</th>
			<th>Cost</th>
			<th>Subtotal</th>
			<th></th>
            <th></th>
		</tr>
		<?
		
		function get_item_list($po_id){
			

			
			$sql = " select * from tbl_po_item where po_id={$po_id} and deleted = 0 and active = 1 order by sort_no asc ";
			
			if ( $result = mysql_query($sql)){
			  
			  while ($row = mysql_fetch_array($result)){

				  ?>
				  
				  <tr>


			<td align="center"><?=get_field("tbl_erp_product", "sku", $row[product_id]);?></td>
					<td align="center">
						<div style="font-size:14px;"><?=get_field("tbl_erp_product", "name", $row[product_id]); ?></div>
					</td>
			<td align="center">
                        <input type="text" name="row_qty_<?=$row[id]; ?>" value="<?=$row[qty]; ?>" style="width: 100px;" />
					</td>
			<td align="center">
                        <input type="text" name="row_cost_<?=$row[id]; ?>" value="<?=$row[cost]; ?>" style="width: 100px;" />
					</td>                 
					<td align="right" style="padding-right: 20px;">
						<?=number_format( $row[cost] *$row[qty], 2); ?>
					</td>
                    <td align="right">
						<input type="button" value="X" onclick="javascript: order_details_delete_item(<?=$row[id]; ?>); " style="margin-right:10px; ">
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

	<div id="order-summary">
		<?			
			## total amount	
				$total_amount = number_format(get_po_total_amount($id), 2);
	
		?>

        <table style="float:right; width:600px; border: 0px solid #eee; ">           
            <tr>
                <td align="left"><b>Total Amount: </b></td>
                <td align="right" style="padding-right: 50px"><b><?=$total_amount; ?></b></td>
            </tr>                        
   </table>
   <input type="hidden" name="id" value="<?=$id?>">

   
</form>

	</div>
</div>

