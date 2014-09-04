<?
	## include
		include("../include/init.php");


	## request
		extract($_REQUEST);
		
		
	if ($id>0){
		## update 
		$sql=" update tbl_product set
			au_shopping_rank='$au_shopping_rank',
			au_shopping_price=$au_shopping_price,
			au_shopping_shipping=$au_shopping_shipping,
			au_shopping_remarks='$au_shopping_remarks'
		where id = $id ";

		if (!mysql_query($sql)){
			echo $sql;
		}else{
			?>updated<?
		}

	}

?>