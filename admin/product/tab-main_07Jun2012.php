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
        
        <p><label>Product Name:</label><input type="text" name="name_1" value="<?=$row[name_1]; ?>" ></p>
        
        <p><label>Model:</label><input type="text" name="model" value="<?=$row[model]; ?>" ></p>
        
        <p><label>Manufacturer SKU:</label><input type="text" name="manufacturer_sku" value="<?=$row[manufacturer_sku]; ?>"></p>
        
        <p><label>UPC:</label><input type="text" name="upc" value="<?=$row[upc]; ?>"></p>

        <p><label>EAN:</label><input type="text" name="ean" value="<?=$row[ean]; ?>"></p>
        
        <p><label>MPN:</label><input type="text" name="mpn" value="<?=$row[mpn]; ?>"></p>
            
        <p><label>Brand:</label>
            <select name="brand_id">
                <option value=""> -- </option>
                <?=get_combobox_src("tbl_brand", "name_1", $row[brand_id]); ?>
            </select></p>
            
		<p><label>Weight(kg):</label><input type="text" name="weight" value="<?=$row[weight]; ?>"></p>
        
        <p><label>Filter Size(mm):<br /><span class="notice">for DSLR, Lenses, Filter</span></label><input type="text" name="filter_size" value="<?=$row[filter_size]; ?>"></p>
        
        <br />
        
        <p><label>RRP:</label><input type="text" name="price_3" value="<?=$row[price_3]; ?>" style="width:150px"></p>
        
        <br />
        
        <p><label>Display to getprice.com.au:</label>
           <input type="radio" name="display_to_getprice" value="1" <?=set_checked($row[display_to_getprice], 1); ?>>YES
           <input type="radio" name="display_to_getprice" value="0" <?=set_checked($row[display_to_getprice], 0); ?>>NO
        </p>
        <p><label>Display to shopbot.com:</label>
           <input type="radio" name="display_to_shopbot"  value="1" <?=set_checked($row[display_to_shopbot], 1); ?>>YES
           <input type="radio" name="display_to_shopbot"  value="0" <?=set_checked($row[display_to_shopbot], 0); ?>>NO
        </p>
        <p><label>Display to shopping.com:</label>
           <input type="radio" name="display_to_shopping" value="1" <?=set_checked($row[display_to_shopping], 1); ?>>YES
           <input type="radio" name="display_to_shopping" value="0" <?=set_checked($row[display_to_shopping], 0); ?>>NO</p>
        
        <br />

        
        <p><label>Bundle Deal Photo:</label><? get_image_upload_box($tbl, $id, 4, "vie_crop", "600 * 120 pixels", $curr_page); ?></p>
        
        <br />
        
        <p><label>Product Status:</label>
            <? 
                if($row[stock_status] == 0){
                    $stock_status_selected = 1;

                }else{
                    $stock_status_selected = $row[stock_status];

                }
            ?>
            <input type="radio" name="stock_status" value="1" <?=set_checked($stock_status_selected, 1); ?>>Preorder
            <input type="radio" name="stock_status" value="2" <?=set_checked($stock_status_selected, 2); ?>>In stock
            <input type="radio" name="stock_status" value="3" <?=set_checked($stock_status_selected, 3); ?>>2-3 weeks handling time
            <input type="radio" name="stock_status" value="4" <?=set_checked($stock_status_selected, 4); ?>>Unavailable</p>
        
        <p><label>Sort No:</label><input type="text" name="sort_no" value="<?=$row[sort_no]; ?>"></p>
        
        <p><label>Available(Display?):</label>
           <input type="radio" name="active" value="1" <?=set_checked($row[active], 1); ?>>Yes
           <input type="radio" name="active" value="0" <?=set_checked($row[active], 0); ?>>No</p>
    </div>
</fieldset>