<?
	### init
		include("../include/init.php");
	
	### request 
		extract($_REQUEST);
		
	### response
		// echo "$srh_cat_id<br />";
		// echo "$srh_brand_id<br />";
		// echo "$bulk_profit<br />";
		// echo "$bulk_balancer<br />";
		// echo "$bulk_act<br />";
		
	### update
		$sql="
			select
				*
			from
				tbl_product
			where
				status=0
				and deleted=0
			";

		if ($srh_cat_id){
			$sql .= " and cat_id = {$srh_cat_id} ";
		}

		if ($srh_brand_id){
			$sql .= " and brand_id = {$srh_brand_id} ";
		}
		
		$sql .="order by
				active desc,
				stock_status,
				create_date desc";
		
		if($result = mysql_query($sql)){
			
			while($row = mysql_fetch_array($result)){
				
//				echo $row[name_1]."<br />";
				if ($bulk_act==1){
					$update_sql = "
						update 
							tbl_product
						set
							price_profit = ".($row[price_profit] + $bulk_profit).",
							price_balancer = ".($row[price_balancer] + $bulk_balancer)."
						where
							id = ".$row[id];
				}else{
					$update_sql = "
						update 
							tbl_product
						set
							price_profit = ".($row[price_profit] - $bulk_profit).",
							price_balancer = ".($row[price_balancer] - $bulk_balancer)."
						where
							id = ".$row[id];
				}
				
				// echo $update_sql."<br />";
				
				if(!mysql_query($update_sql)){
					echo $update_sql."<br />";
				}
				
			}
			
		}else
			echo $sql;
		
	
		
?>
<script>
	path="../main/main.php?func_pg=index";
	path+="&srh_cat_id=<?=$srh_cat_id; ?>";
	path+="&srh_brand_id=<?=$srh_brand_id; ?>";
	window.location=path;
</script>