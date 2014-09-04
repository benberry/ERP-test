<?
	### include
	// include("../include/init.php");

?>
<h1>Accessories data transfer</h1>
<?

	$sql="
		select
			*
		from
			tbl_product_attribute
		where
			active=1
			and deleted=0
			and (attribute_cat_id != 1 or attribute_cat_id != 11)
		order by
			product_id, id";

	if ($result = mysql_query($sql)){

		?><ul><?

		while ($row = mysql_fetch_array($result)){
			?>
            <li>
            	<strong>
				<span><?=get_field("tbl_product", "name_1", $row[product_id]); ?>(<?=$row[product_id]; ?>)</span>&nbsp;-&nbsp;
				<span><?=get_field("tbl_attribute", "name_1", $row[attribute_id]); ?>(<?=$row[attribute_id]; ?>)</span>&nbsp;-&nbsp;
                <span><?=$row[price_1]; ?></span>&nbsp; - &nbsp;
                <span><?=$row[weight]; ?></span>
                </strong>
                <br />
                <span>
					<? $new_id = get_new_id($row[attribute_id]); ?>
                    <? $new_cat_id = get_field("tbl_product", "cat_id", $new_id); ?>
                    New ID: <?=get_field("tbl_product", "name_1", $new_id); ?>(<?=$new_id; ?>)<br />
                    <?
                    
					echo $sql="
						insert into tbl_product_accessory
						(
							product_id,
							cat_id,
							accessory_id,
							price_1,
							weight,
							active
						)
						values
						(
							$row[product_id],
							$new_cat_id,
							$new_id,
							$row[price_1],
							$row[weight],
							1
						)";
						
					if (!mysql_query($sql))
						echo $sql;
					
					?>
					<br />

                </span>

                <br />

            </li>
			<? 
		}

		?></ul><?
		
	}else
		echo $sql;


	function get_new_id($old_id){

		$sql = " select * from tbl_product where old_id=$old_id";

		if ($result = mysql_query($sql)){

			$num_rows = mysql_num_rows($result);

			if ($num_rows == 1){

				$row = mysql_fetch_array($result);

				return $row[id];

			}

		}else
			echo $sql;

	}

?>