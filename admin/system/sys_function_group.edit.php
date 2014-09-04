<?

//*** Default
$func_name = "System Function Group";
$tbl = "sys_function_group";
$prev_page = "sys_function_group.list";
$curr_page = "sys_function_group.edit";
$action_page = "sys_function_group.act";


//*** request
$id = $_REQUEST['id'];
$pg_num = $_REQUEST["pg_num"];


if (!empty($id))
{

	$sql = " select * from $tbl where id = $id ";
	
	
	if ($rows = mysql_query($sql)){
		$row = mysql_fetch_array($rows);
	}
	
}



?>

<script>

	function form_action(act)
	{
	
		fr = document.frm
		
		fr.act.value = act;
		

		if (act == '2')
		{
			window.location = '../main/main.php?func_pg=<?=$curr_page?>'
			
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
		
		
		if (act == '1')
		{
			
			if (fr.id.value=='')
				fr.active[0].checked = true;
		
			fr.action = '../main/main.php?func_pg=<?=$action_page?>'
			fr.method = 'post';
			fr.target = '_self';
			fr.submit();
		
		}	
	
	}

</script>

<form name="frm">
<input type="hidden" name="id" value="<?=$row[id]?>">
<input type="hidden" name="deleted" value="<?=$row[deleted]?>">
<input type="hidden" name="tbl" value="<?=$tbl?>">
<input type="hidden" name="act" value="<?=$action?>">
<input type="hidden" name="pg_num" value="<?=$pg_num?>">

<div id="edit">
        
	<? include("../include/edit_title.php")?>
	<? include("../include/edit_toolbar.php") ?>
	
	<fieldset><legend>Function Group Info</legend>
		<table>
			<tr>
				<td width="150" align="right"><br></td>
				<td width="20"><br></td>                    
				<td width="*"><br></td>                    
			</tr>    
			<tr>
				<td align="right">Name (ENG):</td>
				<td></td>
				<td><input type="text" name="name_1" value="<?=$row[name_1] ?>"></td>
			</tr>
			<tr>
				<td><br></td>
				<td><br></td>                    
				<td><br></td>                    
			</tr> 
			<tr>
				<td align="right">Name (CHI):</td>
				<td></td>
				<td><input type="text" name="name_2" value="<?=$row[name_2] ?>"></td>
			</tr>
			<tr>
				<td><br></td>
				<td><br></td>                    
				<td><br></td>                    
			</tr>
			<tr>
				<td align="right">Sort No:</td>
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
				<td align="left"><input type="radio" name="active" value="1" <?=set_checked($row[active], 1)?>>Yes
				<input type="radio" name="active" value="0" <?=set_checked($row[active], 0)?>>No</td>
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