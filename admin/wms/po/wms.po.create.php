<?
//*** Default
	$func_name 		= "Create PO";
	$tbl 			= "tbl_po";
	$product_tbl 			= "tbl_erp_product";
	$curr_page 		= "wms.po.create";
	$edit_page 		= "wms.po.edit";
	$action_page 		= "wms.po.act";
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
			*, current_qty + po_qty - so_qty need_qty
		from
			$product_tbl
		where
			current_qty + po_qty - so_qty < 0";


//*** Search
	if ($srh_sku){
		$sql .= " and sku like '%".addslashes($srh_sku)."%'";
	}		

	if ($srh_name){
		$sql .= " and name like '%".addslashes($srh_name)."%'";
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

	function form_create_po(){

		fr = document.frm;

		fr.act.value = 1;

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

<div id="list">
	<div id="title"><?=$func_name?></div>
    <div id="search">
		<!-- First Line -->
		<div id="line-1">
			
			SKU:<input type="text" name="srh_sku" value="<?=$srh_sku?>">
			Product Name:<input type="text" name="srh_name" value="<?=$srh_name?>">
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
		<a class="boldbuttons" href="javascript:form_create_po();"><span>Create</span></a>
      
		</div>
		<br class="clear">
		
	</div>

<table>
	<tr>
        <th width="50"><input type="checkbox" name="select_all" onclick="checkbox_select_all(<?=$page_item?>)"></th>
        <th>SKU</th>
        <th>Name</th>
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
		<tr>
                    <td width="50" valign="top"><input type="checkbox" name="cb_<?=$i?>" value="<?=$row[id]?>"> </td>
               
                    <td align="right" valign="top">
                    	<?=$row[sku] ?>
                    </td>
                    <td align="right" valign="top">
			<?=$row[name] ?>
                    </td>
                    <td align="right" valign="top">
                    	<?=$row[need_qty] ?>
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