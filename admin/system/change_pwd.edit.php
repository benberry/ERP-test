<?

//*** Default
$func_name = "Change Password";
$tbl = "sys_user";
$prev_page = "change_pwd.edit";
$curr_page = "change_pwd.edit";
$action_page = "change_pwd.act";


//*** Request
$list_page_num = $_REQUEST["pg_num"];


?>

<script>

	function form_action(act)
	{
	
	
		fr = document.frm
		
		if (act == '1')
		{
			
			fr.act.value = 1;
			
			if (js_is_empty(fr.curr_pwd)){
				alert("Please fill in Current Password.")
			}
			else if(js_is_empty(fr.password)){
				alert("Please fill in New Password.")			
			}
			else if(js_is_empty(fr.confirm_password)){
				alert("Please fill in Confirm Password.")
			}
			else if (fr.password.value!=fr.confirm_password.value){
				alert("New Password and Confirm Password different.")
			}else
			{
		
				fr.action = '../main/main.php?func_pg=<?=$action_page?>'
				fr.method = 'post';
				fr.target = '_self';
				fr.submit();
			
			}
		
		}	
	
	}

</script>

<form name="frm">
<input type="hidden" name="id" value="<?=$_SESSION['user_id']?>">
<input type="hidden" name="tbl" value="<?=$tbl?>">
<input type="hidden" name="act" value="<?=$action?>">

<div id="edit">
	
        <? include("../include/edit_title.php")?>
        <? //include("../include/edit_toolbar.php") ?>
		<div id="tool">
				<? if ($_SESSION["sys_write"]) { ?>
					<a class="boldbuttons" href="javascript:form_action(1)"><span>Save</span></a>
					
				<? } ?>
		</div>		
		
		
		<fieldset>
		<legend>Change Password</legend>
		<table>
			<tr>
				<td width="180" align="right"><br></td>
				<td width="20"><br></td>                    
				<td width="*"><br></td>                    
			</tr>
			<!----> 
			<tr>
				<td align="right">Current Password : </td>
				<td></td>
				<td><input type="password" name="curr_pwd" value=""></td>
			</tr>
			<tr>
				<td><br></td>
				<td><br></td>                    
				<td><br></td>                    
			</tr> 
			<tr>
				<td align="right">New Password : </td>
				<td></td>
				<td><input type="password" name="password" value=""></td>
			</tr>
			<tr>
				<td><br></td>
				<td><br></td>                    
				<td><br></td>                    
			</tr>
			<tr>
				<td align="right">Confirm New Password : </td>
				<td></td>
				<td><input type="password" name="confirm_password" value=""></td>
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