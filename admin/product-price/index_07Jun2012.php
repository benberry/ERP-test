<?
### Default
	$func_name 		= "Price Management";
	$tbl 			= "tbl_product";
	$curr_page 		= "index";
	$edit_page 		= "";
	$action_page 	= "";
	$page_item 		= 9999;


### Request
	extract($_REQUEST);
	if ($srh_cat_id=='')
		$srh_cat_id=5;


### Select SQL
	$sql="select
			*
		from
			$tbl
		where
			status=0
			and deleted=0";

	if ($srh_cat_id){
		$sql .= " and cat_id = {$srh_cat_id} ";
	}

	if ($srh_brand_id){
		$sql .= " and brand_id = {$srh_brand_id} ";
	}

	if ($srh_id){
		$sql .= " and id = $srh_id ";
	}

	if ($srh_keyword){
		$sql .= " and ( ";
		$sql .= " name_1 like '%{$srh_keyword}%' ";
		$sql .= " or name_2 like '%{$srh_keyword}%' ";
		$sql .= " or model like '%{$srh_keyword}%' ";
		$sql .= " ) ";
	}

	if ($srh_price_comparison == 1){
		$sql .= " and display_to_getprice=1 ";

	}elseif ($srh_price_comparison == 2){
		$sql .= " and display_to_shopbot=1 ";

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
		$sql.="order by
			active desc,
			stock_status, 
			$order_by
			$ascend ";}

### Order by end
if ($result=mysql_query($sql)){

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

	function get_total_price_result(id){
		$.get("../product-price/update.php", {
			product_id: id,
			vat_option: $('#product_vat_'+id).val(),
			unit_cost: $('#unit_cost_'+id).val(),
			price_profit: $('#price_profit_'+id).val(),
			price_balancer:　$('#price_balancer_'+id).val(),
			accessory_price:　$('#accessory_price_'+id).val(),
			stock_status: $('#product_staus_'+id).val()
		},
		function(data){
			$('#total_amount_'+id).html(data);

		});

	}

	function update_product_active(id, val){
		$.get("../product-price/update-active.php", {
			id: id,
			val: val
		},
		function(data){
			$('#product_active_'+id).html(data);

		});

	}
	
	function bulk_edit(bulk_act){
		
		fr = document.frm
		
		fr.action = "../product-price/bulk-edit.php?bulk_act=" + bulk_act;
		fr.method = "post";
		fr.target = "_self";
		fr.submit();

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
			Category:
			<select name="srh_cat_id">
                <option value="">all category</option>
                <?=get_cat_menu_combo(0, 0, $srh_cat_id); ?>
            </select>

            <select name="srh_brand_id">
                <option value="">all brands</option>
                <?=get_combobox_src("tbl_brand", "name_1", $srh_brand_id); ?>
			</select>
            
			<input type="button" value="SEARCH" onclick="form_search()">
			<input type="button" value="RESET" onclick="form_search_reset()">            
            <br class="clear" />
		</div>
		<div id="tool">
			<div id="paging">
				<?
					/* 
						echo $pbar[1];
						echo $pbar[2];
						echo $pbar[4];
						echo $pbar[3];
						echo $pbar[5];
					*/
				?>
			</div>
			<div id="button">
				<? // include("../include/list_toolbar.php"); ?>
                <span style="width: 200px; font-weight:bold; font-size:20px; ">Rate: <?=get_rate(); ?></span>
            </div>
			<br class="clear">
		</div>
		<table>
			<thead>
				<tr>
					<th width="500">Model</th>
					<th>Display</th>
                    <th>VAT</th>
					<th>Status</th>
					<th>Cost</th>
                    <th>Profit(+/-)</th>
                    <th>Balancer(+/-)</th>
                    <th>Weight</th>
                    <th>Acc. Price</th>
                    <th></th>
                    <th width="100">Price</th>
                    <th width="100">Express Shipping</th>
                    <th width="100">Registered Airmail</th>
					<th width="100">Total(Express Shipping)</th>
					<th width="100">Total(Registered Airmail)</th>
				</tr>
			</thead>    
			<tbody>
            	<tr style="background-color:#eee;">
                	<td colspan="5" align="right">Bulk Edit</td>
                	<td align="left"><input type="text" name="bulk_profit" value="0" style="width: 60px;"></td>
                	<td align="left"><input type="text" name="bulk_balancer" value="0" style="width: 60px;"></td>
                	<td colspan="8" align="left"><input type="button" value="+" onclick="javascript:bulk_edit(1); "> <input type="button" value="-" onclick="javascript:bulk_edit(2); "></td>
                </tr>
			<?
			
				if ($num_rows > 0){

					mysql_data_seek($result, $pbar[0]);
					
					$rate = get_rate();
					
					for($i=0; $i < $page_item ;$i++){
					
						if ($row = mysql_fetch_array($result)){
							
							if ($row[price_balancer]!=0){
								$express_shipping 	= item_express_shipping_cost($row[weight], 1) - ($row[price_balancer] / $rate);
								$registered_airmail = item_registered_airmail_cost($row[weight]) - ($row[price_balancer] / $rate);
								
							}else{
								$express_shipping 	= item_express_shipping_cost($row[weight], 1);
								$registered_airmail = item_registered_airmail_cost($row[weight]);
								
							}
							
							$price 					= (get_price($row[id]));
							$total_amount_express 	= $express_shipping+$price;
							$total_amount_airmail 	= $registered_airmail+$price;

							?>
							<tr>
								<td align="left">
									<?=$row[name_1]; ?>
                                    <div style=" font-size: 9px; color:#aaa; ">
									<?=$row[modify_date]; ?>
                                    </div>
                                    <div style=" font-size: 9px; color:#aaa; ">
                                    <a href="../product-price/price-history.php?id=<?=$row[id]; ?>" target="_blank">view history</a>
                                    </div>
                                </td>
								<td align="left">
                                    <div id="product_active_<?=$row[id]; ?>">
                                        <?
                                            if($row[active] == 1){
                                                ?><a href="javascript: update_product_active(<?=$row[id]?>, 0);"><img src="../images/yes.png" width="24" border="0"></a><?
                                            }else{
                                                ?><a href="javascript: update_product_active(<?=$row[id]?>, 1);"><img src="../images/no.png" width="24" border="0"></a><?
                                            }
                                        ?>
                                    </div>
                                </td>
                                <td align="left">
                                    <select id="product_vat_<?=$row[id]; ?>" name="product_vat_<?=$row[id]; ?>"  style="width: 100px;">
                                    	<option value="<?=0;?>" <? if($row[vat_option]==0){ echo "selected"; } ?>>N/A</option>
                                        <option value="<?=1;?>" <? if($row[vat_option]==1){ echo "selected"; } ?>>VAT(FIX)</option>
                                        <option value="<?=2;?>" <? if($row[vat_option]==2){ echo "selected"; } ?>>VAT(%)</option>
                                    </select>
                                </td>
								<td align="left">
                                    <select id="product_staus_<?=$row[id]; ?>" name="product_staus_<?=$row[id]; ?>"  style="width: 100px;">
                                    <option value="<?=1;?>" <? if($row[stock_status]==1){ echo "selected"; } ?>><?=get_stock_status(1); ?></option>
                                    <option value="<?=2;?>" <? if($row[stock_status]==2){ echo "selected"; } ?>><?=get_stock_status(2); ?></option>
                                    <option value="<?=3;?>" <? if($row[stock_status]==3){ echo "selected"; } ?>><?=get_stock_status(3); ?></option>
                                    <option value="<?=4;?>" <? if($row[stock_status]==4){ echo "selected"; } ?>><?=get_stock_status(4); ?></option>                                    
                                    </select>
                                </td>                                                                
								<td align="left"><input type="text" id="unit_cost_<?=$row[id]; ?>" name="unit_cost_<?=$row[id]; ?>" value="<?=$row[unit_cost]; ?>" style="width:60px"></td>
								<td align="left"><input type="text" id="price_profit_<?=$row[id]; ?>" name="price_profit_<?=$row[id]; ?>" value="<?=$row[price_profit]; ?>" style="width:60px"></td>
								<td align="left"><input type="text" id="price_balancer_<?=$row[id]; ?>" name="price_balancer_<?=$row[id]; ?>" value="<?=$row[price_balancer]; ?>" style="width:60px"></td>
                                <td align="left"><?=$row[weight]; ?></td>
                                <td align="left"><input type="text" id="accessory_price_<?=$row[id]; ?>" name="accessory_price_<?=$row[id]; ?>" value="<?=$row[accessory_price]; ?>" style="width:60px"></td>
								<td align="left"><input type="button" name="Update" value="Update" onclick="get_total_price_result('<?=$row[id]?>'); "></td>
                                <td align="left" colspan="5">
                                  <div id="total_amount_<?=$row[id]; ?>">
                                  <table width="100%" style="margin:0;">
                                	<tr>
                                	  <td width="100" style="border:0px">
										  <?=number_format(get_price($row[id]), 2);
                                              $accessory_price=get_field("tbl_product", "accessory_price", $row[id]);
                                              if ($accessory_price > 0){
                                                  ?><div style="color:#BBB; ">acc:<?=number_format(get_field("tbl_product", "accessory_price", $row[id]) / get_rate(), 2); ?></div><?
                                              }
                                          ?>
                                      </td>
                                	  <td width="100" style="border:0px"><?=number_format($express_shipping, 2); ?></td>
                                	  <td width="100" style="border:0px"><?=number_format($registered_airmail, 2); ?></td>
                                	  <td width="100" style="border:0px"><?=number_format($total_amount_express, 2); ?></td>
                                	  <td width="100" style="border:0px"><?=number_format($total_amount_airmail, 2); ?></td>
                                	</tr>
                                  </table>
                                  </div>
                                </td>
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
