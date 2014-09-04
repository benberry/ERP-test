<script>
	function form_relate_item_add(){
		fr = document.frm
		fr.action = "../<?=$curr_folder?>/tab-relate-item-update.php";
		fr.method = "POST";
		fr.target = "_self";
		fr.submit();

	}
	
	function form_relate_item_del(id){
		fr = document.frm
		ans = confirm("OK to delete?")
		if (ans){
			fr.action = "../<?=$curr_folder?>/tab-relate-item-delete.php?del_relate_item_id="+id;
			fr.method = "POST"
			fr.target = "_self";
			fr.submit();

		}
	}
	
	function form_relate_item_sort(photo_id, act){
		fr = document.frm
		fr.action = "../<?=$curr_folder?>/tab-relate-item-sort.php?photo_id="+photo_id+"&sort_act="+act;
		fr.method = "POST"
		fr.target = "_self";
		fr.submit();

	}

</script>

<fieldset class="inner_list">
	<legend><b>Related Items</b></legend>
	<? get_related_item($id); ?>

</fieldset>

<? if ($_SESSION["sys_write"]) { ?>
<fieldset>

	<legend>Add Related Item</legend>
	
	<p><label>Product:</label><?=get_lookup("relate_item_id", "../lookup/product.php", 0, '', "Product Lookup"); ?></p>
	<p><label>&nbsp;</label><input type="button" value="ADD" onclick="javascript:form_relate_item_add();"></p>
	
</fieldset>
<? } ?>


<?

function get_related_item($pid){

?>
	<table width="100%">
	
		<tr bgcolor="#333333">

			<th width="100">Photo</td>
					
			<th width="100">Category</td>
			
			<th width="100">Product</td>
            
			<th width="100">Model</td>            
            
            <th width="100"></td>
			
            <th width="100"></td>
			
		</tr>
        
        <?
        
		$sql = " select * from tbl_product_relate_item where parent_id={$pid} order by sort_no";
		
		if ($result = mysql_query($sql)){
		
			if (mysql_num_rows($result) > 0){
		
				while ($row = mysql_fetch_array($result)){

					?>
					<tr>
						<td align="center"><?=get_prod_img_first($row[item_id], "icon"); ?></td>

						<td align="center"><?=get_field("tbl_product_category", "name_1", get_field("tbl_product", "cat_id", $row[item_id]))?></td>						
						<td align="center"><?=get_field("tbl_product", "name_1", $row[item_id])?></td>
                		<td align="center"><?=get_field("tbl_product", "model", $row[item_id])?></td>
						<td align="center">
							<? if ($_SESSION["sys_write"]) { ?>
							<a href="javascript:form_relate_item_sort(<?=$row[id]?>, 1)"><img src="../images/up.png" width="25" border="0" title="sequence up"></a>
							<a href="javascript:form_relate_item_sort(<?=$row[id]?>, 2)"><img src="../images/down.png" width="25" border="0" title="sequence down"></a>
							<? } ?>
						</td>
						<td align="center">
							<? if ($_SESSION["sys_write"]) { ?>
								<input type="button" value="Remove" onclick="form_relate_item_del('<?=$row[id]?>')">
							<? } ?>				
						</td>
					</tr>
					<?

				}

			}else{
			
				?>
				<tr>
					<td>No Records</td>
				</tr>
				<?
        	}
		}
		
		?>
	
	</table>
	
	<?

}

?>