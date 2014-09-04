<?

//*** Default
	$func_name = "Zone";
	$tbl = "tbl_shipping_express_zone";
	$prev_page = "index";
	$curr_page = "cat-edit";
	$action_page = "cat-update";


//*** Request
	extract($_REQUEST);


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
		
		<fieldset>
		<table>
			<tr>
				<td width="150"><br></td>
				<td width="20"><br></td>                    
				<td width="*"><br></td>                    
			</tr>
			<tr>
				<td align="right">Zone: </td>
				<td></td>
				<td><input type="text" name="zone" value="<?=$row[zone] ?>"></td>
			</tr>
			<tr>
				<td><br></td>
				<td><br></td>                    
				<td><br></td>
			</tr>
			<tr>
				<td align="right">Sort no.: </td>
				<td></td>
				<td><input type="text" name="sort_no" value="<?=$row[sort_no] ?>"></td>
			</tr>
			<tr>
				<td><br></td>
				<td><br></td>                    
				<td><br></td>                    
			</tr>
			
			<tr>
				<td align="right">Available: </td>
				<td></td>
				<td>
				<input type="radio" name="active" value="1" <?=set_checked($row[active],1)?>>Yes
				<input type="radio" name="active" value="0" <?=set_checked($row[active],0)?>>No
				</td>
			</tr>
			<tr>
				<td><br></td>
				<td><br></td>
				<td><br></td>                    
			</tr>                                 
		</table>
		</fieldset>
		
		<br class="clear">
				
	</div>
	
	</form>