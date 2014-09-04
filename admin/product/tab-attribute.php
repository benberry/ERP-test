	<script>
		function del_attribute(id){
		
			fr = document.frm;
			
			ans = confirm("OK to delete?");
			
			if (ans){
	
				fr.action = "../product/tab-attribute-delete.php?product_attribute_id=" + id;
				fr.method = "POST";
				fr.target = "_self";
				fr.submit();
			
			}
	
		}

		function update_attribute(){
		
			fr = document.frm;
			
			fr.action = "../product/tab-attribute-update.php";
			fr.method = "POST";
			fr.target = "_self";
			fr.submit();
	
		}		

		function show_add_attribute_list(id){

			$.get("../attribute/get-attribute-list.php", {cat_id: id}, function(data){

				$("#add_attribute_list").html(data);

			});

		}

		function add_attribute(){
			
			fr = document.frm
			
			fr.action = "../product/tab-attribute-add.php";
			fr.method = "POST";
			fr.target = "_self";
			fr.submit();

		}

	</script>

    <div id="product-attribute-list">
        <fieldset><legend>Attributes</legend>
        <table width="100%">
            <tr>
                <th>Item</th>
                <th style="width:100px">Weight(kg)</th>
                <th style="width:100px">Price($)</th>
                <th style="width:100px"></th>
            </tr>
            <?

            	## get attribute group
				$sql = " select * from tbl_attribute_category where active=1 and deleted=0 order by sort_no ";

				if ($result = mysql_query($sql)){

					while ($row = mysql_fetch_array($result)){
						
						get_product_attribute_list($id, $row[id]);
						
					}

				}else
					echo $sql;

			?>
            <tr>
                <td colspan="4"></td>
            </tr>
        </table>
        <input type="button" value="Update" onclick="update_attribute();" style="float:right; margin-right:150px">
        </fieldset>			
    </div>
    
    <br class="clear">
    
    <div id="product-attribute-add">
    
    	<fieldset><legend>Add Attributes</legend>

            <?
            
			$sql = "select * from tbl_attribute_category where parent_id=0 and active=1 and deleted=0 order by sort_no";
			
			if ($result = mysql_query($sql)){
				
				$num_rows = mysql_num_rows($result);
				
					while ($row = mysql_fetch_array($result)){
						
					?>
					<fieldset>
						<legend><?=$row[name_1];?></legend>
						<br style="clear:both">
							<? get_attribute_item($row[id], $id); ?>
						<br style="clear:both">
						<br style="clear:both">
                        
                        <script>
						
							function attribute_select_all_<?=$row[id]; ?>(){
								
								 <? get_attribute_select_all_item($row[id], $id); ?>

							}
						
						</script>
                        
                        <button type="button" onclick="attribute_select_all_<?=$row[id]; ?>();"> Select All </button>
						<button type="button" onclick="add_attribute();"> ADD </button>
					</fieldset>
					<?
						
				}

			}else
				echo $sql;
				
			
			function get_attribute_item($cat_id, $id){

				$sql = "select * from tbl_attribute where cat_id=$cat_id and active=1 and deleted=0 order by sort_no";

				if ($result = mysql_query($sql)){
					
					// echo "num rows: ".$num_rows = mysql_num_rows($result);					
					
					while ($row = mysql_fetch_array($result)){
						

						
						if (check_attribute_exists($id, $row[id])==false){
						
							?>
							<div style="width:300px; height:60px; float:left;">
                                <div style="float:left; width:50px; text-align:right"><input type="checkbox" id="add_attribute_<?=$row[id];?>" name="add_attribute_<?=$row[id];?>" value="1" style="width:20px"></div>
                                <div style="float:left; width:250px"><span style="font-size:14px"><b><?=$row[name_1];?></b></span>
                                <br /><span style="font-size:10px"><b>Price :</b> $<?=number_format($row[price_1], 2);?></span>
                                <br /><span style="font-size:10px"><b>Weight:</b>  <?=$row[weight];?>kg</span>
                                </div>
							</div>
							<?
						
						}

					}

				}else
					echo $sql;				

			}
			
			function get_attribute_select_all_item($cat_id, $id){

				$sql = "select *from tbl_attribute where cat_id=$cat_id and active=1 and deleted=0 order by sort_no";

				if ($result = mysql_query($sql)){
					
					while ($row = mysql_fetch_array($result)){
						
						if (check_attribute_exists($id, $row[id])==false){
						
							?>
								document.frm.add_attribute_<?=$row[id];?>.checked = 1;
							<?
						
						}

					}

				}else
					echo $sql;				

			}			
			
			function check_attribute_exists($product_id, $attribute_id){
				
				$sql = " select * from tbl_product_attribute where deleted=0 and product_id=$product_id and attribute_id=$attribute_id";
				
				if ($result = mysql_query($sql)){
					
					if (mysql_num_rows($result) > 0)
						return true;
					else
						return false;
					
				}else
					echo $sql;				
				
			}

			?>

        </fieldset>
    
    </div>
    
    <br class="clear">
    
    <?
    
	function get_product_attribute_list($product_id, $attribute_cat_id){
		
		$sql = " select * from tbl_product_attribute where product_id=$product_id and attribute_cat_id=$attribute_cat_id and active=1 and deleted=0 order by sort_no ";
		
		if ($result = mysql_query($sql)){
			
			$num_rows = mysql_num_rows($result);
			
			if ($num_rows > 0){
				
				?>
                <tr>
					<td colspan="4" align="left" style=" border-bottom: 1px #333 solid; background-color:#eee"><b><?=get_field("tbl_attribute_category", "name_1", $attribute_cat_id);?></b></td>
				</tr>
                <?
				
				while ($row = mysql_fetch_array($result)){
				
					?>
					<tr>
						<td><?=get_field("tbl_attribute", "name_1", $row[attribute_id]); ?></td>
						<td><input type="text" name="pa_weight_<?=$row[id]; ?>" value="<?=$row[weight]?>" style=" width:50px"></td>                    
						<td><input type="text" name="pa_price_1_<?=$row[id]; ?>" value="<?=$row[price_1]?>" style=" width:50px"></td>
						<td><input type="button" value="Delete" onclick="del_attribute('<?=$row[id]?>')"></td>
					</tr>
					<?
				
				}
				?>
                <tr>
					<td colspan="4">&nbsp;</td>
				</tr>
                <?

			}
			
		}else
			echo $sql;

	}
	
	?>
