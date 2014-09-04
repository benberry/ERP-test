<? include("../include/init.php"); ?>
<? include("../include/html_head.php"); ?>
<?
//*** Default
$func_name = "User List";
$tbl = "sys_user";
$curr_page = "pop_user.list.php";
$page_item = 24;


//*** Request
extract($_REQUEST);





//*** Select SQL
$sql = "
select
	*
	
from
	$tbl

where
	status=0 and deleted<>1 and id<>0
	
";

if ($srh_keyword != ""){

	$sql .= " and ( user like '%$srh_keyword%' )";
	
}


$sql .= " order by
	user

";


if ($rows=mysql_query($sql))
{


	$num_rows = mysql_num_rows($rows);
	
	if ($num_rows > 0 )
		$pbar = paging_bar($page_item, $num_rows);

?>

<script>

	function send_back(str1, str2)
	{
		
		window.top.opener.document.getElementById('user_name').value = str1;
		window.top.opener.document.getElementById('user_id').value = str2;
		window.close();
	}
	
	function form_search()
	{
		fr = document.frm;
		fr.action = "pop_user.list.php";
		fr.method = "post";
		fr.target = "_self";
		fr.submit();
	}
	

</script>
<body topmargin="0" leftmargin="0">
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
		<?
		echo $pbar[1];
		echo $pbar[2];
		echo $pbar[4];
		echo $pbar[3];
		echo $pbar[5];
        ?>
        </td>
    	<td align="right"><input type="text" name="srh_keyword" value="<?=$srh_keyword;?>"><input type="button" value="Search" onClick="form_search()"></td>
	</tr>
</table>
<table cellpadding="0" cellspacing="0" border="1" width="100%" id="table_records">
    <thead>
        <tr>
            <th onClick="javascript:order('<?=$curr_page?>','user')" class="clickable sortable">Staff No.</th>
            <th onClick="javascript:order('<?=$curr_page?>','user')" class="clickable sortable">User</th>
            <th onClick="javascript:order('<?=$curr_page?>','user')" class="clickable sortable">Group</th>            
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
                    <td class="clickable" onClick="send_back('<?=get_field($tbl, "user", $row[id]);?>', '<?=$row[id]?>');"><?=$row[user];?></td>
                    <td align="center" onClick="send_back('<?=get_field($tbl, "user", $row[id]);?>', '<?=$row[id]?>');"><?=$row[code]?></td>
                    <td class="clickable" onClick="send_back('<?=get_field($tbl, "user", $row[id]);?>', '<?=$row[id]?>');"><?=get_field('sys_user_group', 'name_2',$row[sys_user_group_id])?></td>
                </tr>
					
				<?
		
				}
		
			}
			
		}else{
			
				?>
					
                <tr>
                    <td class="clickable" >No record.</td>
                </tr>
					
				<?
			
		}
        
    }
    else
        echo $sql;	
    
    ?>
    </tbody>
</table>
</form>
</body>