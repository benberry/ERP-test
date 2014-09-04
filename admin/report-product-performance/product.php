<?
### Default
	$func_name 		= "Product Popularity";
	$curr_page 		= "index";
	$edit_page 		= "";
	$action_page 	= "";
	$page_item 		= 9999;

### Request
	extract($_REQUEST);

	if ($srh_cat_id == '')
		$srh_cat_id = 5;



### Select SQL
	$sql="select
			p.*, 
				(
				select
					count(pv.id) 
				from 
					tbl_visitor_product_viewed pv 
				where 
					pv.product_id=p.id
			";
	
			### Search Date
				if ($srh_order_date_from){
					$sql.=" and pv.create_date >= '$srh_order_date_from'";
					
				}else{
					$srh_order_date_from=date("Y-m-1");
					$sql.=" and pv.create_date >= '$srh_order_date_from'";
				}
				
				if ($srh_order_date_to){
					$sql.=" and pv.create_date <= '$srh_order_date_to'";
				}

			### End of Search Date
				
	$sql.="
		)as view_count
			
		from
			tbl_product p

		where
			p.active=1
			and p.deleted=0
			and p.stock_status < 4";
	

### Cat ID
	if ($srh_cat_id){
		$sql .= " and p.cat_id=$srh_cat_id ";
	}


### Order by start
	$sql .= " order by view_count desc";


### Limit
	$sql .= " limit 10 ";


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
            <?=get_cat_menu_combo(0, 0, $srh_cat_id); ?>
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

    <table>
    	<tr>
        	<th>MODEL</th>
        	<th>VIEWS</th>
            <th>REFERER</th>
        </tr>
        <?
			if ($result = mysql_query($sql)){
				
				while ($row = mysql_fetch_array($result)){
				
					?>
					<tr>

						<td align="left" valign="top" style="font-size:16px" width="400">
							<?=$row[name_1]; ?><br />
                            <span style="font-size:10px;">ID: <?=$row[id]; ?></span>
                        </td>
						<td align="left" valign="top" style="font-size:16px" width="100"><?=$row[view_count]; ?></td>
                        <td align="left" valign="top" width="300">
							<? 
							// get_source_list($srh_order_date_from, $srh_order_date_to, $row[id]);
							get_source_from($srh_order_date_from, $srh_order_date_to, $row[id]);
							?>
                        </td>
					</tr>				
					<?
				
				}
				
			}else
				echo $sql;
        ?>
    </table>

</div>
</form>	

<?

function get_source_list($srh_order_date_from, $srh_order_date_to, $product_id){

	$sql ="
		select
			distinct(http_referer)
		from 
			tbl_visitor v, 
			tbl_visitor_product_viewed pv
		where 
			v.id=pv.visitor_id
			and product_id=$product_id";
	
	### Search Date
		if ($srh_order_date_from){
			$sql .= " and v.create_date >= '$srh_order_date_from'";
			
		}else{
			$srh_order_date_from=date("Y-m-1");
			$sql .= " and v.create_date >= '$srh_order_date_from'";
		}
		
		if ($srh_order_date_to){
			$sql .= " and v.create_date <= '$srh_order_date_to'";
		}
		
		if ($result = mysql_query($sql)){
			
			while ($row = mysql_fetch_array($result)){
				
				?><li><?=$row[http_referer]; ?></li><?
				
			}
			
		}else
			echo $sql."<br />"; 
	
}

