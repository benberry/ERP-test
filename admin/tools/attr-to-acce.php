<?

	### include
	// include("../include/init.php");
	
	$sql = " select * from tbl_attribute_category where active=1 and deleted=0 order by name_1 ";
	
	if ($result = mysql_query($sql)){
		
		?><ul><?
		
		while ($row = mysql_fetch_array($result)){
			
			?><li><?=$row[name_1]; ?></li><?
			get_attr_item($row[id]);
			
			
		}
		
		?></ul><?
		
	}else
		echo $sql;
		
	function get_attr_item($cat_id){
		
		$sql = " select * from tbl_attribute where cat_id=$cat_id and active=1 and deleted=0 order by name_1 ";
	
		if ($result = mysql_query($sql)){
			
			?><ul><?
			
			while ($row = mysql_fetch_array($result)){
				
				?><li><?=$row[name_1]; ?>-<? insert_item($row[id]); ?></li><?
				
			}
			
			?></ul><?
			
		}else
			echo $sql;	
		
		
	}
	
	function insert_cat($old_cat_id){
		
		$sql = " select * from tbl_attribute_category where id=$old_cat_id";
		
		if ($result = mysql_query($sql)){
			
			while($row = mysql_fetch_array($result)){

				$sql = "
					insert into tbl_product_category
					(
						old_id,
						name_1,
						name_2,
						active
						
					)values(
						'$row[id]',
						'$row[name_1]',
						'$row[name_2]',
						1			
					)
				";
				
				if (!mysql_query($sql))
					echo $sql;
				
				$sql = " update tbl_product_category set sort_no=(".mysql_insert_id()." * 10) where id=".mysql_insert_id();
				
				if (!mysql_query($sql))
					echo $sql;

			}
			
		}else
			echo $sql;
		
	}
	
	function insert_item($old_id){
		
		$sql = " select * from tbl_attribute where id=$old_id";
		
		if ($result = mysql_query($sql)){
			
			while($row = mysql_fetch_array($result)){
				
				$cat_id = get_new_cat_id($row[cat_id]);

				$sql = "
					insert into tbl_product
					(
						old_id,
						old_cat_id,
						cat_id,
						name_1,
						name_2,
						price_1,
						weight,
						active
						
					)values(
						'$row[id]',
						'$row[cat_id]',
						'$cat_id',
						'$row[name_1]',
						'$row[name_2]',
						'$row[price_1]',
						'$row[weight]',
						1			
					)
				";
				
				if (!mysql_query($sql))
					echo $sql;
				
				$sql = " update tbl_product_category set sort_no=(".mysql_insert_id()." * 10) where id=".mysql_insert_id();
				
				if (!mysql_query($sql))
					echo $sql;

			}
			
		}else
			echo $sql;
		
	}
	
	function get_new_cat_id($old_cat_id){
	
		$sql = " select * from tbl_product_category where old_id=$old_cat_id ";
		
		if ($result = mysql_query($sql)){
			
			$row = mysql_fetch_array($result);

			return $row[id];
			
		}else
			echo $sql;
		
	}
	
?>