<?
### Default
	$func_name = "Category";
	$tbl = "tbl_product_category";
	$prev_page = "index";
	$curr_page = "cat-edit";
	$action_page = "cat-update";


### Request
	extract($_REQUEST);
$tab = $_REQUEST['tab'];
if (empty($tab))
	$tab=0;
    
	if (!empty($id)){

		$sql = " select * from $tbl where id = $id ";
		
		if ($rows = mysql_query($sql)){

			$row = mysql_fetch_array($rows);
	
		}
		
	}
    
    
	

?>
<script src="../product/index.js" language="javascript"></script>
<script>

	function form_action(act)
	{
	
		fr = document.frm
		fr.act.value = act;
		
		// save
		if (act == '1')
		{
			
			if (fr.id.value=='')
				fr.active[0].checked = true;
		
			fr.action = '../main/main.php?func_pg=<?=$action_page?>'
			fr.method = 'post';
			fr.target = '_self';
			fr.submit();
		
		}		

		// not use		
		if (act == '2')
		{
			window.location = '../main/main.php?func_pg=<?=$curr_page?>'
			
			return
			
		}
		
		// delete
		if (act == '3')
		{
			fr.deleted.value = 1;
			fr.action = '../main/main.php?func_pg=<?=$action_page?>'
			fr.method = 'post';
			fr.target = '_self';
			fr.submit();
			
		}
	
	}

	function del_photo(){
		path = "../main/std_del_photo.php?func_pg=<?=$curr_page?>&pg_num=" + fr.pg_num.value + "&id=" + id + "&idx=" + idx;
		window.location = path;
	
	}

