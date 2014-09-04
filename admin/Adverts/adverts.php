<?
   
//*** Default
$func_name = "Adverts";
$tbl = "sys_user";
$prev_page = "sys_user.list";
$curr_page = "sys_user.edit";
$action_page = "sys_user.act";


//*** Request
$id = $_REQUEST['id'];
$list_page_num = $_REQUEST["pg_num"];


if(isset($_POST) && count($_POST)>0){
    if(isset($_POST['delete']) && strtolower($_POST['delete'])=='delete'){
        $rec_id = $_POST['my_id'];
        $sqlw = " DELETE from adverts_images_urls where id = $rec_id ";
        $rst = mysql_query($sqlw);
        if (mysql_affected_rows()>0){
            $my_smsg = 'Success: Record was deleted successfully.';
        }
        else{
            $my_emsg = 'Error: Record was not deleted.';
        }

    }
    if(isset($_POST['update']) && strtolower($_POST['update'])=='update'){
        $my_emsg ='';
        $rec_id = $_POST['my_id'];
        $url3 = $_POST['url3'];
        $alternate_text3 = $_POST['alternate_text3'];
        $new_window = $_POST['new_window'];
        $sort_no = $_POST['sort_no'];
        $sets = " url='$url3', alternate_text='$alternate_text3', sort_no=$sort_no, new_window='$new_window' ";
        if($_FILES['img']['size']>0){
            $image = upload_image('img');
            if($image->status){
                $path = $image->path;
               $sets.=" , image_path ='$path' ";
            }else{
                $my_emsg = $image->msg;
            }
        }
        $sqld = " UPDATE adverts_images_urls SET $sets where id = $rec_id ";
        $rstd = mysql_query($sqld);
        if (mysql_affected_rows()>0){
            $my_smsg = 'Success: Record was updated successfully.';
        }
        else{
            $my_emsg.= 'Error: Record was not updated.';
        }
    }
    if(isset($_POST['submit1']) && strtolower($_POST['submit1'])=='save'){
        $my_emsg ='';
        $rec_id = $_POST['this_id'];
        $url = $_POST['url'];
        $text = $_POST['text'];
        $new_window = $_POST['new_window'];
        $alternate_text = $_POST['alternate_text'];
        $sets = " url='$url', alternate_text='$alternate_text', new_window='$new_window' ";
        if($_FILES['img']['size']>0){
            $image = upload_image('img');
            if($image->status){
                $path = $image->path;
               $sets.=" , image_path ='$path' ";
            }else{
                $my_emsg = $image->msg;
            }
        }
        $sqld = " UPDATE adverts_images_urls SET $sets where id = $rec_id ";
        $aff = mysql_query("INSERT INTO product_page_text (id,text) VALUES ('','$text')");
        $mrows = mysql_affected_rows();
        $rstd = mysql_query($sqld);
        if (mysql_affected_rows()>0 || $mrows>0){
            $my_smsg = 'Success: Record was saved successfully.';
        }
        else{
            $my_emsg.= 'Error: Record was not saved.';
        }
    }
    if(isset($_POST['submit2']) && strtolower($_POST['submit2'])=='save'){
        $my_emsg ='';
        $rec_id = $_POST['this_id'];
        $url = $_POST['url'];
        $alternate_text = $_POST['alternate_text'];
        $new_window = $_POST['new_window'];
        $sets = " url='$url', alternate_text='$alternate_text', new_window='$new_window' ";
        if($_FILES['img']['size']>0){
            $image = upload_image('img');
            if($image->status){
                $path = $image->path;
               $sets.=" , image_path ='$path' ";
            }else{
                $my_emsg = $image->msg;
            }
        }
        $sqld = " UPDATE adverts_images_urls SET $sets where id = $rec_id ";
        $rstd = mysql_query($sqld);
        if (mysql_affected_rows()>0){
            $my_smsg = 'Success: Record was saved successfully.';
        }
        else{
            $my_emsg.= 'Error: Record was not saved.';
        }
    }
    if(isset($_POST['submit3']) && strtolower($_POST['submit3'])=='add new'){
        $rec_id = $_POST['this_id'];
        $url = $_POST['url'];
        $alternate_text = $_POST['alternate_text'];
        $sort_no = $_POST['sort_no'];
        $new_window = $_POST['new_window'];
        $image = upload_image('img');
        if($image->status){
             $sqld = " INSERT INTO adverts_images_urls (url,alternate_text,sort_no,image_path,new_window) VALUES ('$url','$alternate_text','$sort_no','$image->path','$new_window') ";
            $rstd = mysql_query($sqld);
            if (mysql_affected_rows()>0){
                $my_smsg = 'Success: Record was saved successfully.';
            }
            else{
                $my_emsg = 'Error: Record was not saved.';
            }
        }
        else{
                $my_emsg = $image->msg;
        }
       
    }
    
}
function upload_image($name,$required = true){
    $img_path = '';
    $arr = array();
    // define a constant for the maximum upload size
    define ('MAX_FILE_SIZE', 1024 * 500);
      // define constant for upload folder
      define('UPLOAD_DIR', '../../en/images/banner/');
      // replace any spaces in original filename with underscores
      $file = str_replace(' ', '_', $_FILES[$name]['name']);
      $fnamesasas = 'image_'.rand(0,100000).'_'.time().'_'.$file;
      $img_path.= UPLOAD_DIR . $fnamesasas;
      // create an array of permitted MIME types
      $permitted = array('image/gif', 'image/jpeg', 'image/pjpeg','image/png','image/jpg','image/x-png');
      // upload if file is OK
      if(in_array($_FILES[$name]['type'], $permitted)){
        if ($_FILES[$name]['size'] > 0 && $_FILES[$name]['size'] <= MAX_FILE_SIZE) {
            move_uploaded_file($_FILES[$name]['tmp_name'], $img_path);
            $arr['msg'] = 'Image was successfully uploaded';
            $arr['path'] = $fnamesasas;
            $arr['status'] = true;
        }else{
            $arr['msg'] = 'Error while uploading image.';
            $arr['status'] = false;
        }
      }else{
            $arr['msg'] = 'Error Filetype not permitted.';
            $arr['status'] = false;
        }
        return (object)$arr;
      
}
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
<?php 
$text = '';
$sqlx = "SELECT * FROM product_page_text ORDER BY id DESC LIMIT 1";
$resultx = mysql_query($sqlx);
if(mysql_num_rows($resultx)>0){
    while($row = mysql_fetch_array($resultx)){
        $text = $row['text'];
    }
}



