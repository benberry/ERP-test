<?

//*** Default
$func_name = "圖片管理";
$tbl = "sys_file_management";
$prev_page = "image_mngt.list";
$curr_page = "image_mngt.edit";
$action_page = "image_mngt.act";


//*** Request
$id = $_REQUEST['id'];
$list_page_num = $_REQUEST["pg_num"];




if (!empty($id))
{

	$sql = " select * from $tbl where id = $id ";
	
	if ($rows = mysql_query($sql)){
	
	}
	
	$row = mysql_fetch_array($rows);

//	echo "<font color='#EEEE00'>123".$row[name_1]."</font>";
	
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

<form name="frm" enctype="multipart/form-data">
<input type="hidden" name="id" value="<?=$row[id]?>">
<input type="hidden" name="deleted" value="<?=$row[deleted]?>">
<input type="hidden" name="tbl" value="<?=$tbl?>">
<input type="hidden" name="act" value="<?=$action?>">
<input type="hidden" name="pg_num" value="<?=$list_page_num?>">
<br>
<table align="center" width="95%" cellpadding="1" cellspacing="0" border="1" bordercolor="333333" style="border-collapse:collapse">

	<tr>
    	<td bgcolor="333333">
        
        <table width="100%" border="0">
        	<tr>
            	<td width="50%" rowspan="2" align="center"><font color="FFFFFF"> <?=$func_name?> </font></td>            
            	<td><font color="FFFFFF">Last modify date:</font></td>
            	<td><font color="FFFFFF"><?=$row[modify_date]?></font></td>
            	<td><font color="FFFFFF">Create date:</font></td>
            	<td><font color="FFFFFF"><?=$row[create_date]?></font></td>
            </tr>
        	<tr>
            	<td><font color="FFFFFF">Last modify by:</font></td>
            	<td><font color="FFFFFF"><?=get_sys_user($row[modify_by])?></font></td>
            	<td><font color="FFFFFF">Create by:</font></td>
            	<td><font color="FFFFFF"><?=get_sys_user($row[create_by])?></font></td>
            </tr>            
        </table>

        </td>
    </tr> 
    
	<tr>
    	<td bgcolor="666666">
        <? include("../include/edit_tool_bar.php") ?>
		</td>
    </tr>
       
    <tr>
    	<td>
        	<table bgcolor="#EEEEEE" width="100%" cellpadding="1" cellspacing="0" border="0" style="border-collapse:collapse">
                <tr>
                    <td width="150" class="field_name1" align="right"><br></td>
                    <td width="20" class="field_name1"><br></td>                    
                    <td width="*"><br></td>                    
                </tr>
                <tr>
                    <td align="right" class="field_name1">Name (Eng) : </td>
                    <td class="field_name1"></td>
                    <td><input type="text" name="name_1" class="input_text1" value="<?=$row[name_1] ?>"></td>
                </tr>
                <tr>
                    <td class="field_name1"><br></td>
                    <td class="field_name1"><br></td>                    
                    <td><br></td>                    
                </tr> 
                <tr>
                    <td align="right" class="field_name1">Name (Chi) : </td>
					<td class="field_name1"></td>
                    <td><input type="text" name="name_2" class="input_text1" value="<?=$row[name_2] ?>"></td>
                </tr>
                <tr>
                    <td class="field_name1"><br></td>
                    <td class="field_name1"><br></td>                    
                    <td><br></td>                    
                </tr>
                <tr>
                    <td align="right" class="field_name1">Photo : </td>
					<td class="field_name1"></td>
                    <td>
                    <?=get_img($tbl,"$row[id]", 1, "thu")?><br>
                    <input type="file" name="tmp_photo_1" class="input_text1" value="">
                    </td>
                </tr>
                <tr>
                    <td class="field_name1"><br></td>
                    <td class="field_name1"><br></td>                    
                    <td><br></td>                    
                </tr>                                
                <!--
                <tr>
                    <td align="right" class="field_name1">Folder: </td>
					<td class="field_name1"></td>
                    <td><input type="text" name="folder" class="input_text1" value="<?=$row[folder] ?>"></td>
                </tr>
                <tr>
                    <td class="field_name1"><br></td>
                    <td class="field_name1"><br></td>                    
                    <td><br></td>                    
                </tr>
                <tr>
                    <td align="right" class="field_name1">Page: </td>
					<td class="field_name1"></td>
                    <td><input type="text" name="page" class="input_text1" value="<?=$row[page] ?>"></td>
                </tr>
                <tr>
                    <td class="field_name1"><br></td>
                    <td class="field_name1"><br></td>                    
                    <td><br></td>                    
                </tr>
                -->            
                <tr>
                    <td align="right" class="field_name1">Sort no.: </td>
					<td class="field_name1"></td>
                    <td><input type="text" name="sort_no" class="input_text1" value="<?=$row[sort_no] ?>"></td>
                </tr>
                <tr>
                    <td class="field_name1"><br></td>
                    <td class="field_name1"><br></td>                    
                    <td><br></td>                    
                </tr>
                
                <tr>
                    <td align="right" class="field_name1">Active: </td>
					<td class="field_name1"></td>
                    <td align="left"><input type="radio" name="active" class="input_radio1" value="1" <?=set_radio_checked($row[active],1)?>>是
                    <input type="radio" name="active" class="input_radio1" value="0" <?=set_radio_checked($row[active],0)?>>否</td>
                </tr>
                <tr>
                    <td class="field_name1"><br></td>
                    <td class="field_name1"><br></td>
                    <td><br></td>                    
                </tr>                                 
			</table>
		</td>  
	</tr>
    <!--     
	<tr>
    	<td bgcolor="333333">
        <input type="button" value="Save" onclick="form_save()" style="width:120px">
        <input type="button" value="New"  style="width:120px">
        <input type="button" value="Delete"  style="width:120px">
        <input type="button" value="Back"  style="width:120px">
        </td>
    </tr>
    -->
</table>

</form>