<?
	### include
	// include("../include/init.php");

	### size filter
	$sql = " select * from tbl_product where brand_id<>23 and cat_id=10 and active=1 and deleted=0 order by brand_id, name_1 ";
	
	if($result = mysql_query($sql)){

		?><ul><?
			while ($row=mysql_fetch_array($result)){
				?>
                <li>
                <?=$row[name_1];?>-
                <span style="font-size:10px;"><?
				
					$sub_string=substr($row[content_2], strpos($row[content_2], "Filter size"));
					
					$sub_string=substr($sub_string, 0, strpos($sub_string, "</tr>"));
					
					$sub_string=strip_tags($sub_string);
					
					$sub_string=str_replace("Filter size", "", $sub_string);
					
					$sub_string=str_replace("mm", "", $sub_string);					
					
					$sub_string=trim($sub_string);
					
					echo $sub_string;
					
					if (!is_numeric($sub_string)){
						
						?><span style="color:#F03;">*****</span><?
						
					}else{
						
						$sql="update tbl_product set filter_size=$sub_string where id=".$row[id];
						
						if (!mysql_query($sql))
							echo $sql;
						
					}

                ?></span>
                </li>
				<?
			}
         ?></ul><?

	}else
		echo $sql;

?>