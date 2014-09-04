<?php
## Include
	include("../include/init.php");


## default
	$tbl = "tbl_product";


## Request
	extract($_REQUEST);


## CSV field
	$csv_sql_field = "
		id,
		name_1 as display_name,
		name_2 as title,
		mpn,
		cat_id,
		cat_id as category_name,
		brand_id,
		brand_id as brand_name,
		model,
		unit_cost,
		gp_percent as GP,
		rate,
		price_1 as Price_AU,
		round(price_1 * rate, 2) as Price_HK,
		round(unit_cost * ( 1 + gp_percent) - unit_cost, 2) as Product_GP,
		weight,
		weight as express_shipping_cost,
		weight as registered_airmail_cost,
		id as final_GP,
		stock_status as product_status,
		active as display,
		display_to_getprice,
		display_to_shopbot,
		meta_keyword,
		meta_description,
		popularity,
		bestselling,
		create_date,
		create_by,
		modify_date,
		modify_by
	";


## Select SQL
	$sql = "
		select
			$csv_sql_field
		from
			$tbl
		where
			status = 0
			and deleted=0";
	
	if ($srh_cat_id){
		$sql .= " and cat_id = {$srh_cat_id} ";
	}
	
	if ($srh_id){
		$sql .= " and id = $srh_id ";
	}
	
	if ($srh_keyword){
		$sql .= " and (";
		$sql .= " name_1 like '%{$srh_keyword}%' ";
		$sql .= " name_2 like '%{$srh_keyword}%' ";		
		$sql .= " or model like '%{$srh_keyword}%' ";
		$sql .= " ) ";
	
	}


//*** Order by start
	if (empty($_POST["order_by"]))
		$order_by = "cat_id, brand_id, name_1 "; 
	else
		$order_by = $_POST["order_by"];
	
	if (empty($_POST["ascend"]))
		$ascend = "";
	else
		$ascend = $_POST["ascend"];
	
	if (!empty($order_by))
	{
		$sql .= "
		order by
			$order_by
			$ascend
		";
	}
	
	
	// echo $sql."<br/>";
	
	
//*** Order by end

exportMysqlToCsv($sql);

function exportMysqlToCsv($sql_query)
{

	$today = date("Y-m-d");
	$filename = "product-list-".$today.".csv";
	
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
 				//set field
 				if (mysql_field_name($result, $j) == "brand_name"){
					
					$str = get_field("tbl_brand", "name_1", $row[$j]);
					
				}elseif (mysql_field_name($result, $j) == "category_name"){
					
					$str = get_field("tbl_product_category", "name_1", $row[$j]);
					
 				}elseif(mysql_field_name($result, $j) == "product_status"){
					
					$str = $row[$j];
					
 				}elseif(mysql_field_name($result, $j) == "express_shipping_cost"){
					
					if ($row[$j] > 0)
						$str = round(item_express_shipping_cost($row[$j], 1), 2);
					else
						$str = 0;
					
 				}elseif(mysql_field_name($result, $j) == "registered_airmail_cost"){
					
					if ($row[$j] > 0)
						$str = round(item_registered_airmail_cost($row[$j]), 2);
					else
						$str = 0;
				
 				}elseif(mysql_field_name($result, $j) == "final_GP"){
					
					if ($row[Product_GP] > 0){					
						$str = round($row[Product_GP] + item_express_shipping_cost($row[weight], 1) * $row[rate], 2);
					}else{
						$str = 0;
					}
					
 				}elseif(mysql_field_name($result, $j) == "create_by"){
					$str = get_field("sys_user", "user", $row[$j]);
					
 				}elseif(mysql_field_name($result, $j) == "modify_by"){
					$str = get_field("sys_user", "user", $row[$j]);
					
				}else{
					$str = $row[$j];

				}
 
				if ($csv_enclosed == ''){
					$schema_insert .= $str;
					
				}else {
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
    header("Content-Disposition: attachment; filename=$filename");
    echo $out;
    exit;
 
}
 
?>