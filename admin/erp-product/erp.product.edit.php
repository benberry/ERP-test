<?
//***
	include("../include/tinymce_huge.php");

//*** Default
	$func_name = "ERP Search Item";
	$curr_folder="erp-product";
	$tbl = "tbl_erp_product";
	$prev_page = "erp.product.list";
	$curr_page = "erp.product.edit";
	$action_page = "erp.product.act";
	
	


//*** Request
extract($_REQUEST);

if (empty($tab))
	$tab = 0;


if (!empty($id))
{

	$sql = " select * from $tbl where id = $id ";
	
	if ($rows = mysql_query($sql)){
	
	}
	
	$row = mysql_fetch_array($rows);
	
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
<input type="hidden" name="pg_num" value="<?=$pg_num?>">
<input type="hidden" name="tab" id="tab_curr" value="<?=$tab?>">
<input type="hidden" name="fid" value="1">

<!-- Search Temp -->
<input type="hidden" name="srh_erp_main_cat" value="<?=$srh_erp_main_cat?>">
<input type="hidden" name="srh_sku" value="<?=$srh_sku?>">
<input type="hidden" name="srh_keyword" value="<?=$srh_keyword?>">
<!-- Search Temp -->

<div id="edit">

	<div id="title">
        <table>
            <tr>
                <th rowspan="2"><?=$row[name]; ?></th>
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
    <? include("../include/edit_toolbar.php") ?>

    <div id="tabs">
        <ul>
            <li><a href="#tabs-1" onclick="$('#tab_curr').val(0)">Main</a></li>
            <? if (!empty($id)) { ?>
               <!-- <li><a href="#tabs-2" onclick="$('#tab_curr').val(1)">Product Highlight</a></li>
                <li><a href="#tabs-3" onclick="$('#tab_curr').val(2)">Technical Details</a></li>
                <li><a href="#tabs-4" onclick="$('#tab_curr').val(3)">What's in the Box</a></li>
                <li><a href="#tabs-5" onclick="$('#tab_curr').val(4)">Photos</a></li>
                <li><a href="#tabs-6" onclick="$('#tab_curr').val(5)">Accessories</a></li>                    
                <li><a href="#tabs-7" onclick="$('#tab_curr').val(6)">Options</a></li>
                <li><a href="#tabs-8" onclick="$('#tab_curr').val(7)">ebay</a></li>
                <li><a href="#tabs-9" onclick="$('#tab_curr').val(8)">ebay-2</a></li>
                <li><a href="#tabs-10" onclick="$('#tab_curr').val(9)">ebay-watches</a></li>-->
            <? } ?>
        </ul>
        <div id="tabs-1"><? include("tab-main.php"); ?></div>
        <? if (!empty($id)) { ?>
       <!-- <div id="tabs-2"><? //include("tab-desc-1.php"); ?></div>
            <div id="tabs-3"><? //include("tab-desc-2.php"); ?></div>
            <div id="tabs-4"><? //include("tab-desc-3.php"); ?></div>
            <div id="tabs-5"><? //include("tab-photo.php"); ?></div>
            <div id="tabs-6"><? //include("tab-accessory.php"); ?></div>
            <div id="tabs-7"><? //include("tab-attribute.php"); ?></div>
            <div id="tabs-8"><? //include("tab-ebay-product.php"); ?></div>
            <div id="tabs-9"><? //include("tab-ebay-product-2.php"); ?></div>
            <div id="tabs-10"><?// include("tab-ebay-product-3.php"); ?></div>    -->        
        <? } ?>
    </div>

    <script>
        $('#tabs').tabs({ selected: <?=$tab?> });
    </script>

    <? include("../include/edit_toolbar.php") ?>

</div>

</form>