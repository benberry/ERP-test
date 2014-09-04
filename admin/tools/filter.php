<?
	### include
	// include("../include/init.php");

	### size filter
	$sql = " select * from tbl_product where brand_id=7 and cat_id=7 and active=1 and deleted=0 order by brand_id, name_1 ";
	
	if($result = mysql_query($sql)){

		?><ul><?

			while ($row=mysql_fetch_array($result)){

				?>
                <li>
                <?=$row[name_1];?>-
                <span style="font-size:10px;"><?
				
					$pos_1 = strpos($row[name_1], "mm");
					$sub_string=substr($row[name_1], ($pos_1-2), 2);
					echo $sub_string;
					
					if (!is_numeric($sub_string)){
						?><span style="color:#F03;">*****</span><?

					}else{
						//$sql="update tbl_product set filter_size=$sub_string where id=".$row[id];
						//if(!mysql_query($sql))
						//	echo $sql;

					}
                ?></span>
                </li>
				<?

			}
         ?></ul><?
		 
	}else
		echo $sql;

?>