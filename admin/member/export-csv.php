<?php
 
include("../include/init.php");


$csv_sql_field = "
	member_create_date,
	first_name,
	last_name,
	email,
	password,
	phone_1,
	phone_2,
	addr_1 as billing_addr_1,
	addr_2 as billing_addr_2,
	addr_3 as billing_addr_3,
	country_state,
	country_id as billing_country_id,
	postal_code as billing_postal_code,
	shipping_first_name,
	shipping_last_name,	
	shipping_addr_1,					
	shipping_addr_2,
	shipping_addr_3,
	shipping_country_state,
	shipping_country_id,
	shipping_postal_code	
";
// $csv_sql_field = "*";

	
//$csv_sql = " select $csv_sql_field from tbl_cart where active=1 and deleted=0 and progress_id<>0 order by member_create_date desc ";
$csv_sql = " select $csv_sql_field from tbl_member where active=1 and deleted=0 order by id ";

//echo $csv_sql."<br />";
 
exportMysqlToCsv($csv_sql);

function exportMysqlToCsv($sql_query)
{
    $csv_terminated = "\n";
    $csv_separator = ",";
    $csv_enclosed = '"';
    $csv_escaped = "\\";
    // $sql_query = "select * from $table";
 
    // Gets the data from the database
	if (!mysql_query($sql_query))
		echo $sql_query;

    $result = mysql_query($sql_query);
	// echo $sql_query;
    $fields_cnt = mysql_num_fields($result);
 
    $schema_insert = '';

    for ($i = 0; $i < $fields_cnt; $i++)
    {
        $l = $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed,
            stripslashes(mysql_field_name($result, $i))) . $csv_enclosed;
        $schema_insert .= $l;
        $schema_insert .= $csv_separator;
    } // end for
 
    $out = trim(substr($schema_insert, 0, -1));
    $out .= $csv_terminated;
	
 
    // Format the data
    while ($row = mysql_fetch_array($result))
    {
        $schema_insert = '';
        for ($j = 0; $j < $fields_cnt; $j++){
            if ($row[$j] == '0' || $row[$j] != ''){
 				//set field

 				if (mysql_field_name($result, $j) == "billing_country_id"){
					$str = get_field("tbl_country", "name_1", $row[$j]);
					
				}elseif (mysql_field_name($result, $j) == "shipping_country_id"){
					$str = get_field("tbl_country", "name_1", $row[$j]);
					
 				}elseif(mysql_field_name($result, $j) == "password"){
					$str = base64_decode($row[$j]);
					
 				}elseif(mysql_field_name($result, $j) == "payment_method_id"){
					$str = get_field("tbl_cart_payment_method", "name_1", $row[$j]);
					
 				}elseif(mysql_field_name($result, $j) == "shipping_method_id"){
					$str = get_field("tbl_cart_shipping_method", "name_1", $row[$j]);
					
				}else{
					$str = $row[$j];

				}

				if ($csv_enclosed == ''){
					$schema_insert .= $str;
					
				}else{
					$schema_insert .= $csv_enclosed . 
					str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $str) . $csv_enclosed;
					
				}

            }else{
                $schema_insert .= '';
            }
 
            if ($j < $fields_cnt - 1){
                $schema_insert .= $csv_separator;
            }
        }// end for
 
        $out .= $schema_insert;
        $out .= $csv_terminated;

    }// end while
 
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Content-Length: " . strlen($out));
    // Output to browser with appropriate mime type, you choose ;)
    header("Content-type: text/x-csv");
    //header("Content-type: text/csv");
    //header("Content-type: application/csv");
    header("Content-Disposition: attachment; filename=customer-".date("Y-m-d").".csv");
    echo $out;
    exit;
 
}
 
?>