<?
### get item records
if ($num_rows > 0){

	mysql_data_seek($result, $pbar[0]);
	
	for($i=0; $i < $page_item ;$i++){
	
		if ($row = mysql_fetch_array($result)){		
			?>
			  <tr>
				<td width="50"><input type="checkbox" name="cb_<?=$i?>" value="<?=$row[id]?>"></td>
                <td onclick="goto_item('<?=$item_edit_page?>','<?=$cat_id?>','<?=$row[id]?>')"><?=$row[id]; ?></td>                
				<td width="300" align="left" onclick="goto_item('<?=$item_edit_page?>','<?=$cat_id?>','<?=$row[id]?>')"><span style="font-size:14px"><?=$row[main_category]?></span></td>
				<td width="300" align="left" onclick="goto_item('<?=$item_edit_page?>','<?=$cat_id?>','<?=$row[id]?>')"><span style="font-size:14px"><?=$row[name]?></span></td>
                <td align="left" onclick="goto_item('<?=$item_edit_page?>','<?=$cat_id?>','<?=$row[id]?>')">
                	<?=$row[sku] ?>
                </td>             
                <td onclick="goto_item('<?=$item_edit_page?>','<?=$cat_id?>','<?=$row[id]?>')" align="right">
	                <?=$row[current_qty] ?>
				</td>
                <td><? echo $row[active]==0?"Disabled":"Enabled"; ?></td>                
               	<? if ($_SESSION["sys_write"]) { ?>
	                <td>
						<?=get_active_icon($tbl, $row[id], $row[active], $curr_page, $pg_num, 0, 0)?>
                    </td>
                <? } ?>				
			  </tr>
			<?
		}
	}	
}
### end of get item records
?>