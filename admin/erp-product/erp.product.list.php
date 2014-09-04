<?
### Default
	$func_name = "ERP product Searching";
	$tbl = "tbl_erp_product";
	$curr_page = "erp.product.list";
	$edit_page = "erp.product.edit";
	$item_edit_page = "erp.product.edit";
	$action_page = "erp.product.act";
	$page_item = 500;


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
			sku <> ''";

	if ($srh_erp_main_cat){
		$sql .= " and main_category = '{$srh_erp_main_cat}' ";
	}
		
	if ($srh_sku){
		$sql .= " and sku = '{$srh_sku}' ";
	}
		
	if ($srh_current_qty){
		$sql .= " and current_qty > {$srh_current_qty} ";
	}
	
	if ($srh_keyword){
		$sql .= " and (";
		$sql .= " name like '%{$srh_keyword}%' ";
	//	$sql .= " or name_2 like '%{$srh_keyword}%' ";	
	//	$sql .= " or model like '%{$srh_keyword}%' ";
	//	$sql .= " or desc_1 like '%{$srh_keyword}%' ";
	//	$sql .= " or desc_2 like '%{$srh_keyword}%' ";
		$sql .= " ) ";
	
	}

	if (!empty($order_by)){
			$sql.="
			order by				
				id ASC";
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
			<select name="srh_erp_main_cat">
                <option value=""> all category </option>
                <?=get_erp_cat_menu()?>
			</select>           
			sku: <input type="text" name="srh_sku" value="<?=$srh_sku?>">
			Current Qty>=<input type="text" name="srh_current_qty" value="<?=$srh_current_qty?>" >
			Keyword: <input type="text" name="srh_keyword" value="<?=$srh_keyword?>" style="width:300px">
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
					<th>ID</th>
					<th>Category</th>
					<th>Name</th>
					<th>SKU</th>
					<th>Current Qty</th>
					<th>Status</th>                    
                    <th>Display(Temp)</th>
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
