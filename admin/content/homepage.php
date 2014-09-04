<?
   
//*** Default
$func_name = "Homepage Meta Data";
$tbl = "other_texts";
$prev_page = "order.list";
$curr_page = "homepage";
$action_page = "homepage";


//*** Request
$id = $_REQUEST['id'];
$list_page_num = $_REQUEST["pg_num"];


if(isset($_POST) && count($_POST)>0){
    
    if(isset($_POST['custom']) && strtolower($_POST['custom'])=='custom'){
        $my_emsg ='';
        $hp_meta_title = mysql_escape_string(trim($_POST['hp_meta_title']));
        $hp_meta_description = mysql_escape_string(trim($_POST['hp_meta_description']));
        $hp_meta_keywords = mysql_escape_string(trim($_POST['hp_meta_keywords']));
        if($hp_meta_title==''){
            $my_emsg.= ' Meta Title field is required.<br/>';
        }
        if($hp_meta_description==''){
            $my_emsg.= ' Meta Description field is required.<br/>';
        }
        if($hp_meta_keywords==''){
            $my_emsg.= ' Meta Keywords field is required.<br/>';
        }
        
        if(strlen($my_emsg)<1){
            $sqld = " UPDATE $tbl SET  text='$hp_meta_title' WHERE type = 'homepage_meta_title' ";
            $rstd = mysql_query($sqld);
            $sqld = " UPDATE $tbl SET  text='$hp_meta_description' WHERE type = 'homepage_meta_description' ";
            $rstd = mysql_query($sqld);
            $sqld = " UPDATE $tbl SET  text='$hp_meta_keywords' WHERE type = 'homepage_meta_keywords' ";
            $rstd = mysql_query($sqld);
            $my_smsg = 'Success: Homepage meta data was saved successfully.';
            
        }
        
        
        
    }
     
    
}


    $hp_meta_title = '';
	$sql_hp_meta_title = " select * from $tbl where type = 'homepage_meta_title' ORDER BY id DESC LIMIT 0,1 ";
	$rows = mysql_query($sql_hp_meta_title);
    if(mysql_num_rows($rows)>0){
        while($row = mysql_fetch_array($rows)){
            $hp_meta_title = $row['text'];
        }
    }
    
    $hp_meta_description = '';
    $sql_hp_meta_description = " select * from $tbl where type = 'homepage_meta_description' ORDER BY id DESC LIMIT 0,1 ";
	$rows = mysql_query($sql_hp_meta_description);
    if(mysql_num_rows($rows)>0){
        while($row = mysql_fetch_array($rows)){
            $hp_meta_description = $row['text'];
        }
    }
    
    $hp_meta_keywords = '';
    $sql_hp_meta_keywords = " select * from $tbl where type = 'homepage_meta_keywords' ORDER BY id DESC LIMIT 0,1 ";
	$rows = mysql_query($sql_hp_meta_keywords);
    if(mysql_num_rows($rows)>0){
        while($row = mysql_fetch_array($rows)){
            $hp_meta_keywords = $row['text'];
        }
    }
	
	

//	echo "<font color='#EEEE00'>123".$row[name_1]."</font>";
	




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

<input type="hidden" name="id" value="<?=$row[id]?>">
<input type="hidden" name="deleted" value="<?=$row[deleted]?>">
<input type="hidden" name="tbl" value="<?=$tbl?>">
<input type="hidden" name="act" value="<?=$action?>">
<input type="hidden" name="pg_num" value="<?=$list_page_num?>">
<div id="edit">
        <? include("../include/edit_title.php")?>
        <? //include("../include/edit_toolbar.php") ?>
        <div id="tool"> 
        <? if ($_SESSION["sys_write"]) { ?>

		<a class="boldbuttons" href="javascript:document.frm.submit();" ><span>Save</span></a>


	<? } ?>
    <a class="boldbuttons" href="javascript:go_back('<?=$prev_page?>', '<?=$list_page_num?>')"><span>Back</span></a>
    
</div>

<?php 
if(isset($my_smsg) && strlen($my_smsg)>2){
    echo '<div style="color:green; text-align:center; width:900px; font-size:17px;">'.$my_smsg.'</div>';
}
if(isset($my_emsg) && strlen($my_emsg)>2){
    echo '<div style="color:red; text-align:center; width:900px; font-size:17px;">'.$my_emsg.'</div>';
}
 ?>
			<fieldset><legend>Homepage Meta Data</legend>
                <form name="frm" method ="post"  action="">
                    <input type="hidden" name="custom" value="custom"/>
			
			<table>
                <tr>
                    <td width="150" align="right"><br/></td>
                    <td width="200"><br/></td>                   
                </tr>
                <tr>
                    <td align="right">Meta Title: </td>
                    
                    <td>
						<textarea name="hp_meta_title" rows="4" cols="50"><?=$hp_meta_title?></textarea>
					</td>
                </tr>
                <tr>
                    <td><br></td>
                    <td><br></td>                   
                </tr>
                <tr>
                    <td align="right">Meta Description: </td>
                    
                    <td>
						<textarea name="hp_meta_description" rows="4" cols="50"><?=$hp_meta_description?></textarea>
					</td>
                </tr>
                <tr>
                    <td><br></td>
                    <td><br></td>                   
                </tr>
                <tr>
                    <td align="right">Meta Keywords: </td>
                    
                    <td>
						<textarea name="hp_meta_keywords" rows="4" cols="50"><?=$hp_meta_keywords?></textarea>
					</td>
                </tr>
                <tr>
                    <td><br></td>
                    <td><br></td>                   
                </tr>
                
			</table>	
			</form>
			</fieldset>
	
		<br class="clear"/>
</div>		