	<script>
		function del_accessory(id){
			fr = document.frm;
			ans = confirm("OK to delete?");
			
			if (ans){
				fr.action = "../product/tab-accessory-delete.php?product_accessory_id=" + id;
				fr.method = "POST";
				fr.target = "_self";
				fr.submit();
			}
		}

		function update_accessory(){
			fr = document.frm;
			fr.action = "../product/tab-accessory-update.php";
			fr.method = "POST";
			fr.target = "_self";
			fr.submit();
		}

		function show_add_accessory_list(id){
			$.get("../accessory/get-accessory-list.php", {cat_id: id}, function(data){
				$("#add_accessory_list").html(data);
			});
		}

		function add_accessory(){
			fr = document.frm
			fr.action = "../product/tab-accessory-add.php";
			fr.method = "POST";
			fr.target = "_self";
			fr.submit();
		}

	</script>

    <div id="product-attribute-add">
        <fieldset><legend>Accessories</legend>
        <table width="100%">
            <tr>
                <th>Item</th>
                <th style="width:100px">Weight(kg)</th>
                <th style="width:100px">Price(AUD)</th>
                <!--<th style="width:100px">Sort No</th>-->
                <th style="width:100px"></th>
            </tr>
            <?

            	## get accessory group
				$sql = " select * from tbl_product_category where active=1 and deleted=0 order by sort_no ";

				if ($result = mysql_query($sql)){

					while ($row = mysql_fetch_array($result)){
						
						get_product_accessory_list($id, $row[id]);
						
					}

				}else
					echo $sql;

			?>
            <tr>
                <td colspan="4"></td>
            </tr>
        </table>
        <!--<input type="button" value="Update" onclick="update_accessory();" style="float:right; margin-right:150px">-->
        </fieldset>			
    </div>
    
    <br class="clear" />
    
    <div id="product-accessory-add">
    
    	<fieldset>
        	<legend>Accessories</legend>
            <?
            
			$sql = "
				select 
					*

				from 
					tbl_product_category

				where 
					parent_id=0 
					and accessory=1 
					and active=1 
					and deleted=0

				order by 
					sort_no";
			
			if ($result = mysql_query($sql)){
				
				$num_rows = mysql_num_rows($result);
				
					while ($row = mysql_fetch_array($result)){
						
					?>
					<fieldset>
						<legend><?=$row[name_1];?></legend>
                        
						<br class='clear' />
						<? get_accessory_item($row[id], $id); ?>
						<br class='clear' />
						<br class='clear' />
                        
                        <script>
							function accessory_select_all_<?=$row[id]; ?>(){
								 <? get_accessory_select_all_item($row[id], $id); ?>
							}
						</script>
                        
                        <button type="button" onclick="accessory_select_all_<?=$row[id]; ?>();">Select All</button>
						<button type="button" onclick="add_accessory();">ADD</button>
					</fieldset>
					<?
						
				}

			}else
				echo $sql;
				
			
			function get_accessory_item($cat_id, $id){

				$sql = "select * from tbl_product where cat_id=$cat_id and active=1 and deleted=0 order by sort_no";

				if ($result = mysql_query($sql)){
					
					// echo "num rows: ".$num_rows = mysql_num_rows($result);
					?>
					<table width="100%">
                        <tr>
                            <th align="left" width="50"></th>
                            <th align="left" width="400">Name</th>
                            <th align="left" width="150">Original Price</th>
                            <th align="left" width="150">Accessory Price</th>
                            <th align="left" width="150">Weight</th>
                        </tr>
					<?
					
					while ($row = mysql_fetch_array($result)){
						
						if (check_accessory_exists($id, $row[id])==false){
						
							?>
                            <tr>
                            	<td><input type="checkbox" id="add_accessory_<?=$row[id];?>" name="add_accessory_<?=$row[id];?>" value="1" style="width:20px"></td>
                                <td><?=$row[name_1]; ?></td>
                                <td>$<?=number_format($row[price_1], 2);?></td>
								<td>$<?=number_format($row[accessory_price], 2);?></td>
                                <td><?=$row[weight];?>kg</td>
                            </tr>
							<?
						
						}

					}
					?>

                    </table>
					<?

				}else
					echo $sql;				

			}

			function get_accessory_select_all_item($cat_id, $id){

				$sql=" 
					select 
						* 
					from 
						tbl_product 
					where 
						cat_id=$cat_id 
						and active=1 
						and deleted=0 
					order by 
						sort_no";

				if ($result = mysql_query($sql)){
					
					while ($row = mysql_fetch_array($result)){
						
						if (check_accessory_exists($id, $row[id])==false){
						
							?>document.frm.add_accessory_<?=$row[id];?>.checked = 1;<?
						
						}

					}

				}else
					echo $sql;				

			}			
			
			function check_accessory_exists($product_id, $accessory_id){
				
				$sql = "
					select 
						*
					from 
						tbl_product_accessory 
					where 
						deleted=0 
						and product_id=$product_id 
						and accessory_id=$accessory_id";

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

    <br class="clear" />
<?
	function get_product_accessory_list($product_id, $cat_id){
		
		$sql = "
			select
				*
			from 
				tbl_product_accessory
			where
				product_id=$product_id
				and cat_id=$cat_id
				and active=1
				and deleted=0
			order by
				sort_no";

		if ($result = mysql_query($sql)){
			
			$num_rows = mysql_num_rows($result);
			
			if ($num_rows > 0){
				
				?>
                <tr>
					<td colspan="5" align="left" style=" border-bottom: 1px #333 solid; background-color:#eee">
                    	<b><?=get_field("tbl_product_category", "name_1", $cat_id);?></b>
                    </td>
				</tr>
                <?
				while ($row = mysql_fetch_array($result)){
					?>
					<tr>
						<td><?=get_field("tbl_product", "name_1", $row[accessory_id]); ?></td>
						<td><?=number_format(get_field("tbl_product", "weight", $row[accessory_id]), 2); ?></td>
						<td><?=number_format(get_field("tbl_product", "accessory_price", $row[accessory_id]), 2); ?></td>
                        <!--
                        <td><input type="text" name="as_sort_no_<?=$row[id]; ?>" value="<?=$row[sort_no];?>" style=" width:50px"></td>-->
						<td><input type="button" value="Delete" onclick="del_accessory('<?=$row[id]; ?>')"></td>
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