<?
//*** Default
	$func_name 		= "Stock In";
	$tbl 			= "tbl_stockin";
	$potbl 			= "tbl_po";
	$poitemtbl 		= "tbl_po_item";
	$curr_page 		= "wms.stockin.create";
	$edit_page 		= "wms.stockin.edit";
	$action_page 		= "wms.stockin.act";
	$page_item 		= 15;


//*** Request
	extract($_REQUEST);

	if ($srh_progress_id == '')
		//$srh_progress_id = 7;


//*** Return Path
 

//echo get_random_no(9);

    echo "";

//*** Select SQL
	$sql="
		select
			a.po_no, a.create_date, a.supplier_id, b.product_id, b.qty, b.balqty, b.id, b.po_id
		from
			$potbl a, $poitemtbl b
		where
			a.id = b.po_id
		  and   a.po_no <> ''
		  and   b.balqty > 0";


//*** Search
	if ($srh_order_date_from){
		$sql .= " and a.create_date >= '$srh_order_date_from'";
	}/*else{
		$srh_order_date_from=date("Y-m-d");
		$sql .= " and a.create_date >= '$srh_order_date_from'";
	}*/
	
	if ($srh_order_date_to){
		$sql .= " and a.create_date <= '$srh_order_date_to'";
	}

	if ($srh_sku){
		$sql .= " and exists(select null from tbl_erp_product d where d.id = b.product_id and d.sku like '%".addslashes($srh_sku)."%')";
	}

	if ($srh_name){
		$sql .= " and exists(select null from tbl_erp_product f where f.id = b.product_id and f.name like '%".addslashes($srh_name)."%')";
	}
		
	if ($srh_order_no){
		$sql .= " and a.po_no like '%".addslashes($srh_order_no)."%'";
	}

	if ($srh_supplier_id != '' && $srh_supplier_id!='all'){
		$sql .= " and supplier_id = $srh_supplier_id";
	}

if ($result=mysql_query($sql))
{

	$num_rows = mysql_num_rows($result);
	
	if ($num_rows > 0 )
		$pbar = paging_bar($page_item, $num_rows);

?>

<script>
	function form_search(){

		fr = document.frm;

		fr.action = "<?=$_SERVER['PHP_SELF']?>?<?=$_SERVER['QUERY_STRING']?>";
		fr.method = "post";
		fr.target = "_self";
		fr.submit();

	}
	
	function form_search_reset(){

		window.location = "<?=$_SERVER['PHP_SELF']?>?<?=$_SERVER['QUERY_STRING']?>";

	}

	function form_create_stockin(po_item_id,supplier_id){

		fr = document.frm;

		fr.act.value = 1;

		fr.po_item_id.value = po_item_id;
		fr.supplier_id.value = supplier_id;

		fr.action = '../main/main.php?func_pg=<?=$action_page?>'
		fr.method = "post";
		fr.target = "_self";
		fr.submit();

	}
</script>

<form name="frm">
<input type="hidden" name="tbl" value="<?=$tbl?>">
<input type="hidden" name="act" value="">
<input type="hidden" name="thispage" value="<?=$_SERVER['QUERY_STRING']?>">
<input type="hidden" name="po_item_id" value="">
<input type="hidden" name="supplier_id" value="">


<div id="list">
	<div id="title"><?=$func_name?></div>
    <div id="search">
		<!-- First Line -->
		<div id="line-1">
			PO No:<input type="text" name="srh_order_no" value="<?=$srh_order_no?>">
			Supplier:
			<select name="srh_supplier_id">
				<option value="all" <?=set_selected("all", $srh_supplier_id); ?>>All</option>
				<?=get_combobox_src("tbl_supplier", "name", $_POST['srh_supplier_id'], " sort_no asc "); ?>
			</select>
			SKU:<input type="text" name="srh_sku" value="<?=$srh_sku?>">
			Product Name:<input type="text" name="srh_name" value="<?=$srh_name?>">
            Date:
        <input type="text" id="srh_order_date_from" name="srh_order_date_from" value="<?=date_empty($srh_order_date_from)?>" readonly="readonly">
        <a href="#" id="btn_srh_order_date_from"><img src="../images/calendar.jpg" border="0"></a>
        <script type="text/javascript">//<![CDATA[

			var cal = Calendar.setup({
				onSelect: function(cal) { cal.hide() }
			});
			cal.manageFields("btn_srh_order_date_from", "srh_order_date_from", "%Y-%m-%d");

        //]]></script>
        <span> - </span>
		<input type="text" id="srh_order_date_to" name="srh_order_date_to" value="<?=date_empty($srh_order_date_to)?>" readonly="readonly">
        <a href="#" id="btn_srh_order_date_to"><img src="../images/calendar.jpg" border="0"></a>
        <script type="text/javascript">//<![CDATA[

			  var cal = Calendar.setup({
				  onSelect: function(cal) { cal.hide() }
			  });
			  cal.manageFields("btn_srh_order_date_to", "srh_order_date_to", "%Y-%m-%d");

        //]]></script>
			

		</div>
        <div id="line-2">            

        <input type="button" value="SEARCH" onclick="form_search()">
        <input type="button" value="RESET" onclick="form_search_reset()">
		</div>
		<!-- End of Second Line -->
		
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
        
        <div id="button"><? //include("../include/list_toolbar.php");	?>
		
		<!-- Berry Add Print Select -->
		<a class="boldbuttons" href="javascript:form_create_stockin(0,0);"><span>Direct Sock In</span></a>
      
		</div>
		<br class="clear">
		
	</div>
<table>
	<tr>
        <th>PO#</th>
        <th>Order Date</th>
        <th>Supplier</th>
        <th>SKU</th>
        <th>Product Name</th>
        <th>PO Qty</th>
        <th>Received Qty</th>
        <th>Pending</th>
        <th>Stock In</th>
	</tr>
	<?

	if ($num_rows > 0)
	{
	
		$order_count = 0;

		mysql_data_seek($result, $pbar[0]);
	
		for($i=0; $i < $page_item ;$i++)
		{
			if ($row = mysql_fetch_array($result))
			{
				?>
		<tr>
                    
               
                    <td align="left" valign="top">
                    	<?=$row[po_no] ?>
                    </td>
                    <td align="left" valign="top">
			<?=$row[create_date] ?>
                    </td>
                    <td align="left" valign="top">
                    	<?=get_field("tbl_supplier","name",$row["supplier_id"]) ?>
                    </td>
                    <td align="left" valign="top">
                    	<?=get_field("tbl_erp_product","sku",$row[product_id]) ?>
                    </td>
                    <td align="left" valign="top">
                    	<?=get_field("tbl_erp_product","name",$row[product_id]) ?>
                    </td>
                    <td align="left" valign="top">
                    	<?=$row[qty] ?>
                    </td>
                    <td align="left" valign="top">
                    	<?=$row[qty]-$row[balqty] ?>
                    </td>
                    <td align="left" valign="top">
                    	<?=$row[balqty] ?>
                    </td>
                    <td align="center" valign="top">
                    	<input type="button" value="Stock In" onclick="form_create_stockin(<?=$row[id]?>,<?=$row[supplier_id]?>)">
                    </td>
	<?		}
		} 
	}?>
</table>
<br class="clear" />
</div>

</form>	
<?	
	
}
else
	echo $sql;
	
?>