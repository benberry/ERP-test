<?php

@set_time_limit(0);
//*** Default
	$func_name 		= "Tracking Reports";
	$tbl 			= "tbl_tracking_records";
	$curr_page 		= "report";
	$edit_page 		= "report";
	$action_page 	= "report";
	$page_item 		= 100;

//*** Request

	extract($_REQUEST);
    if(!isset($report_type))
        $report_type = 'Order Source';
    if(isset($pg_num) && $pg_num>1){
        $moffset = ($page_item*($pg_num-1))-1;
        $limit = " LIMIT $moffset ,$page_item";
    }
    else{
        if($report_type != 'Order Source')
        $page_item+=1;
        $limit = " LIMIT 0, $page_item";
    }

//*** Select SQL
if($myaction=='delete'){
    if($report_type == 'All Custom URLs'){
    
    $include_file = 'allcustom_urls.php';
         $sql="SELECT * FROM tbl_tracking WHERE 1 ";
        $where = " ";
    	if ($start_date){
    		$where .= " and DATE(tbl_tracking.date_created)  >= '$start_date'";
    	}else{
    		$start_date=date("Y-m-01");
    		$where .= " and DATE(tbl_tracking.date_created)  >= '$start_date'";
    	}
    	
    	if ($end_date!=''){
    		$where .= " and DATE(tbl_tracking.date_created)  <= '$end_date'";
    	}
        
       // echo  $sql;
        $sqlx = $sql.$where;
        $resultx=mysql_query($sqlx);
        if(mysql_num_rows($resultx)>0){
            while($this_rowm= mysql_fetch_object($resultx)){
                $tracking_code_idx = $this_rowm->id;
                mysql_query("DELETE FROM tbl_tracking_records WHERE tracking_code_id=$tracking_code_idx ");
            }
        }
        mysql_query("DELETE FROM tbl_tracking WHERE 1 $where ");
}
elseif($report_type == 'Conversion'){
    	$include_file = 'conversion.php';
         $sql="DELETE FROM tbl_tracking_records  WHERE 1 ";
    	if ($start_date){
    		$sql .= " and tbl_tracking_records.time_of_visit  >= '$start_date'";
    	}else{
    		$start_date=date("Y-m-01");
    		$sql .= " and tbl_tracking_records.time_of_visit  >= '$start_date'";
    	}
    	
    	if ($end_date){
    		$sql .= " and tbl_tracking_records.time_of_visit  <= '$end_date'";
    	}
        $sqlx = $sql;
        $resultx=mysql_query($sqlx);
}
elseif($report_type == 'Daily Conversion'){
    
    $include_file = 'dailyconversion.php';
    $sql="DELETE FROM tbl_tracking_records WHERE 1 ";
    	if ($start_date){
    		$sql .= " and tbl_tracking_records.time_of_visit  >= '$start_date'";
    	}else{
    		$start_date=date("Y-m-01");
    		$sql .= " and tbl_tracking_records.time_of_visit  >= '$start_date'";
    	}
    	
    	if ($end_date){
    		$sql .= " and tbl_tracking_records.time_of_visit  <= '$end_date'";
    	}
        $sqlx = $sql;
        $resultx=mysql_query($sqlx);
}
else{   $include_file = 'ordersource.php';
        $sql="DELETE FROM tbl_tracking_records WHERE 1 
        ";
    	if ($start_date){
    		$sql .= " and tbl_tracking_records.time_of_visit  >= '$start_date'";
    	}else{
    		$start_date=date("Y-m-01");
    		$sql .= " and tbl_tracking_records.time_of_visit  >= '$start_date'";
    	}
    	
    	if ($end_date){
    		$sql .= " and tbl_tracking_records.time_of_visit  <= '$end_date'";
    	}
        $sqlx = $sql;
        $resultx=mysql_query($sqlx);

    	
    	
}	
}


