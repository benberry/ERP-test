<? include("../include/init.php"); ?>
<? include("../include/html_head.php"); ?>
<?

//*** Default
$func_name = "Images";
$tbl = "sys_file_management";
$prev_page = "pop_image_mgnt.list.php";
$curr_page = "pop_image_mgnt.edit.php";
$action_page = "pop_image_mgnt.act.php";


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
			window.location = 'pop_image_mgnt.act.php'
			
			return
			
		}

		if (act == '3')
		{
			fr.deleted.value = 1;
			
			fr.action = 'pop_image_mgnt.act.php'
			fr.method = 'post';
			fr.target = '_self';
			fr.submit();
			
		}
		
		
		if (act == '1')
		{
		
			fr.action = 'pop_image_mgnt.act.php'
			fr.method = 'post';
			fr.target = '_self';
			fr.submit();
		
		}	
	
	}
	
	function file_go_back(path, pg_num)
	{
	
		window.location = "pop_image_mgnt.list.php?pg_num=" + pg_num
	
	}	

</script>

<form name="frm" enctype="multipart/form-data">
<input type="hidden" name="id" value="<?=$row[id]?>">
<input type="hidden" name="deleted" value="<?=$row[deleted]?>">
<input type="hidden" name="tbl" value="<?=$tbl?>">
<input type="hidden" name="act" value="<?=$action?>">
<input type="hidden" name="pg_num" value="<?=$list_page_num?>">
<input type="hidden" name="active" value="1">
<div id="edit">
        
        <? include("../include/edit_title.php")?>
		
		<div id="tool">
				<a class="boldbuttons" href="javascript:form_action(1)"><span>Save</span></a>
				<a class="boldbuttons" href="javascript:file_go_back('<?=$prev_page?>', '<?=$list_page_num?>')"><span>Back</span></a> 
		</div>		
		
		<fieldset><legend>Info</legend>
				<table>
                <tr>
                    <td width="150" align="right"><br></td>
                    <td width="20"><br></td>                    
                    <td width="*"><br></td>                    
                </tr>
                <tr>
                    <td align="right">Upload Image :</td>
					<td></td>
                    <td><input type="file" name="tmp_photo_1" value=""></td>
                </tr>
                <tr>
                    <td><br></td>
                    <td><br></td>                    
                    <td><br></td>                    
                </tr>				
                <tr>
                    <td align="right">Name : </td>
                    <td></td>
                    <td><input type="text" name="name_1" value="<?=$row[name_1] ?>"></td>
                </tr>
                <tr>
                    <td><br></td>
                    <td><br></td>                    
                    <td><br></td>                    
                </tr> 
                <tr>
                    <td align="right">Desc. : </td>
					<td></td>
                    <td><input type="text" name="desc_2" value="<?=$row[desc_2] ?>"></td>
                </tr>
                <tr>
                    <td><br></td>
                    <td><br></td>                    
                    <td><br></td>                    
                </tr>
			</table>		
		
		</fieldset>
		
</div>		
</form>