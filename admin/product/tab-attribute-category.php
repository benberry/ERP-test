    <div id="product-attribute-add">
    
    	<fieldset><legend>Accessories Control</legend>
        
			<input type="hidden" name="attribute_category" value="<?=$row[attribute_category]; ?>">

			<?
			
			
			$product_attribute_category_i = get_attribute_category($row[attribute_category]);
			

			function get_attribute_category($val){
				
				$temp_array = preg_split("/,/", $val);
				
				$sql = "select * from tbl_attribute_category where active=1 and deleted=0 order by sort_no ";
				
				if ($result = mysql_query($sql)){
					
					$product_attribute_category_i=0;
					
					while ($row = mysql_fetch_array($result)){
						
						$found = 0;
						
						for ($i=0; $i<count($temp_array); $i++){
							
							if ($temp_array[$i] == $row[id]){
								
								$found = 1;
								
							}
							
						}
					
						if ($found == 1){
							
							?><p><input type="checkbox" name="product_attribute_category_<?=$product_attribute_category_i; ?>" value="<?=$row[id]?>" checked><?=$row[name_1]; ?></p><?
							
						}else{
							
							?><p><input type="checkbox" name="product_attribute_category_<?=$product_attribute_category_i; ?>" value="<?=$row[id]?>"><?=$row[name_1]; ?></p><?
							
						}
						
						$product_attribute_category_i++;

					}

					return $product_attribute_category_i;
					
				}else
					echo $sql;

			}

			?>            
            
            <script>

				function update_accessories(){
					
					fr = document.frm;

					fr.attribute_category.value = "";
					
					
					for (i=0; i < <?=$product_attribute_category_i; ?>; i++){
						
						if (fr['product_attribute_category_' + i]){
							
							if(fr['product_attribute_category_' + i].checked == true){

								fr.attribute_category.value = fr.attribute_category.value + fr['product_attribute_category_' + i].value+',';
																
							}
							
						}
					
					}
					
				}

			</script>

        </fieldset>
    
    </div>
    
    <br class="clear">