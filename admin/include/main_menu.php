<div class="urbangreymenu">
<?

	$sql = " select * from sys_function_group where active = 1 and deleted = 0 order by sort_no ";
	
	if ($rows = mysql_query($sql))
	{
	
		while ($row = mysql_fetch_array($rows))
		{
		
		?>
		<h3 class="headerbar"> 
		<table width="200" border=0>
			<tr>
				<td width="30" align="left" ><img src="../images/downgreen.gif" height="16"></td>
				<td width="170" align="left" ><?=$row[name_1]?></td>
			</tr>
		</table>
		</h3>
		<ul>
		<? get_sub_menu($row[id]); ?>
		</ul>
		<br>
		<?
		}
	}

?>
</div>