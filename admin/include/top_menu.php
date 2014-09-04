<div id="smoothmenu-ajax" class="ddsmoothmenu">
	<ul>
	
	<?
	
	$lang = 1;
	
	?>
	
	<?
	
	$sql = " select * from sys_function_group where active = 1 and id not in ( 6, 40, 43, 44, 47, 48 ) and deleted = 0 ";
	
	if ($rows = mysql_query($sql))
	{
	
		$i = 0;
	
		while ($row = mysql_fetch_array($rows))
		{
		
		?>
	
			<li><a href="#"><?=$row['name_'.$lang] ?></a>
				<ul>
				<? get_sub_menu($row[id]); ?>
				</ul>
			</li>
	
		<?
		
			$i++;
		
		}
	}else
		echo $sql;
	?>
	
	</ul>
</div>


<?
/*
$sql = " select * from sys_function_group where active = 1 and deleted = 0 order by sort_no ";

if ($rows = mysql_query($sql))
{

	$i = 0;

	while ($row = mysql_fetch_array($rows))
	{
	
	?>

		<ul id="ddsubmenu<?=$i?>" class="ddsubmenustyle">
        
        <? get_sub_menu($row[id]); ?>
        
        </ul>

	<?
	
		$i++;
	
	}
	
}else
	echo $sql;
*/
?>

<script type="text/javascript">

ddsmoothmenu.init({
	mainmenuid: "smoothmenu-ajax", //menu DIV id
	orientation: 'h', //Horizontal or vertical menu: Set to "h" or "v"
	classname: 'ddsmoothmenu', //class added to menu's outer DIV
	contentsource: "markup", //"markup" or ["container_id", "path_to_menu_file"]

})

</script>	
