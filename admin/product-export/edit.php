<?

//*** Default
	$func_name = "Export / Import";
	$tbl = "tbl_product_import";
	// $prev_page = "list";
	$curr_page = "edit";
	$action_page = "update";


//*** Request
	$tab = $_REQUEST['tab'];
	
	if (empty($tab))
		$tab=0;

?>
<script>

	function form_action(act){

		fr = document.frm
		fr.act.value = act;

		if (act == '1' || act == "5" ){
			fr.action = '../main/main.php?func_pg=<?=$action_page?>'
			fr.method = 'post';
			fr.target = '_self';
			fr.submit();
		}		

/*
		if (act == '2'){
			window.location = '../main/main.php?func_pg=<?=$curr_page?>'
			return
			
		}


		if (act == '3'){
			fr.deleted.value = 1;
			
			fr.action = '../main/main.php?func_pg=<?=$action_page?>'
			fr.method = 'post';
			fr.target = '_self';
			fr.submit();
			
		}
*/
	
	}

</script>

<form name="frm" enctype="multipart/form-data">
<input type="hidden" name="id" value="<?=$row[id]?>">
<input type="hidden" name="deleted" value="<?=$row[deleted]?>">
<input type="hidden" name="tbl" value="<?=$tbl?>">
<input type="hidden" name="act" value="<?=$action?>">
<input type="hidden" name="pg_num" value="<?=$list_page_num?>">
<input type="hidden" name="tab" id="tab_curr" value="<?=$tab?>">

<div id="edit">
	
        <? include("../include/edit_title.php")?>
		
		<div id="tabs">
			<ul>
				<li><a href="#tabs-1" onclick="$('#tab_curr').val(0)">Main</a></li>
			</ul>
			
			<div id="tabs-1"><? include("tab-main.php") ?></div>

		</div>		
		<script>
		$('#tabs').tabs({ selected: <?=$tab?> });
		</script>
		
</div>
</form>