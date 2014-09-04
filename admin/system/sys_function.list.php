<?
//*** Default
	$func_name = "System Function";
	$tbl = "sys_function";
	$curr_page = "sys_function.list";
	$edit_page = "sys_function.edit";
	$action_page = "sys_function.act";
	$page_item = 12;


//*** Request
	extract($_REQUEST);


//*** Select SQL
	$sql = "
	select
		*
		
	from
		$tbl
	
	where
		status = 0 and deleted <> 1
	
	";
	
	//*** search criteria - start

		if (!empty($srh_type_id)){
			$_SESSION["srh_type_id"]=$srh_type_id;
		}elseif (!empty($_SESSION["srh_type_id"])){
			$srh_type_id=$_SESSION["srh_type_id"];
		}
	
		if (!empty($srh_type_id)){
			$sql .= " and sys_function_group_id={$srh_type_id} ";
			
		}
			
		
	//*** search criteria - end

	


	//*** Order by start
		if (empty($_POST["order_by"]))
			$order_by = "sys_function_group_id, name_1"; 
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
	
	//echo $sql;

//*** Select SQL - end


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
				<div id="search">
					Type: 
					<select name="srh_type_id" onchange="type_change()">
						<option value=""> All </option>
						<?=get_combobox_src("sys_function_group", "name_1", $srh_type_id)?>
					</select>
				</div>
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
					<thead>
						<tr>
							<th width="50"><input type="checkbox" name="select_all" onclick="checkbox_select_all(<?=$page_item?>)"></th>
							<th onclick="javascript:order('<?=$curr_page?>','id')">ID</th>            
							<th onclick="javascript:order('<?=$curr_page?>','sys_function_group_id')">Function Group</th>
							<th onclick="javascript:order('<?=$curr_page?>','name_1')">Name(eng)</th>
							<th onclick="javascript:order('<?=$curr_page?>','name_2')">Name(chi)</th>
							<th onclick="javascript:order('<?=$curr_page?>','folder')">Folder</th>
							<th onclick="javascript:order('<?=$curr_page?>','page')">Path</th>					
							<th onclick="javascript:order('<?=$curr_page?>','active')"></th>
						</tr>
					</thead>    
					<tbody>
				<?
				
				if ($num_rows > 0){
			
					mysql_data_seek($result, $pbar[0]);
				
					for($i=0; $i < $page_item ;$i++)
					{
					
						if ($row = mysql_fetch_array($result))
						{
					
						?>
							
							<tr>
								<td align="center" width="50"><input type="checkbox" name="cb_<?=$i?>" value="<?=$row[id]?>"></td>
								<td><?=$row[id]?></td>
								<td onclick="goto_page('<?=$edit_page?>', '<?=$row[id]?>')"><?=get_field('sys_function_group', 'name_1',$row[sys_function_group_id])?></td>
								<td onclick="goto_page('<?=$edit_page?>', '<?=$row[id]?>')"><?=$row[name_1]?></td>
								<td onclick="goto_page('<?=$edit_page?>', '<?=$row[id]?>')"><?=$row[name_2]?></td>
								<td onclick="goto_page('<?=$edit_page?>', '<?=$row[id]?>')"><?=$row[folder]?></td>
								<td onclick="goto_page('<?=$edit_page?>', '<?=$row[id]?>')"><?=$row[page]?></td>
								<td>
								<?=get_active_icon($tbl, $row[id], $row[active], $curr_page, $_REQUEST['pg_num'], $srh_type_id)?>
								</td>
							</tr>
							
						<?
				
						}
				
					}
					
				}
				?>
		    </tbody>
		</table>		
	</div>
</form>		
	<?
	
}
else
	echo $sql;	

?>


