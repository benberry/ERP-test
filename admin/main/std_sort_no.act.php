<?
include("../include/init.php");

$id = $_REQUEST['id'];
$cat_id = $_REQUEST['cat_id'];
$tbl = $_REQUEST['tbl'];
$rtn_page = $_REQUEST['rtn_page'];
$sort_act = $_REQUEST['sort_act'];
$pg_num = $_REQUEST['pg_num'];
$order_by = trim($_REQUEST['order_by']);
$ascend = trim($_REQUEST['ascend']);
$prev_arr = 0;
$next_arr = 0;
$int = 0;

//echo " id : $id <br>";
//echo " tbl : $tbl <br>";
//echo " rtn_page : $rtn_page <br>";
//echo " sort_act : $sort_act <br>";
//echo " pg_num : $pg_num <br>";
//echo " sort_act : $sort_act <br>";
//echo " order_by : $order_by <br>";
//echo " ascend : $ascend <br>";

if (!empty($id) && !empty($sort_act) && !empty($tbl))
{

	$sql = " select id, sort_no from $tbl where deleted = 0 ";
	
	if (!empty($cat_id)){
	
		$sql .= " and cat_id = $cat_id ";
	
	}
	
	if (!empty($order_by)){

		$sql .= " order by $order_by ";
		
		if (!empty($ascend)){

			$sql .= " $ascend ";	

		}
		
	}else{
	
		$sql .= " order by sort_no ";
		
	}

	
	// echo "$sql<br>";
		
	
	if ($result = mysql_query($sql)){
	
		while ($row = mysql_fetch_array($result))
		{
	
			$arr[$int][0] = $row[id];
			$arr[$int][1] = $row[sort_no];
		
			$int++;
		
		}
	
	}else
		echo $sql;
	
	
	//$id = 13;
	//$sort_act = 1;
	//echo " ttl count : ".count($arr)."<br>";
	
	for ($i=0; $i < count($arr); $i++)
	{
		
		if ($id == $arr[$i][0])
		{
		
			
			if ($i != 0 && $i != count($arr)-1){
	
				$prev_arr = $i - 1;
				$curr_arr = $i;			
				$next_arr = $i + 1;
	
			}elseif ($i == 0 && $i == count($arr)-1){
			
				$prev_arr = -1;
				$curr_arr = $i;			
				$next_arr = -1;
			
			}elseif ($i == 0){
			
				$prev_arr = -1;
				$curr_arr = $i;			
				$next_arr = $i+1;
			
			}elseif ($i == count($arr)-1){
			
				$prev_arr = $i-1;
				$curr_arr = $i;			
				$next_arr = -1;		
			
			}
			
			//echo "------> arr : $i &nbsp;&nbsp;&nbsp; id : {$arr[$i][0]} &nbsp;&nbsp;&nbsp; sort_no : {$arr[$i][1]} <br> ";
			//echo "******* prev_arr : $prev_arr / next_arr : $next_arr <br> ";		
			
		}
		else
		{
			//echo " arr : $i &nbsp;&nbsp;&nbsp; id : {$arr[$i][0]} &nbsp;&nbsp;&nbsp; sort_no : {$arr[$i][1]} <br> ";
		
		}
	
	}
	
	//echo "<br><br>";
	
	if ($sort_act == 1)
	{
	
		if ($prev_arr > -1)
		{
	
			//echo " - curr_arr > ".$curr_arr."<br>";
			//echo $prev_arr."<br>";
			//echo $arr[$prev_arr][0]."<br>";
			//echo $arr[$prev_arr][1]."<br>";
			
			$sql = " update $tbl set sort_no = {$arr[$prev_arr][1]} where id = {$arr[$curr_arr][0]}";
			//echo $sql."<br>";
			if (!mysql_query($sql)) echo $sql;
			$sql = " update $tbl set sort_no = {$arr[$curr_arr][1]} where id = {$arr[$prev_arr][0]}";
			//echo $sql."<br>";
			if (!mysql_query($sql)) echo $sql;		
			
		}else{
			//echo "start";
		}
		
	}
	else
	{
	
		if ($next_arr > -1)
		{
	
			//echo " + curr_arr > ".$curr_arr."<br>";
			//echo $next_arr."<br>";	
			//echo $arr[$next_arr][0]."<br>";
			//echo $arr[$next_arr][1]."<br>";
			
			$sql = " update $tbl set sort_no = {$arr[$next_arr][1]} where id = {$arr[$curr_arr][0]}";
			//echo $sql."<br>";
			if (!mysql_query($sql)) echo $sql;		
			$sql = " update $tbl set sort_no = {$arr[$curr_arr][1]} where id = {$arr[$next_arr][0]}";		
			//echo $sql."<br>";		
			if (!mysql_query($sql)) echo $sql;		
		
		}else{
			//echo "end";
		}
	}
}

?>
<script>
	//print "../main/main.php?func_pg=<?=$rtn_page?>&cat_id='+<?=$cat_id?>+'&pg_num='+<?=$pg_num?>";
	window.location = '../main/main.php?func_pg=<?=$rtn_page?>&cat_id=<?=$cat_id?>&pg_num=<?=$pg_num?>&order_by=<?=$order_by?>&ascend=<?=$ascend?>';
</script>