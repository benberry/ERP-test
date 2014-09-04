<?
//*** Default
$func_name = "Price Comparison";
$tbl = "tbl_product";
$curr_page = "index";
$edit_page = "";
$action_page = "update";
$page_item = 999;


//*** Request
extract($_REQUEST);


//*** Select SQL
$sql="select
		*
	from
		$tbl
	where
		status = 0
		and active=1	
		and deleted=0
		and stock_status<4";

if ($srh_cat_id){
	$sql .= " and cat_id = {$srh_cat_id} ";
}

if ($srh_id){
	$sql .= " and id = $srh_id ";
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
	$sql = " and display_to_getprice = 1 ";	
}elseif ($srh_price_comparison == 2){
	$sql = " and display_to_shopbot = 1 ";	
}


//*** Order by start
if (empty($_POST["order_by"]))
	$order_by = "cat_id, brand_id, name_1 "; 
else
	$order_by = $_POST["order_by"];

if (empty($_POST["ascend"]))
	$ascend = "desc";
else
	$ascend = $_POST["ascend"];

if (!empty($order_by))
{
	$sql .= "
	order by
		cat_id, 
		name_1,
		display_to_getprice desc,
		display_to_shopbot desc,
		display_to_shopping desc,
		$order_by
		$ascend
	
	";

}
//*** Order by end



if ($result=mysql_query($sql))
{

	$num_rows = mysql_num_rows($result);
	
	if ($num_rows > 0 )
		$pbar = paging_bar($page_item, $num_rows);

?>

<script>

	function form_add(){
	
		fr = document.frm
		
		fr.action = "../getprice/add.php";
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
	<div id="list">
		<div id="title"><?=$func_name?></div>
		<div id="search">
            
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
				<? // include("../include/list_toolbar.php");	?>
                <!--<a class="boldbuttons" href="javascript:location='../product/search-export.php'"><span>Export</span></a>-->
            </div>
			<br class="clear">
		</div>


		<table>
			<thead>
				<tr>
					<th width="50"><input type="checkbox" name="select_all" onclick="checkbox_select_all(<?=$page_item?>)"></th>
                    <th>ID</th>
                    <th>Category</th>
					<th>Product</th>                    
					<th>Weight(kg)</th>
                    <th>Price</th>
                    <th>Status</th>
					<th width="100">GetPrice</th>
                    <th width="100">Shopbot</th>
                    <th width="100">Shopping.com</th>
                    <th width="100">MyShopping.com</th>
                    <th width="100">PriceRunner</th>
				</tr>
			</thead>    
			<tbody>
			<?
			
				if ($num_rows > 0)
				
				{
			
					mysql_data_seek($result, $pbar[0]);
					
					for($i=0; $i < $page_item ;$i++)
					{
					
						if ($row = mysql_fetch_array($result))
						{

							?>
							
							<tr>
								<td align="center" width="50"><input type="checkbox" name="cb_<?=$i?>" value="<?=$row[id]?>"></td>
                                <td><?=$row[id]; ?></td>
								<td><?=get_field('tbl_product_category','name_1',$row[cat_id])?></td>								
								<td align="left"><?=$row[name_1]; ?></td>
                                <td align="right"><?=number_format($row[weight],2); ?></td>
								<td align="right"><?=number_format(get_price($row[id]),2); ?></td>
                                <td>
                                	<? echo get_stock_status($row[stock_status]); ?>
                                </td>
                                <td align="center">
                                <?
                                
									if ($row[display_to_getprice] == 1){
										?><a href="../price-comparison/getprice-remove.php?id=<?=$row[id]; ?>"><img src="../images/tick-circle.png" border="0"></a><?
									}else{
										?><a href="../price-comparison/getprice-add.php?id=<?=$row[id]; ?>"><img src="../images/cross_circle.png" border="0"></a><?
									}
								
								?>
                                </td>
                                <td align="center">
                                <?
                                
									if ($row[display_to_shopbot] == 1){
										?><a href="../price-comparison/shopbot-remove.php?id=<?=$row[id]; ?>"><img src="../images/tick-circle.png" border="0"></a><?
									}else{
										?><a href="../price-comparison/shopbot-add.php?id=<?=$row[id]; ?>"><img src="../images/cross_circle.png" border="0"></a><?
									}
								
								?>
                                </td>
                                <td align="center">
                                <?
                                
									if ($row[display_to_shopping] == 1){
										?><a href="../price-comparison/shopping-remove.php?id=<?=$row[id]; ?>"><img src="../images/tick-circle.png" border="0"></a><?

									}else{
										?><a href="../price-comparison/shopping-add.php?id=<?=$row[id]; ?>"><img src="../images/cross_circle.png" border="0"></a><?

									}
								
								?>
                                </td>
                                <td align="center"><?
                                
									if ($row[display_to_myshopping] == 1){
										?><a href="../price-comparison/myshopping-remove.php?id=<?=$row[id]; ?>"><img src="../images/tick-circle.png" border="0"></a><?

									}else{
										?><a href="../price-comparison/myshopping-add.php?id=<?=$row[id]; ?>"><img src="../images/cross_circle.png" border="0"></a><?

									}
								
								?></td>
                                <td align="center"><?

									if ($row[display_to_pricerunner] == 1){
										?><a href="../price-comparison/pricerunner-remove.php?id=<?=$row[id]; ?>"><img src="../images/tick-circle.png" border="0"></a><?

									}else{
										?><a href="../price-comparison/pricerunner-add.php?id=<?=$row[id]; ?>"><img src="../images/cross_circle.png" border="0"></a><?

									}

								?></td>
							</tr>
						<?
				
						}
				
					}
					
				}
				
				?>
			</tbody>
			
		</table>

	</div>

</form>
	<?
        
    }else
        echo $sql;
    
    ?>
