<?

//*** Default
$func_name = "Customers";
$tbl = "tbl_member";
$prev_page = "list";
$curr_page = "edit";
$action_page = "update";

//include("../include/tinymce.php");

//*** Request
$id = $_REQUEST['id'];
$list_page_num = $_REQUEST["pg_num"];
$tab = $_REQUEST['tab'];
if (empty($tab))
	$tab=0;


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

<form name="frm" enctype="multipart/form-data">
<input type="hidden" name="id" value="<?=$row[id]?>">
<input type="hidden" name="deleted" value="<?=$row[deleted]?>">
<input type="hidden" name="tbl" value="<?=$tbl?>">
<input type="hidden" name="act" value="<?=$action?>">
<input type="hidden" name="pg_num" value="<?=$list_page_num?>">
<input type="hidden" name="tab" id="tab_curr" value="<?=$tab?>">

<div id="edit">
	
        <? include("../include/edit_title.php")?>
        <? include("../include/edit_toolbar.php") ?>
		
		<div id="tabs">
			<ul>
				<li><a href="#tabs-1" onclick="$('#tab_curr').val(0)">Main</a></li>
				<? if (!empty($id)) { ?>
					<li><a href="#tabs-2" onclick="$('#tab_curr').val(1)">Address</a></li>
				<? } ?>
			</ul>
			
			<div id="tabs-1"><? include("tab-main.php") ?></div>
			<? if (!empty($id)) { ?>
				<div id="tabs-2"><? include("tab-address.php") ?></div>
			<? } ?>
		</div>		
		<script>
		$('#tabs').tabs({ selected: <?=$tab?> });
		</script>
		
		<? //include("../include/edit_toolbar.php") ?>
		
</div>
</form>