if($report_type == 'All Custom URLs'){
    
    $include_file = 'allcustom_urls.php';
         $sql="SELECT *,DATE(tbl_tracking.date_created) as datex,sum(IF( (tbl_tracking_records.id>0 ), 1, 0 )) as clicks, 
         sum(IF( ((tbl_cart.order_status_id = 2 OR tbl_cart.order_status_id = 4 OR tbl_cart.order_status_id = 7) AND tbl_tracking_records.cart_id!=0 ), 1, 0 )) as orders,
         CONCAT(((sum(IF( ((tbl_cart.order_status_id = 2 OR tbl_cart.order_status_id = 4 OR tbl_cart.order_status_id = 7) AND tbl_tracking_records.cart_id!=0 ), 1, 0 ))/count(*))*100),'','%') as 'Conversion Rate'
         FROM tbl_tracking
        LEFT JOIN tbl_tracking_records ON tbl_tracking.id = tbl_tracking_records.tracking_code_id
        LEFT JOIN tbl_cart ON tbl_cart.id = tbl_tracking_records.cart_id WHERE 1 
        ";
    	if ($start_date){
    		$sql .= " and DATE(tbl_tracking.date_created)  >= '$start_date'";
    	}else{
    		$start_date=date("Y-m-1");
    		$sql .= " and DATE(tbl_tracking.date_created)  >= '$start_date'";
    	}
    	
    	if ($end_date!=''){
    		$sql .= " and DATE(tbl_tracking.date_created)  <= '$end_date'";
    	}
        $sql.="GROUP BY tbl_tracking.id 
        ORDER BY tbl_tracking.date_created DESC, tbl_tracking.tracking_name ASC, tbl_tracking.tracking_code ASC ";
       // echo  $sql;
        $sqlx = $sql.$limit;
        $resultx=mysql_query($sqlx);
}
elseif($report_type == 'Conversion'){
    	$include_file = 'conversion.php';
         $sql="SELECT *,DATE(time_of_visit) as datex,count(*) as clicks, 
         sum(IF( ((tbl_cart.order_status_id = 2 OR tbl_cart.order_status_id = 4 OR tbl_cart.order_status_id = 7) AND tbl_tracking_records.cart_id!=0 ), 1, 0 )) as orders 
         FROM tbl_tracking 
        LEFT JOIN tbl_tracking_records ON tbl_tracking.id = tbl_tracking_records.tracking_code_id
        LEFT JOIN tbl_cart ON tbl_cart.id = tbl_tracking_records.cart_id WHERE 1 
        ";
    	if ($start_date){
    		$sql .= " and tbl_tracking_records.time_of_visit  >= '$start_date'";
    	}else{
    		$start_date=date("Y-m-01");
    		$sql .= " and tbl_tracking_records.time_of_visit  >= '$start_date'";
    	}
    	
    	if ($end_date){
    		$sql .= " and tbl_tracking_records.time_of_visit  <= '$end_date'";
    	}
        $sql.="GROUP BY CONCAT(tbl_tracking.id,'-', tbl_tracking_records.product_id) 
        ORDER BY tbl_tracking.tracking_name ASC, tbl_tracking.tracking_code ASC, tbl_tracking_records.product_id ASC ";
        $sqlx = $sql.$limit;
        $resultx=mysql_query($sqlx);
}
elseif($report_type == 'Daily Conversion'){
    
    $include_file = 'dailyconversion.php';
    $sql="SELECT *,DATE(time_of_visit) as datex,count(*) as clicks, 
    sum(IF( ((tbl_cart.order_status_id = 2 OR tbl_cart.order_status_id = 4 OR tbl_cart.order_status_id = 7) AND tbl_tracking_records.cart_id!=0 ), 1, 0 )) as orders FROM tbl_tracking_records
        LEFT JOIN tbl_tracking ON tbl_tracking.id = tbl_tracking_records.tracking_code_id
        LEFT JOIN tbl_cart ON tbl_cart.id = tbl_tracking_records.cart_id WHERE 1 
        ";
    	if ($start_date){
    		$sql .= " and tbl_tracking_records.time_of_visit  >= '$start_date'";
    	}else{
    		$start_date=date("Y-m-01");
    		$sql .= " and tbl_tracking_records.time_of_visit  >= '$start_date'";
    	}
    	
    	if ($end_date){
    		$sql .= " and tbl_tracking_records.time_of_visit  <= '$end_date'";
    	}
        $sql.="GROUP BY DATE(time_of_visit), tbl_tracking.id, tbl_tracking_records.product_id ORDER BY time_of_visit DESC, tbl_tracking.tracking_name ASC, tbl_tracking.tracking_code ASC ";
        $sqlx = $sql.$limit;
        $resultx=mysql_query($sqlx);
}
else{   $include_file = 'ordersource.php';
        $sql="SELECT * FROM tbl_tracking_records
        LEFT JOIN tbl_tracking ON tbl_tracking.id = tbl_tracking_records.tracking_code_id
        LEFT JOIN tbl_cart ON tbl_cart.id = tbl_tracking_records.cart_id WHERE 1 
        ";
    	if ($start_date){
    		$sql .= " and tbl_tracking_records.time_of_visit  >= '$start_date'";
    	}else{
    		$start_date=date("Y-m-01");
    		$sql .= " and tbl_tracking_records.time_of_visit  >= '$start_date'";
    	}
    	
    	if ($end_date){
    		$sql .= " and tbl_tracking_records.time_of_visit  <= '$end_date'";
    	}
        //$sql.=" ORDER BY time_of_visit DESC, tbl_tracking.tracking_name ASC, tbl_tracking.tracking_code ASC ";
        $sql.=" ORDER BY time_of_visit DESC ";
        $sqlx = $sql.$limit;
        //echo $sqlx;
        $resultx=mysql_query($sqlx);

    	
    	
}	
	
			

