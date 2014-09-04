<fieldset class='single-form'>

	<p><label>Technical Details:</label>
    	<textarea id="content_2" name="content_2" class="richeditor">
		<?

        if ($row[content_2_new] > 0){

            echo $row[content_2];


        }else{
			
			if (file_exists("../product/product-spec-compact.html") 
				&& get_field("tbl_product_category", "technical_details", $row[cat_id])==1 ) {

				$product_spec = file_get_contents("../product/product-spec-compact.html");

				echo $product_spec;

			}

			if (file_exists("../product/product-spec-dslr.html")
				&& get_field("tbl_product_category", "technical_details", $row[cat_id])==2 ) {

				$product_spec = file_get_contents("../product/product-spec-dslr.html");

				echo $product_spec;

			}

			if (file_exists("../product/product-spec-lens.html") 
				&& get_field("tbl_product_category", "technical_details", $row[cat_id])==3 ) {

				$product_spec = file_get_contents("../product/product-spec-lens.html");

				echo $product_spec;

			}

        }

        ?>
        </textarea>
	</p>
    <input name="content_2_new" type="hidden" value="1">
    <?
	
	/*

    	if ($row[content_2]!=''){
			
			?><input name="content_2_new" type="hidden" value="1"><?

		}

	*/
		
		
		
	## Content 4
	
	if (get_field("tbl_product_category", "technical_details", $row[cat_id])==2){

		?>
		<p><label>Display Lens Details:</label><input type="checkbox" name="content_4_display" value="1" <?=set_checked(1, $row[content_4_display]); ?> ></p>
		<p><label>Lens Details:</label>
			<div id="temp_content">
			<textarea name="content_4" class="richeditor">
			<?
	
			if ($row[content_4_new] > 0){
	
				echo $row[content_4];
	
	
			}else{
				if (file_exists("../product/product-spec-lens.html")) {
	
					$product_spec = file_get_contents("../product/product-spec-lens.html");
	
					echo $product_spec;
	
				}
	
			}
	
			?>
			</textarea>
			</div>
		</p>
        <input name="content_4_new" type="hidden" value="1">
		<? 
	
	}
	
	?>
    
</fieldset>