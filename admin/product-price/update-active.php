<?

## init
	include("../include/init.php");

## request 
	extract($_REQUEST);

	if ($_SESSION["sys_write"]){
	
		## sql
		$sql="update
				tbl_product
			set
				active=$val,
				modify_date=NOW(),
				modify_by=".$_SESSION["user_id"]."
			where
				id=$id";
	
	
		if (mysql_query($sql)){
			if($val == 1){
				?><a href="javascript: update_product_active(<?=$id;?>, 0);"><img src="../images/yes.png" width="24" border="0"></a><?
			}else{
				?><a href="javascript: update_product_active(<?=$id;?>, 1);"><img src="../images/no.png" width="24" border="0"></a><?
			}

		}else{
			echo $sql;

		}

	}

?>
