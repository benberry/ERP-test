<?
	## include
	include("../include/init.php");

	$sql="
		select 
			p.*
		from 
			tbl_product p
			left join tbl_product_category pc on p.cat_id=pc.id
		where
			p.active=1
			and p.deleted=0
			and p.stock_status<4
			and p.unit_cost>0
			and pc.main_product=1
			and(p.cat_id=5)
		order by
			p.cat_id,
			p.brand_id,
			p.stock_status,
			p.sort_no desc";
	
	if ($result = mysql_query($sql)){
		
		$rate = get_field("tbl_currency", "rate", 1);	
		
		echo '<?xml version="1.0" encoding="UTF-8" ?>';
		
		?>
		<rss version ="2.0" xmlns:g="http://base.google.com/ns/1.0" >
		<channel>
		<title>Camera Paradise</title>
		<description>Digital SLR Cameras, DSLR, Digital camerss, Lenses and Photography Accessories, Australia, Ships International, 18 months warranty, Camera Paradise</description>
		<link>http://cameraparadise.com</link>
		<?

		while ($row = mysql_fetch_array($result)){
			
			if ($row[content_1] != ''){
				$desc = strip_tags($row[content_1]);
				$desc = strip_tags(str_replace("</li>", ". ", $row[content_1]));
				$desc = str_replace("\n", "", $desc);
				$desc = str_replace("\r", "", $desc);				
				$desc = preg_replace("/&#?[a-z0-9]{2,8};/i","",$desc);
				
			}else{
				$desc = "8 hours response time by email, Fully tracking Express delivery. Better Value Better Choice. 100% Excellent reviews ";

			}

			?>
			<item>
				<title><?=$row[name_1]; ?></title>
                <g:condition>new</g:condition>
                <g:brand><?=get_field("tbl_brand", "name_1", $row[brand_id]); ?></g:brand>
				<description>AUD 5 Instant Discount Coupon. <?=$desc; ?></description>

				<link>http://cameraparadise.com/<?=get_mod_rewrite($row[name_1], $row[id]); ?></link>
				<g:id><?=$row[id]; ?>AU</g:id>
				<g:image_link>http://cameraparadise.com/<?=str_replace("../../", "", get_item_image_first("tbl_product_photo", $row[id])); ?></g:image_link>
				<g:price><?=get_price($row[id]); ?> AUD</g:price>
				<g:product_type><?=get_field("tbl_product_category", "google_merchant_cat", $row[cat_id]); ?></g:product_type>
                <g:google_product_category><?=get_field("tbl_product_category", "google_merchant_cat", $row[cat_id]); ?></g:google_product_category>
				<g:weight><?=$row[weight]; ?> kilograms</g:weight>
				<g:availability>in stock</g:availability>
                <g:gtin><?=$row[gtin]; ?></g:gtin>
                <? if ($row[mpn] != ''){ ?>
	                <g:mpn><?=$row[mpn]; ?></g:mpn>
                <? }else{ ?>
                	<g:mpn><?=$row[id]; ?>AU</g:mpn>
                <? } ?>
			</item>
			<?

		}
		
		?>
		</channel>
		</rss>				
		<?

	}else
		echo $sql;			

?>
