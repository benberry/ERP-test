<?
## Default
	$func_name = "Create Order";
	$tbl = "tbl_cart";
	$prev_page = "";
	$curr_page = "index";
	$action_page = "update";


## Request
	extract($_REQUEST);

	if ($tab=='')
		$tab=0;


## TinyMCE
	include("../include/tinymce_tiny.php");


if (!empty($id)){
	
	$sql = " select * from $tbl where id = $id ";
	
	if ($rows = mysql_query($sql)){
		$row = mysql_fetch_array($rows);
	
	}

}

?>

<script>
	function form_action(act){
		fr = document.frm;
		
		fr.act.value = act;
		
		if (act == '1'){
			
			//  if (fr.id.value=='')
			//	fr.active[0].checked = true;
		
			fr.action = '../main/main.php?func_pg=<?=$action_page?>'
			fr.method = 'post';
			fr.target = '_self';
			fr.submit();
		
		}
		/*

			if (act == '2'){
				window.location = '../main/main.php?func_pg=<?=$curr_page?>'
				return

			}
	
			if (act == '3'){
				fr.deleted.value = 1;
				fr.action = '../main/main.php?func_pg=<?=$action_page?>'
				fr.method = 'post';
				fr.target = '_self';
				fr.submit();

			}

		*/

	}

</script>

<form name="frm" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?=$row[id]?>">
    <input type="hidden" name="cart_id" value="<?=$row[id]?>">
    <input type="hidden" name="deleted" value="<?=$row[deleted]?>">
    <input type="hidden" name="tbl" value="<?=$tbl?>">
    <input type="hidden" name="act" value="<?=$action?>">
    <input type="hidden" name="tab" value="<?=$tab?>">
    <input type="hidden" name="pg_num" value="<?=$pg_num?>">
    <input type="hidden" name="active" value="1">
    
    <!-- Search Temp -->
        <input type="hidden" name="srh_order_date_from" value="<?=$srh_order_date_from?>" >
        <input type="hidden" name="srh_order_date_to" value="<?=$srh_order_date_to?>" >
        <input type="hidden" name="srh_order_no" value="<?=$srh_order_no?>" >
        <input type="hidden" name="srh_process_type_id" value="<?=$srh_process_type_id?>" >
        <input type="hidden" name="srh_payment_method_id" value="<?=$srh_payment_method_id?>" >
        <input type="hidden" name="srh_delivery_method_id" value="<?=$srh_delivery_method_id?>" >

    <!-- Search Temp -->

    <div id="edit">
        <? include("../include/edit_title.php")?>
        <div id="tool">
			<?
    
                if($row[id] > 0){
                    ?><a class="boldbuttons" href="javascript:form_action(1)"><span>Save</span></a><?
                    
                }else{
                    ?><a class="boldbuttons" href="javascript:form_action(1)"><span>Create</span></a><?
                    
                }
    
            ?>
        </div>
        <div id="tabs">
        
        	<? if($row[id] > 0){ ?>
            
                <ul>
                    <li><a href="#tabs-1" onclick="$('#tab_curr').val(0)">Main</a></li>
                </ul>

                <div id="tabs-1"><? include("tab-main.php") ?></div>

            <? }else{ ?>

            	<div style="margin:100px 0 100px 0;">

                	<center><h1>Please Click Create</h1></center>

                </div>
                <input type="hidden" name="invoice_no" value="<?=get_invoice_no(); ?>" />
                <input type="hidden" name="order_status_id" value="1" />
                <input type="hidden" name="" value="" />
                

			<? } ?>
    
        </div>
        <script>$('#tabs').tabs({ selected: <?=$tab?> });</script>		
        
        <div id="order"></div>
        <br class="clear">	
    </div>

</form>