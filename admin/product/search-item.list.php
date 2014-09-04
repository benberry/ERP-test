<?
### Default
	$func_name = "Search Item";
	$tbl = "tbl_product";
	$curr_page = "search-item.list";
	$edit_page = "search-item.edit";
	$item_edit_page = "search-item.edit";
	$action_page = "search-item.act";
	$page_item = 999;


### Request
	extract($_REQUEST);
	
	if (empty($cat_id))
		$cat_id=5;

	

### Select SQL
	$sql = "
		select
			*
		from
			$tbl
		where
			status = 0
			and deleted=0";

	if ($srh_cat_id){
		$sql .= " and cat_id = {$srh_cat_id} ";
	}
	
	if ($srh_brand_id){
		$sql .= " and brand_id = {$srh_brand_id} ";
	}
	
	if ($srh_codeno){
		$sql .= " and codeno = '{$srh_codeno}' ";
	}
	
	if ($srh_keyword){
		$sql .= " and (";
		$sql .= " name_1 like '%{$srh_keyword}%' ";
		$sql .= " or name_2 like '%{$srh_keyword}%' ";	
		$sql .= " or model like '%{$srh_keyword}%' ";
	//	$sql .= " or desc_1 like '%{$srh_keyword}%' ";
	//	$sql .= " or desc_2 like '%{$srh_keyword}%' ";
		$sql .= " ) ";
	
	}

	if ($srh_price_comparison == 1){
		$sql .= " and display_to_getprice = 1 ";

	}elseif ($srh_price_comparison == 2){
		$sql .= " and display_to_shopbot = 1 ";

	}
	
### Order by start
	if (empty($_POST["order_by"]))
		$order_by = " create_date"; 
	else
		$order_by = $_POST["order_by"];
	
	if (empty($_POST["ascend"]))
		$ascend=" desc";
	else
		$ascend=$_POST["ascend"];
	
	if (!empty($order_by)){
			$sql.="
			order by
				active desc,
				stock_status, 
				$order_by
				$ascend ";
	}

// echo $sql;

### Order by end


if ($result=mysql_query($sql))
{

	$num_rows = mysql_num_rows($result);
	
	if ($num_rows > 0 )
		$pbar = paging_bar($page_item, $num_rows);

?>

<script>

	function form_search(){
	
		fr = document.frm
		
		fr.action = "<?=$_SERVER['PHP_SELF']?>?<?=$_SERVER['QUERY_STRING']?>";
		fr.method = "post";
		fr.target = "_self";
		fr.submit();
	
	}
	
	function form_search_reset(){
		
		window.location = "<?=$_SERVER['PHP_SELF']?>?<?=$_SERVER['QUERY_STRING']?>";
	
	}

</script>

<form name="frm">
<input type="hidden" name="tbl" value="<?=$tbl?>">
<input type="hidden" name="act" value="">
<input type="hidden" name="order_by" value="<?=$order_by?>">
<input type="hidden" name="ascend" value="<?=$ascend?>">
<input type="hidden" name="del_id" value="">
<script src="../product/index.js" language="javascript"></script>
	<div id="list">
		<div id="title"><?=$func_name?></div>
		<div id="search">
			Category:
			<select name="srh_cat_id">
                <option value=""> all category </option>
                <?=get_cat_menu_combo(0, 0, $srh_cat_id)?>
			</select>
            <select name="srh_brand_id">
                <option value=""> all brands </option>
                <?=get_combobox_src("tbl_brand", "name_1", $srh_brand_id); ?>
			</select>
			Code Number: <input type="text" name="srh_codeno" value="<?=$srh_codeno?>">
			Keyword: <input type="text" name="srh_keyword" value="<?=$srh_keyword?>" style="width:300px">

            <!--select name="srh_price_comparison">
	            <option value="">Price Comparison</option>
	            <option value="1" <?=set_selected("1", $srh_price_comparison)?>>getprice </option>
	            <option value="2" <?=set_selected("2", $srh_price_comparison)?>>shopbot</option>                
			</select-->
			<input type="button" value="SEARCH" onclick="form_search()">
			<input type="button" value="RESET" onclick="form_search_reset()">            
            <br class="clear">
            
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
				<? include("../include/list_toolbar.php");	?>
            </div>
			<br class="clear">
		</div>


		<table>
			<thead>
				<tr>
					<th width="50"><input type="checkbox" name="select_all" onclick="checkbox_select_all(<?=$page_item?>)"></th>
					<th><? set_sequence("ID","id", $order_by, $ascend, $curr_page); ?></th>
					<th>Brand</th>
					<th><? set_sequence("Title","name_2", $order_by, $ascend, $curr_page); ?></th>
					<th>Code number</th>
                    <th width="80">Bar code</th>
                    <th width="80">Price</th>
					<th width="80">Available Qty</th>
					<!--th width="80"><? set_sequence("Status","stock_status", $order_by, $ascend, $curr_page); ?></th>
                    <th width="80"><? set_sequence("Sort No.","sort_no", $order_by, $ascend, $curr_page); ?></th-->
                    <th>Display</th>
					<th width="80">&nbsp;</th>
				</tr>
			</thead>    
			<tbody>
			   
			<?
			   ### Item list
			   include("item-list.php");
			?>
			</tbody>
			
		</table>

	</div>

</form>
	<?
        
    }else
        echo $sql;
    
    ?>
