<?
	### include
		//include("../include/init.php");
	
	### size filter
	$sql="
		select
			*

		from
			tbl_product

		where
			(
			cat_id=5
			or cat_id=10
			or cat_id=3
			)
			and active=1
			and deleted=0

		order by 
			brand_id, 
			name_1
		";

	if($result = mysql_query($sql)){
	
		?><ul><?
			while ($row=mysql_fetch_array($result)){
				?><li><?=$row[name_1];?><?

					 	insert_accessory_by_cat($row[id], $row[filter_size]);	
					
				?></li><?
			}
		 ?></ul><?
	
	}else
		echo $sql;


	function count_accessory_by_cat($product_id){

		$sql=" select *from tbl_product_accessory where product_id=$product_id and cat_id=7 and active=1 and deleted=0 ";
		
		if ($result = mysql_query($sql)){
			
			$num_rows = mysql_num_rows($result);
			
			?><!--<ul><?
			while ($row = mysql_fetch_array($result)){
				?><li><?=get_field("tbl_product", "name_1", $row[accessory_id]); ?></li><?
			}
			?></ul>--><?
			
			return $num_rows;
			
		}else
			echo $sql;
		
	}


	function insert_accessory_by_cat($product_id, $filter_size){
		
		$sql = "select *from tbl_product where cat_id=25 and id=1074";
		
		if ($result = mysql_query($sql)){
			
			?>
            <ul style="font-size:10px;">
			<?
				while ($row=mysql_fetch_array($result)){
					?><li><?=$row[name_1]; ?> - <?=$row[weight]; ?>kg - $<?=number_format($row[accessory_price], 2); ?></li><?
					
					
					$sql="insert into tbl_product_accessory(
							product_id,
							cat_id,
							accessory_id,
							price_1,
							weight,
							active

						)values(
							$product_id,
							$row[cat_id],
							$row[id],
							$row[accessory_price],
							$row[weight],
							1

						)";
					
/*
					echo $sql = "
							delete from
								tbl_product_accessory

							where
								product_id=$product_id
								and cat_id=37
								and accessory_id=$row[id]
							";
*/					
						
					if (!mysql_query($sql))
					 	echo $sql."<br />";
				}

			?>
            </ul>
            <br class="clear" />
			<?
			
		}else
			echo $sql;


	}

?>