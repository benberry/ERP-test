<?
   
//*** Default
$func_name = "Custom Tracking Urls";
$tbl = "tbl_tracking";
$prev_page = "order.list";
$curr_page = "custom";
$action_page = "custom";


//*** Request
$id = $_REQUEST['id'];
$list_page_num = $_REQUEST["pg_num"];


if(isset($_POST) && count($_POST)>0){
    
    if(isset($_POST['custom']) && strtolower($_POST['custom'])=='custom'){
        $my_emsg ='';
        $tracking_name = trim($_POST['tracking_name']);
        $source_url = trim($_POST['source_url']);
        $tracking_code = trim($_POST['tracking_code']);
        $source_url_correct = true;
        $tracking_code_used = mysql_num_rows(mysql_query("SELECT * FROM tbl_tracking WHERE tracking_code = '$tracking_code'"));
        if($tracking_name==''){
            $my_emsg.= ' Tracking Name field is required.<br/>';
        }
        if($tracking_code==''){
            $my_emsg.= ' Tracking Code field is required.<br/>';
        }
        if($tracking_code_used){
            $my_emsg.= ' Tracking Code is already used.<br/>';
        }
        if($source_url==''){
            $my_emsg.= ' Source Url field is required.<br/>';
        }
        if(!$source_url_correct){
            $my_emsg.= ' Source Url is invalid.<br/>';
        }
        
        if($tracking_name!='' && $tracking_code!='' && !$tracking_code_used && $source_url_correct){
            $parsed_url = parse_url($url, PHP_URL_PATH);
            $source_url = substr($source_url,0,strlen($source_url)-stripos($source_url,'#'));
            $tracking_url = (isset($parsed_url['query']) && $parsed_url['query']!='')? $source_url.'&tid='.$tracking_code:$source_url.'?tid='.$tracking_code;
            $sqld = " INSERT INTO tbl_tracking SET  tracking_code='$tracking_code', tracking_name='$tracking_name', source_url='$source_url', tracking_url='$tracking_url', date_created=now() ";
            $rstd = mysql_query($sqld);
            
            if (mysql_affected_rows()>0){
                $tracking_urlx = $tracking_url;
                $tracking_code = '';
                $tracking_name = '';
                $tracking_url = '';
                $my_smsg = 'Success: Tracking code was created successfully. Below is the tracking url:';
            }
            else{
                $my_emsg.= 'Error: Tracking code was not created.';
            }
        }
        
        
        
    }
     
    
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
if(isset($tracking_urlx)){
    echo '<div style="color:black; font-weight:bold; text-align:center; width:900px; font-size:17px;">'.$tracking_urlx.'</div>';
}
if(isset($my_emsg) && strlen($my_emsg)>2){
    echo '<div style="color:red; text-align:center; width:900px; font-size:17px;">'.$my_emsg.'</div>';
}
 ?>
			<fieldset><legend>Custom Url</legend>
                <form name="frm" method ="post"  action="">
                    <input type="hidden" name="custom" value="custom"/>
			
			<table>
                <tr>
                    <td width="150" align="right"><br></td>
                    <td width="200"><br/></td>                   
                </tr>
                <tr>
                    <td align="right">Tracking Name: </td>
                    
                    <td>
						<input type="text" name="tracking_name" value="<?=$tracking_name?>" size="25" style="width: 300px;"/>
					</td>
                </tr>
                <tr>
                    <td><br></td>
                    <td><br></td>                   
                </tr>
                <tr>
                    <td align="right">Product URL: </td>
                    
                    <td><input type="text" name="source_url" value="<?=$source_url ?>" size="45" style="width: 550px;"/><br/>The Source Product URL should end with 'html' extension (.html) for best results.<br /><br />Example:<span style="color:green">http://cameraparadise.com/Nikon-D7000-Body-Only-Digital-Camera-198-GBP.html</span> </td>
                </tr>
                <tr>
                    <td><br></td>
                    <td><br></td>                    
                </tr> 
                <tr>
                    <td align="right">Tracking Code:</td>
                    
                    <td><input type="text" name="tracking_code" value="<?=$tracking_code ?>" size="15"  style="width: 300px;"/></td>
                </tr>
                
			</table>	
			</form>
			</fieldset>
	
		<br class="clear"/>
</div>		