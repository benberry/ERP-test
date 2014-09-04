<?
	### include
	include("init.php");
	$GLOBALS['cfg']['company_website_address']="http://cameraparadise.com/";

	$sql="select 
			*
		from 
			tbl_product
		where
			active=1
			and deleted=0
			and stock_status<4					
			and display_to_shopping=1
		order by
			cat_id,
			brand_id,
			stock_status,
			sort_no desc";

	if ($result = mysql_query($sql)){
		$rate = get_field("tbl_currency", "rate", 1);	
		echo '<?xml version="1.0" encoding="UTF-8" ?>';
		
		?>
		<products>
			<?

            while ($row = mysql_fetch_array($result)){

                if ($row[content_1] != ''){
                    $desc = strip_tags($row[content_1]);
                    $desc = strip_tags(str_replace("</li>", ". ", $row[content_1]));
                    $desc = str_replace("\n", "", $desc);
                    $desc = str_replace("\r", "", $desc);				
                    $desc = preg_replace("/&#?[a-z0-9]{2,8};/i","",$desc);

                }else{
                    $desc = "AU$30 Coupon; 14-Day Return Policy; 18-Month Door-to-Door Warranty; 1-3 Day Express Delivery; No GST";

                }
				
				$desc = "AU$30 Coupon; 14-Day Return Policy; 18-Month Door-to-Door Warranty; 1-3 Day Express Delivery; No GST";

			?>
            <product>		
            <merchant_sku><?=$row[id]; ?></merchant_sku>	
            <product_name><?=$row[name_1]; ?></product_name>	
            <product_url><?=get_cfg("company_website_address")?><?=get_mod_rewrite($row[name_1], $row[id]); ?></product_url> 	
            <image_url><?=get_cfg("company_website_address")?><?=str_replace("../../", "", get_item_image_first("tbl_product_photo", $row[id])); ?></image_url>	
            <current_price>$<?=round(get_price($row[id]), 2); ?></current_price> 	
            <shipping_rate>$<?
                if ($row[weight] > 1){
                    echo round(item_express_shipping_cost($row[weight]), 2);

                }else{
                    echo round(item_registered_airmail_cost($row[weight]), 2);

                }
            ?></shipping_rate>	
            <stock_availability>YES</stock_availability>
            <condition>New</condition>	
            <upc><?=$row[id]; ?></upc>
            <mpn><?=$row[mpn]; ?></mpn>
            <original_price>$<?=round(get_price($row[id]), 2); ?></original_price> 	
            <coupon_code>CP_AUD_10</coupon_code>	
            <coupon_code_description>AU$10 Instant Discount Coupon</coupon_code_description>	
            <manufacturer><?=get_field("tbl_brand", "name_1", $row[brand_id]); ?></manufacturer>	
            <product_description><?=$desc; ?></product_description>	
            <product_type><?=get_field("tbl_product_category", "shopping_type", $row[cat_id]);?></product_type>	
            <category><?=get_field("tbl_product_category", "shopping_cat", $row[cat_id]);?></category>	
            <category_id><?=get_field("tbl_product_category", "shopping_cat_id", $row[cat_id]);?></category_id>	
            <parent_sku></parent_sku>	
            <parent_name></parent_name>	
            <top_seller_rank></top_seller_rank>	
            <estimated_ship_date>AU$30 Instant Discount Coupon. 1-3 Day Delivery, POBOX Delivered.</estimated_ship_date>	
            <gender></gender>
            <color><? get_product_color($row[id]); ?></color>	
            <material></material>	
            <size></size>	
            <size_unit_of_measure></size_unit_of_measure>	
            <age_range></age_range>	
            <cell_phone_plan_type></cell_phone_plan_type>	
            <cell_phone_service_provider></cell_phone_service_provider>	
            <stock_description>1-3 Day Delivery, 18-Month Warranty, POBOX Delivered</stock_description>	
            <product_launch_date>20110101</product_launch_date>	
            <product_bullet_point_1></product_bullet_point_1>	
            <product_bullet_point_2></product_bullet_point_2>	
            <product_bullet_point_3></product_bullet_point_3>	
            <product_bullet_point_4></product_bullet_point_4>	
            <product_bullet_point_5></product_bullet_point_5>	
            <alternative_image_url_1></alternative_image_url_1>	
            <alternative_image_url_2></alternative_image_url_2>	
            <alternative_image_url_3></alternative_image_url_3>	
            <alternative_image_url_4></alternative_image_url_4>	
            <alternative_image_url_5></alternative_image_url_5>	
            <mobile_url></mobile_url>
            <related_products></related_products>
            <merchandising_type>New</merchandising_type>
            <product_weight><?=$row[weight]; ?></product_weight>
            <zip_code></zip_code>
            <shipping_weight><?=$row[weight]; ?></shipping_weight>
            <weight_unit_of_measure>Kilograms</weight_unit_of_measure>
            <unit_price></unit_price>
            <bundle>No</bundle>
            <software_platform></software_platform>
            <watch_display_type></watch_display_type>
            </product>
            <?

            }

            ?>
		</products>				
		<?

	}else
		echo $sql;

		
	function get_product_color($id){

		$sql = "select * from tbl_product_attribute where product_id=$id and attribute_cat_id=1 and attribute_id <> 42 and attribute_id <> 53";

		if ($result=mysql_query($sql)){
			
			$num_rows = mysql_num_rows($result);
			
			if ($num_rows > 0){
				
				$i=1;
				
				while ($row = mysql_fetch_array($result)){
					
					if ($i==1){
						?><?=get_field("tbl_attribute", "name_1", $row[attribute_id]); ?><?

					}else{
						?>/<?=get_field("tbl_attribute", "name_1", $row[attribute_id]); ?><?

					}

					$i++;	
					
				}
				
			}
			
		}else
			echo $sql;
		
	}

?>