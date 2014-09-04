<?

include("../include/init.php");

extract($_REQUEST);

$sql = " update $tbl set active = $act where id = $id ";

if (!mysql_query($sql))
	echo $sql;

?>
<script>
	window.location = "../main/main.php?func_pg=<?=$func_pg?>&id=<?=$id?>&cat_id=<?=$cat_id;?>&pg_num=<?=$pg_num?>&cat_id=<?=$cat_id?>&srh_type_id=<?=$srh_type_id?>";
</script>