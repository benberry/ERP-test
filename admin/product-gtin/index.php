<?
### Default
	$func_name 		= "Product GTIN / MPN";
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

	function update_ctin(id){
		$.get("../product-ctin/update.php", {
			product_id: id,
			ctin: $('#ctin_'+id).val(),
			mpn: $('#mpn_'+id).val()
		},
		function(data){
			$('#update_result_'+id).html(data);

		});

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
					<th>Status</th>
                    <th>MPN</th>
                    <th>CTIN</th>
                    <th></th>
				</tr>
			</thead>    
			<tbody>
			<?
			
				if ($num_rows > 0){

					mysql_data_seek($result, $pbar[0]);
					
					$rate = get_rate();
					
					for($i=0; $i < $page_item ;$i++){
					
						if ($row = mysql_fetch_array($result)){
							
							?>
							<tr>
								<td align="left">
									<?=$row[name_1]; ?>
                                    <div style=" font-size: 9px; color:#aaa; "><?=$row[modify_date]; ?></div>
                                </td>
								<td align="left">
                                <div id="product_active_<?=$row[id]; ?>">
									<?
                                        if($row[active] == 1){
                                            ?><img src="../images/yes.png" width="24" border="0"><?
                                        }else{
                                            ?><img src="../images/no.png" width="24" border="0"><?
                                        }
                                    ?>
                                </div>
                                </td>
                                <td align="left"><?=get_stock_status($row[stock_status]);?></td>
								
								<td align="left"><input type="text" id="mpn_<?=$row[id]; ?>" name="mpn_<?=$row[id]; ?>" value="<?=$row[mpn]; ?>" style="width:300px"></td>
                                <td align="left"><input type="text" id="ctin_<?=$row[id]; ?>" name="ctin_<?=$row[id]; ?>" value="<?=$row[ctin]; ?>" style="width:300px"></td>
                                <td align="left"><input type="button" name="Update" value="Update" onclick="update_ctin('<?=$row[id]?>'); "><div id="update_result_<?=$row[id]; ?>"></div></td>
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
