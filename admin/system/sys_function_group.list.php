<?
//*** Default
$func_name = "System Function Group";
$tbl = "sys_function_group";
$curr_page = "sys_function_group.list";
$edit_page = "sys_function_group.edit";
$action_page = "sys_function_group.act";
$page_item = 24;


//*** Request






//*** Select SQL
$sql = "
select
	*
	
from
	$tbl

where
	status = 0 and deleted <> 1

";


//*** Order by start
if (empty($_POST["order_by"]))
	$order_by = " sort_no "; 
else
	$order_by = $_POST["order_by"];

if (empty($_POST["ascend"]))
	$ascend = "";
else
	$ascend = " desc ";

if (!empty($order_by))
{
	$sql .= "
	order by
		$order_by
		$ascend
	
	";

}
//*** Order by end



if ($result=mysql_query($sql))
{

	$num_rows = mysql_num_rows($result);
	
	if ($num_rows > 0 )
		$pbar = paging_bar($page_item, $num_rows);
		

?>

<script>

	function set_sort_no(id, sort_act)
	{

		fr = document.frm

		window.location = '../main/std_sort_no.act.php?tbl=<?=$tbl?>&rtn_page=<?=$curr_page?>&sort_act='+sort_act+'&id='+id+'&pg_num='+fr.pg_num.value+'&order_by='+fr.order_by.value+'&ascend='+fr.ascend.value;
		
	}

</script>
			<form name="frm">
			<input type="hidden" name="tbl" value="<?=$tbl?>">
			<input type="hidden" name="act" value="">
			<input type="hidden" name="order_by" value="<?=$order_by?>">
			<input type="hidden" name="ascend" value="<?=$ascend?>">
			<input type="hidden" name="del_id" value="">
			<div id="list">
				<div id="title"><?=$func_name?></div>
				<div id="tool">
					<div id="paging">
						<?	
							echo $pbar[1];
							echo $pbar[2];
							echo $pbar[4];
							echo $pbar[3];
							echo $pbar[5];
						?>
					</div>
					<div id="button"><? include("../include/list_toolbar.php");	?></div>
					<br class="clear">
				</div>
				
				<table>
					<tr>
						<th width="50"><input type="checkbox" name="select_all" onclick="checkbox_select_all(<?=$page_item?>)"></th>
						<th onclick="javascript:order('<?=$curr_page?>','name_1')">Name(eng)</th>
						<th onclick="javascript:order('<?=$curr_page?>','name_2')">Name(chi)</th>
						<th onclick="javascript:order('<?=$curr_page?>','sort_no')">Sort No.</th>
						<th onclick="javascript:order('<?=$curr_page?>','active')"></th>
					</tr>
				
				<?
				
					mysql_data_seek($result, $pbar[0]);
				
					for($i=0; $i < $page_item ;$i++)
					{
					
						if ($row = mysql_fetch_array($result))
						{
					
						?>
							
							<tr>
								<td align="center" width="50"><input type="checkbox" name="cb_<?=$i?>" value="<?=$row[id]?>"></td>
                                <td onclick="goto_page('<?=$edit_page?>', '<?=$row[id]?>')"><?=$row[name_1]?></td>
								<td onclick="goto_page('<?=$edit_page?>', '<?=$row[id]?>')"><?=$row[name_2]?></td>
								<td onclick="goto_page('<?=$edit_page?>', '<?=$row[id]?>')"><?=$row[sort_no]?></td>
								<td>
								<?=get_active_icon($tbl, $row[id], $row[active], $curr_page, $_REQUEST['pg_num'])?>
								<a href="javascript:set_sort_no('<?=$row[id]?>', 1)">
									<img src="../images/up.png" width="25" border="0" title="sequence up">
								</a>
								<a href="javascript:set_sort_no('<?=$row[id]?>', 2)">
									<img src="../images/down.png" width="25" border="0" title="sequence down">
								</a>
								</td> 
							</tr>				
					
						<?
				
						}
				
					}
					?>

			</table>
		</div>
	</form>		
	<?
}
else
	echo $sql;	

?>



</form>