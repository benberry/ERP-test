<?php
 
include("../include/init.php");

extract($_REQUEST);

//*** Select SQL
	
    if(!isset($report_type))
        $report_type = 'Order Source';

//*** Select SQL
if($report_type == 'All Custom URLs'){
        $sql="SELECT DATE_FORMAT(tbl_tracking.date_created,'%d-%c-%Y') as 'Date Created',tbl_tracking.tracking_name as 'Tracking Name', tbl_tracking.tracking_code as 'Tracking Code',
        sum(IF( (tbl_tracking_records.id>0 ), 1, 0 )) as 'Number of Clicks', 
         sum(IF( ((tbl_cart.order_status_id = 2 OR tbl_cart.order_status_id = 4 OR tbl_cart.order_status_id = 7) AND tbl_tracking_records.cart_id!=0 ), 1, 0 )) as 'Number of Orders',
         CONCAT(((sum(IF( ((tbl_cart.order_status_id = 2 OR tbl_cart.order_status_id = 4 OR tbl_cart.order_status_id = 7) AND tbl_tracking_records.cart_id!=0 ), 1, 0 ))/count(*))*100),'','%') as 'Conversion Rate',tbl_tracking.tracking_url as 'Tracking URL'
         FROM tbl_tracking
        LEFT JOIN tbl_tracking_records ON tbl_tracking.id = tbl_tracking_records.tracking_code_id
        LEFT JOIN tbl_cart ON tbl_cart.id = tbl_tracking_records.cart_id WHERE 1 
        ";
    	if ($start_date){
    		$sql .= " and tbl_tracking.date_created  >= '$start_date'";
    	}else{
    		$start_date=date("Y-m-1");
    		$sql .= " and tbl_tracking.date_created  >= '$start_date'";
    	}
    	
    	if ($end_date){
    		$sql .= " and tbl_tracking.date_created  <= '$end_date'";
    	}else{
            $end_date=date('Y-m-d');
        }
        $sql.="GROUP BY tbl_tracking.id 
        ORDER BY tbl_tracking.date_created DESC, tbl_tracking.tracking_name ASC, tbl_tracking.tracking_code ASC ";
        $schema_insert = 'All Custom URLs from '.date('d F Y',strtotime($start_date)).' To '.date('d F Y',strtotime($end_date));
        $filename = 'All-Custom-URLs';
}
elseif($report_type == 'Conversion'){
        
         $sql="SELECT tbl_tracking.tracking_name as 'Tracking Name', tbl_tracking.tracking_code as 'Tracking Code', tbl_tracking_records.product_id as 'Product ID',count(*) as 'Number of Clicks', sum(IF( ((tbl_cart.order_status_id = 2 OR tbl_cart.order_status_id = 4 OR tbl_cart.order_status_id = 7) AND tbl_tracking_records.cart_id!=0 ), 1, 0 )) as 'Number of Orders', CONCAT(((sum(IF( ((tbl_cart.order_status_id = 2 OR tbl_cart.order_status_id = 4 OR tbl_cart.order_status_id = 7) AND tbl_tracking_records.cart_id!=0 ), 1, 0 ))/count(*))*100),'','%') as 'Conversion Rate',  tbl_tracking_records.access_url as 'URL'
         FROM tbl_tracking 
        LEFT JOIN tbl_tracking_records ON tbl_tracking.id = tbl_tracking_records.tracking_code_id
        LEFT JOIN tbl_cart ON tbl_cart.id = tbl_tracking_records.cart_id WHERE 1 
        ";
    	if ($start_date){
    		$sql .= " and tbl_tracking_records.time_of_visit  >= '$start_date'";
    	}else{
    		$start_date=date("Y-m-1");
    		$sql .= " and tbl_tracking_records.time_of_visit  >= '$start_date'";
    	}
    	
    	if ($end_date){
    		$sql .= " and tbl_tracking_records.time_of_visit  <= '$end_date'";
            
    	}
        else{
            $end_date=date('Y-m-d');
        }
        $sql.="GROUP BY CONCAT(tbl_tracking.id,'-', tbl_tracking_records.product_id) 
        ORDER BY tbl_tracking.tracking_name ASC, tbl_tracking.tracking_code ASC, tbl_tracking_records.product_id ASC ";
        $schema_insert = 'Tracking Conversion from '.date('d F Y',strtotime($start_date)).' To '.date('d F Y',strtotime($end_date));
        $filename = 'Conversion';
        
}
elseif($report_type == 'Daily Conversion'){
    
    $include_file = 'dailyconversion.php';
    $sql="SELECT DATE_FORMAT(time_of_visit,'%d-%c-%Y') as Date,tbl_tracking.tracking_name as 'Tracking Name', tbl_tracking.tracking_code as 'Tracking Code',count(*) as 'Number of Clicks', sum(IF( ((tbl_cart.order_status_id = 2 OR tbl_cart.order_status_id = 4 OR tbl_cart.order_status_id = 7) AND tbl_tracking_records.cart_id!=0 ), 1, 0 )) as 'Number of Orders',CONCAT(((sum(IF( ((tbl_cart.order_status_id = 2 OR tbl_cart.order_status_id = 4 OR tbl_cart.order_status_id = 7) AND tbl_tracking_records.cart_id!=0 ), 1, 0 ))/count(*))*100),'','%') as 'Conversion Rate',  tbl_tracking_records.product_id as 'Product ID', tbl_tracking_records.access_url as 'URL' 
        FROM tbl_tracking_records
        LEFT JOIN tbl_tracking ON tbl_tracking.id = tbl_tracking_records.tracking_code_id
        LEFT JOIN tbl_cart ON tbl_cart.id = tbl_tracking_records.cart_id WHERE 1 
        ";
    	if ($start_date){
    		$sql .= " and tbl_tracking_records.time_of_visit  >= '$start_date'";
    	}else{
    		$start_date=date("Y-m-1");
    		$sql .= " and tbl_tracking_records.time_of_visit  >= '$start_date'";
    	}
    	
    	if ($end_date){
    		$sql .= " and tbl_tracking_records.time_of_visit  <= '$end_date'";
    	}else{
            $end_date=date('Y-m-d');
        }
        $sql.="GROUP BY DATE(time_of_visit), tbl_tracking.id, tbl_tracking_records.product_id ORDER BY time_of_visit DESC, tbl_tracking.tracking_name ASC, tbl_tracking.tracking_code ASC ";
        $schema_insert = 'Daily Tracking Conversions from '.date('d F Y',strtotime($start_date)).' To '.date('d F Y',strtotime($end_date));
        $filename = 'Daily-Conversion';
        
}
else{   
        $sql="SELECT  DATE_FORMAT(time_of_visit,'%d-%c-%Y') as Date,tbl_tracking.tracking_name as 'Tracking Name', tbl_tracking.tracking_code as 'Tracking Code', tbl_tracking_records.product_id as 'Product ID', tbl_cart.invoice_no as 'Order Number', tbl_tracking_records.access_url as URL
        FROM tbl_tracking_records
        LEFT JOIN tbl_tracking ON tbl_tracking.id = tbl_tracking_records.tracking_code_id
        LEFT JOIN tbl_cart ON tbl_cart.id = tbl_tracking_records.cart_id WHERE 1 
        ";
    	if ($start_date){
    		$sql .= " and tbl_tracking_records.time_of_visit  >= '$start_date'";
    	}else{
    		$start_date=date("Y-m-1");
    		$sql .= " and tbl_tracking_records.time_of_visit  >= '$start_date'";
    	}
    	
    	if ($end_date){
    		$sql .= " and tbl_tracking_records.time_of_visit  <= '$end_date'";
    	}else{
            $end_date=date('Y-m-d');
        }
        $sql.=" ORDER BY time_of_visit DESC, tbl_tracking.tracking_name ASC, tbl_tracking.tracking_code ASC ";
        
    	$schema_insert = 'Tracking Order Source from '.date('d F Y',strtotime($start_date)).' To '.date('d F Y',strtotime($end_date));
        $filename = 'Order-Source';
    	
}


// echo $sql."<br />";
 
exportMysqlToCsv($sql,$schema_insert,$filename);

function exportMysqlToCsv($sql_query,$schema_insert = '',$filename = 'Tracking')
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
    $schema_insert.= $csv_terminated.$csv_terminated;
    

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
    header("Content-type: text/x-csv");
    header("Content-type: text/csv");
    header("Content-type: application/csv");
    header("Content-Disposition: attachment; filename=$filename-".date("d-F-Y").".csv");
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