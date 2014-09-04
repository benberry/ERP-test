<?
	### check parent id			
	if ( $parent_id != "" ){
		?>
		<tr onClick="goto_parent('<?=$curr_page?>', '<?=$parent_id?>')">
			<td></td>					
			<td><img src="../images/back.png" width="40" border="0" title="back"></td>            
			<td colspan="4"></td>
		</tr>
		<?
	}

	
	### Category - Start
	
	$cat_sql = "
		select
			*

		from
			$cat_tbl

		where
			status = 0 
			and deleted <> 1
			and parent_id = {$cat_id}

		order by 
			sort_no

		";
	
	if ($cat_result=mysql_query($cat_sql)){
	
		while ($cat_row=mysql_fetch_array($cat_result)){
	
			?>
			<tr>
				<td></td>
				<td onClick="goto_parent('<?=$curr_page?>', '<?=$cat_row[id]?>')"><img src="../images/folder.png" border="0" width="40" title="folder"></td>
				<td onClick="goto_parent('<?=$curr_page?>', '<?=$cat_row[id]?>')" align="left">
					<span style="font-size:18px">Zone <?=$cat_row[zone]?> - <?=$cat_row[name_1];?> </span>
				</td>
                <td onClick="goto_parent('<?=$curr_page?>', '<?=$cat_row[id]?>')">--</td>
                <td onClick="goto_parent('<?=$curr_page?>', '<?=$cat_row[id]?>')">--</td>
			</tr>
			<?
	
		}
	
	}
	
	//**** Category - End
	?>