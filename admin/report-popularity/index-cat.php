<?
### Default
	$func_name 		= "CPC Performance";
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
	$sql="select
			pc.*
			
		from
			tbl_product_category pc
			
		where
			pc.active=1
			and pc.deleted=0
			and pc.main_product=1";


### Cat ID
	if ($srh_cat_id){
		$sql .= " and p.cat_id=$srh_cat_id ";
	}


### Order by start
	$sql .= " order by sort_no";


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
        	<th>Categpr</th>
            <th>REFERER</th>
        </tr>
        <?
			if ($result = mysql_query($sql)){
				
				while ($row = mysql_fetch_array($result)){
				
					?>
					<tr>
						<td align="left" valign="top" style="font-size:16px" width="200">
							<?=$row[name_1]; ?>
                        </td>
						<td align="left" valign="top" style="font-size:16px" width="*">
                        	
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



?>