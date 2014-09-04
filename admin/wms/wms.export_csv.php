<?php
 
include("../include/init.php");

extract($_REQUEST);

$csv_sql_field="
sku as SKU,
main_category,
sub_category,
name,
current_qty,
so_qty,
po_qty,
current_qty + po_qty - so_qty as available_qty
";




//*** Select SQL
	$sql="
		select
			$csv_sql_field
		from
			$tbl
		where
			active=1";


//*** Search
	if ($srh_sku){
		$sql .= " and sku like '%$srh_sku%'";
	}

	if ($srh_name){
		$sql .= " and name like '%$srh_name%'";
	}

	if ($srh_category){
		$sql .= " and main_category like '%$srh_category%'";
	}		

	if ($srh_avai_qty!='all'){
		if($srh_avai_qty == '')
		{
			$srh_avai_qty = "<0";
		}

		$sql .= " and current_qty + po_qty - so_qty $srh_avai_qty";
	}

//*** Order by start
	if (empty($_POST["order_by"]))
		$order_by = "create_date"; 
	else
		$order_by = $_POST["order_by"];
	
	if (empty($_POST["ascend"]))
		$ascend = "desc";
	else
		$ascend = $_POST["ascend"];
	
	if (!empty($order_by))
	{
		$sql .="
			order by
				$order_by
				$ascend
		";
	}

//*** Order by end


// echo $sql."<br />";
 
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
 				//set field
 				if (mysql_field_name($result, $j) == "billing_country_id"){
					$str = get_field("tbl_country", "name_1", $row[$j]);
					
				}elseif (mysql_field_name($result, $j) == "shipping_country_id"){
					$str = get_field("tbl_country", "name_1", $row[$j]);					
					
 				}elseif(mysql_field_name($result, $j) == "order_status"){
					$str = get_field("tbl_cart_order_status", "name_1", $row[$j]);
					
 				}elseif(mysql_field_name($result, $j) == "payment_method_id"){
					$str = get_field("tbl_payment_method", "name_1", $row[$j]);

					
 				}elseif(mysql_field_name($result, $j) == "shipping_method_id"){
					
					if ($row[$j] == 1){
						$str = "Registered Airmail";

					}else{
						$str = "Express Shipping";

					}
					
 				}elseif(mysql_field_name($result, $j) == "currency"){
					$str = get_field("tbl_currency", "name_1", $row[$j]);

					
 				}elseif(mysql_field_name($result, $j) == "total"){
					//$str = round(get_total_amount($row[$j]),2);
					$ttl_amt = get_total_amount($row[$j]) * $row[exchange_rate];	
					$str = number_format($ttl_amt, 3);
					
 				}elseif(mysql_field_name($result, $j) == "member"){
					$str = get_field("tbl_cart", "title", $row[$j])." ".get_field("tbl_cart", "first_name", $row[$j])." ".get_field("tbl_cart", "last_name", $row[$j]);
					
				}else{
					$str = $row[$j];

				}
 
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
    header("Content-type: text/x-csv");
    header("Content-type: text/csv");
    header("Content-type: application/csv");
    header("Content-Disposition: attachment; filename=products-".date("Y-m-d").".csv");
    echo $out;
    exit;
	
	function get_cart_item_list_with_accessory($cart_id){
		
		$sql = "select * from tbl_cart_item where id=$cart_id";
		
		if ($result = mysql_query($result)){
			
			while ($row = mysql_fetch_array($result)){
				
				
				
			}
			
		}else
			echo $sql;
		
	}
 
}
 
?>