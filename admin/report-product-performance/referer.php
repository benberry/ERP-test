<?
### Default
	$func_name 		= "Referer List";
	$curr_page 		= "index";
	$edit_page 		= "";
	$action_page 	= "";
	$page_item 		= 9999;


### Request
	extract($_REQUEST);
	
	if ($srh_order_date_from == ''){
		$srh_order_date_from = date("Y-m-1");

	}

### Select SQL

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
					))
				)
			) as referer_domain

		from 
			tbl_visitor v, 
			tbl_visitor_product_viewed pv

		where 
			v.id=pv.visitor_id
			and http_referer not like 'https://%'";
			
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
		
### Search Keyword		
		if ($srh_keyword){
			$sql .= " and http_referer like '%$srh_keyword%' ";

		}

### Order by start
	$sql .= " order by referer_domain ";


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
        
        Keyword: <input type="text" name="srh_keyword" value="<?=$srh_keyword; ?>" style="width:300px;">
        
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
        	<th>Referer</th>
            <th>Viewed</th>
            <th>Transaction</th>            
        </tr>
        <?
			if ($result = mysql_query($sql)){

				while ($row = mysql_fetch_array($result)){

					?>
					<tr>
						<td align="left" valign="top">
						<?
						if ($row[referer_domain]!=''){
							echo $row[referer_domain];
							
						}else{
							echo 'NULL';
							
						}
						?>
                        </td>
						<td align="left" valign="top">
                        	<? get_view_count($srh_order_date_from, $srh_order_date_to, $row[referer_domain]); ?>
                        </td>
						<td align="left" valign="top">
							<? get_transaction_count($srh_order_date_from, $srh_order_date_to, $row[referer_domain]); ?>
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
	function get_view_count($srh_order_date_from, $srh_order_date_to, $referer_domain){
		
		$sql = "
			select
				count(v.id) as view_count
				
			from 
				tbl_visitor v
				
			where 
				v.http_referer like '%$referer_domain%'

			";
		
		if ( $srh_order_date_from ){
			$sql .= " and v.create_date >= '$srh_order_date_from'";

		}
		
		if ( $srh_order_date_to ){
			$sql .= " and v.create_date <= '$srh_order_date_to'";

		}
		
		if($result=mysql_query($sql)){

			while ($row = mysql_fetch_array($result)){

				echo $row[view_count];

			}

		}else
			echo $sql;
		
	}

	function get_transaction_count($srh_order_date_from, $srh_order_date_to, $referer_domain){
		
		$sql="
		select 
			count(c.id) as transaction_count
			
		from 
			tbl_cart c,
			tbl_visitor v
			
		where 
			c.visitor_id = v.id
			and v.http_referer like '%$referer_domain%'
			and c.visitor_id > 0
			and c.active = 1
			and c.order_status_id <> 1
			and c.order_status_id <> 6";
		
		if ($srh_order_date_from){
			$sql .= " and v.create_date >= '$srh_order_date_from'";
		}
		
		if ($srh_order_date_to){
			$sql .= " and v.create_date <= '$srh_order_date_to'";
		}
		
		if($result=mysql_query($sql)){
			
			while ($row = mysql_fetch_array($result)){
				
				echo $row[transaction_count];
				
			}
			
		}else
			echo $sql;
		
	}

?>