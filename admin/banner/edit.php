<?
//*** Default
$func_name = "Top Banner";
$tbl = "tbl_banner";
$prev_page = "list";
$curr_page = "edit";
$action_page = "update";

include("../include/tinymce_large.php");

//*** Request
$id = $_REQUEST['id'];
$list_page_num = $_REQUEST["pg_num"];

if (!empty($id))
{

	$sql = " select * from $tbl where id = $id ";
	
	if ($rows = mysql_query($sql)){
	
		$row = mysql_fetch_array($rows);
	
	}

	//	echo "<font color='#EEEE00'>123".$row[name_1]."</font>";
	
}

?>

<script>

	// form
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

<form name="frm" enctype="multipart/form-data">
<input type="hidden" name="id" value="<?=$row[id]?>">
<input type="hidden" name="deleted" value="<?=$row[deleted]?>">
<input type="hidden" name="tbl" value="<?=$tbl?>">
<input type="hidden" name="act" value="<?=$action?>">
<input type="hidden" name="pg_num" value="<?=$list_page_num?>">

	<div id="edit">
        
        <? include("../include/edit_title.php")?>
        <? include("../include/edit_toolbar.php") ?>
			
			<fieldset>
			<legend>Banner</legend>
			<table>
                <tr>
                    <td width="150" align="right"><br></td>
                    <td width="20"><br></td>                    
                    <td width="*"><br></td>                    
                </tr>
				<tr>
					<td align="right">Title: </td>
					<td></td>
					<td><input type="text" name="name_1" value="<?=$row[name_1] ?>"></td>
				</tr>
                <tr>
                    <td><br></td>
                    <td><br></td>
                    <td><br></td>                    
                </tr>
				<tr>
					<td align="right">Link: </td>
					<td></td>
					<td>
					<input type="text" name="link_1" value="<?=$row[link_1] ?>"><br />
					<span>( eg. http://www.google.com )</span>
					</td>
				</tr>
                <tr>
                    <td><br></td>
                    <td><br></td>
                    <td><br></td>                    
                </tr>				
				<tr>
					<td align="right">Photo:</td>
					<td></td>
					<td>
					<? get_image_upload_box($tbl, $row[id], 1, "vie_crop", "", $curr_page); ?>
					</td>
				</tr>
				<tr>
					<td><br></td>
					<td><br></td>                    
					<td><br></td>                    
				</tr>				
                <tr>
					<td align="right">Status: </td>
					<td></td>
					<td align="left">
					<input type="radio" name="active" value="1" <?=set_checked($row[active],1)?>>Enable
					<input type="radio" name="active" value="0" <?=set_checked($row[active],0)?>>Disable
					</td>
				</tr>
				<tr>
					<td><br></td>
					<td><br></td>
					<td><br></td>                    
				</tr>								
			</table>
			</fieldset>

		<br />
		
	</div>

</form>