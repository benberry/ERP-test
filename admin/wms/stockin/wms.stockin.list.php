<?
//*** Default
	$func_name 		= "Stock In";
	$tbl 			= "tbl_stockin";
	$curr_page 		= "wms.stockin.list";
	$edit_page 		= "wms.stockin.edit";
	$action_page 		= "wms.stockin.act";
	$page_item 		= 25;


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
			*
		from
			$tbl a
		where
			status=0
			and active=1
			and deleted=0
			and supplier_inv_no <> ''";


//*** Search
	if ($srh_order_date_from){
		$sql .= " and create_date >= '$srh_order_date_from'";
	}/*else{
		$srh_order_date_from=date("Y-m-d");
		$sql .= " and create_date >= '$srh_order_date_from'";
	}*/
	
	if ($srh_order_date_to){
		$sql .= " and create_date <= '$srh_order_date_to'";
	}
	
	if ($srh_order_no){
		$sql .= " and supplier_inv_no like '%".addslashes($srh_order_no)."%'";
	}
	
	if ($srh_supplier_id != '' && $srh_supplier_id!='all'){
		$sql .= " and supplier_id = $srh_supplier_id";
	}
	
	if ($srh_IMEI ){
		$sql .= " and exists(select null from tbl_stockin_item b where a.id = b.stockin_id and b.IMEI like '%".addslashes($srh_IMEI)."%')";
	}	

	if ($srh_MD_Barcode){
		$sql .= " and exists(select null from tbl_stockin_item c where a.id = c.stockin_id and c.MD_Barcode like '%".addslashes($srh_MD_Barcode)."%')";
	}

	if ($srh_sku){
		$sql .= " and exists(select null from tbl_erp_product d, tbl_stockin_item e where a.id = e.stockin_id and d.id = e.product_id and d.sku like '%".addslashes($srh_sku)."%')";
	}

	if ($srh_name){
		$sql .= " and exists(select null from tbl_erp_product f, tbl_stockin_item g where a.id = g.stockin_id and f.id = g.product_id and f.name like '%".addslashes($srh_name)."%')";
	}

//*** Order by start
	if (empty($_POST["order_by"]))
		$order_by = "create_date"; 
	else
		$order_by = $_POST["order_by"];
	
	if (empty($_POST["ascend"]))
		$ascend = "desc";
	else
		$ascend = $_POST["ascend"];
	
	if (!empty($order_by))
	{
		$sql .="
			order by
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

</script>

<form name="frm">
<input type="hidden" name="tbl" value="<?=$tbl?>">
<input type="hidden" name="act" value="">
<input type="hidden" name="order_by" value="<?=$order_by?>">
<input type="hidden" name="ascend" value="<?=$ascend?>">
<input type="hidden" name="del_id" value="">
<input type="hidden" name="thispage" value="<?=$_SERVER['QUERY_STRING']?>">
<div id="list">
	<div id="title"><?=$func_name?></div>
    <div id="search">
		<!-- First Line -->
		<div id="line-1">
			
			Invoice #:<input type="text" name="srh_order_no" value="<?=$srh_order_no?>">
			Supplier:
			<select name="srh_supplier_id">
				<option value="all" <?=set_selected("all", $srh_supplier_id); ?>>All</option>
				<?=get_combobox_src("tbl_supplier", "name", $_POST['srh_supplier_id'], " sort_no asc "); ?>
			</select>
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
     	IMEI:<input type="text" name="srh_IMEI" value="<?=$srh_IMEI?>">
	MD Barcode:<input type="text" name="srh_MD_Barcode" value="<?=$srh_MD_Barcode?>">
	SKU:<input type="text" name="srh_sku" value="<?=$srh_sku?>">
	Product Name:<input type="text" name="srh_name" value="<?=$srh_name?>">
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
		
		<? if ($_SESSION["sys_delete"]) { ?>

			<a class="boldbuttons" href="javascript:del_item('<?=$action_page?>', '<?=$page_item?>')"><span>Delete</span></a>

        <? } ?>
        
		</div>
		<br class="clear">
		
	</div>

<table>
	<tr>
        <th width="50"><input type="checkbox" name="select_all" onclick="checkbox_select_all(<?=$page_item?>)"></th>
        <th><? set_sequence("Invoice #","supplier_inv_no", $order_by, $ascend, $curr_page) ?></th>
        <th>Stock In Date</th>
	<th>Supplier</th>
	<th>Total Qty</th>
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
		<tr >
                    <td width="50" valign="top"><input type="checkbox" name="cb_<?=$i?>" value="<?=$row[id]?>"> </td>
                    <td align="left" valign="top" onclick="goto_page('<?=$edit_page?>', '<?=$row[id]?>')">
			<div style=" text-decoration: underline; color:blue;"><?=$row[supplier_inv_no]; ?></div>
                    </td>
		    <td align="left" valign="top">
		    	<?=$row[create_date]; ?>
		    </td>		
                    <td align="left" valign="top">         
		        <?=get_field("tbl_supplier","name",$row["supplier_id"]) ?>
                    </td>
                    <td align="right" valign="top">
			<?=get_sum("tbl_stockin_item","stockin_id",$row["id"],"1");?>
                    </td>

		</tr>
<?
	
			}
	
		}
	
	}

?>
</table>
<br class="clear" />
</div>
</form>	
<?	
	
}
else
	echo $sql;

	
?>