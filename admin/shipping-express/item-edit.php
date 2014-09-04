<?
	## Default
	$func_name="Shipping - Express";
	$tbl="tbl_shipping_express";
	$cat_tbl="tbl_shipping_express_zone";
	$curr_folder="shipping-express";
	$curr_page="item-edit";
	$prev_page="index";
	$action_page="item-update";
	
	
	## TinyMCE
	include("../include/tinymce.php");

	
	## Request
	extract($_REQUEST);
	
	
	## get parent id
	if ($cat_id>0)	
		$cat_parent_id = get_field($cat_tbl,"parent_id",$cat_id);
		
	
	## check tab empty
	if (empty($tab))
		$tab=0;
		
	
	## get item records
	if (!empty($id)){
	
		$sql = " select * from $tbl where id=$id ";
		
		if ($rows = mysql_query($sql)){
			$row = mysql_fetch_array($rows);	

		}

	}
	
?>

<script>

	function form_action(act)
	{
		fr = document.frm
		fr.act.value = act;
		
		// save
		if (act == '1'){

			fr.action = '../main/main.php?func_pg=<?=$action_page?>'
			fr.method = 'post';
			fr.target = '_self';
			fr.submit();

		}		

		// not use
		if (act == '2'){
			window.location = '../main/main.php?func_pg=<?=$curr_page?>'
			return

		}

		// delete
		if (act == '3'){
			fr.deleted.value = 1;
			fr.action = '../main/main.php?func_pg=<?=$action_page?>'
			fr.method = 'post';
			fr.target = '_self';
			fr.submit();

		}

	}
	
	/*
	function goto_category(){
		fr = document.frm;
		fr.action = '../main/main.php?func_pg=<?=$prev_page?>'
		fr.method = 'post';
		fr.target = '_self';
		fr.submit();
	}
	*/

</script>
<form name="frm" enctype="multipart/form-data">
<input type="hidden" name="id" value="<?=$row[id]?>">
<input type="hidden" name="active" value="1">
<input type="hidden" name="deleted" value="<?=$row[deleted]?>">
<input type="hidden" name="tbl" value="<?=$tbl?>">
<input type="hidden" name="act" value="<?=$action?>">
<input type="hidden" name="pg_num" value="<?=$pg_num?>">
<input type="hidden" name="cat_id" value="<?=$cat_parent_id?>">
<input type="hidden" name="tab" id="tab_curr" value="<?=$tab?>">
<div id="edit">
	
        <? include("../include/edit_title.php")?>
		
        <div id="tool">
	
			<? if ($_SESSION["sys_write"]) { ?>
				<a class="boldbuttons" href="javascript:form_action(1)"><span>Save</span></a>
				
			<? } ?>
			
			<? if ($_SESSION["sys_delete"]) { ?>
				<a class="boldbuttons" href="javascript:form_action(3)"><span>Delete</span></a>
				
			<? } ?>
			
			<a class="boldbuttons" href="javascript:go_back('<?=$prev_page; ?>', '<?=$pg_num; ?>')"><span>Back</span></a>
	
		</div>
		
		<div id="tabs">
			<ul>
				<li><a href="#tabs-1" onclick="$('#tab_curr').val(0)">Main</a></li>
				<? //if (!empty($id)) { ?>
				<? //} ?>
			</ul>
			<div id="tabs-1"><? include("tab-main.php"); ?></div>
			<? // if (!empty($id)) { ?>
			<? // } ?>
		</div>
		<script>$('#tabs').tabs({ selected: <?=$tab?> });</script>
	</div>
</form>