<?
//*** Default
$func_name = "圖片管理";
$tbl = "sys_file_management";
$curr_page = "image_mngt.list";
$edit_page = "image_mngt.edit";
$action_page = "image_mngt.act";
$page_item = 18;


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



if ($rows=mysql_query($sql))
{


	$num_rows = mysql_num_rows($rows);
	
	include("../../function/paging_bar.func.php");

?>


<form name="frm">
<input type="hidden" name="tbl" value="<?=$tbl?>">
<input type="hidden" name="act" value="">
<input type="hidden" name="order_by" value="<?=$order_by?>">
<input type="hidden" name="ascend" value="<?=$ascend?>">
<input type="hidden" name="del_id" value="">

<table cellpadding="5" cellspacing="0" border="1" width="100%" style="border-collapse:collapse">
	<tr>
    	<th bgcolor="#333333" align="left"><font color="#FFFFFF">::<?=$func_name?></font></th>
    </tr>
</table>

<table cellpadding="5" cellspacing="0" border="0" bgcolor="BBBBBB" width="100%" style="border-collapse:collapse">
	<tr>
    	<td>
		<?=$page_bar?>
        </td>
        <td>
		<? include("../include/list_tool_bar.php");?>
        </td>
	</tr>
</table>

<div id="cms_data">

<table cellpadding="0" cellspacing="0" border="1" width="100%" id="table_records">
    <thead>
        <tr>
            <th width="50"><input type="checkbox" name="select_all" onclick="checkbox_select_all(<?=$page_item?>)"></th>
            <th onclick="javascript:order('<?=$curr_page?>','id')" class="clickable sortable">ID</th>
            <th onclick="javascript:order('<?=$curr_page?>','photo_1')" class="clickable sortable">Photo</th>            
            <th onclick="javascript:order('<?=$curr_page?>','name_1')" class="clickable sortable">Name(eng)</th>
            <th onclick="javascript:order('<?=$curr_page?>','name_2')" class="clickable sortable">Name(chi)</th>
            <th onclick="javascript:order('<?=$curr_page?>','active')" class="clickable sortable">Active</th>
        </tr>
    </thead>    
    <tbody>
    <?
    
		if ($num_rows > 0)
		
		{
	
			mysql_data_seek($rows, $fetch_from);
			
			for($i=0; $i < $page_item ;$i++)
			{
			
				if ($row = mysql_fetch_array($rows))
				{
			
				?>
					
					<tr>
						<td align="center" width="50"><input type="checkbox" name="cb_<?=$i?>" value="<?=$row[id]?>"></td>
						<td class="clickable" onclick="goto_page('<?=$edit_page?>', '<?=$row[id]?>')"><?=$row[id]?></td>                        
						<td class="clickable" onclick="goto_page('<?=$edit_page?>', '<?=$row[id]?>')"><?=get_img($tbl,"{$row[id]}", 1, "thu")?></td>
						<td class="clickable" onclick="goto_page('<?=$edit_page?>', '<?=$row[id]?>')"><?=$row[name_1]?></td>
						<td class="clickable" onclick="goto_page('<?=$edit_page?>', '<?=$row[id]?>')"><?=$row[name_2]?></td>
						<td class="clickable type_boolean" onclick="goto_page('<?=$edit_page?>', '<?=$row[id]?>')"><?=$row[active]?></td>
					</tr>
					
				<?
		
				}
		
			}
			
		}
        
    }
    else
        echo $sql;	
    
    ?>
    </tbody>
    
</table>

</div>

</form>