<?
//*** Default
	$func_name = "System User Group";
	$tbl = "sys_user_group";
	$curr_page = "sys_user_group.list";
	$edit_page = "sys_user_group.edit";
	$action_page = "sys_user_group.act";
	$page_item = 12;


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
		$order_by = "id"; 
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
					<th onclick="javascript:order('<?=$curr_page?>','name_1')" style="cursor:pointer">Name</th>
					<th onclick="javascript:order('<?=$curr_page?>','active')" style="cursor:pointer">Status</th>
				</tr>
			
			<?
			
				mysql_data_seek($result, $pbar[0]);
			
				for($i=0; $i < $page_item ;$i++)
				{			
					if ($row = mysql_fetch_array($result))
					{
					?>
						<tr>
							<td width="50">
							<input type="checkbox" name="cb_<?=$i?>" value="<?=$row[id]?>"></td>
							<td onclick="goto_page('<?=$edit_page?>', '<?=$row[id]?>')"><?=$row[name_1]?></td>
							<td><?=get_active_icon($tbl, $row[id], $row[active], $curr_page, $_REQUEST['pg_num'])?></td>
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
			
