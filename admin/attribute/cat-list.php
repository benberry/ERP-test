<?
	### check parent id			
	if ( $parent_id != "" ){
		?>
		<tr onClick="goto_parent('<?=$curr_page?>', '<?=$parent_id?>')">
			<td></td>					
			<td><img src="../images/back.png" width="40" border="0" title="back"></td>            
			<td colspan="6"></td>
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
				<td onClick="goto_parent('<?=$curr_page?>', '<?=$cat_row[id]?>')">
					<span style="font-size:18px"><?=$cat_row[name_1]?></span><br />
					<?=get_item_count($tbl, $cat_row[id]); ?><br />
				</td>
                <td>--</td>
                <td>--</td>
				<td><?=get_active_icon($cat_tbl, $cat_row[id], $cat_row[active], $curr_page, $pg_num, 0, $cat_id);?></td>
				<td align="left">
				<?
					// sorting
					if ($_SESSION["sys_write"]) {
						if (get_category_level_count($cat_tbl, $cat_id)<$cat_level){ 
							?>
							<a href="javascript:sort_category('<?=$cat_tbl?>', <?=$cat_id?>, '<?=$cat_row[id]?>', 1)"><img src="../images/up.png" width="32" border="0" title="up"></a>
							<a href="javascript:sort_category('<?=$cat_tbl?>', <?=$cat_id?>, '<?=$cat_row[id]?>', 2)"><img src="../images/down.png" width="32" border="0" title="down"></a>
							<a href="javascript:edit_category('<?=$cat_edit_page?>', '<?=$cat_id?>', '<?=$cat_row[id]?>')"><img src="../images/edit_add.png" width="32" border="0" title="edit category"></a>
							<?
						}
					}
				
					// delete category
					if ($_SESSION["sys_delete"]) {
						if (get_category_level_count($cat_tbl, $cat_id)<$cat_level){ 
							?><a href="javascript:delete_category('<?=$cat_tbl?>','<?=$cat_id?>', '<?=$cat_row[id]?>')"><img src="../images/edit_remove.png" width="32" border="0" title="delete"></a><?
						}
					}
				?>
				</td>                    
			</tr>
			<?
	
		}
	
	}
	
	//**** Category - End
	?>