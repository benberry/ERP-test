<?php

@set_time_limit(0);
//*** Default
	$func_name 		= "Order Shipment List";
	$tbl 			= "tbl_order_shipment";
	$curr_page 		= "oms.shipments";
	$edit_page 		= "oms.shipments.edit";
	$action_page 	= "oms.shipments";
	$page_item 		= 100;

//*** Request

	extract($_REQUEST);
    if(!isset($report_type))
        $report_type = 'Order Shipment';
    if(isset($pg_num) && $pg_num>1){
        $moffset = ($page_item*($pg_num-1))-1;
        $limit = " LIMIT $moffset ,$page_item";
    }
   

//*** Select SQL
		/*$include_file = 'oms.shipments.orders.php';
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
        $resultx=mysql_query($sqlx);*/
	
		$include_file = 'oms.shipments.orders.php';
        $sql="SELECT * FROM $tbl WHERE order_id<>0";
    	if ($start_date){
    		$sql .= " and create_date  >= '$start_date'";
    	}else{
    		$start_date=date("Y-m-01");
    		$sql .= " and create_date  >= '$start_date'";
    	}
    	
    	if ($end_date){
    		$sql .= " and create_date  <= '$end_date'";
    	}
		
    	if ($order_no){
    		$sql .= " and order_no = $order_no";
    	}
        //$sql.=" ORDER BY time_of_visit DESC, tbl_tracking.tracking_name ASC, tbl_tracking.tracking_code ASC ";
        $sql.=" ORDER BY create_date DESC ";
        $sqlx = $sql.$limit;
        //echo $sqlx;
        $resultx=mysql_query($sqlx);
		

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
        
        &nbsp; &nbsp; &nbsp; Order No::
			 <input type="text" name="order_no" value="<?=$order_no?>" >
			 
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
		<!--<? if ($_SESSION["sys_delete"]) { ?>

			<a style="float: right;" class="boldbuttons" href="javascript:delete_this_records();"><span>Delete</span></a> 

        <? } ?>
        
        <? if ($_SESSION["sys_export"]==1){ ?>

			<a style="float: right;" class="boldbuttons" href="javascript:form_export();"><span>Export&nbsp;.csv</span></a>

        <? } ?> -->
		</div>
        
		<br class="clear"/>
	</div>

<?php include($include_file);?>
<br class="clear" />
</div>
</form>	
<?php }else
		echo "load SQL FAIL!";
 ?>