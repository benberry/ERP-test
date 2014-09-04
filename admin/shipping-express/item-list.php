<?
### get item records
if ($num_rows > 0){

	mysql_data_seek($result, $pbar[0]);
	
	for($i=0; $i < $page_item ;$i++){
	
		if ($row = mysql_fetch_array($result)){
	
			?>
			  <tr>
				<td width="50"><input type="checkbox" name="cb_<?=$i?>" value="<?=$row[id]?>"></td>
				<td width="100" onclick="goto_item('<?=$item_edit_page?>','<?=$cat_id?>','<?=$row[id]?>')">
				<img src="../images/doc.png" border="0" width="40" title="item"></td>
				<td onclick="goto_item('<?=$item_edit_page?>','<?=$cat_id?>','<?=$row[id]?>')">--</td>
				<td width="100" align="right" style="font-size:16px" onclick="goto_item('<?=$item_edit_page?>','<?=$cat_id?>','<?=$row[id]?>')"><?=number_format($row[weight], 1);?></td>
				<td width="100" align="right" style="font-size:16px" onclick="goto_item('<?=$item_edit_page?>','<?=$cat_id?>','<?=$row[id]?>')"><?=number_format($row[cost], 2);?></td>
			  </tr>
			<?

		}

	}
	
}

### end of get item records
?>