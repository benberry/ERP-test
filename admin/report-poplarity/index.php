<?
##*** Default
	$func_name 		= "Popularity (TEMP)";
	// $tbl 		= "tbl_report_popular";
	$curr_page 		= "index";
	$edit_page 		= "";
	$action_page 	= "";
	$page_item 		= 9999;


##*** Request
	extract($_REQUEST);


##*** Select SQL
	$sql = "
		select
			*
		from
			tbl_product		
		where
			active=1
			and deleted=0

	";


##*** Search
	/*
	if ($srh_order_date_from){
		$sql .= " and c.member_create_date >= '$srh_order_date_from'";
		
	}else{
		$srh_order_date_from=date("Y-m-1");
		$sql .= " and c.member_create_date >= '$srh_order_date_from'";
		
	}
	
	if ($srh_order_date_to){
		$sql .= " and c.member_create_date <= '$srh_order_date_to'";

	}
	*/
##*** Cat ID
	if ($srh_cat_id){
		$sql .= " and cat_id = $srh_cat_id";

	}
	

##*** Order by start
		$sql .= "order by popularity desc ";


//*** Order by end
if ($result=mysql_query($sql)){

	$num_rows = mysql_num_rows($result);
	
	
		
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
        <!--
        
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
		-->
        Category:
        <select name="srh_cat_id">
            <option value=""> all category </option>
            <?=get_cat_menu_combo(0, 0, $srh_cat_id)?>
        </select>
		</div>
        
		<!-- End of Second Line -->
        
		
    </div>
    
	<div id="tool">
        <div id="button"></div>
		<br class="clear"/>
	</div>
    <?
    
	if ($result = mysql_query($sql)){
		
		?><table width="600">
			<tr>
                <th align="left">Model</th>
                <th align="left">Views</th>
			</tr>
		<?
		
		while ($row = mysql_fetch_array($result)){
			
			?>
            <tr style="cursor:default; ">
                <td align="left" style="font-size:16px;"><?=$row[name_1]; ?></td>
                <td align="right" style="font-size:16px;"><?=$row[popularity]; ?></td>
			</tr>
            <?
			
		}
		
		?></table><?
		
	}else
		echo $sql;
	
	
	?>
    

</div>
</form>	