function get_source_from($srh_order_date_from, $srh_order_date_to, $product_id){
	
	$sql="
		select
			distinct(
				SUBSTRING(
					REPLACE(http_referer, 'http://', ''), 
					1, 
					(LOCATE(
						'/', 
						REPLACE(http_referer, 'http://',
						'')
					)- 1)
				)
			) as referer_domain
			
		from 
			tbl_visitor v, 
			tbl_visitor_product_viewed pv
			
		where 
			v.id=pv.visitor_id
			and product_id=$product_id";	
	
	### Search Date
		if ($srh_order_date_from){
			$sql .= " and v.create_date >= '$srh_order_date_from'";
			
		}else{
			$srh_order_date_from=date("Y-m-1");
			$sql .= " and v.create_date >= '$srh_order_date_from'";
	
		}
		
		if ($srh_order_date_to){
			$sql .= " and v.create_date <= '$srh_order_date_to'";
		}
	
	### End of Search Date

		$sql .= " order by referer_domain";	
	
		if ($result = mysql_query($sql)){
			
			?><table><?
			
			while ($row = mysql_fetch_array($result)){
				
				if ($row[referer_domain] != ''){
				
					?>
					<tr>
						<td align="left" valign="top" width="30">
						<?=$row[referer_domain]; ?>
                        </td>
						<td align="left" valign="top" width="30">
						<?=get_view_count($srh_order_date_from, $srh_order_date_to, $product_id, $row[referer_domain]);?></td>
						<td align="left" valign="top" width="30">
						<?=count_visitor_transaction($srh_order_date_from, $srh_order_date_to, $row[referer_domain], $product_id);?></td>
					</tr>
					<?
				
				}
				
			}
			
			?></table><?			
			
		}else
			echo $sql."<br />";
	
}

function get_view_count($srh_order_date_from, $srh_order_date_to, $product_id, $referer_domain){

	$sql ="
		select 
			pv.id,
			pv.visitor_id
			
		from 
			tbl_visitor v, 
			tbl_visitor_product_viewed pv
			
		where 
			v.id=pv.visitor_id
			and pv.product_id=$product_id
			and v.http_referer like '%$referer_domain%'";
	
	### Search Date
		if ($srh_order_date_from){
			$sql .= " and v.create_date >= '$srh_order_date_from'";
			
		}else{
			$srh_order_date_from=date("Y-m-1");
			$sql .= " and v.create_date >= '$srh_order_date_from'";
	
		}
	
		if ($srh_order_date_to){
			$sql .= " and v.create_date <= '$srh_order_date_to'";
		}

	### End of Search Date
		if ($result = mysql_query($sql)){
			
			$num_rows = mysql_num_rows($result);
			
			echo $num_rows."<br />";
			
			/*
			
			?><ul><?
			
			while ($row = mysql_fetch_array($result)){
				
				?><li><?=$row[visitor_id]; ?></li><?
				
			}
			
			?></ul><?
			
			*/

		}else
			echo $sql."<br />";
	
}

function count_visitor_transaction($srh_order_date_from, $srh_order_date_to, $referer_domain, $product_id){
	
	$sql="select 
			c.id,
			c.visitor_id
			
		from 
			tbl_cart c,
			tbl_visitor v
			
		where 
			c.visitor_id = v.id
			and v.http_referer like '%$referer_domain%'
			and c.visitor_id>0			
			and c.active=1
			and c.order_status_id <> 1
			and c.order_status_id <> 6
			and (select count(id) from tbl_cart_item ci where ci.cart_id = c.id and ci.product_id=$product_id ) > 0
			";

	
	### Search Date
		if ($srh_order_date_from){
			$sql .= " and v.create_date >= '$srh_order_date_from'";

		}else{
			$srh_order_date_from=date("Y-m-1");
			$sql .= " and v.create_date >= '$srh_order_date_from'";

		}
	
		if ($srh_order_date_to){
			$sql .= " and v.create_date <= '$srh_order_date_to'";
		}

	if ($result = mysql_query($sql)){
		
		$num_rows = mysql_num_rows($result);
		
		echo $num_rows;
		
		/*

			?><ul><?
			
			while ($row = mysql_fetch_array($result)){
				
				?><li><a href="http://cameraparadise.com/admin/main/main.php?func_pg=order.edit&id=<?=$row[id]; ?>" target="_blank"><?=$row[id]; ?>-<?=$row[visitor_id]; ?></a></li><?
				
			}
			
			?></ul><?

		*/
	}
		
}

?>