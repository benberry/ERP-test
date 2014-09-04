<fieldset class='single-form'>
	<legend>Product Information</legend>
	<div style="float:left;">
        <p><label>Category:</label><input type="text" name="main_category" value="<?=$row[main_category]; ?>"></p>
		
        <p><label>Sub Category:</label><input type="text" name="sub_category" value="<?=$row[sub_category]; ?>"></p>
          
        <p><label>SKU:</label><input type="text" name="sku" value="<?=$row[sku]; ?>" <?echo $row[id]?"disabled":"" ?>></p>
          
        <p><label>Product Name:</label><input style="width:675px;" type="text" name="name" value="<?=$row[name]; ?>" ></p>
        
		<p><label>Actual Weight(kg):</label><input type="text" name="actual_weight" value="<?=$row[actual_weight]; ?>"></p>
       
		<p><label>Dimension Weight:</label><input type="text" name="dimension_weight" value="<?=$row[dimension_weight]; ?>"></p>
       
		<p><label>Current Quantity:</label><input type="text" name="current_qty" value="<?=$row[current_qty]; ?>" style="width:150px" <?echo $row[id]?"disabled":"" ?>></p>
		
		<p><label>BULKY:</label>
		   <?
		     if(isset($row[bulky])){
		   ?>
           <input type="radio" name="bulky" value="1" <?=set_checked($row[bulky], 1); ?>>Yes
           <input type="radio" name="bulky" value="0" <?=set_checked($row[bulky], 0); ?>>No
		   <?
		     }else{
		   ?>
		   <input type="radio" name="bulky" value="1" checked="true">Yes
           <input type="radio" name="bulky" value="0">No
		   <?
		     }
		   ?>
		</p>
		
		<p><label>Status(TEMP):</label>
		   <?
		     if(isset($row[active])){
		   ?>
           <input type="radio" name="active" value="1" <?=set_checked($row[active], 1); ?>>Enable
           <input type="radio" name="active" value="0" <?=set_checked($row[active], 0); ?>>Disable
		   <?
		     }else{
		   ?>
		   <input type="radio" name="active" value="1" checked="true">Enable
           <input type="radio" name="active" value="0">Disable
		   <?
		     }
		   ?>
		</p>
		
    </div>
</fieldset>