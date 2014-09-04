<fieldset>  
	<p>
	   <label>Type:</label>
       <input type="radio" name="type_id" value=1 <?=set_checked(1, $row[type_id])?>>discount coupon
       <input type="radio" name="type_id" value=2 <?=set_checked(2, $row[type_id])?>>free shipping
       <input type="radio" name="type_id" value=3 <?=set_checked(3, $row[type_id])?>>free warranty
    </p>
	
	<br />
	
	<p><label>Start date:</label><? get_calendar("start_date", $row[start_date]); ?></p><br />
    
    <p><label>End date:</label><? get_calendar("end_date", $row[end_date]); ?></p><br />
    
	<p><label>Name:</label><input type="text" name="name_1" value="<?=$row[name_1]; ?>"></p><br />
    
    <p><label>Code:</label><input type="text" name="code" value="<?=$row[code]; ?>"></p><br />
	
	
	
	<div style="background-color:#eee; padding: 20px 0 20px 0; ">
	
    	<h3>discount coupon only</h3>
    	
    	<p><label>Discount:</label>
    		<input type="radio" name="discount_type" value="1" <?=set_checked($row[discount_type], 1); ?>>
    		&nbsp; money coupon $<input type="text" name="amount" value="<?=$row[amount]; ?>" style="width: 30px;">
    		
    	</p><br />
    	
        <p><label>&nbsp;</label>
    	    <input type="radio" name="discount_type" value="2" <?=set_checked($row[discount_type], 2); ?>>
    		&nbsp; percentage discount coupon <input type="text" name="discount_percentage" value="<?=$row[discount_percentage]; ?>" style="width: 30px;">% OFF								  
        </p><br />
	
	</div>
	
	<p><label>Minimum QTY:</label><input type="text" name="minimum_qty" value="<?=$row[minimum_qty]; ?>">item(s)</p><br />
	
	<p><label>Minimum purchase($):</label><input type="text" name="minimum_purchase" value="<?=$row[minimum_purchase]; ?>"></p><br />	
	
	<p><label>Need bought with:</label><? get_lookup("product_id", "../lookup/product.php", $row[product_id], get_field("tbl_product", "name_1", $row[product_id]), "Product Lookup"); ?></p><br />
    <p><label>Country:</label><select name="tbl_country_id"><?=get_combobox_src("tbl_country", "name_1", $row[tbl_country_id], " sort_no "); ?></select></p>
    <br />
	<p><label>Available:</label>
		<input type="radio" name="active" value="1" <?=set_checked($row[active], 1); ?>>Yes
		<input type="radio" name="active" value="0" <?=set_checked($row[active], 0); ?>>No
	</p>
	
	       
</fieldset>