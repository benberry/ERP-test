<?
### get item records
if ($num_rows > 0){

	mysql_data_seek($result, $pbar[0]);
	
	for($i=0; $i < $page_item ;$i++){
	
		if ($row = mysql_fetch_array($result)){
	
			?>
			  <tr>
				<td width="50"><input type="checkbox" name="cb_<?=$i?>" value="<?=$row[id]?>"></td>
				<td onclick="goto_item('<?=$item_edit_page?>','<?=$cat_id?>','<?=$row[id]?>')">
				<?
				
					if ($row[photo_1] != ''){
						
						echo get_img("tbl_attribute", $row[id], 1, "icon_crop");
	
					}else{
	
						?><img src="../images/doc.png" width="50"><?
	
					}

				?>
                </td>
				<td>
                	<a href="javascript:goto_item('<?=$item_edit_page?>','<?=$cat_id?>','<?=$row[id]?>')"><span style="font-size:14px"><?=$row[name_1]?></span></a></td>
  				<td onclick="goto_item('<?=$item_edit_page?>','<?=$cat_id?>','<?=$row[id]?>')">
                	<span style="font-size:14px"><?=number_format($row[price_1],2);?></span></td>
				<td onclick="goto_item('<?=$item_edit_page?>','<?=$cat_id?>','<?=$row[id]?>')">
                	<span style="font-size:14px"><?=number_format($row[weight],2);?> kg</span></td>
				<td><?=get_active_icon($tbl, $row[id], $row[active], $curr_page, $pg_num, 0, $cat_id)?></td>
				<td>
				  <? if ($_SESSION["sys_write"]) { ?>
					<a href="javascript:sort_item('<?=$tbl?>', '<?=$cat_id?>', '<?=$row[id]?>', 1)"><img src="../images/up.png" width="32" border="0" title="up"></a>								
					<a href="javascript:sort_item('<?=$tbl?>', '<?=$cat_id?>', '<?=$row[id]?>', 2)"><img src="../images/down.png" width="32" border="0" title="down"></a>
				  <? } ?>
				</td>
			  </tr>
			<?

		}

	}
	
}

### end of get item records
?>