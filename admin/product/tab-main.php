<fieldset class='single-form'>
	<div style="float:left;">
        <p><label>Category:</label>
            <select name="cat_id">
                <option value="">TOP</option>
                <?
                    if (!empty($row[cat_id]))
                        $cat_id = $row[cat_id];
                
					echo get_category_combo("tbl_product_category", 0, 0, $cat_id);
					
				?>
            </select></p>
        
        <p><label>Product Name:</label><input style="width:675px;" type="text" name="name_1" value="<?=$row[name_1]; ?>" ></p>
        
        <p style="display:none;"><label>Model:</label><input type="text" name="model" value="<?=$row[model]; ?>" ></p>
        
        <p style="display:none;"><label>Manufacturer SKU:</label><input type="text" name="manufacturer_sku" value="<?=$row[manufacturer_sku]; ?>"></p>
        
		<p><label>Code No:</label><input type="text" name="codeno" value="<?=$row[codeno]; ?>"></p>
		
        <p><label>Bar Code:</label><input type="text" name="product_code" value="<?=$row[product_code]; ?>"></p>

        <p style="display:none;"><label>EAN:</label><input type="text" name="ean" value="<?=$row[ean]; ?>"></p>
        
        <p style="display:none;"><label>MPN:</label><input type="text" name="mpn" value="<?=$row[mpn]; ?>"></p>
            
        <p><label>Brand:</label>
            <select name="brand_id">
                <option value=""> -- </option>
                <?=get_combobox_src("tbl_brand", "name_1", $row[brand_id]); ?>
            </select></p>
            
		<p style="display:none;"><label>Weight(kg):</label><input type="text" name="weight" value="<?=$row[weight]; ?>"></p>
        
        <p style="display:none;"><label>Filter Size(mm):<br /><span class="notice">for DSLR, Lenses, Filter</span></label><input type="text" name="filter_size" value="<?=$row[filter_size]; ?>"></p>
        
        
        <p><label>Price(HK$):</label><input type="text" name="unit_cost" value="<?=$row[unit_cost]; ?>" style="width:150px"></p>
		
		<p><label>Available Quantity:</label><input type="text" name="avail_qty" value="<?=$row[avail_qty]; ?>" style="width:150px"></p>
		
		<?
		   if(isset($row[total_sold]) || $row[total_sold] = null){
		?>
		<p><label>Totally Sold:</label><input type="text" name="total_sold" value="<?=$row[total_sold]; ?>" style="width:150px" readonly="readonly"></p>
        <?
		  }else{
		?>
		  
		<p><label>Totally Sold:</label><input type="text" name="total_sold" value="0" style="width:150px" readonly="readonly"></p> 
		<?
		  }
		?>
        
        <p style="display:none;"><label>Display to getprice.com.au:</label>
           <input type="radio" name="display_to_getprice" value="1" <?=set_checked($row[display_to_getprice], 1); ?>>YES
           <input type="radio" name="display_to_getprice" value="0" <?=set_checked($row[display_to_getprice], 0); ?>>NO
        </p>
        <p style="display:none;"><label>Display to shopbot.com:</label>
           <input type="radio" name="display_to_shopbot"  value="1" <?=set_checked($row[display_to_shopbot], 1); ?>>YES
           <input type="radio" name="display_to_shopbot"  value="0" <?=set_checked($row[display_to_shopbot], 0); ?>>NO
        </p>
        <p style="display:none;"><label>Display to shopping.com:</label>
           <input type="radio" name="display_to_shopping" value="1" <?=set_checked($row[display_to_shopping], 1); ?>>YES
           <input type="radio" name="display_to_shopping" value="0" <?=set_checked($row[display_to_shopping], 0); ?>>NO</p>
        
        
        <p style="display:none;"><label>Bundle Deal Photo:</label><? get_image_upload_box($tbl, $id, 4, "vie_crop", "600 * 120 pixels", $curr_page); ?></p>
        
        <p style="display:none;"><label>Product Status:</label>
            <? 
                if($row[stock_status] == 0){
                    $stock_status_selected = 1;

                }else{
                    $stock_status_selected = $row[stock_status];

                }
            ?>
            <input type="radio" name="stock_status" value="1" <?=set_checked($stock_status_selected, 1); ?>>Preorder
            <input type="radio" name="stock_status" value="2" <?=set_checked($stock_status_selected, 2); ?>>In stock
            <input type="radio" name="stock_status" value="3" <?=set_checked($stock_status_selected, 3); ?>>2-3 weeks handling time <br/>
            <label>&nbsp;&nbsp;</label>
            <input type="radio" name="stock_status" value="4" <?=set_checked($stock_status_selected, 4); ?>>Unavailable
            <input type="radio" name="stock_status" value="5" <?=set_checked($stock_status_selected, 5); ?>>Discontinued</p>
        
        <p style="display:none;"><label>Sort No:</label><input type="text" name="sort_no" value="<?=$row[sort_no]; ?>"></p>
        
        <p><label>Special Promotion:</label>
		   <?
		     if(isset($row[isPromotion])){
		   ?>
           <input type="radio" name="isPromotion" value="1" <?=set_checked($row[isPromotion], 1); ?>>Yes
           <input type="radio" name="isPromotion" value="0" <?=set_checked($row[isPromotion], 0); ?>>No
		   <?
		     }else{
		   ?>
		   <input type="radio" name="isPromotion" value="1">Yes
           <input type="radio" name="isPromotion" value="0" checked="true">No
		   <?
		     }
		   ?>
		</p>
		
		<p><label>Available(Display?):</label>
		   <?
		     if(isset($row[active])){
		   ?>
           <input type="radio" name="active" value="1" <?=set_checked($row[active], 1); ?>>Yes
           <input type="radio" name="active" value="0" <?=set_checked($row[active], 0); ?>>No
		   <?
		     }else{
		   ?>
		   <input type="radio" name="active" value="1" checked="true">Yes
           <input type="radio" name="active" value="0">No
		   <?
		     }
		   ?>
		</p>
		
    </div>
</fieldset>