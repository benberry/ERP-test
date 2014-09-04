<?
//*** Default
$func_name = "System User Group";
$tbl = "sys_user_group";
$prev_page = "sys_user_group.list";
$curr_page = "sys_user_group.edit";
$action_page = "sys_user_group.act";


//*** request
$id = $_REQUEST['id'];
$list_page_num = $_REQUEST["pg_num"];


if (!empty($id))
{

	$sql = " select * from $tbl where id = $id ";
	
	if ($rows = mysql_query($sql)){
		$row = mysql_fetch_array($rows);

	}
	
}



?>

<script>

	function form_action(act){

	
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

//**** set function right

	function func_cols_set(act, field_name)
	{
				window.location = "../system/sys_func_right.act.php?gid=<?=$id?>&fname="+field_name+"&act="+act+"&case=1";
	}
	
	function func_rows_set(act, func_id)
	{
				window.location = "../system/sys_func_right.act.php?gid=<?=$id?>&func_id="+func_id+"&act="+act+"&case=2";
	}
	
	function func_all(act)
	{
				window.location = "../system/sys_func_right.act.php?gid=<?=$id?>&act="+act+"&case=3";		
	}

	function func_sigle(act, field_name, func_id)
	{
				window.location = "../system/sys_func_right.act.php?gid=<?=$id?>&fname=" + field_name + "&act=" + act + "&func_id=" + func_id + "&case=4";
	}
	
//*** set user_group right

	function ug_cols_set(act, field_name)
	{
				window.location = "../system/sys_user_group_right.act.php?gid=<?=$id?>&fname="+field_name+"&act="+act+"&case=1";
	}
	
	function ug_rows_set(act, id)
	{
				window.location = "../system/sys_user_group_right.act.php?gid=<?=$id?>&id="+id+"&act="+act+"&case=2";
	}
	
	function ug_all(act)
	{
				window.location = "../system/sys_user_group_right.act.php?gid=<?=$id?>&act="+act+"&case=3";		
	}

	function ug_sigle(act, field_name, id)
	{
				window.location = "../system/sys_user_group_right.act.php?gid=<?=$id?>&fname=" + field_name + "&act=" + act + "&id=" + id + "&case=4";
	}


</script>

<form name="frm">
<input type="hidden" name="id" value="<?=$row[id]?>">
<input type="hidden" name="deleted" value="<?=$row[deleted]?>">
<input type="hidden" name="tbl" value="<?=$tbl?>">
<input type="hidden" name="act" value="<?=$action?>">
<input type="hidden" name="pg_num" value="<?=$list_page_num?>">

<div id="edit">
        
        <? include("../include/edit_title.php")?>
        <? include("../include/edit_toolbar.php") ?>
		
		<fieldset><legend>User Group</legend>
        	<table>
                <tr>
                    <td width="150" align="right"><br></td>
                    <td width="20"><br></td>                    
                    <td width="*"><br></td>                    
                </tr>    
                <tr>
                    <td align="right">Group: </td>
                    <td></td>
                    <td><input type="text" name="name_1" value="<?=$row[name_1] ?>"></td>
                </tr>
                <tr>
                    <td><br></td>
                    <td><br></td>                    
                    <td><br></td>                    
                </tr> 
                <tr>
                    <td align="right">Available: </td>
					<td></td>
                    <td align="left"><input type="radio" name="active" value="1" <?=set_checked($row[active],1)?>>Yes
                    <input type="radio" name="active" value="0" <?=set_checked($row[active],0)?>>No</td>
                </tr>
                <tr>
                    <td><br></td>
                    <td><br></td>
                    <td><br></td>                    
                </tr>                                 
			</table>
		</fieldset>
<?

if (!empty($id)){

?>
	<fieldset><legend>System Access Right</legend>
		<div id="inner_list">
			
			<table width="100%">
				<thead>
					<tr>
						<th> Module </th>
						<th> Read </th>
						<th> Write </th>
						<th> Delete </th>
						<th> Print </th>
						<th> Export </th>
						<th> </th>
					</tr>
					
				</thead>
				<tbody>
					
					<?
					
						$sql_fg = " select * from sys_function_group where deleted=0 and active = 1 order by sort_no ";
						
						if ($result_fg=mysql_query($sql_fg))
						{
							
							while ($row_fg = mysql_fetch_array($result_fg))
							{
							
							?>
							<tr>
								<td colspan="7" id="sub-title" align="left" ><strong><?=$row_fg[name_1];?></strong></td>
							</tr>
							<?				
							
							
								$sql_f = " select * from sys_function where deleted=0 and active = 1 and sys_function_group_id = $row_fg[id] order by sort_no ";
							
								if ($result_f=mysql_query($sql_f))
								{
									
									while ($row_f = mysql_fetch_array($result_f))
									{
									
									?>
									
										<tr>
											<td align="left">&nbsp;&nbsp;&nbsp;&nbsp;<?=$row_f[name_1];?></td>
											
											<?
											
												$sql_r = " 
												select * from 
												sys_function_right where 
												deleted=0 
												and active = 1 
												and sys_function_id = $row_f[id] 
												and sys_user_group_id = $id
												";
											
												if ($result_r=mysql_query($sql_r))
												{
													
													while ($row_r = mysql_fetch_array($result_r))
													{
													
													?>
														<td align="center"><?=right_to_str($row_r[sys_read], "sys_read", $row_f[id]);?></td>
														<td align="center"><?=right_to_str($row_r[sys_write], "sys_write", $row_f[id]);?></td>
														<td align="center"><?=right_to_str($row_r[sys_delete], "sys_delete", $row_f[id]);?></td>
														<td align="center"><?=right_to_str($row_r[sys_print], "sys_print", $row_f[id]);?></td>
														<td align="center"><?=right_to_str($row_r[sys_export], "sys_export", $row_f[id]);?></td>
														<td align="center">
															<input type="button" value="Allow" onclick="func_rows_set(1, <?=$row_f[id]?>)">
															<input type="button" value="Deny" onclick="func_rows_set(0, <?=$row_f[id]?>)">
														</td>
													<?
													
													}
													
												}
											
											?>
											
																																											
										</tr>	
															
									
									<?
									
									}
									
									
									
										
								}
								
								?>
								<td colspan="7">&nbsp;</td>				
								<?
							
							}
						
						}
					
					?>
					</tr>
					<tr>
						<td>  </td>
						<td align="center"><input type="button" value="Allow" onclick="func_cols_set(1, 'sys_read')">&nbsp;<input type="button" value="Deny" onclick="func_cols_set(0, 'sys_read')"> </td>
						<td align="center"> <input type="button" value="Allow" onclick="func_cols_set(1, 'sys_write')">&nbsp;<input type="button" value="Deny" onclick="func_cols_set(0, 'sys_write')"> </td>
						<td align="center"> <input type="button" value="Allow" onclick="func_cols_set(1, 'sys_delete')">&nbsp;<input type="button" value="Deny" onclick="func_cols_set(0, 'sys_delete')"> </td>
						<td align="center"> <input type="button" value="Allow" onclick="func_cols_set(1, 'sys_print')">&nbsp;<input type="button" value="Deny" onclick="func_cols_set(0, 'sys_print')"> </td>
						<td align="center"> <input type="button" value="Allow" onclick="func_cols_set(1, 'sys_export')">&nbsp;<input type="button" value="Deny" onclick="func_cols_set(0, 'sys_export')"> </td>
						<td align="center"> <input type="button" value="All Allow" onclick="javascript:func_all(1)">&nbsp;<input type="button" value="All Deny" onclick="javascript:func_all(0)"> </th> 
					</tr>
				</tbody>    
			</table>
		</div>
	</fieldset>
<!--
<table align="center" width="95%" cellpadding="5" cellspacing="" border="1" bordercolor="#EEEEEE" style="border-collapse:collapse">
	<thead>
    	<tr bgcolor="#004400">
        	<td colspan="7"><font color="#FFFFFF">System users to read, modify or delete information on other systems user group permissions.</font></td>
        </tr>
    	<tr bgcolor="#333333">
            <th> System user groups </th>
            <th> Read </th>
            <th> Write </th>
            <th> Delete </th>
            <th> Print </th>
            <th> Export </th>
            <th>  </th>
        </tr>
        
    </thead>
	<tbody>
		<?
/*
            $sql_r = " 
            select 
			ugr.*
			from
            sys_user_group_right ugr,
			sys_user_group ug
            where
			ug.id = ugr.sys_user_group_right_id
			and ug.deleted = 0

            and ugr.sys_user_group_id = $id
            ";
        
            if ($result_r=mysql_query($sql_r))
            {
                
                while ($row_r = mysql_fetch_array($result_r))
                {
*/              
					?>
					<tr>
						<td>&nbsp;&nbsp;&nbsp;&nbsp;<?//=get_field('sys_user_group', 'name_1', $row_r[sys_user_group_right_id]);?></td>
						<td align="center"><?//=right_to_str_user($row_r[sys_read], "sys_read", $row_r[id]);?></td>
						<td align="center"><?//=right_to_str_user($row_r[sys_write], "sys_write", $row_r[id]);?></td>
						<td align="center"><?//=right_to_str_user($row_r[sys_delete], "sys_delete", $row_r[id]);?></td>
						<td align="center"><?//=right_to_str_user($row_r[sys_print], "sys_print", $row_r[id]);?></td>
						<td align="center"><?//=right_to_str_user($row_r[sys_export], "sys_export", $row_r[id]);?></td>
						<td align="center"><input type="button" value="Allow" onclick="ug_rows_set(1, '<?//=$row_r[id]?>')">
						<input type="button" value="Deny" onclick="ug_rows_set(0, '<?//=$row_r[id]?>')"></td>
					</tr>
					<?
                
//                }
                
//            }
        
        ?>


        <tr bgcolor="#333333">
            <td align="center"> </td>
            <td align="center"> <input type="button" value="Allow" onclick="ug_cols_set(1, 'sys_read')"><input type="button" value="Deny" onclick="ug_cols_set(0, 'sys_read')"> </td>
            <td align="center"> <input type="button" value="Allow" onclick="ug_cols_set(1, 'sys_write')"><input type="button" value="Deny" onclick="ug_cols_set(0, 'sys_write')"> </td>
            <td align="center"> <input type="button" value="Allow" onclick="ug_cols_set(1, 'sys_delete')"><input type="button" value="Deny" onclick="ug_cols_set(0, 'sys_delete')"> </td>
            <td align="center"> <input type="button" value="Allow" onclick="ug_cols_set(1, 'sys_print')"><input type="button" value="Deny" onclick="ug_cols_set(0, 'sys_print')"> </td>
            <td align="center"> <input type="button" value="Allow" onclick="ug_cols_set(1, 'sys_export')"><input type="button" value="Deny" onclick="ug_cols_set(0, 'sys_export')"> </td>
            <td align="center"> <input type="button" value="All Allow" onclick="ug_all(1)"><input type="button" value="All Deny" onclick="ug_all(0)"> </th>
        </tr>
    </tbody>
</table>
-->

<?
	}//if (!empty($id)){
?>
		<br class="clear">
	</div>

</form>


<?

	function right_to_str($val, $field_name, $func_id)
	{
	
		if ($val == 1)
			return "<a href=\"javascript:func_sigle(0, '$field_name', '$func_id')\" style='text-decoration:none;'><font color='green'>Allow</font></a>";
			
		if ($val == 0)
			return "<a href=\"javascript:func_sigle(1, '$field_name', '$func_id')\" style='text-decoration:none;'><font color='red'>Deny</font></a>";
	
	}
	
	function right_to_str_user($val, $field_name, $id)
	{
	
		if ($val == 1)
			return "<a href=\"javascript:ug_sigle(0, '$field_name', '$id')\" style='text-decoration:none;'><font color='green'>Allow</font></a>";
			
		if ($val == 0)
			return "<a href=\"javascript:ug_sigle(1, '$field_name', '$id')\" style='text-decoration:none;'><font color='red'>Deny</font></a>";
	
	}	

?>