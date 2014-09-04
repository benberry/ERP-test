<?
	## include
	include("../include/init.php");
	include("../include/html_head.php");

	## request
	extract($_REQUEST);
	$item_id = $id;
	
	## init 
	$tbl = "tbl_product_photo";
	$prev_page = "item-edit";
	
	## delete record
	$sql = " delete from $tbl where id = {$photo_id}";
	
	if (mysql_query($sql)){
		## unlink
		$idx = 1;
		@unlink(get_img_src($tbl, $photo_id, $idx, "icon"));
		@unlink(get_img_src($tbl, $photo_id, $idx, "icon_crop"));
		@unlink(get_img_src($tbl, $photo_id, $idx, "thu"));
		@unlink(get_img_src($tbl, $photo_id, $idx, "thu_crop"));
		@unlink(get_img_src($tbl, $photo_id, $idx, "vie"));
		@unlink(get_img_src($tbl, $photo_id, $idx, "vie_crop"));
		@unlink(get_img_src($tbl, $photo_id, $idx, "org"));		
		
	}else
		echo $sql;

?>
<script>
	path = "../main/main.php?func_pg=<?=$prev_page?>";
	path += "&id=<?=$item_id?>";
	path += "&pg_num=<?=$pg_num?>";
	path += "&tab=<?=$tab?>";
	path += "&cat_id=<?=$cat_id?>";			
	window.location=path;
</script>