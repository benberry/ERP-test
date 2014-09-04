<?

include("../include/init.php");

extract($_REQUEST);


if ($action > 0 && $add_to_cat_id > 0 && $selected_item != ''){
	
	//echo "add_to_cat_id: ".$add_to_cat_id."<br />";
	//echo "selected_item: ".$selected_item."<br />";
	//echo "action: ".$action."<br />";
	echo "<center><h2>Updated</h2></center>";
	
	get_item_list($add_to_cat_id, $selected_item, $action);
	

}


## get item list
	function get_item_list($cat_id, $selected_item, $action){
		
		$sql = " select * from tbl_product where cat_id=$cat_id and deleted=0 order by sort_no desc";
		
		if ($result = mysql_query($sql)){
			
			$num_rows = mysql_num_rows($result);
			
			echo $num_rows." record(s)";						
			?>
			<table border="1" width="100%" bordercolor="#eeeeee">
				<tr>
                	<th width="50">id</th>
					<th>items</th>
					<th></th>
				</tr>
				<?
				
				while ($row = mysql_fetch_array($result)){
					
					get_attribute_list($row[id], $selected_item, $action);
					
					?>
					<tr>
                    	<td><?=$row[id]?></td>
						<td><?=$row[name_2]?></td>
						<td>updated</td>
					</tr>
					<?
					
				}
	
				?>
			</table>
			<?
			
		}else
			echo $sql;
		
	}
	

## get item attribute
	function get_attribute_list($product_id, $selected_item, $action){
		
		$selected_item_array = preg_split("/,/", $selected_item);
			
		for ($i = 0; $i < count($selected_item_array); $i++){
			
			if (!empty($selected_item_array[$i])){
				
				if ($action == 1){
				
					### delete
					$sql = "delete from tbl_product_attribute where product_id=$product_id and attribute_id=".$selected_item_array[$i];
					if (!mysql_query($sql))
						echo $sql;
						
					### insert
						update_attribute($product_id, $selected_item_array[$i]);
				
				}
				
				if ($action == 2){
			
					$sql = "select * from tbl_product_attribute where product_id=$product_id and attribute_id=".$selected_item_array[$i]." and deleted=0";
					
					if ($result = mysql_query($sql)){
						
						$num_rows = mysql_num_rows($result);
						
						if ($num_rows == 0){
							
							update_attribute($product_id, $selected_item_array[$i]);
													
						}
						
					}else
						echo $sql;			
					
				}
				
				if ($action == 3){
				
					### delete
					$sql = "delete from tbl_product_attribute where product_id=$product_id and attribute_id=".$selected_item_array[$i];
					if (!mysql_query($sql))
						echo $sql;
				
				}
				
			}
			
		}
		
	}

	
	function update_attribute($product_id, $attribute_id){
		
		$sql = "insert into tbl_product_attribute
				(
					product_id,
					attribute_cat_id,
					attribute_id,
					price_1,
					weight,
					sort_no,
					active,
					create_date,
					create_by

				)
				values
				(
					".$product_id.",
					".get_field("tbl_attribute", "cat_id", $attribute_id).",
					".$attribute_id.",
					".get_field("tbl_attribute", "price_1", $attribute_id).",
					".get_field("tbl_attribute", "weight", $attribute_id).",
					".get_field("tbl_attribute", "sort_no", $attribute_id).",
					1,
					NOW(),
					".$_SESSION["user_id"]."

				)
				";

		if (!mysql_query($sql))
			echo $sql;
		
	}
	

?>