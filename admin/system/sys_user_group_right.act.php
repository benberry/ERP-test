<?
//*** Include
include("../include/init.php");
include("../include/html_head.php");

//*** Request
$id = $_REQUEST["id"];
$gid = $_REQUEST["gid"];
$fname = $_REQUEST["fname"];
$case = $_REQUEST["case"];
$act = $_REQUEST["act"];


if ($case == 1)
{
	//echo "$case<br>";
	//***func_cols_set
	
	$sql = " 
	update 
		sys_user_group_right 
	set 
		$fname = $act 
	where 
		sys_user_group_id = $gid 
	";

	if (!mysql_query($sql))
		echo "sql syntax err : ".$sql;
		
		
}


if ($case == 2)
{
	//echo "$case<br>";
	//***func_rows_set
	
	$sql = " 
	update 
		sys_user_group_right 
	set 
	 	sys_read = $act,
	 	sys_write = $act,
	 	sys_delete = $act,
	 	sys_print = $act,
	 	sys_export = $act				
	where 
		id = $id 
	";
		

	if (!mysql_query($sql))
		echo "sql syntax err : ".$sql;
		
	
}



if ($case == 3)
{

	//echo "$case<br>";
	//***func_all
	$sql = " update sys_user_group_right 
	set 
	 sys_read = $act,
	 sys_write = $act,
	 sys_delete = $act,
	 sys_print = $act,
	 sys_export = $act				
	where sys_user_group_id = $gid ";

	if (!mysql_query($sql))
		echo "sql syntax err : ".$sql;
		
	
}


if ($case == 4)
{

	//echo "$case<br>";
	//***func_sigle
	$sql = " 
	update 
		sys_user_group_right 
	set 
		$fname = $act 
	where 
		sys_user_group_id = $gid 
		and id = $id 
	";
	
	if (!mysql_query($sql))
		echo "sql syntax err : ".$sql;
	
}


$return_to = "../main/main.php?func_pg=sys_user_group.edit&func_id=2&id=$gid";


?>
<script>
	window.location = '<?=$return_to?>';
</script>