<?
//*** Default
	$func_name 		= "AWB export";
	$tbl 			= "tbl_order";
	$curr_page 		= "oms.awb";
	$page_item 		= 200;


//*** Request
	extract($_REQUEST);

	if ($srh_progress_id == '')
		//$srh_progress_id = 7;


//*** Return Path
 

//echo get_random_no(9);

    echo "";

//*** Select SQL
	$sql="
		SELECT 
		tbl_order.id, tbl_order.order_no, tbl_order.order_status_id, tbl_order.ship_status, tbl_order.create_date, tbl_order.awb_check, tbl_order.shipping_method, tbl_order.awb_carrier,
		TOSA.country, TOSA.post_code, order_weight.weight_sum, order_weight.total_qty 
		FROM tbl_order
		LEFT JOIN tbl_order_shipping_address TOSA ON TOSA.order_id = tbl_order.id
		LEFT JOIN 
			(SELECT order_id, SUM(actual_weight*qty_ordered) as weight_sum, SUM(qty_ordered) AS total_qty
			FROM tbl_order_item TOI
			LEFT JOIN tbl_erp_product TEP ON TEP.sku = TOI.sku
			WHERE TEP.sku <> '' AND TEP.sku IS NOT null AND TOI.is_cancel_item = 0
			GROUP BY order_id) order_weight 
		ON order_weight.order_id = tbl_order.id
		WHERE
			tbl_order.deleted=0
			AND cs_check=1 AND payment_check=1 AND buyer_check=1 AND invoice_check=1 AND packing_check=1 
			";


//*** Search
	if ($srh_order_date_from){
		$sql .= " and tbl_order.create_date >= '$srh_order_date_from'";
	}else{
		//$srh_order_date_from=date("Y-m-d");
		//$sql .= " and create_date >= '$srh_order_date_from'";
	}
	
	if ($srh_order_date_to){
		$sql .= " and tbl_order.create_date <= '$srh_order_date_to'";
	}
	
	if ($srh_order_no){
		$sql .= " and order_no = ".$order_no;
	}

	if ($srh_awb_check == "on"){
		$sql .= " and awb_check = 1";
	}else
		$sql .= " and awb_check = 0";

	if ($srh_weight_sum){
		$sql .= " and weight_sum >= ".$srh_weight_sum;
	}
	
////////////////AWB Carrier Selector//////////////
	if($srh_awb_carrier && $srh_awb_carrier!= "all"){
	//	##1:RMA		2:TOLL		3:4PX EMS		4:TNT	
		$sql .= " and awb_carrier = ".$srh_awb_carrier;
	}
//////////////////////////////////////////////////

//*** Order by start
	if (empty($_POST["order_by"]))
		$order_by = "tbl_order.id"; 
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

//echo $sql."<br>";
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
	
	function update_carrier(){

		window.location = "<?=$_SERVER['PHP_SELF']?>?&func_pg=oms.awb.update";

	}

	function form_export(){
		if($( "#srh_awb_carrier option:selected" ).val() == "all")
		{
			alert("Please select one carrier for export");
			return false;
		}
		fr = document.frm

		fr.action = "../oms/awb/oms.awb.export.php";
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
<input type="hidden" name="thispage" value="<?=$_SERVER['QUERY_STRING']?>">
<div id="list">
	<div id="title"><?=$func_name?></div>
    <div id="search">
		<!-- First Line -->
	<div id="line-1">
	Order No.:<input type="text" name="srh_order_no" value="<?=$srh_sku?>">
	AWB checked:<input type="checkbox" name="srh_awb_check" <?echo $srh_awb_check?"checked":"" ?>>	
	Total Weight >=<input type="text" name="srh_weight_sum" value="<?=$srh_weight_sum?>">
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
		Carrier:
		<select name="srh_awb_carrier" id="srh_awb_carrier">
				<option value="all">All</option>
				<?=get_combobox_src('tbl_carrier', 'name', $srh_awb_carrier)?>  
		</select>	
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
		
        <? if ($_SESSION["sys_write"]==1){ ?>

			<a class="boldbuttons" href="javascript:update_carrier();"><span>Update Carrier</span></a>

        <? } ?>
		
        <? if ($_SESSION["sys_export"]==1){ ?>

			<a class="boldbuttons" href="javascript:form_export();"><span>Export Excel</span></a>

        <? } ?>
        
		</div>
		<br class="clear">
		
	</div>

<table>
	<tr>
        <th><? set_sequence("Order Number","order_no", $order_by, $ascend, $curr_page) ?></th>
        <th><? set_sequence("Create Date","create_date", $order_by, $ascend, $curr_page) ?></th>
        <th><? set_sequence("Total Weight","weight_sum", $order_by, $ascend, $curr_page) ?></th>
        <th><? set_sequence("Total Qty","total_qty", $order_by, $ascend, $curr_page) ?></th>
        <th><? set_sequence("AWB check status","awb_check", $order_by, $ascend, $curr_page) ?></th>        
        <th>Assign Carrier by Updater</th>        
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
            <td align="left"><?=$row[order_no]; ?></td>
		    <td align="left"><?=$row[create_date]; ?></td>		
		    <td align="left"><?=ROUND($row[weight_sum],2); ?></td>		
		    <td align="left"><?=ROUND($row[total_qty],0); ?></td>		
		    <td align="left"><?echo $row[awb_check]==1?"Checked":"Un-check" ?></td>		
		    <td align="left"><?echo get_field('tbl_carrier', 'name', $row[awb_carrier]) ?></td>		
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