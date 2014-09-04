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
$chkDrop = "A";


if(isset($_REQUEST["srccond"]))
{
  $strExp = explode("_",$_REQUEST["srccond"]);
  $chkDrop = $strExp[1];
  if($strExp[1] == 'A')
    break;
  else
  {
    if($strExp[1]=='S') 
	  $disCon = 1;
	else  
	  $disCon = 0;
    $sql .= " and display_to_".$strExp[0]. " = $disCon ";	
  } 	
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
	
	function save_all(){
	
		fr = document.frm
		
		fr.action = "../price-comparison/save-all.php";
		fr.method = "post";
		fr.target = "_self";
		fr.submit();
	
	}	
	
	function form_search_reset(){
		
		window.location = "<?=$_SERVER['PHP_SELF']?>?<?=$_SERVER['QUERY_STRING']?>";
	
	}
	function filterRec(val,url,fld)
	{
	  //alert(val+"XX"+url+"XX"+fld);
	  var str = "?func_id=114&func_pg=index"; // Have to change later
	  location.href = url+str+"&srccond="+fld+"_"+val;
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
                    <th width="100">PriceMe</th>
					<th width="100">Google AU</th>
					<th width="100">Google UK</th>
				</tr>
			</thead>    
			<tbody>
            	<tr>
                    <td colspan="15" align="right"><input type="button" value="Save All" onclick="save_all();"></td>
				</tr>
                <tr>
                    <td colspan="7" align="right"></td>
                    <td align="right"><?=get_comperison_count("display_to_getprice"); ?> item(s)</td>
                    <td align="right"><?=get_comperison_count("display_to_shopbot"); ?> item(s)</td>
                    <td align="right"><?=get_comperison_count("display_to_shopping"); ?> item(s)</td>
                    <td align="right"><?=get_comperison_count("display_to_myshopping"); ?> item(s)</td>
                    <td align="right"><?=get_comperison_count("display_to_pricerunner"); ?> item(s)</td>
                    <td align="right"><?=get_comperison_count("display_to_priceme"); ?> item(s)</td>
					<td align="right"><?=get_comperison_count("display_to_google"); ?> item(s)</td>
					<td align="right"><?=get_comperison_count("display_to_google_uk"); ?> item(s)</td>
				</tr>
				
				<tr>
                    <td colspan="7" align="right"></td>
                    <td align="right"><!--<select name="displayproduct" onchange="filterRec(this.value,'<?php echo $_SERVER['PHP_SELF'];?>','getprice')" ><option value="A" <?php if($chkDrop=='A') echo "checked";?>>All</option><option value="S" <?php if($chkDrop=='S') echo "checked";?>>Selected</option><option value="D" <?php if($chkDrop=='D') echo "checked";?>>Deselected</option> </select>-->  </td>
                    <td align="right"></td>
                    <td align="right"></td>
                    <td align="right"></td>
                    <td align="right"></td>
                    <td align="right"></td>
					<td align="right"></td>
					<td align="right"></td>
				</tr>
				
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
										?><input type="checkbox" name="getprice_<?=$row[id]?>" value="1" checked="checked" /><?
									}else{
										?><input type="checkbox" name="getprice_<?=$row[id]?>" value="1" /><?
									}
								
								?>
                                </td>
                                <td align="center">
                                <?
                                
									if ($row[display_to_shopbot] == 1){
										?><input type="checkbox" name="shopbot_<?=$row[id]?>" value="1" checked="checked" /><?
									}else{
										?><input type="checkbox" name="shopbot_<?=$row[id]?>" value="1" /><?
									}
								
								?>
                                </td>
                                <td align="center">
                                <?
                                
									if ($row[display_to_shopping] == 1){
										?><input type="checkbox" name="shopping_<?=$row[id]?>" value="1" checked="checked" /><?

									}else{
										?><input type="checkbox" name="shopping_<?=$row[id]?>" value="1" /><?

									}
								
								?>
                                </td>
                                <td align="center"><?
                                
									if ($row[display_to_myshopping] == 1){
										?><input type="checkbox" name="myshopping_<?=$row[id]?>" value="1" checked="checked" /><?

									}else{
										?><input type="checkbox" name="myshopping_<?=$row[id]?>" value="1" /><?

									}
								
								?></td>
                                <td align="center"><?

									if ($row[display_to_pricerunner] == 1){
										?><input type="checkbox" name="pricerunner_<?=$row[id]?>" value="1" checked="checked" /><?

									}else{
										?><input type="checkbox" name="pricerunner_<?=$row[id]?>" value="1" /><?

									}

								?></td>
                                <td align="center"><?

									if ($row[display_to_priceme] == 1){
										?><input type="checkbox" name="priceme_<?=$row[id]?>" value="1" checked="checked" /><?

									}else{
										?><input type="checkbox" name="priceme_<?=$row[id]?>" value="1" /><?

									}

								?></td>
								
								<td align="center"><?

									if ($row[display_to_google] == 1){
										?><input type="checkbox" name="google_<?=$row[id]?>" value="1" checked="checked" /><?

									}else{
										?><input type="checkbox" name="google_<?=$row[id]?>" value="1" /><?

									}

								?></td>
								
								<td align="center"><?

									if ($row[display_to_google_uk] == 1){
										?><input type="checkbox" name="google_uk_<?=$row[id]?>" value="1" checked="checked" /><?

									}else{
										?><input type="checkbox" name="google_uk_<?=$row[id]?>" value="1" /><?

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
		
		
	function get_comperison_count($comperison){
		
		$sql="
			select
				count(id) as cnt
			from
				tbl_product
			where
				$comperison = 1	
			";
			
		if ($result = mysql_query($sql)){
			
			$row = mysql_fetch_array($result);
			
			return $row[cnt];
			
		}else
			echo $sql;
				
	}	
    
    ?>
