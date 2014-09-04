<?
### init
 include("../include/init.php");
 $prev_page = "item-edit";


### request
 extract($_REQUEST);

 
### get record
 $sql = "
 	select 
		*

	from 
		tbl_product

	where
		active=1
		and deleted=0

	order by
		sort_no";
	
  if($result = mysql_query($sql)){
  
  	$num_rows = mysql_num_rows($result);
	
	if ($num_rows > 0){
		
		while ($row = mysql_fetch_array($result)){
			
			if($_REQUEST["add_accessory_".$row[id]] == 1){
				
				$insert_sql = "
					insert into tbl_product_accessory(
						product_id,
						cat_id,
						accessory_id,
						weight,
						price_1,
						active
					
					)values(
						".$id.",
						".$row[cat_id].",
						".$row[id].",
						".$row[weight].",
						".$row[accessory_price].",
						1

					)
				
				";
				
				if (!mysql_query($insert_sql))
					echo $insert_sql."<br>";
					
				$update_sql = "update tbl_product_accessory set sort_no=(id*10) where id=".mysql_insert_id();
				
				if (!mysql_query($update_sql))
					echo $update_sql."<br>";				
				
			}
			
		}
		
		## insert into product
	  
	}
  
  }else{

  	## echo $sql;

  }

?>
<script>
	path="../main/main.php?func_pg=<?=$prev_page?>";
	path+="&id=<?=$id?>";
	path+="&pg_num=<?=$pg_num?>";
	path+="&tab=<?=$tab?>";
	path+="&cat_id=<?=$cat_id?>";
	window.location=path;
</script>