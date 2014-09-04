<?
	### init
		include("../include/init.php");
	
	### request 
		extract($_REQUEST);
	
		if ($_SESSION["sys_write"]){
		
			### sql
			$sql="update
					tbl_product
				set
					ctin='$ctin',
					mpn='$mpn'
				where
					id=$product_id";
		
		
			if (mysql_query($sql)){
				
			}else{
				echo $sql;
				
			}
		
		}else{
			get_total_amount_result($product_id);
			
		}

?>
<div class="notice">updated</div>