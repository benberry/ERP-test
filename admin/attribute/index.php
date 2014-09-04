<?
## Default
	$func_name			= "Accessories";
	$folder				= "attribute";
	$tbl 				= "tbl_attribute";
	$curr_page 			= "index";
	$curr_folder 		= "attribute";
	$item_edit_page 	= "item-edit";
	$item_update_page 	= "item-update";
	$cat_tbl			= "tbl_attribute_category";
	$cat_edit_page 		= "cat-edit";
	$cat_update_page 	= "cat-update";
	$page_item			= 999;
	$cat_level			= 1;
	$item_level			= 1;


## Request
	extract($_REQUEST);


## if cat id empty
	if (empty($cat_id))
		$cat_id=0;


## get parent id	
	$parent_id=get_field($cat_tbl, "parent_id", $cat_id);


## sql get product records
	$sql = "
		select
			*
		from
			$tbl
		where
			deleted=0
			and cat_id=$cat_id

	";


## sql set order by
	if (empty($_POST["order_by"]))
		$order_by = "sort_no";
	else
		$order_by = $_POST["order_by"];


	if (empty($_POST["ascend"]))
		$ascend = " ";
	else
		$ascend = $_POST["ascend"];


	if (!empty($order_by))
	{
		$sql .= "
			order by
				$order_by
				$ascend
		";
	}
	
	//echo $sql;


## end of sql set order by
if ($result=mysql_query($sql)){
	
	$num_rows = mysql_num_rows($result);
	
	if ($num_rows > 0 )
		$pbar = paging_bar($page_item, $num_rows);

	?>
	<script>
		var folder="<?=$folder; ?>";

	</script>
	<script src="../<?=$folder; ?>/index.js" language="javascript"></script>
	<form name="frm">
	<input type="hidden" name="tbl" value="<?=$tbl?>">
	<input type="hidden" name="cat_tbl" value="<?=$cat_tbl?>">
	<input type="hidden" name="act" value="">
	<input type="hidden" name="order_by" value="<?=$order_by?>">
	<input type="hidden" name="ascend" value="<?=$ascend?>">
	<input type="hidden" name="del_id" value="">
	<input type="hidden" name="deleted" value="">

	<div id="list">
		<div id="title"><?=$func_name?></div>
		<div id="search">
			GO TO:
			<select name="cat_id" style="width:400px" onchange="goto_parent('<?=$curr_page?>', this.value)">
				<option value="">TOP</option>
				<?=get_category_combo($cat_tbl, 0, 0, $cat_id)?>
			</select>
		</div>
		<div id="tool">
			<div id="paging">
				<?	
					echo $pbar[1];
					echo $pbar[2];
					echo $pbar[4];
					echo $pbar[3];
					echo $pbar[5];
				?>
			</div>
			<div id="button">


			<? 
			## set add category level
			if (get_category_level_count($cat_tbl, $cat_id) < $cat_level ){
				?>
				<a class="boldbuttons" href="javascript:add_category('<?=$cat_edit_page?>', '<?=$cat_id?>')">
					<span>Add&nbsp;Category</span>
				</a>
				<? 
			}


			## set add / delete product level

			if (get_category_level_count($cat_tbl, $cat_id) >= $item_level ){ 
				if ($_SESSION["sys_write"]) {
					?>
					<a class="boldbuttons" style="width:200px" href="javascript:add_option_to_product('<?=$item_update_page?>', '<?=$page_item?>')"><span>Add&nbsp;accessories&nbsp;to&nbsp;products</span></a>
					<?
				}			
			
				if ($_SESSION["sys_write"]) {
					?>
					<a class="boldbuttons" href="javascript:add_item('<?=$item_edit_page?>', '<?=$cat_id?>')"><span>Add&nbsp;Item</span></a>
					<?
				}
				
				if ($_SESSION["sys_delete"]) {
					?> 
					<a class="boldbuttons" href="javascript:del_item('<?=$item_update_page?>', '<?=$page_item?>')"><span>Delete&nbsp;Item</span></a>
					<?
				}
				
			}

			?>					
			
			</div>			
			<br class="clear">
		</div>
		
		<div id="location">::<?=get_category_location($cat_tbl, $cat_id)?></div>	

		<table>
			<thead>
				<tr>
					<th width="50"><input type="checkbox" name="select_all" onclick="checkbox_select_all(<?=$page_item?>)"></th>
					<th>Category / Item</th> 
					<th><? set_sequence("Name","name_1", $order_by, $ascend, $cat_edit_page) ?></th>
					<!--<th><? //set_sequence("Style No.","product_code", $order_by, $ascend, $cat_edit_page) ?></th>-->
					<th>Price($)</th>
                    <th>Weight(kg)</th>
                    <th></th>
					<th width="160">&nbsp;</th>          
				</tr>
			</thead>    
			<tbody>
				
				<?
				
				### Category list
					include("cat-list.php");
					
					
				### Item list
					include("item-list.php");
					
				
			}else //if ($result=mysql_query($sql))
				echo $sql;	
			
			?>
		</table>
	</div>
</form>
	
		