$url = '';
$img_path = '';
$alternate_text = '';
$sqlu = "SELECT * FROM adverts_images_urls WHERE type = 'PRODUCT PAGE' ORDER BY id DESC LIMIT 1";
$resultu = mysql_query($sqlu);
if(mysql_num_rows($resultu)>0){
    while($row = mysql_fetch_array($resultu)){
        $url = $row['url'];
        $img_path = $row['image_path'];
        $alternate_text = $row['alternate_text'];
        $this_id = $row['id'];
        $new_window = $row['new_window'];
    }
}
?>

<input type="hidden" name="id" value="<?=$row[id]?>">
<input type="hidden" name="deleted" value="<?=$row[deleted]?>">
<input type="hidden" name="tbl" value="<?=$tbl?>">
<input type="hidden" name="act" value="<?=$action?>">
<input type="hidden" name="pg_num" value="<?=$list_page_num?>">
<div id="edit">
        <? include("../include/edit_title.php")?>
        <? //include("../include/edit_toolbar.php") ?>
        <div id="tool"> 
    <a class="boldbuttons" href="javascript:go_back('<?=$prev_page?>', '<?=$list_page_num?>')"><span>Back</span></a>
    
</div>
<script type="text/javascript" src="../../js/ckeditor/ckeditor.js"></script>
    <script src="../../js/ckeditor/sample.js" type="text/javascript"></script>
    <link href="../../js/ckeditor/sample.css" rel="stylesheet" type="text/css" />
<?php 
if(isset($my_smsg) && strlen($my_smsg)>2){
    echo '<div style="color:green; text-align:center; width:900px; font-size:17px;">'.$my_smsg.'</div>';
}
if(isset($my_emsg) && strlen($my_emsg)>2){
    echo '<div style="color:red; text-align:center; width:900px; font-size:17px;">'.$my_emsg.'</div>';
}
 ?>
			<fieldset>
                <form name="frm1" method ="post" enctype="multipart/form-data" action="">
                    <input type="hidden" name="level" value="product"/>
			<legend>Products Page</legend>
			<table>
                <tr>
                    <td width="150" align="right"><br></td>
                    <td width="20"><br></td>                    
                    <td width="*"><br></td>                    
                </tr>
                <tr>
                    <td align="right">Image/banner: </td>
                    
                    <td>
						<input type="file" name="img" value=""/><br/> This image should not exceed Width: 300px and Height: 86px.
					</td>
                    <td><img src="../../en/images/banner/<?=$img_path;?>"/></td>
                </tr>
                <tr>
                    <td><br></td>
                    <td><br></td>                    
                    <td><br></td>                    
                </tr>
                <tr>
                    <td align="right">Alt Text: <input type="hidden" name="this_id" value="<?=$this_id ?>"></td>
                    
                    <td><input type="text" name="alternate_text" value="<?=$alternate_text ?>"></td>
                    <td></td>
                </tr>
                <tr>
                    <td><br></td>
                    <td><br></td>                    
                    <td><br></td>                    
                </tr> 
                <tr>
                    <td align="right">Link URL: </td>
                    
                    <td><input type="text" name="url" value="<?=$url ?>"></td>
                    <td></td>
                </tr>
                <tr>
                    <td><br></td>
                    <td><br></td>                    
                    <td><br></td>                    
                </tr>
                <tr>
                    <td align="right">Open in new window: </td>
                    
                    <td>
                        <input type="radio" name="new_window" <?php if($new_window=='YES') echo ' checked="checked" '; ?>value="YES">YES &nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="new_window" <?php if($new_window=='NO') echo ' checked="checked" '; ?>value="NO">NO
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td><br></td>
                    <td><br></td>                    
                    <td><br></td>                    
                </tr> 

                <tr>
                    <td align="right">Text below Price tag: </td>
					
                    <td colspan="2"><textarea name="text"  class="ckeditor" cols="60" id="editor1" ><? echo $text; ?></textarea></td>
                </tr>
               <tr>
                    <td><br></td>
                    <td><br></td>                    
                    <td><br></td>                    
                </tr>
                <tr>
                    <td align="right">&nbsp;</td>
                    
                    <td>
                    <? if ($_SESSION["sys_write"]) { ?>
                    <input type="submit" name="submit1" value="SAVE">
                    <? } ?>
                    </td>
                    <td></td>
                </tr>
			</table>	
			</form>
			</fieldset>
		<fieldset>
