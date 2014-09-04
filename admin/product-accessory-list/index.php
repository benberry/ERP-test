<?
## init
include("../include/init-without-login.php");

## request
extract($_REQUEST);

if ($cat_id=='')
	$cat_id=5;
	
?>
<script>
	function form_submit(){
		
		fr = document.frm;
		
		fr.action = "?cat_id="+fr.cat_id.value+"&brand_id="+fr.brand_id.value;
		
		fr.method = "post";
		fr.submit();
		
	}

</script>
<h1>Product and Accessories</h1>
<form name="frm">
    <select name="cat_id" style="width:500px;" onchange="form_submit(); ">
        <?=get_cat_product_and_accessory(0, 0, $cat_id)?>
    </select>
    <select name="brand_id" onchange="form_submit(); ">
    	<option value="">all</option>
        <?=get_combobox_src("tbl_brand", "name_1", $brand_id)?>
    </select>
<div style="width:1000px">
	<?
    
    ## retrieve data
    $sql = " select
                p.*
    
             from
                tbl_product p
                left join 
                    tbl_product_category pc
                on
                    p.cat_id = pc.id
    
             where
                p.active=1
                and p.deleted=0
                and pc.main_product=1
                and pc.id=$cat_id
				and p.stock_status < 3";

	if ($brand_id > 0)		
		$sql .= " and p.brand_id = $brand_id";

    
	$sql .= " order by
                pc.sort_no, 
				p.stock_status desc,
				p.sort_no desc";
    
    if ($result = mysql_query($sql)){
        
        ?><ul><?
        
        while ($row = mysql_fetch_array($result)){
            
            ?>
            <li style="margin-bottom: 50px; border-bottom:1px dashed #999;">
				<h3>
				<?=$row["name_1"];?>- 
                <a href="http://cameraparadise.com/admin/main/main.php?func_pg=item-edit&id=<?=$row[id]; ?>&tab=5" target="_blank" style="font-size:12px;">VIEW &amp; UPDATE</a>
                <?=get_accessory_list($row[id]);?>
                </h3>
            </li>
			<?
            
        }
        
        ?></ul><?
        
    }else
        echo $sql;
    
    ?>
</div>
</form>

<?

	function get_accessory_list($product_id){
		
		$sql = "
			select
				*

			from
				tbl_product_accessory pa
				left join 
					tbl_product_category pc
				on
					pa.cat_id = pc.id

			where 
				pa.product_id = $product_id
				and pc.accessory=1
			
			order by
				pc.sort_no
			
			";
		
		if ($result = mysql_query($sql)){
			
			?><table style="font-size:11px; width:800px; margin-left:100px;"><?
			
			while ($row = mysql_fetch_array($result)){
				
				?>
                <tr>
                    <td style="width: 150px;"><strong><?=get_field("tbl_product_category", "name_1", $row[cat_id]); ?></strong></td>                
                    <td style="width: 200px;"><?=get_field("tbl_product", "name_1", $row[accessory_id]); ?></td>
                    <td style="width: 100px;">AUD <?=number_format($row[price_1], 2); ?></td>
                    <td style="width: 100px;"><?=number_format($row[weight], 2); ?> kg</td>
                </tr>
				<?

			}
			
			?></table><?
			
		}else
			echo $sql;
		
	}
	
	function get_cat_product_and_accessory($cat_id, $lvl, $id)
	{

		//***
			$str="";
			
			for ($i=0; $i<$lvl+1; $i++){
				$str .= "&nbsp;&nbsp;&nbsp;&nbsp;";
			}
			
			$lvl++;


		//***
			$sql = "
			select
				*
			from 
				tbl_product_category
			where
				parent_id = {$cat_id}
				and active=1
				and deleted=0
				and status=0
				and main_product=1
			order by 
				sort_no
			
			";
		

	
		if ($result = mysql_query($sql))
		{
			if (mysql_num_rows($result) > 0)
			{
				while($row = mysql_fetch_array($result))
				{
				
					if ($id == $row[id]){
						?><option value="<?=$row[id]?>" selected="selected"><?=$str?>-&nbsp;<?=$row[name_1]?></option><?
					}else{
						?><option value="<?=$row[id]?>"><?=$str?>-&nbsp;<?=$row[name_1]?></option><?					
					}
				
					get_cat_menu_combo($row[id], $lvl, $id);
			
				}
				
			}
		
		}
	
	}

?>