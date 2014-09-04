<?
//*** Default
	$func_name 		= "Stock Summary";
	$tbl 			= "tbl_erp_product";
	$curr_page 		= "wms.list";
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
			*, current_qty + po_qty - so_qty avi_qty
		from
			$tbl
		where
			active=1";


//*** Search

	if ($srh_sku){
		$sql .= " and sku like '%".addslashes($srh_sku)."%'";
	}

	if ($srh_name){
		$sql .= " and name like '%".addslashes($srh_name)."%'";
	}

	if ($srh_category){
		$sql .= " and main_category like '%".addslashes($srh_category)."%'";
	}

	if ($srh_avai_qty!='all'){
		if($srh_avai_qty == '')
		{
			$srh_avai_qty = "<0";
		}

		$sql .= " and current_qty + po_qty - so_qty $srh_avai_qty";
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

	function form_export(){

		fr = document.frm

		fr.action = "../wms/wms.export_csv.php";
		fr.method = "post";
		fr.target = "_self";
		fr.submit();

	}

	function form_check_po(product_id){


		fr = document.frm;

		fr.action = "../main/main.php?func_id=144&func_pg=wms.po.list&srh_product_id=" + product_id;
		fr.method = "post";
		fr.target = "_self";
		fr.submit();

	}

	function form_check_so(sku){


		fr = document.frm;
		fr.srh_sku.value = sku;
		fr.action = "../main/main.php?func_id=143&func_pg=oms.so";
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
	SKU:<input type="text" name="srh_sku" value="<?=$srh_sku?>">
	Product Name:<input type="text" name="srh_name" value="<?=$srh_name?>">	
	Category:<input type="text" name="srh_category" value="<?=$srh_category?>">
	Available Qty: 
	<select name="srh_avai_qty">
		<option value="all" <?=set_selected("all", $srh_avai_qty); ?>>All</option>
		<option value="&#60;0" <?=set_selected("<0", $srh_avai_qty); ?>>&#60;0</option>
		<option value="&#62;0" <?=set_selected(">0", $srh_avai_qty); ?>>&#62;0</option>
		<option value="&#61;0" <?=set_selected("=0", $srh_avai_qty); ?>>&#61;0</option>
		<option value="&#60;&#62;0" <?=set_selected("<>0", $srh_avai_qty); ?>>&#60;&#62;0</option>
		
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
		
        <? if ($_SESSION["sys_export"]==1){ ?>

			<a class="boldbuttons" href="javascript:form_export();"><span>Export&nbsp;.csv</span></a>

        <? } ?>
        
		</div>
		<br class="clear">
		
	</div>

<table>
	<tr>
        <th><? set_sequence("SKU","sku", $order_by, $ascend, $curr_page) ?></th>
        <th><? set_sequence("Product Name","name", $order_by, $ascend, $curr_page) ?></th>
        <th><? set_sequence("Category","main_category", $order_by, $ascend, $curr_page) ?></th>
        <th>SO Qty</th>
        <th>PO Qty</th>
        <th>Current Stock</th>
	<th>Available Qty</th>
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
                    <td align="left">
			<?=$row[sku]; ?>
                    </td>
		    <td align="left">
		    	<?=$row[name]; ?>
		    </td>		
                    <td align="left">         
		        <?=$row["main_category"] ?>
                    </td>
                    <td align="right" <?if($row["so_qty"]!=0){ ?> style=" text-decoration: underline; color:blue;" onclick="javascript:form_check_so('<?=$row["sku"]?>');" <?}?>>         
		        <?=$row["so_qty"] ?>
                    </td>
                    <td align="right" <?if($row["po_qty"]!=0){ ?> style=" text-decoration: underline; color:blue;" onclick="javascript:form_check_po(<?=$row["sku"]?>);" <?}?>>         
		        <?=$row["po_qty"] ?>
                    </td>
                    <td align="right">         
		        <?=$row["current_qty"] ?>
                    </td>
                    <td align="right">         
		        <?=$row["avi_qty"] ?>
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