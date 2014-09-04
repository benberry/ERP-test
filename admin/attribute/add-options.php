<?
//*** Default
	$func_name = "Add Options to Products";
	$tbl = "";
	$prev_page = "index";
	$curr_page = "cat-edit";
	$action_page = "cat-update";
	$folder = "product";


//*** Request
	extract($_REQUEST);
	$select_item = $del_id;


?>
	<script src="../<?=$folder; ?>/index.js" language="javascript"></script>
	<form name="frm" enctype="multipart/form-data">
	<input type="hidden" name="act" value="<?=$action?>">
	<input type="hidden" name="pg_num" value="<?=$list_page_num?>">
	<input type="hidden" name="cat_id" value="<?=$cat_id?>">

        <div id="edit">
        
            <? include("../include/edit_title.php")?>
            
            <div id="tool">
                <a class="boldbuttons" href="javascript:goto_parent('<?=$prev_page?>', '<?=$cat_id?>')"><span>Back</span></a>
            </div>
            
            <fieldset><legend>Selected options</legend>
				<? //echo $cat_id."<br />"; ?>
                <? //echo $del_id."<br />"; ?>
                <div style="float:left">
                    <h2><?=get_field("tbl_attribute_category", "name_1", $cat_id); ?></h2>
                    <table width="100%" border="1" cellpadding="10">
                        <tr>
                            <th>Options</th>
                            <th>Default Weight</th>
                            <th>Default Price</th>
                        </tr>
                        
                        <?
                        
                        #get select item
                        
                        $select_item_array = preg_split("/,/", $select_item);
                        
                        for ($i = 0; $i < count($select_item_array); $i++)
                        {
                            
                            if (!empty($select_item_array[$i]))
                            {
                                
                                ?>
                                <tr>
                                    <td><?=get_field("tbl_attribute", "name_1", $select_item_array[$i])?></td>
                                    <td align="right"><?=get_field("tbl_attribute", "weight", $select_item_array[$i]); ?> kg</td>
                                    <td align="right">$<?=number_format(get_field("tbl_attribute", "price_1", $select_item_array[$i]), 2); ?></td>
                                </tr>
                                <?
                                        
                            }
                        
                        }
                        
                        ?>
                        
                    </table>
                </div>
                <div style="float:left; margin-left:100px">
                    <script>
						function add_to_cat(val){
							
							if ($("#add_to_cat_id").val() == ''){
								
								$("#add_to_cat_id_error").text('please select');
								
							}else{
								
								$("#add_to_cat_id_error").text('');
								
								$("#processing").css("display", "block");
								
								$.get("../attribute/add-options-update.php", 
								
									{add_to_cat_id: $("#add_to_cat_id").val(), selected_item:'<?=$select_item?>', action: val}, 
									
									function(data){
									
										$("#processing").css("display", "none");
										
										$("#result").css("display", "block");
										
										$("#result").html(data);
									
									});
								
							}
						
						}
					</script>
                	<h2>Add to Category</h2>
                    <select id="add_to_cat_id" name="add_to_cat_id" style="width:400px" >
                        <option value="">--</option>
                        <?=get_category_combo("tbl_product_category", 0, 0, 0)?>
                    </select>
                    <div id="add_to_cat_id_error" class="form-error"></div>
                    
                    <br />
                    <br />
                    <input type="button" value="add / replace" style=" width: 100px" onclick="add_to_cat(1)">
                    <div class="notice"></div>
                    
                    <br />
                    <br />
                    <input type="button" value="append" style=" width: 100px" onclick="add_to_cat(2)">
                    <div class="notice"></div>
                    
                    
                    <br />
                    <br />
                    <input type="button" value="remove" style=" width: 100px" onclick="add_to_cat(3)">
                    <div class="notice"></div>
                    
                    
                    <br />
                    <br />
                    
                    <div id="processing" style="display:none">
                    	<center>
                        <img src="../images/loading.gif" width="50">
                    	<h2>Processing...</h2>
						</center>
                    </div>
                    <div id="result" style="display:none"></div>
                    
                </div>
                
                <br class="clear">
                
            </fieldset>
            
            <br class="clear">
                    
        </div>

	</form>