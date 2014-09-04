<?
	### init
		include("../include/init.php");
	
	### request 
		extract($_REQUEST);
		
	### update
		$sql="
			select
				*
			from
				tbl_product
			where
				status=0
				and deleted=0
			order by
				cat_id,
				name_1,
				display_to_getprice desc,
				display_to_shopbot desc,
				display_to_shopping desc,
				cat_id,
				brand_id,
				name_1";
		
		if($result = mysql_query($sql)){
			
			while($row = mysql_fetch_array($result)){
				
				if($_REQUEST["getprice_".$row[id]]==1)
					$getprice=1;
				else
					$getprice=0;
					
				if($_REQUEST["shopbot_".$row[id]]==1)
					$shopbot=1;
				else
					$shopbot=0;
					
				if($_REQUEST["shopping_".$row[id]]==1)
					$shopping=1;
				else
					$shopping=0;
					
				if($_REQUEST["myshopping_".$row[id]]==1)
					$myshopping=1;
				else
					$myshopping=0;
					
				if($_REQUEST["pricerunner_".$row[id]]==1)
					$pricerunner=1;
				else
					$pricerunner=0;
					
				if($_REQUEST["priceme_".$row[id]]==1)
					$priceme=1;
				else
					$priceme=0;
				
				if($_REQUEST["google_".$row[id]]==1)
					$google=1;
				else
					$google=0;															
	                       if($_REQUEST["google_uk_".$row[id]]==1)
					$google_uk=1;
				else
					$google_uk=0;													
				

				$update_sql="
					update 
						tbl_product
					set
						display_to_getprice		= ".$getprice.",
						display_to_shopbot		= ".$shopbot.",
						display_to_shopping		= ".$shopping.",
						display_to_myshopping	= ".$myshopping.",
						display_to_pricerunner	= ".$pricerunner.",
						display_to_priceme		= ".$priceme.",
						display_to_google		= ".$google.",
                                                display_to_google_uk		= ".$google_uk."
					where
						id=".$row[id]."
				";
				
				// echo $row[name_1]."$update_sql<br />";
				if(!mysql_query($update_sql)){
					echo $update_sql."<br />";
				}
			}
			
		}else
			echo $sql;
		
	
		
?>
<script>
	path="../main/main.php?func_pg=index";
	window.location=path;
</script>