<?php

// include("../include/init.php");

$source = "shopping.com-price-list.csv";

$row = 1;

if (($handle = fopen($source, "r")) !== FALSE) {
	
	fgetcsv($handle, 9999, ",");
	
	$records=0;
	$updated=0;
	$error=0;	

    while (($data = fgetcsv($handle, 9999, ",")) !== FALSE){
		
		$records++;
		
        $num = count($data);
        // echo "<p> $num fields in line $row: <br /></p>\n";
		
		if ($num==6){
		
			$row++;
			
			if (!empty($data[0])){
				
				$sql = "
						update
							tbl_product

						set
							au_shopping_rank =".sql_str($data[1]).",
							au_shopping_price =".sql_str($data[2]).",
							au_shopping_shipping =".sql_str($data[3]).",
							au_shopping_remarks =".sql_str($data[5])."
							
						where
							id=".$data[0]."

						";
						
			}
			
			if (mysql_query($sql)){
				$updated++;
				$display .= $data[0]." - ".$data[2]." ... OK<br />";
				
			}else{
				$error++;
				$display .= "new item - ".$data[2]." ... ERROR ($sql)<br />";
				
			}
		
		}else{
			
			$error++;
		
			?> wrong number of fields <br /><?
			
		}
		
    }

    fclose($handle);
	
	echo "<h3>Total: $records</h3>";
	echo "<h3>Updated: $updated</h3>";
	echo "<h3>Error: $error</h3>";
	echo $display;		

}

?>