<?php
$url2 = '';
$img_path2 = '';
$alternate_text2 = '';
$sql2 = "SELECT * FROM adverts_images_urls WHERE type = 'SIDEBAR TOP LEFT' ORDER BY id DESC LIMIT 1";
$result2 = mysql_query($sql2);
if(mysql_num_rows($result2)>0){
    while($row = mysql_fetch_array($result2)){
        $url2 = $row['url'];
        $img_path2 = $row['image_path'];
        $alternate_text2 = $row['alternate_text'];
        $this_id = $row['id'];
        $new_window = $row['new_window'];
    }
}
?>
            <form name="frm2" method ="post" enctype="multipart/form-data" action="">
                <input type="hidden" name="level" value="topleft"/>
			<legend>Sidebar: Top Left Advert</legend>
			<table>
                <tr>
                    <td width="150" align="right"><br></td>
                    <td width="20"><br></td>                    
                    <td width="*"><br></td>                    
                </tr>
                <tr>
                    <td align="right">Image/banner: </td>
                    
                    <td>
						<input type="file" name="img" value=""/><br/> This image should not exceed Width: 230px.
					</td>
                    <td><img src="../../en/images/banner/<?=$img_path2;?>"/></td>
                </tr>
                <tr>
                    <td><br></td>
                    <td><br></td>                    
                    <td><br></td>                    
                </tr>
                <tr>
                    <td align="right">Alt Text: <input type="hidden" name="this_id" value="<?=$this_id ?>"></td>
                    
                    <td><input type="text" name="alternate_text" value="<?=$alternate_text2 ?>"></td>
                    <td></td>
                </tr>
                <tr>
                    <td><br></td>
                    <td><br></td>                    
                    <td><br></td>                    
                </tr> 
                <tr>
                    <td align="right">Link URL: </td>
                    
                    <td><input type="text" name="url" value="<?=$url2; ?>"></td>
                    <td></td>
                </tr>
               <tr>
                    <td><br></td>
                    <td><br></td>                    
                    <td><br></td>                    
                </tr>
                <tr>
                    <td align="right">Open in new window: </td>
                    
                    <td>
                        <input type="radio" name="new_window" <?php if($new_window=='YES') echo ' checked="checked" '; ?>value="YES">YES &nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="new_window" <?php if($new_window=='NO') echo ' checked="checked" '; ?>value="NO">NO
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td><br></td>
                    <td><br></td>                    
                    <td><br></td>                    
                </tr>
                <tr>
                    <td align="right">&nbsp;</td>
                    
                    <td>
                    <? if ($_SESSION["sys_write"]) { ?>
                    <input type="submit" name="submit2" value="SAVE">
                    <? } ?>
                    </td>
                    <td></td>
                </tr>
			</table>	
			</form>
			</fieldset>
			<fieldset>
                <form name="frm3" method ="post" enctype="multipart/form-data" action="">
                    <input type="hidden" name="level" value="others"/>
			<legend>Other Sidebar Adverts</legend>
			<table>
                <tr>
                    <td width="150" align="right"><br></td>
                    <td width="20"><br></td>                    
                    <td width="*"><br></td>                    
                </tr>
                <tr>
                    <td align="right">Image/banner: </td>
                    <td></td>
                    <td>
						<input type="file" name="img" value=""/><br/> This image should not exceed Width: 240px.
					</td>
                </tr>
                <tr>
                    <td><br></td>
                    <td><br></td>                    
                    <td><br></td>                    
                </tr>
                <tr>
                    <td align="right">Link URL: </td>
                    <td></td>
                    <td><input type="text" name="url" value=""></td>
                </tr>
                <tr>
                    <td><br></td>
                    <td><br></td>                    
                    <td><br></td>                    
                </tr>
                <tr>
                    <td align="right">Open in new window: </td>
                    <td></td>
                    <td>
                        <input type="radio" name="new_window" checked="checked" value="YES">YES &nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="new_window" value="NO">NO
                    </td>
                    
                </tr>
                <tr>
                    <td><br></td>
                    <td><br></td>                    
                    <td><br></td>                    
                </tr>
                <tr>
                    <td align="right">Alt Text: </td>
                    <td></td>
                    <td><input type="text" name="alternate_text" value=""></td>
                    
                </tr>
                <tr>
                    <td><br></td>
                    <td><br></td>                    
                    <td><br></td>                    
                </tr> 
                <tr>
                    <td align="right">Priority: </td>
					<td></td>
                    <td><input type="text" name="sort_no" value=""></td>
                </tr>
               <tr>
                    <td><br></td>
                    <td><br></td>                    
                    <td><br></td>                    
                </tr>
                <tr>
                    <td align="right">&nbsp;</td>
                    <td></td>
                    <td>
                    <? if ($_SESSION["sys_write"]) { ?>
                    <input type="submit" name="submit3" value="ADD NEW">
                    <? } ?>
                    </td>
                </tr>
			</table>
            </form>
 <?php
 $count = 1;
