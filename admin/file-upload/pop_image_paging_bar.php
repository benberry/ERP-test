<?
//*** paging start


$pg_num = $_REQUEST["pg_num"];


$total_page = ceil($num_rows / $page_item);
if($total_page <= 0){
	$total_page = 1;
}

if($pg_num < 1 || $pg_num > $total_page || !is_numeric($pg_num)){
	$pg_num = 1;
}

if($total_page > 1){
	if($pg_num > 1){
		$prev_pg = $pg_num - 1;
	}
	if($pg_num < $total_page){
		$next_pg = $pg_num + 1;
	}
}

$fetch_from = ($pg_num-1) * $page_item;

//*** paging end

if (!empty($prev_pg))
{
$page_bar = '
<input type="button" value=" < " onclick="paging('.$prev_pg.')">
';
}


$page_bar .= '
<select name="pg_num" onchange="paging(this.value)">
';

        
for ($i=1; $i <= $total_page; $i++)
{
	
	if ($pg_num != $i)
	{
		$page_bar .= "<option value='$i'>Page ".$i."</option>";
	}
	else
	{
		$page_bar .= "<option value='$i' selected='selected'>Page ".$i."</option>";
	}

}
		
$page_bar .= '
</select>
';

if (!empty($next_pg))
{
$page_bar .= '
<input type="button" value=" > " onclick="paging('.$next_pg.')">
';
}

$page_bar .= '
&nbsp;&nbsp;&nbsp;&nbsp;'.$total_page.' page(s), '.$num_rows.' record(s)
';

?>
<script>
	function paging(pg_num)
	{
	
		fr = document.frm
		
		fr.pg_num.value = pg_num
		
		fr.method = "post";
		fr.target = "_self";
		fr.action = "<?=$curr_page?>";
		fr.submit()
		
	}
</script>