<?php
 
include("../include/init.php");

$tbl = "tbl_erp_product";

$csv_sql_field="
sku,
main_category,
sub_category,
name,
actual_weight,
dimension_weight
";

//*** Select SQL
	$sql="
		select
			$csv_sql_field
		from
			$tbl
		where
			active=1
			order by id asc";
	
exportMysqlToCsv($sql);

function exportMysqlToCsv($sql_query)
{
    $csv_terminated = "\n";
    $csv_separator = ",";
    $csv_enclosed = '"';
    $csv_escaped = "\\";
    // $sql_query = "select * from $table";
 
    // Gets the data from the database
    $result = mysql_query($sql_query);
	//echo $sql_query;
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
 				$str = $row[$j];
 
				if ($csv_enclosed == ''){
					$schema_insert .= $str;
					
				} else {
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
	header('Content-Encoding: UTF-8');
	header('Content-type: text/csv; charset=UTF-8');
    //header("Content-type: application/excel");    
    header("Content-Disposition: attachment; filename=products_export-".date("Y-m-d").".csv");
    echo $out;
    exit;
 
}
 
?>