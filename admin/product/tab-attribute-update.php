<?

 ## init
 include("../include/init.php");
 $prev_page = "item-edit";
 
 ## request
 extract($_REQUEST);

 
 ## get record
 $sql = "
 	select 
		*

	from 
		tbl_product_attribute
	
	where
		active=1
		and deleted=0
		and product_id=$id
		
	order by
		sort_no

	";
	
	
  if($result = mysql_query($sql)){
  
  	$num_rows = mysql_num_rows($result);
	
	if ($num_rows > 0){
		
		while ($row = mysql_fetch_array($result)){

			$update_sql = "
				update tbl_product_attribute set

					weight='".$_REQUEST["pa_weight_".$row[id]]."',
					price_1='".$_REQUEST["pa_price_1_".$row[id]]."'

				where
					id=".$row[id];

			if (!mysql_query($update_sql))
				echo $update_sql."<br>";

		}

		## insert into product

	}

  }else{
  	//echo $sql;
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