$sql3 = "SELECT * FROM adverts_images_urls WHERE type = 'SIDEBAR OTHERS' ORDER BY id DESC ";
$result3 = mysql_query($sql3);
if(mysql_num_rows($result3)>0){
    while($row = mysql_fetch_array($result3)){
        $url3 = $row['url'];
        $img_path3 = $row['image_path'];
        $alternate_text3 = $row['alternate_text'];
        $my_id = $row['id'];
        $sort_no = $row['sort_no'];
        $new_window = $row['new_window'];

?>
<hr/>
<h3>Image No: <?=$count++;?></h3>
<form name="frmx<?=$count;?>" method ="post" enctype="multipart/form-data" action="">
        <table>
                <tr>
                    <td width="150" align="right"><br></td>
                    <td width="20"><br></td>                    
                    <td width="*"><br></td>                    
                </tr>
                <tr>
                    <td align="right">Image/banner: </td>
                    
                    <td>
                        <input type="file" name="img" value=""/><br/> This image should not exceed Width: 240px.
                    </td>
                    <td><img src="../../en/images/banner/<?=$img_path3;?>"/></td>
                </tr>
                <tr>
                    <td><br></td>
                    <td><br></td>                    
                    <td><br></td>                    
                </tr>
                <tr>
                    <td align="right">Alt Text: <input type="hidden" name="my_id" value="<?=$my_id ?>"></td>
                    
                    <td><input type="text" name="alternate_text3" value="<?=$alternate_text3 ?>"></td>
                    <td></td>
                </tr>
                <tr>
                    <td><br></td>
                    <td><br></td>                    
                    <td><br></td>                    
                </tr> 
                <tr>
                    <td align="right">Link URL: </td>
                    
                    <td><input type="text" name="url3" value="<?=$url3; ?>"></td>
                    <td></td>
                </tr>
               <tr>
                    <td><br></td>
                    <td><br></td>                    
                    <td><br></td>                    
                </tr>
                <tr>
                    <td align="right">Open in new window: </td>
                    
                    <td>
                        <input type="radio" name="new_window" <?php if($new_window=='YES') echo ' checked="checked" '; ?>value="YES">YES &nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="new_window" <?php if($new_window=='NO') echo ' checked="checked" '; ?>value="NO">NO
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td><br></td>
                    <td><br></td>                    
                    <td><br></td>                    
                </tr>
                <tr>
                    <td align="right">Priority: </td>
                    <td><input type="text" name="sort_no" value="<?=$sort_no;?>"></td><td></td>
                </tr>
               <tr>
                    <td><br></td>
                    <td><br></td>                    
                    <td><br></td>                    
                </tr>
                <tr>
                    <td align="right">&nbsp;</td>
                    
                    <td>
                    <? if ($_SESSION["sys_write"]) { ?>
                    <input type="submit" name="update" value="UPDATE">
                    <? } ?>
                    </td>
                    <td>
                    <? if ($_SESSION["sys_delete"]) { ?>
                    <input type="submit" name="delete" value="DELETE">
                    <? } ?>
                    </td>
                </tr>
            </table>
</form>


<?php
    }
}
?>	
			
			</fieldset>
		<br class="clear">
</div>		