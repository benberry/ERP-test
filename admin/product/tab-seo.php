<script>
	function form_relate_item_add(){
		fr = document.frm
		fr.action = "../<?=$curr_folder?>/tab-relate-item-update.php";
		fr.method = "POST";
		fr.target = "_self";
		fr.submit();

	}
	
	function form_relate_item_del(id){
		fr = document.frm
		ans = confirm("OK to delete?")
		if (ans){
			fr.action = "../<?=$curr_folder?>/tab-relate-item-delete.php?del_relate_item_id="+id;
			fr.method = "POST"
			fr.target = "_self";
			fr.submit();

		}
	}
	
	function form_relate_item_sort(photo_id, act){
		fr = document.frm
		fr.action = "../<?=$curr_folder?>/tab-relate-item-sort.php?photo_id="+photo_id+"&sort_act="+act;
		fr.method = "POST"
		fr.target = "_self";
		fr.submit();

	}

</script>
<script type="text/javascript" src="../../js/ckeditor/ckeditor.js"></script>
    <script src="../../js/ckeditor/sample.js" type="text/javascript"></script>
    <link href="../../js/ckeditor/sample.css" rel="stylesheet" type="text/css" />

<?
$meta_title = '';
$custom_url = '';
$custom_url = '';
## get item records
	if (!empty($id)){
		$sql = " select * from $tbl where id=$id ";
		
		if ($rows = mysql_query($sql)){
			$rowx = mysql_fetch_array($rows);	

		}

	}
        $custom_url = $rowx[custom_url];
        $custom_url = (strlen($rowx[custom_url])>0)?$rowx[custom_url]:$rowx[name_1];
        $to_replace = array(" ", "/", "\\", "*", "&", "#", "@", "\"", "'", "+");
        $custom_url = str_replace($to_replace, "-", $custom_url);
        
        $meta_title_this = (strlen($rowx[meta_title])>0)?$rowx[meta_title]:$rowx[name_1];
        $meta_description_this = (strlen($rowx[meta_description])>0)?$rowx[meta_description]:$rowx[name_1];
        $meta_keyword_this = (strlen($rowx[meta_keyword])>0)?$rowx[meta_keyword]:$rowx[name_1];
if ($_SESSION["sys_write"]) { ?>
<fieldset>

	<legend><b>Product SEO Settings</b></legend>
	
	<p><label>Meta Title:</label><input type="text" style="width:600px;" name="meta_title" value="<?=$meta_title_this; ?>" ></p>
        
        <p><label>Meta Description:</label><input type="text" style="width:600px;" name="meta_description" value="<?=$meta_description_this; ?>"></p>
        
        <p><label>Meta Keywords:</label><input type="text" style="width:600px;" name="meta_keyword" value="<?=$meta_keyword_this; ?>"></p>
        
        <p><label>Custom URL:</label><?=get_cfg("company_website_address");?><input type="text" style="width:423px;" name="custom_url" value="<?=$custom_url; ?>">-<?=$rowx[id]; ?>.html</p>
        <p style="color:green;"><label>Current URL:</label><a target="_blank" href="<?=get_cfg("company_website_address").$custom_url;?>-<?=$rowx[id]; ?>.html"> <?=get_cfg("company_website_address").$custom_url;?>-<?=$rowx[id]; ?>.html</a></p>

        <p><label>Content:</label><div style="width: 800px; float:right; margin-right: 15px;" ><textarea name="page_bottom_content" class="ckeditor" cols="60" id="editor1"><?=$rowx[page_bottom_content]; ?></textarea></div></p>
	
</fieldset>
<? } ?>

