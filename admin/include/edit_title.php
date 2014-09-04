<div id="title">
<table>
	<tr>
		<th rowspan="2"><?=$func_name?></th>
		<td>Last modify date:</td>
		<td><?=$row[modify_date]?></td>
		<td>Create date:</td>
		<td><?=$row[create_date]?></td>
	</tr>
	<tr>
		<td>Last modify by:</td>
		<td><?=get_sys_user($row[modify_by])?></td>
		<td>Create by:</td>
		<td><?=get_sys_user($row[create_by])?></td>
	</tr>            
</table>
</div>