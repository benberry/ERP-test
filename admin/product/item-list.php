<?
### get item records
if ($num_rows > 0){

	mysql_data_seek($result, $pbar[0]);
	
	for($i=0; $i < $page_item ;$i++){
	
		if ($row = mysql_fetch_array($result)){
		
		    $brand_name=get_field("tbl_brand", "name_1", $row[brand_id]);
	
			?>
			  <tr>
				<td width="50"><input type="checkbox" name="cb_<?=$i?>" value="<?=$row[id]?>"></td>
                <td onclick="goto_item('<?=$item_edit_page?>','<?=$cat_id?>','<?=$row[id]?>')"><?=$row[id]; ?></td>                
				<td onclick="goto_item('<?=$item_edit_page?>','<?=$cat_id?>','<?=$row[id]?>')"><?=$brand_name ?></td>
				<td width="300" align="left" onclick="goto_item('<?=$item_edit_page?>','<?=$cat_id?>','<?=$row[id]?>')"><span style="font-size:14px"><?=$row[name_1]?></span><br />
                <span style="font-size:12px; color: #cccccc;"><?=$row[name_2]?></span></td>
                <td align="left" onclick="goto_item('<?=$item_edit_page?>','<?=$cat_id?>','<?=$row[id]?>')">
                	<?=$row[codeno] ?>
                </td>
				<td onclick="goto_item('<?=$item_edit_page?>','<?=$cat_id?>','<?=$row[id]?>')" align="right">
        	        <?=$row[product_code] ?>
				</td>
                <td onclick="goto_item('<?=$item_edit_page?>','<?=$cat_id?>','<?=$row[id]?>')" align="right">
	                <?=$row[unit_cost] ?>
				</td>                
                <td onclick="goto_item('<?=$item_edit_page?>','<?=$cat_id?>','<?=$row[id]?>')" align="right">
	                <?=$row[avail_qty] ?>
				</td>
                <!--td><? echo get_stock_status($row[stock_status]); ?></td>
                <td><?=$row[sort_no]?></td-->
               	<? if ($_SESSION["sys_write"]) { ?>
	                <td>
						<?=get_active_icon($tbl, $row[id], $row[active], $curr_page, $pg_num, 0, $cat_id)?>
                    </td>
                <? } ?>
				<td width="120">
				  <? if ($_SESSION["sys_write"]) { ?>
					<a href="javascript:sort_item('<?=$tbl?>', '<?=$cat_id?>', '<?=$row[id]?>', 2)"><img src="../images/up.png" width="24" border="0" title="up"></a>								
					<a href="javascript:sort_item('<?=$tbl?>', '<?=$cat_id?>', '<?=$row[id]?>', 1)"><img src="../images/down.png" width="24" border="0" title="down"></a>
                    <a href="<?=get_cfg("company_website_address")?><?=get_search_rewrite($row[name_1], $row[id])?>.html" target="_blank"><img src="../images/search.png" border="0" width="24px;"></a>
				  <? } ?>
				</td>
			  </tr>
			<?

		}

	}
	
}

### end of get item records
?>