if ($result=mysql_query($sql))
{

	$num_rows = mysql_num_rows($result);
	
	if ($num_rows > 0 )
		$pbar = paging_bar($page_item, $num_rows);

    

?>

<script>
	function form_search(){

		fr = document.frm

		fr.action = "<?=$_SERVER['PHP_SELF']?>?<?=$_SERVER['QUERY_STRING']?>";
		fr.method = "post";
		fr.target = "_self";
		fr.submit();

	}
	
	function delete_this_records(){
	   if(confirm('Are you sure you want to delete these records?')){
	       fr = document.frm;
           fr.myaction.value = 'delete';
           fr.action = "<?=$_SERVER['PHP_SELF']?>?<?=$_SERVER['QUERY_STRING']?>";
		  fr.method = "post";
		  fr.target = "_self";
		  fr.submit();
	   }
	}
	function form_export(){

		fr = document.frm

		fr.action = "../Tracking/export_csv.php";
		fr.method = "post";
		fr.target = "_self";
		fr.submit();

	}	form_markshipped
	
	
	function form_search_reset(){

		window.location = "<?=$_SERVER['PHP_SELF']?>?<?=$_SERVER['QUERY_STRING']?>";

	}

</script>

<form name="frm">
<input type="hidden" name="tbl" value="<?=$tbl?>">
<input type="hidden" name="act" value="">
<input type="hidden" name="myaction" value="QUERY">
<input type="hidden" name="order_by" value="<?=$order_by?>">
<input type="hidden" name="ascend" value="<?=$ascend?>">
<input type="hidden" name="del_id" value="">
<input type="hidden" name="thispage" value="<?=$_SERVER['QUERY_STRING']?>">
<div id="list">
	<div id="title"><?=$func_name?></div>
    <div id="search">
		<!-- First Line -->
		<div id="line-1" style="padding-bottom: 10px;">
			

            Start Date:
        <input type="text" id="start_date" name="start_date" value="<?=date_empty($start_date)?>" readonly="readonly">
        <a href="#" id="btn_srh_order_date_from"><img src="../images/calendar.jpg" border="0"></a>
        <script type="text/javascript">//<![CDATA[

			var cal = Calendar.setup({
				onSelect: function(cal) { cal.hide() }
			});
			cal.manageFields("btn_srh_order_date_from", "start_date", "%Y-%m-%d");

        //]]></script>
        <span> &nbsp; &nbsp; &nbsp; &nbsp; End Date: </span>
		<input type="text" id="end_date" name="end_date" value="<?=date_empty($end_date)?>" readonly="readonly">
        <a href="#" id="btn_srh_order_date_to"><img src="../images/calendar.jpg" border="0"></a>
        <script type="text/javascript">//<![CDATA[

			  var cal = Calendar.setup({
				  onSelect: function(cal) { cal.hide() }
			  });
			  cal.manageFields("btn_srh_order_date_to", "end_date", "%Y-%m-%d");

        //]]></script>
        
        &nbsp; &nbsp; &nbsp; Report Type:
			<select name="report_type">
				<option value="Order Source" <?php if($report_type=='Order Source') echo 'selected="selected"';?>>Order Source</option>
				<option value="Conversion" <?php if($report_type=='Conversion') echo 'selected="selected"';?>>Conversion</option>
                <option value="Daily Conversion" <?php if($report_type=='Daily Conversion') echo 'selected="selected"';?>>Daily Conversion</option>
                <option value="All Custom URLs" <?php if($report_type=='All Custom URLs') echo 'selected="selected"';?>>All Custom URLs</option>
			</select>
            &nbsp; &nbsp; &nbsp; 
        <input type="button" value="SEARCH" onclick="form_search()">
        <input type="button" value="RESET" onclick="form_search_reset()">

		</div>
        
		<!-- End of first Line -->
		
    </div>
  
    
    
	<div id="tool">
		<div id="paging" style="width: 340px;">
			<?	
				echo $pbar[1];
				echo $pbar[2];
				echo $pbar[4];
				echo $pbar[3];
				echo $pbar[5];

			?>
		</div>
        
        <div id="button" style="width: 900px; text-align: left;"><? //include("../include/list_toolbar.php");	?>
        <span style="font-size: 21px;"><?=$report_type?></span>
		<? if ($_SESSION["sys_delete"]) { ?>

			<a style="float: right;" class="boldbuttons" href="javascript:delete_this_records();"><span>Delete</span></a> 

        <? } ?>
        
        <? if ($_SESSION["sys_export"]==1){ ?>

			<a style="float: right;" class="boldbuttons" href="javascript:form_export();"><span>Export&nbsp;.csv</span></a>

        <? } ?>
		</div>
        
		<br class="clear"/>
	</div>

<?php include($include_file);?>
<br class="clear" />
</div>
</form>	
<?php } ?>