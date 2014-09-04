<?php
	
	session_start();
	require_once("../../library/config.func.php");
	require_once("../../library/common.func.php");
	require_once("../../library/main.func.php");
	require_once("../../library/date.func.php");
	require_once("../../library/sql.func.php");
	require_once("../../library/paging.func.php");	
	require_once("../../library/sys-right.func.php");
	require_once("../../library/file-upload.func.php");	

	require_once("../../library/item.func.php");
	require_once("../../library/category.func.php");
	require_once("../../library/member.func.php");
	require_once("../../library/product.func.php");	
	require_once("../../library/order-management.func.php");
	
	$mdbarcode = $_POST['mdbarcode'];
	$ctype = $_POST['ctype'];
	
	if($ctype == "check"){
		$sql = "SELECT * FROM tbl_stockin_item a WHERE 
active = 1
and deleted = 0
and exists(select null from tbl_stockin b where a.stockin_id = b.id and b.active = 1 and b.deleted=0)
and MD_Barcode = '".addslashes($mdbarcode)."'";
		if($result = mysql_query($sql)){
			$row=mysql_fetch_array($result);
			if($row[shipped] != NULL)
			{	if($row[shipped]==0)
					echo "Available -- ".$row[id];
				else
					echo "Unavailable";
			}else
				echo "Not Exist";
		}
		else
			echo $sql."<Br>";
	}else if($ctype == "release"){
		$sql = "UPDATE tbl_stockin_item SET shipped=0 WHERE MD_Barcode='".addslashes($mdbarcode)."'";
		if(!mysql_query($sql))
			echo $sql;
			
		$sql = "UPDATE tbl_order_shipment_item SET mdbarcode=null WHERE mdbarcode='".addslashes($mdbarcode)."'";
		if(!mysql_query($sql))
			echo $sql;
	
	
	}else
		echo "No check type!";
	
	
function get_remark_record($order_id)
{
	$remark = '';
	
	$sql = " select * from tbl_order_remark where order_id={$order_id} order by create_date desc ";			
	if ($result=mysql_query($sql)){	  
		while ($row=mysql_fetch_array($result)){
			$remark .= '<tr>';
			$remark .= "<td width='160'>".$row[create_date]."</td>";
			if ($row[create_by]==0)
				$remark .= "<td width='80'>system</td>";
			else
				$remark .= "<td width='80'>".get_field("sys_user", "name_1", $row[create_by])."</td>";
				
			$remark .= "<td width='250'>".$row[remarks]."</td>";									
            $remark .= "</tr>";
		}		
		return $remark;
	}else
		return $sql;
}	
?>