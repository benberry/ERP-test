<?
## init
include("../include/init-without-login.php");

## request
extract($_REQUEST);

if ($cat_id=='')
	$cat_id=5;
	
?>
<script>
	function form_submit(id){
		
		fr = document.frm;
		fr.action = "?cat_id="+id;
		fr.method = "post";
		fr.submit();
		
	}

</script>
<h1>Accessories</h1>
<form name="frm">
    <select name="cat_id" style="width:500px;" onchange="form_submit(this.value); ">
        <?=get_cat_product_and_accessory(0, 0, $cat_id); ?>
    </select>
    <div style="margin-top:30px; ">
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
                    and pc.accessory=1
                    and pc.id=$cat_id
                    and p.stock_status < 3
        
                 order by
                    pc.sort_no, 
                    p.stock_status desc,
                    p.sort_no desc";
        
        if ($result = mysql_query($sql)){
            
            ?>
            	<table border="1" style="border-collapse:collapse; font-size:11px; line-height:24px;">
	            <tr>
                    <th style="font-weight: bold;">Model</th>
                    <th style="font-weight: bold;">Original Price (AUD)</th>
                    <th style="font-weight: bold;">Discounted Price (AUD)</th>
                    <th style="font-weight: bold;">Weight (kg)</th>
                    <th></th>                    
                </tr>
			<?
            
            while ($row = mysql_fetch_array($result)){
                
                ?>
                <tr>
                    <td style="width:400px;"><?=$row["name_1"];?></td>
                    <td align="right" style="width:150px; padding-right:20px;"><?=number_format($row["price_1"], 2); ?></td>
                    <td align="right" style="width:150px; padding-right:20px;"><?=number_format($row["accessory_price"], 2); ?></td>
                    <td align="right" style="width:150px; padding-right:20px;"><?=number_format($row["weight"], 2); ?></td>
                    <td style="padding:0 20px 0 20px;">
                    <a href="http://cameraparadise.com/admin/main/main.php?func_pg=item-edit&id=<?=$row[id]; ?>" target="_blank" style="font-size:12px;">VIEW &amp; UPDATE</a>
                    </td>
                </tr>
                <?
                
            }
            
            ?></table><?
            
        }else
            echo $sql;
        
        ?>
    </div>
</form>
<?

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
				and accessory=1
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