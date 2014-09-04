<?
### Default
	$func_name 		= "Product Datafeed";
	$tbl 			= "tbl_product";
	$curr_page 		= "index";
	$edit_page 		= "";
	$action_page 	= "";
	$page_item 		= 9999;

?>
<form name="frm">
	<input type="hidden" name="tbl" value="<?=$tbl?>">
	<input type="hidden" name="act" value="">
	<input type="hidden" name="order_by" value="<?=$order_by?>">
	<input type="hidden" name="ascend" value="<?=$ascend?>">
	<input type="hidden" name="del_id" value="">
	<div id="list">
		<div id="title"><?=$func_name?></div>
		<div id="search">
		</div>
		<div id="tool">
			<div id="paging"></div>
			<br class="clear"/>
		</div>
		<div style="padding: 0 0 60px 60px;">
			<? include("clixgalore-gen-csv.php"); ?>
			<? include("shopping.com-gen-xml.php"); ?>
			<? include("google.com-gen-xml.php"); ?>
                        <? include("priceme.com-xml.php"); ?>
                        <? include("pricerunner.com-xml.php"); ?>
                        <? include("shopbot.com-xml.php");?>
                        <? include("getprice-gen-xml.php");?>
                        <? include("myshopping-gen-xml.php");?>
                        <? include("google.com-uk-gen-xml.php");?>


            <h1>Datafeed Updated</h1>
		</div>
	</div>
</form>
