<?
##*** Default
	$func_name 		= "Best Selling";
	// $tbl 		= "tbl_report_popular";
	$curr_page 		= "index";
	$edit_page 		= "";
	$action_page 	= "";
	$page_item 		= 9999;


##*** Request
	extract($_REQUEST);



##*** Empty report popluar
	$sql = "TRUNCATE tbl_report_best_selling";
	
	if (!mysql_query($sql))
		echo $sql;


##*** Select SQL
	$sql = "
		select
			ci.*,
			c.id,
			c.member_create_date,
			c.email,
			c.first_name,
			c.last_name,
			c.shipping_country_id

		from
			tbl_cart c,
			tbl_cart_item ci
			left join 
				tbl_product p on p.id = ci.product_id


		where
			c.id = ci.cart_id
			and c.status=0
			and c.active=1
			and c.deleted=0
			and c.order_status_id<>0
			and c.order_status_id<>6
			and c.payment_gateway_status='Completed'";


##*** Search
	if ($srh_order_date_from){
		$sql .= " and c.member_create_date >= '$srh_order_date_from'";
		
	}else{
		$srh_order_date_from=date("Y-m-1");
		$sql .= " and c.member_create_date >= '$srh_order_date_from'";
		
	}
	
	if ($srh_order_date_to){
		$sql .= " and c.member_create_date <= '$srh_order_date_to'";

	}


##*** Cat ID
	if ($srh_cat_id){
		$sql .= " and p.cat_id=$srh_cat_id";

	}	
	

##*** Order by start
		$sql .= " order by c.member_create_date desc";


//*** Order by end
if ($result=mysql_query($sql)){

	$num_rows = mysql_num_rows($result);
	
	if ($num_rows > 1){
		
		while ($row = mysql_fetch_array($result)){
		
			$sql = "
				insert into tbl_report_best_selling(
					cart_id,
					transaction_date,
					product_id,
					price,
					qty,
					buyer_email,
					buyer_first_name,
					buyer_last_name,
					shipping_country_id
	
				)values(
					".$row[cart_id].",
					".sql_str($row[member_create_date]).",
					".$row[product_id].",
					".$row[unit_price].",
					".$row[qty].",
					".sql_str($row[email]).",
					".sql_str($row[first_name]).",
					".sql_str($row[last_name]).",
					".$row[shipping_country_id]."
															
				)
	
			";
			
			if (mysql_query($sql)){
				// echo $sql."....OK<br />";
			}else{
				echo $sql."....ERROR<br />";				
			}
		
		}
		
	}
		
}else
	echo $sql;

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
		<!-- First Line -->
		<div id="line-1">
		<!-- End of First Line </div> -->
		
		<!-- Second Line <div id="line-2"> -->
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
        
        Category:
        <select name="srh_cat_id" onchange="form_search(); ">
            <option value=""> all category </option>
            <?=get_cat_menu_combo(0, 0, $srh_cat_id)?>
        </select>
        
        <input type="button" value="SEARCH" onclick="form_search()">

        <input type="button" value="RESET" onclick="form_search_reset()">
		
		</div>
		<!-- End of Second Line -->
		
    </div>
    
	<div id="tool">
        <div id="button"></div>
		<br class="clear"/>
	</div>
    <?
	
	$sql = " 
		select 
			distinct(product_id), 
			(select sum(qty) from tbl_report_best_selling where product_id = rbs.product_id ) as ttl_qty,
			(select sum(price * qty) from tbl_report_best_selling where product_id = rbs.product_id ) as ttl_unit_price,
			p.cat_id,
			p.name_1
		from 
			tbl_report_best_selling rbs, tbl_product p
		where
			p.id=rbs.product_id
		order by 
			ttl_qty desc ";
    
	if ($result = mysql_query($sql)){
		
		?><table width="600">
			<tr>
                <th align="left">QTY</th>
                <th align="left">Model</th>
                <th align="left">Total</th>
                <th align="left">Avg Price</th>                
            	<!--<th align="left">Category</th>-->
			</tr>
		<?
		
		while ($row = mysql_fetch_array($result)){
			
			?>
            <tr style="cursor:default; ">
                <td align="center" style="font-size:20px;"><?=$row[ttl_qty]; ?></td>
                <td align="left" style="font-size:16px;"><?=$row[name_1]; ?></td>
                <td align="right" style="font-size:16px;"><?=number_format($row[ttl_unit_price], 2); ?></td>
                <td align="right" style="font-size:16px;"><?=number_format(($row[ttl_unit_price] / $row[ttl_qty]), 2); ?></td>
			</tr>
            <?
			
		}
		
		?></table><?
		
	}else
		echo $sql;
	
	
	?>
    

</div>
</form>	