</script>

	<form name="frm" enctype="multipart/form-data">
	<input type="hidden" name="id" value="<?=$row[id]?>">
	<input type="hidden" name="deleted" value="<?=$row[deleted]?>">
	<input type="hidden" name="tbl" value="<?=$tbl?>">
	<input type="hidden" name="act" value="<?=$action?>">
	<input type="hidden" name="pg_num" value="<?=$list_page_num?>">
	<input type="hidden" name="cat_id" value="<?=$cat_id?>">
    <input type="hidden" name="tab" id="tab_curr" value="<?=$tab?>">
	
	<div id="edit">
		<? include("../include/edit_title.php")?>
		<div id="tool">
			<? if ($_SESSION["sys_write"]) { ?>
				<a class="boldbuttons" href="javascript:form_action(1)"><span>Save</span></a>
				
			<? } ?>
			<? if ($_SESSION["sys_delete"]) { ?>
				<a class="boldbuttons" href="javascript:form_action(3)"><span>Delete</span></a>
				
			<? } ?>
			<a class="boldbuttons" href="javascript:goto_parent('<?=$prev_page?>', '<?=$cat_id?>')"><span>Back</span></a>
		</div>
        <div id="tabs">
			<ul>
				<li><a href="#tabs-1" onclick="$('#tab_curr').val(0)">Main</a></li>
				
				<? if (!empty($id)) { ?>
                <li><a href="#tabs-2" onclick="$('#tab_curr').val(1)">Meta Tags</a></li>					
				<? } ?>
				
			</ul>
			
			<div id="tabs-1">
		
		<fieldset><legend>Edit Category</legend>
		<table>
			<tr>
				<td width="150"><br></td>
				<td width="20"><br></td>                    
				<td width="*"><br></td>                    
			</tr>
			<tr>
				<td align="right">Parent Category:</td>
				<td></td>
				<td>
				<?
					if (empty($id)) 
						$parent_id = $cat_id; 
					else 
						$parent_id = $row[parent_id];

				?>
				<select name="parent_id" style="width:200px">
					<option value="">Top</option>
					<?
					if (!empty($row[cat_id]))
						$cat_id = $row[cat_id];
					?>
					<?=get_category_combo_without_self($tbl, 0, 0, $parent_id, $row[id])?>
				</select>
				</td>
			</tr>
			<tr>
				<td><br></td>
				<td><br></td>
				<td><br></td>
			</tr>
            <tr>
				<td align="right">Homepage display number:</td>
				<td></td>
				<td><input type="text" name="home_display" value="<?=$row[home_display]; ?>"></td>
			</tr>
			<tr>
				<td><br></td>
				<td><br></td>
				<td><br></td>
			</tr>            
            <tr>
				<td align="right">Related Category:</td>
				<td></td>
				<td>
				<?
					if (empty($id)) 
						$parent_id = $cat_id; 
					else 
						$parent_id = $row[parent_id];
				?>
				<select name="relate_category_id" style="width:200px">
					<option value=""></option>
					<?=get_category_combo_without_self($tbl, 0, 0, $relate_category, $row[relate_category_id]); ?>
				</select>
				</td>
			</tr>
			<tr>
				<td><br></td>
				<td><br></td>
				<td><br></td>
			</tr>
			<tr>
				<td align="right">Name:</td>
				<td></td>
				<td><input type="text" name="name_1" value="<?=$row[name_1] ?>"></td>
			</tr>
            <tr>
				<td><br></td>
				<td><br></td>
				<td><br></td>
			</tr>
            <tr>
				<td align="right">Main Product:</td>
				<td></td>
				<td>
					<input type="radio" name="main_product" value="1" <?=set_checked($row[main_product],1)?>>Yes
					<input type="radio" name="main_product" value="0" <?=set_checked($row[main_product],0)?>>No
                </td>
			</tr>
            <tr>
				<td><br></td>
				<td><br></td>
				<td><br></td>
			</tr>
            <tr>
				<td align="right">Accessory:</td>
				<td></td>
				<td>
					<input type="radio" name="accessory" value="1" <?=set_checked($row[accessory],1)?>>Yes
					<input type="radio" name="accessory" value="0" <?=set_checked($row[accessory],0)?>>No
                </td>
			</tr>
            <tr>
				<td><br></td>
				<td><br></td>
				<td><br></td>
			</tr>            
            <tr>
				<td align="right">Mod_Rewrite:</td>
				<td></td>
				<td><input type="text" name="mod_rewrite" value="<?=$row[mod_rewrite] ?>"></td>
			</tr>
			<tr>
				<td><br></td>
				<td><br></td>                    
				<td><br></td>
			</tr>
            <tr>
				<td align="right">Categories Photo:</td>
				<td></td>
				<td><? get_image_upload_box($tbl, $id, 1, "vie_crop", "", $curr_page); ?></td>
			</tr>
            <tr>
				<td><br></td>
				<td><br></td>
				<td><br></td>
			</tr>
            <tr>
				<td align="right">Icon:</td>
				<td></td>
				<td><? get_image_upload_box($tbl, $id, 2, "icon_crop", "", $curr_page); ?></td>
			</tr>
            <tr>
				<td><br></td>
				<td><br></td>
				<td><br></td>
			</tr>
            <tr>
				<td align="right">Technical Details:</td>
				<td></td>
				<td>
                	<input name="technical_details" type="radio" value="1" <?=set_checked(1, $row[technical_details]); ?>  />Compact Cameras
                	<input name="technical_details" type="radio" value="2" <?=set_checked(2, $row[technical_details]); ?>  />DSLR
                	<input name="technical_details" type="radio" value="3" <?=set_checked(3, $row[technical_details]); ?>  />Lens
                	<input name="technical_details" type="radio" value="4" <?=set_checked(4, $row[technical_details]); ?>  />Other
                </td>
			</tr>
			<tr>
				<td><br></td>
				<td><br></td>                    
				<td><br></td>
			</tr>
			<tr>
				<td align="right">Sort no.:</td>
				<td></td>
				<td><input type="text" name="sort_no" value="<?=$row[sort_no] ?>"></td>
			</tr>
			<tr>
				<td><br></td>
				<td><br></td>                    
				<td><br></td>                    
			</tr>
			<tr>
				<td align="right">Available:</td>
				<td></td>
				<td>
				<input type="radio" name="active" value="1" <?=set_checked($row[active],1)?>>Yes
				<input type="radio" name="active" value="0" <?=set_checked($row[active],0)?>>No
				</td>
			</tr>
		</table>
		</fieldset>
        </div>
			
			<? if (!empty($id)) { ?>
				<div id="tabs-2">
        <fieldset><legend>Category Meta Data</legend>
                <form name="frm" method ="post"  action="">
                    <input type="hidden" name="custom" value="custom"/>
			
			<table>
            
                <tr>
                    <td width="150"  align="right">Meta Title: </td>
                    
                    <td width="200">
						<textarea name="meta_title" rows="3" cols="50"><?=$row[meta_title]?></textarea>
					</td>
                </tr>
                <tr>
                    <td><br></td>
                    <td><br></td>                   
                </tr>
                <tr>
                    <td align="right">Meta Description: </td>
                    
                    <td>
						<textarea name="meta_description" rows="3" cols="50"><?=$row[meta_description]?></textarea>
					</td>
                </tr>
                <tr>
                    <td><br></td>
                    <td><br></td>                   
                </tr>
                <tr>
                    <td align="right">Meta Keywords: </td>
                    
                    <td>
						<textarea name="meta_keywords" rows="3" cols="50"><?=$row[meta_keywords]?></textarea>
					</td>
                </tr>
                <tr>
                    <td><br></td>
                    <td><br></td>                   
                </tr>
                
			</table>	
			</form>
			</fieldset></div>
			<? } ?>
			
		</div>		
		<script>
		$('#tabs').tabs({ selected: <?=$tab?> });
		</script>
		<br class="clear">
	</div>
</form>