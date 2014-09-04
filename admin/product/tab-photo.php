	<script>
	
		function form_photo_add(){
			fr = document.frm;
			fr.action = "../<?=$curr_folder?>/tab-photo-update.php";
			fr.method = "POST";
			fr.target = "_self";
			fr.submit();
		}
		
		function form_photo_edit(id){
			fr = document.frm
			fr.action = "../main/main.php?func_pg=<?=$curr_page?>&id=<?=$id?>&pg_num=<?=$pg_num?>&tab=<?=$tab?>&cat_id=<?=$cat_id?>&item_photo_id="+id+"#edit_photo";
			fr.method = "POST";
			fr.target = "_self";
			fr.submit();
		}	
		
		function form_photo_del(id){
			fr = document.frm
			ans = confirm("OK to delete?")
			if (ans){
				fr.action = "../<?=$curr_folder?>/tab-photo-delete.php?photo_id="+id;
				fr.method = "POST"
				fr.target = "_self";
				fr.submit();
			}
		}
		
		function form_photo_sort(photo_id, act){
			fr = document.frm
			fr.action = "../<?=$curr_folder?>/tab-photo-sort.php?photo_id="+photo_id+"&sort_act="+act;
			fr.method = "POST"
			fr.target = "_self";
			fr.submit();
		}
	
	</script>
	
	
	<fieldset>

		<legend><b>Photo List</b></legend>
		
		<? get_item_photo($tbl."_photo", $id); ?>
	
	</fieldset>
	
				
	<!-- Add Photo Start -->
	<a name="edit_photo"></a>
	<fieldset>

		<legend><b>Add Photo</b></legend>
	
		<? $item_photo_id = $_GET["item_photo_id"]; ?>
		<input type="hidden" name="item_photo_id" value="<?=$item_photo_id?>">
		
		<p><label>Photo:</label><input type="file" name="temp_item_photo_1"><input type="button" value="upload" onclick="form_photo_add();"></p>
		
		<p><label>&nbsp;</label><?=get_img($tbl."_photo", $item_photo_id, 1, "vie_crop");?>&nbsp;</p>
	
	</fieldset>
	<!-- Add Photo End -->


<?

function get_item_photo($tbl, $item_id){
 
	$sql = " select * from $tbl where parent_id ={$item_id} order by sort_no ";

	if ($result = mysql_query($sql)){
	
		?>
			<div id="product-photo">
				<table width="100%">
					<tr>
						<th align="center">Photo</th>
						<th align="center">Sort</th>
						<th align="center">Delete</th>
					</tr>			
					<?
                    
                    while ($row = mysql_fetch_array($result)){
                    
                    	?>
                        <tr>
                            <td align="center">
                                <?=get_img("tbl_product_photo", $row[id], 1, "thu_crop"); ?>
                            </td>
                            <td align="center">
                            <a href="javascript:form_photo_sort(<?=$row[id]?>, 1)"><img src="../images/up.png" width="25" border="0" title="sequence up"></a>
                            <a href="javascript:form_photo_sort(<?=$row[id]?>, 2)"><img src="../images/down.png" width="25" border="0" title="sequence down"></a>
                            </td>
                            <td align="center">
                            <input type="button" value="Delete" onclick="form_photo_del('<?=$row[id]?>')">
                            <!--<input type="button" value="Edit" onclick="form_photo_edit('<?=$row[id]?>')">-->
                            </td>
                        </tr>
                    	<?
                    
                    }
                    
                    ?>
				</table>				
			</div>			
		<?
	
	}else
		echo $sql;

}

?>