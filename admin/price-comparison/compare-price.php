<?
//*** Default
	$func_name = "Price Campare";
	$tbl = "tbl_product";
	$curr_page = "index";
	$edit_page = "";
	$action_page = "update";
	$page_item = 999;


//*** Request
	extract($_REQUEST);


//*** Select SQL
	$sql = "
	select
		*
	
	from
		$tbl
	
	where
		status = 0
		and active=1	
		and deleted=0
		and stock_status < 4
		and display_to_shopping = 1
	
	";
	
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

		<script>
		
		function form_update(id){
		
			fr = document.frm;
			
			text_var = fr['au_shopping_remarks_'+id].value;
		
			$.get("../price-comparison/compare-price-update.php",
				{
					id: id,
					au_shopping_rank: fr['au_shopping_rank_'+id].value,
					au_shopping_price: fr['au_shopping_price_'+id].value,
					au_shopping_shipping: fr['au_shopping_shipping_'+id].value,
					au_shopping_remarks: text_var

				},
				function (data){
					$("result_" + id).html(data);
					location.reload();

				});
		
		}
		
		</script>

		<table>
			<thead>
            	<tr>
                    <th colspan="6">Our Store</th>
					<th colspan="6">au.shopping.com</th>

				</tr>
				<tr>
					<th>Product</th>
					<th>kg</th>                    
					<th>gp</th>
                    <th>P($)</th>
                    <th>S($)</th>
                    <th>Total</th>
                    <th>Rank</th>
                    <th>P($)</th>
                    <th>S($)</th>
                    <th>Total</th>
                    <th>Remarks</th> 
                    <th></th>                   
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
							
							if ($row[weight] > 1){
								$shipping_cost = round(item_express_shipping_cost($row[weight]), 2);
							}else{
								$shipping_cost = round(item_registered_airmail_cost($row[weight]), 2);
							}
							
							$our_total = round($shipping_cost+$row[price_1],2);						
							
							$au_shipping_total = round($row[au_shopping_price] + $row[au_shopping_shipping], 2);
							
							$price_diff = ($au_shipping_total-$our_total);
							
							if ($price_diff != 0 && $au_shipping_total != 0){
								
								$price_diff_percent = $price_diff * 100 / $au_shipping_total ;
								
								if ( $price_diff > 0 && $price_diff_percent >= 5){
									$price_diff_percent_str = '<span style="color:#09F; font-size:10px">'.$price_diff.' <br />('.number_format($price_diff_percent, 1).'%)</span>';

								}elseif ( $price_diff < 0 && $price_diff_percent <= -5){
									$price_diff_percent_str = '<span style="color:#09F; font-size:10px">'.$price_diff.' <br />('.number_format($price_diff_percent, 1).'%)</span>';

								}else{
									$price_diff_percent_str = '<span style="color:#666; font-size:10px">'.$price_diff.' <br />('.number_format($price_diff_percent, 1).'%)</span>';

								}
								
							}else{
								
								$price_diff_percent = 0;
								
							}
							
							if (($our_total >= $au_shipping_total) && $au_shipping_total > 0){
								$display_our_total = "<span style='color: red'>".number_format($our_total, 2)."</span>";

							}else{
								$display_our_total = "<span style='color: green'>".number_format($our_total, 2)."</span>";								

							}

							?>
							
							<tr>
								<td align="left" style="width:300px;"><a href="http://au.shopping.com/<?=get_search_rewrite($row[name_1], $row[id]); ?>/products?CLT=SCH&KW=<?=get_search_rewrite2($row[name_1], $row[id]); ?>" target="_blank"><?=$row[name_1]; ?></a></td>
                                <td align="right"><?=number_format($row[weight],2); ?></td>
                                <td align="right"><?=$row[gp_percent]; ?></td>
								<td align="right"><?=$row[price_1]; ?></td>
								<td align="right"><?=$shipping_cost?></td>
								<td align="right">
                                	<b><?=$display_our_total; ?></b><br/>
                                    <?=$price_diff_percent_str; ?>
                                </td>
                                <td align="center"><input type="text" name="au_shopping_rank_<?=$row[id]?>" value="<?=$row[au_shopping_rank]; ?>" style="width:50px; "></td>
                                <td align="right"><input type="text" name="au_shopping_price_<?=$row[id]?>" value="<?=$row[au_shopping_price]; ?>" style="width:50px; "></td>
                                <td align="right"><input type="text" name="au_shopping_shipping_<?=$row[id]?>" value="<?=$row[au_shopping_shipping]; ?>" style="width:50px; "></td>
                                <td align="right"><b><? if ($au_shipping_total > 0) echo number_format($au_shipping_total,2); ?></b></td>
                                <td align="left"><textarea id="au_shopping_remarks_<?=$row[id]?>" name="au_shopping_remarks_<?=$row[id]?>" style="width:200px; height:44px; font-size:10px;"><?=$row[au_shopping_remarks]; ?></textarea></td>
                                <td align="left"><input type="button" value="Save" onclick="form_update(<?=$row[id];?>)"><div id="result_<?=$row[id]?>">&nbsp;</div></td>
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
