<?
   
//*** Default
$func_name = "Data Feed Descriptions";
$tbl = "datafeed_descriptions";
$prev_page = "sys_user.list";
$curr_page = "datafeed";
$action_page = "datafeed";


//*** Request
$id = $_REQUEST['id'];
$list_page_num = $_REQUEST["pg_num"];


if(isset($_POST) && count($_POST)>0){
    if(isset($_POST['submitx']) && strtolower($_POST['submitx'])=='save'){
        $my_emsg ='';
        $rec_id = $_POST['this_id'];
        $googleau = $_POST['googleau'];
        $googleuk = $_POST['googleuk'];
        $myshopping = $_POST['myshopping'];
        $aushopping = $_POST['aushopping'];
		$getPrice = $_POST["getPrice"];
        
        $sets = " googleau='$googleau', googleuk='$googleuk', myshopping='$myshopping', aushopping='$aushopping', getPrice='$getPrice' ";
        
        $sqld = " UPDATE datafeed_descriptions SET $sets where id = $rec_id ";
        $rstd = mysql_query($sqld);
        if (mysql_affected_rows()>0){
            $my_smsg = 'Success: Record was saved successfully.';
        }
        else{
            $my_emsg.= 'Error: Record was not saved.';
        }
    }   
}
?>

<script>

	function form_action()
	{
	
		fr = document.frm;
		
		fr.act.value = act;
		
		fr.submitx.value = 'save';
		fr.action = '../main/main.php?func_pg=<?=$action_page?>';
		fr.method = 'post';
		fr.target = '_self';
		fr.submit();
	
	}

</script>
<?php 
$sqlx = "SELECT * FROM datafeed_descriptions ORDER BY id DESC LIMIT 1";
$resultx = mysql_query($sqlx);
if(mysql_num_rows($resultx)>0){
    while($row = mysql_fetch_array($resultx)){
        $id = $row['id'];
        $googleau = $row['googleau'];
        $googleuk = $row['googleuk'];
        $myshopping = $row['myshopping'];
        $aushopping = $row['aushopping'];
		$getPrice = $row["getPrice"];
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
			<fieldset>
                <form name="frm" method="post" action="">
                <input type="hidden" name="submitx" value="save" />
                <input type="hidden" name="this_id" value="<?=$id;?>" />
			<legend>Data Feed Descriptions</legend>
			<table>
                <tr>
                    <td width="150" align="right"><br></td>
                    <td width="20"><br></td>                    
                    <td width="*"><br></td>                    
                </tr>
                

                <tr>
                    <td align="right">Google AU: </td>
					
                    <td colspan="2"><textarea name="googleau" cols="60" id="googleau" ><?=$googleau;?></textarea></td>
                </tr>
               <tr>
                    <td><br></td>
                    <td><br></td>                    
                    <td><br></td>                    
                </tr>
                
                <tr>
                    <td align="right">Google UK: </td>
					
                    <td colspan="2"><textarea name="googleuk" cols="60" id="googleuk" ><?=$googleuk;?></textarea></td>
                </tr>
               <tr>
                    <td><br></td>
                    <td><br></td>                    
                    <td><br></td>                    
                </tr>
                
                <tr>
                    <td align="right">My Shopping.com: </td>
					
                    <td colspan="2"><textarea name="myshopping" cols="60" id="myshopping" ><?=$myshopping;?></textarea></td>
                </tr>
               <tr>
                    <td><br></td>
                    <td><br></td>                    
                    <td><br></td>                    
                </tr>
                
                <tr>
                    <td align="right">AU Shopping.com: </td>
					
                    <td colspan="2"><textarea name="aushopping" cols="60" id="aushopping" ><?=$aushopping;?></textarea></td>
                </tr>
                <tr>
                    <td><br></td>
                    <td><br></td>                    
                    <td><br></td>                    
                </tr>
                 <tr>
                    <td align="right">Price :</td>
					
                    <td colspan="2"><input type="text" name="getPrice" id="getPrice" value="<?php echo $getPrice; ?>"  /> </td>
                </tr>
               <tr>
                    <td><br></td>
                    <td><br></td>                    
                    <td><br></td>                    
                </tr>
               
			</table>	
			</form>
			</fieldset>
		
			
		<br class="clear">
</div>		