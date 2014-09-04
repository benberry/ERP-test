<?

	## Default
	$func_name="Product";
	$tbl="tbl_product";
	$cat_tbl="tbl_product_category";
	$curr_folder="product";
	$curr_page="item-edit";
	$prev_page="index";
	$action_page="item-update";
	
	
	## TinyMCE
	include("../include/tinymce_huge.php");

	
	## Request
	extract($_REQUEST);
	
	
	## get parent id
	if ($cat_id > 0)
		$cat_parent_id = get_field($cat_tbl, "parent_id", $cat_id);
		
	
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
			
			// update_accessories();
			
			// set active			
			//if (fr.id.value=='')
			//	fr.active[0].checked = true;
			
			fr.action = '../main/main.php?func_pg=<?=$action_page?>'
			fr.method = 'post';
			fr.target = '_self';
			fr.submit();

		}

		// save as
		if (act == '2'){
			
			fr.id.value = '';
			fr.action = '../main/main.php?func_pg=<?=$action_page?>'
			fr.method = 'post';
			fr.target = '_self';
			fr.submit();


		}

		// delete
		if (act == '3'){
			
			if (confirm("Ok to delete?"))
			{			
			
				fr.deleted.value = 1;
				fr.action = '../main/main.php?func_pg=<?=$action_page?>'
				fr.method = 'post';
				fr.target = '_self';
				fr.submit();
				
			}

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
<input type="hidden" name="deleted" value="<?=$row[deleted]?>">
<input type="hidden" name="tbl" value="<?=$tbl?>">
<input type="hidden" name="act" value="<?=$action?>">
<input type="hidden" name="pg_num" value="<?=$pg_num?>">
<input type="hidden" name="cat_id" value="<?=$cat_parent_id?>">
<input type="hidden" name="tab" id="tab_curr" value="<?=$tab?>">
<div id="edit">
        <? //include("../include/edit_title.php")?>
        <div id="title">
        <table>
            <tr>
                <th rowspan="2"><?=$row[name_1]; ?></th>
                <td>Last modify date:</td>
                <td><?=$row[modify_date]; ?></td>
                <td>Create date:</td>
                <td><?=$row[create_date]; ?></td>
            </tr>
            <tr>
                <td>Last modify by:</td>
                <td><?=get_sys_user($row[modify_by])?></td>
                <td>Create by:</td>
                <td><?=get_sys_user($row[create_by])?></td>
            </tr>            
        </table>
        </div>
		
        <div id="tool">
	
			<? if ($_SESSION["sys_write"]) { ?>
				<a class="boldbuttons" href="javascript:form_action(1)"><span>Save</span></a>
				
			<? } ?>
            
			<? if ($_SESSION["sys_write"]) { ?>
				<!--<a class="boldbuttons" href="javascript:form_action(2)"><span>Save As</span></a>-->
				
			<? } ?>            
			
			<? if ($_SESSION["sys_delete"]) { ?>
				<a class="boldbuttons" href="javascript:form_action(3)"><span>Delete</span></a>
				
			<? } ?>
			
			<a class="boldbuttons" href="javascript:go_back('<?=$prev_page; ?>', '<?=$pg_num; ?>')"><span>Back</span></a>
	
		</div>
		
		<div id="tabs">
        
			<ul>
				<li><a href="#tabs-1" onclick="$('#tab_curr').val(0)">Main</a></li>
				<? if (!empty($id)) { ?>
	                <li><a href="#tabs-2" onclick="$('#tab_curr').val(1)">Price</a></li>
					<li><a href="#tabs-3" onclick="$('#tab_curr').val(2)">Highlight</a></li>
					<li><a href="#tabs-4" onclick="$('#tab_curr').val(3)">Technical Details</a></li>
					<li><a href="#tabs-5" onclick="$('#tab_curr').val(4)">What's in the Box</a></li>
                    <li><a href="#tabs-6" onclick="$('#tab_curr').val(5)">Photos</a></li>
					<li><a href="#tabs-7" onclick="$('#tab_curr').val(6)">Accessories</a></li>                    
					<li><a href="#tabs-8" onclick="$('#tab_curr').val(7)">Options</a></li>
                    <li><a href="#tabs-9" onclick="$('#tab_curr').val(8)">ebay</a></li>
                    <li><a href="#tabs-10" onclick="$('#tab_curr').val(9)">ebay-2</a></li>
                    <li><a href="#tabs-11" onclick="$('#tab_curr').val(10)">ebay-watches</a></li>
                    <li><a href="#tabs-12" onclick="$('#tab_curr').val(11)">Relate items</a></li>
		    <li><a href="#tabs-13" onclick="$('#tab_curr').val(12)">SEO</a></li>
				<? } ?>
			</ul>
            
			<div id="tabs-1"><? include("tab-main.php"); ?></div>
			<? if (!empty($id)) { ?>
				<div id="tabs-2"><? include("tab-price.php"); ?></div>
				<div id="tabs-3"><? include("tab-desc-1.php"); ?></div>
				<div id="tabs-4"><? include("tab-desc-2.php"); ?></div>
				<div id="tabs-5"><? include("tab-desc-3.php"); ?></div>
				<div id="tabs-6"><? include("tab-photo.php"); ?></div>
                <div id="tabs-7"><? include("tab-accessory.php"); ?></div>
                <div id="tabs-8"><? include("tab-attribute.php"); ?></div>
                <div id="tabs-9"><? include("tab-ebay-product.php"); ?></div>
                <div id="tabs-10"><? include("tab-ebay-product-2.php"); ?></div>
                <div id="tabs-11"><? include("tab-ebay-product-3.php"); ?></div>
                <div id="tabs-12"><? include("tab-relate-item.php"); ?></div>
		<div id="tabs-13"><? include("tab-seo.php"); ?></div>
			<? } ?>
            
		</div>
		<script>$('#tabs').tabs({ selected: <?=$tab?> });</script>
        <div id="tool">
			<? if ($_SESSION["sys_write"]) { ?>
				<a class="boldbuttons" href="javascript:form_action(1)"><span>Save</span></a>
			<? } ?>
			
			<? if ($_SESSION["sys_delete"]) { ?>
				<a class="boldbuttons" href="javascript:form_action(3)"><span>Delete</span></a>
			<? } ?>
			
			<a class="boldbuttons" href="javascript:go_back('<?=$prev_page; ?>', '<?=$pg_num; ?>')"><span>Back</span></a>
		</div>
	</div>
</form>