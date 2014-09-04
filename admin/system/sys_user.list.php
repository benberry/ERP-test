<?
//*** Default
$func_name 		= "System User";
$tbl 			= "sys_user";
$curr_page 		= "sys_user.list";
$edit_page 		= "sys_user.edit";
$action_page 	= "sys_user.act";
$page_item 		= 100;


//*** Request
extract($_POST);


//*** Select SQL
$sql = "
select
	*
	
from
	$tbl

where
	status = 0
	and deleted <> 1
	and id <> 1

";

//*** Search
if (!empty($srh_type_id)){
	$sql .= " and sys_user_group_id = {$srh_type_id} ";
}


if (!empty($srh_keyword)){
	$sql .= " and (";
	$sql .= " code like '%{$srh_keyword}%' ";
	$sql .= " or user like '%{$srh_keyword}%' ";
	$sql .= " or name_1 like '%{$srh_keyword}%' ";
	$sql .= " or name_2 like '%{$srh_keyword}%' ";
	$sql .= " or desc_1 like '%{$srh_keyword}%' ";
	$sql .= " or desc_2 like '%{$srh_keyword}%' ";
	$sql .= " ) ";	
}



//*** Order by start
if (empty($_POST["order_by"]))
	$order_by = " sys_user_group_id "; 
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
						<?=get_combobox_src("sys_user_group", "name_1", $srh_type_id)?>
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
                    <tr>
                        <th width="50"><input type="checkbox" name="select_all" onclick="checkbox_select_all(<?=$page_item?>)"></th>
                        <th onclick="javascript:order('<?=$curr_page?>','sys_function_user_id')">Group</th>
                        <th onclick="javascript:order('<?=$curr_page?>','user')">User(Login ID)</th>
						<th onclick="javascript:order('<?=$curr_page?>','name_1')">Name</th>
						<th onclick="javascript:order('<?=$curr_page?>','phone_1')">Phone</th>
						<th onclick="javascript:order('<?=$curr_page?>','email')">Email</th>
                        <th onclick="javascript:order('<?=$curr_page?>','active')">Status</th>
                    </tr>
                
                <?
                
                    if ($num_rows > 0){
                
                        mysql_data_seek($result, $pbar[0]);
                    
                        for($i=0; $i < $page_item; $i++)
                        {
                        
                            if ($row = mysql_fetch_array($result))
                            {
                        
								?>
								<tr>
									<td width="50"><input type="checkbox" name="cb_<?=$i?>" value="<?=$row[id]; ?>"></td>
									<td onclick="goto_page('<?=$edit_page?>', '<?=$row[id]; ?>')"><?=get_field('sys_user_group', 'name_1',$row[sys_user_group_id]); ?></td>
									<td onclick="goto_page('<?=$edit_page?>', '<?=$row[id]; ?>')"><?=$row[user]; ?></td>
									<td onclick="goto_page('<?=$edit_page?>', '<?=$row[id]; ?>')"><?=$row[name_1]; ?></td>
									<td onclick="goto_page('<?=$edit_page?>', '<?=$row[id]; ?>')"><?=$row[phone_1]; ?></td>
									<td onclick="goto_page('<?=$edit_page?>', '<?=$row[id]; ?>')"><?=$row[email]; ?></td>
									<td><?=get_active_icon($tbl, $row[id], $row[active], $curr_page, $_REQUEST['pg_num']); ?></td>
								</tr>
								<?
                    
                            }
                    
                        }
                        
                    }
                    
                    ?>
                    </table>
			</div>
		</form>	
	<?
	
}else
	echo $sql;


?>

							
				
