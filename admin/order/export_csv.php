<?php
 
include("../include/init.php");

extract($_REQUEST);

$csv_sql_field="
member_create_date,
invoice_no as order_id,
order_status_id as order_status,
payment_method_id,
subcharge,
shipping_method_id,
shipping_cost,
shipping_insurance,
priority_handling,
coupon_id,
coupon_name,
coupon_discount,
currency_id as currency,
exchange_rate,
id as total,
first_name,
last_name,
email,
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
shipping_postal_code";

// $csv_sql = "select $csv_sql_field from tbl_cart where active=1 and deleted=0 and order_status_id<>0 order by member_create_date desc";


//*** Select SQL
	$sql="
		select
			$csv_sql_field
		from
			$tbl
		where
			status=0
			and active=1
			and deleted=0
			and order_status_id<>0";


//*** Search
	if ($srh_order_date_from){
		$sql .= " and member_create_date >= '$srh_order_date_from'";
	}else{
		$srh_order_date_from=date("Y-m-1");
		$sql .= " and member_create_date >= '$srh_order_date_from'";
	}
	
	if ($srh_order_date_to){
		$sql .= " and member_create_date <= '$srh_order_date_to'";
	}
	
	if ($srh_order_no){
		$sql .= " and invoice_no like '%$srh_order_no%'";
	}

	if ($srh_progress_id != '' && $srh_progress_id!='all'){
		$sql .= " and order_status_id = $srh_progress_id";
	}
	
	if ($srh_payment_method_id){
		$sql .= " and payment_method_id = $srh_payment_method_id";
	}
	
	if ($srh_delivery_method_id){
		$sql .= " and shipping_location_id = $srh_delivery_method_id";
	}
	
	if ($search_member_id > 0){
		$sql .= " and member_id = $search_member_id";
	}
	
	if ($srh_first_name !=''){
		$sql .= " and first_name like '%$srh_first_name%'";
	}
	
	if ($srh_last_name !=''){
		$sql .= " and last_name like '%$srh_last_name%'";
	}
	
	if ($srh_email !=''){
		$sql .= " and email like '%$srh_email%'";
	}		


//*** Order by start
	if (empty($_POST["order_by"]))
		$order_by = "member_create_date"; 
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
    header("Content-Disposition: attachment; filename=orders-".date("Y-m-d").".csv");
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