<?php

// include("../include/init.php");

$source = "email-0528.csv";

if (($handle = fopen($source, "r")) !== FALSE) {
	
	$records=0;
	$updated=0;
	$error=0;	

    while (($data = fgetcsv($handle, 9999, ",")) !== FALSE){
		
		$records++;
		
        $num = count($data);
        //echo "<p> $num fields in line $row: <br /></p>\n";
		
		if ($num == 1){
		
			$row++;
				
			$sql = "
					insert into tbl_email_list
					(
						cat_id,
						email,
						active
						
					)values(
						4,
						".sql_str($data[0]).",
						1
					)
					";
				
			if (mysql_query($sql)){
				$updated++;
				$display .= $data[0]."... OK<br />";
				
			}else{
				$error++;
				$display .= $data[0]."... ERROR ($sql)<br />";
				
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
