<? include("pop_html_head.php"); ?>
<?
//*** Default
$func_name = "Select / Upload Images";
$tbl = "sys_file_management";
$curr_page = "pop_image_mgnt.list.php";
$edit_page = "pop_image_mgnt.edit.php";
$action_page = "pop_image_mgnt.act.php";
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
	
order by

	create_date desc

";


//*** Order by start
/*
if (empty($_POST["order_by"]))
	$order_by = "create_date"; 
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
*/
//*** Order by end



if ($rows=mysql_query($sql))
{


	$num_rows = mysql_num_rows($rows);
	
	include("pop_image_paging_bar.php");

?>

<script>

	function send_back(file_path)
	{
	
		//alert(file_path);
	
		window.top.opener.jv_win.document.getElementById(window.top.opener.jv_field_name).value = file_path;
		window.close();	
	
	}

	
	function file_add_new()
	{
	
		window.location = "pop_image_mgnt.edit.php";
	
	}
	
		
	function file_del_item(page, num)
	{
	
		fr = document.frm
		
		checkbox_del_id(num);
		
		if (fr.del_id.value == '')
		{
			alert("Please select delete items")
			return
			
		}
	
		if (confirm("OK to delete?"))
		{
			
			fr.act.value = 4
			
			fr.method = "post";
			fr.target = "_self";
			fr.action = "pop_image_mgnt.act.php";
			fr.submit()			
					
		}
	
	}	

</script>
<body>
<form name="frm" enctype="multipart/form-data">
<input type="hidden" name="tbl" value="<?=$tbl?>">
<input type="hidden" name="act" value="">
<input type="hidden" name="order_by" value="<?=$order_by?>">
<input type="hidden" name="ascend" value="<?=$ascend?>">
<input type="hidden" name="del_id" value="">

			<div id="list">
				<div id="title"><?=$func_name?></div>
				<div id="tool">
					<div id="paging">
						<?=$page_bar?>
					</div>
					<div id="button">
					<!--
					<a class="boldbuttons" href="javascript:file_add_new('<?=$edit_page?>')"><span>Upload</span></a>
					<a class="boldbuttons" href="javascript:file_del_item('<?=$action_page?>', '<?=$page_item?>')"><span>Delete</span></a>-->
					<input type="button" name="" value="Add" onClick="file_add_new('<?=$edit_page?>')">
					<input type="button" name="" value="Delete" onClick="file_del_item('<?=$action_page?>', '<?=$page_item?>')">
					</div>
					<br class="clear">
				</div>

	<table>
    <thead>
        <tr>
            <th width="50"><input type="checkbox" name="select_all" onClick="checkbox_select_all(<?=$page_item?>)"></th>
            <th>Image</th>            
            <th>Name</th>
            <th>Create Date</th>
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
						<span onClick="send_back('<?=get_img_src($tbl,"{$row[id]}", 1, "org")?>')">
						<td onClick="send_back('<?=get_img_src($tbl,"{$row[id]}", 1, "org")?>')"><?=get_img($tbl,"{$row[id]}", 1, "thu")?><br><span class="tips">(click to select.)</span></td>
						<td onClick="send_back('<?=get_img_src_absolute($tbl,"{$row[id]}", 1, "org")?>')"><? if (empty($row[name_1])) echo "--"; else echo $row[name_1]; ?></td>
						<td onClick="send_back('<?=get_img_src_absolute($tbl,"{$row[id]}", 1, "org")?>')"><?=$row[create_date];?></td>
						</span>
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
</body>