<?

//*** default
	$list_page = "oms.so";
	$edit_page = "oms.so.edit";


//*** requset	
	$act = $_POST["act"];
	$tbl = $_POST["tbl"];
	$id = $_POST["id"];
	$del_id = $_POST["del_id"];
	$pg_num = $_POST['pg_num'];
	$tab = $_POST["tab"];
	$email_sent = $_POST["email_sent"];
	$current_order_status = $_POST["current_order_status"];
	$order_status_id = $_POST["order_status_id"];
	$magento_order_id = $_POST["magento_order_id"];
	$order_id = $id;
	//$cart_id = $id;
	
	
	if ($act == "1")
	{
	
		include("../main/erp_save.php");
		$dialog = "Successfully saved.";
		$back_to = "../main/main.php?func_pg=$edit_page&id=$id&pg_num=$pg_num&tab=$tab";

		if(ISSET($_POST['remarks']) && $_POST['remarks']!="")
		{	## order remark
			$id = '';
			$tbl = "tbl_order_remark";
			include("../main/erp_save.php");
		}
		$tracker_id = $id;
		
		//////////Update Billing Address/////////
		$first_name = $_POST["bill_to_first_name"];
		$last_name = $_POST["bill_to_last_name"];
		$telephone = $_POST["bill_to_telephone"];
		$company = $_POST["bill_to_company"];
		$street = $_POST["bill_to_street"];
		$city = $_POST["bill_to_city"];
		$country = $_POST["bill_to_country"];
		$region = $_POST["bill_to_region"];
		$post_code = $_POST["bill_to_post_code"];
		$sql = "UPDATE tbl_order_billing_address SET first_name='".addslashes($first_name)."',  last_name='".addslashes($last_name)."',  telephone='".addslashes($telephone)."',  company='".addslashes($company)."',  street='".addslashes($street)."',  city='".addslashes($city)."',  country='".addslashes($country)."',  region='".addslashes($region)."',  post_code='".addslashes($post_code)."' WHERE order_id={$order_id} ";
		if(!mysql_query($sql))
			$dialog .= "<br>".$sql;
			
		//////////Update Shipping Address/////////
		$first_name = $_POST["ship_to_first_name"];
		$last_name = $_POST["ship_to_last_name"];
		$telephone = $_POST["ship_to_telephone"];
		$company = $_POST["ship_to_company"];
		$street = $_POST["ship_to_street"];
		$city = $_POST["ship_to_city"];
		$country = $_POST["ship_to_country"];
		$region = $_POST["ship_to_region"];
		$post_code = $_POST["ship_to_post_code"];
		$sql = "UPDATE tbl_order_shipping_address SET first_name='".addslashes($first_name)."',  last_name='".addslashes($last_name)."',  telephone='".addslashes($telephone)."',  company='".addslashes($company)."',  street='".addslashes($street)."',  city='".addslashes($city)."',  country='".addslashes($country)."',  region='".addslashes($region)."',  post_code='".addslashes($post_code)."' WHERE order_id={$order_id} ";
		if(!mysql_query($sql))
			$dialog .= "<br>".$sql;
		
		if($current_order_status != $order_status_id)
		{	////////////////Update Magento Order Status////////////////
			$sql = "SELECT code, detail FROM tbl_order_status WHERE id = ".$order_status_id;
			//$dialog .= "<br>".$sql;
			$rows = mysql_query($sql);
			$row = mysql_fetch_array($rows);
			$status_url = "http://www.android-enjoyed.com/export/it/update_order_status.php?OrderID={$magento_order_id}&status={$row[code]}&state={$row[detail]}&comment=";			
			$xml = simplexml_load_file($status_url);
			foreach($xml->children() as $return_status){
				$dialog .= "<br>Magento return msg:".$return_status->message."<br>";
			}
		
		}
		//## email to customer
		//if ($email_sent==1){
        //
		//	
		//	#### get_cart_id - end
		//	$to = get_field("tbl_cart", "email", $cart_id);
		//	$from = get_cfg("company_email");
		//	$subject = "[ORDER STATUS] Order Update #".get_field("tbl_cart", "invoice_no", $cart_id);
		//	
		//	$url = get_cfg("company_website_address")."email-template/";
		//	$email_template_content = "order/status.php?cart_id=".$cart_id."&tracker_id=".$tracker_id."act=1";
		//	
		//	$email_template = "template-1/";
		//	$mail_header = file_get_contents("{$url}{$email_template}header.php", 1);
		//	$mail_footer = file_get_contents("{$url}{$email_template}footer.php", 1);					
		//	$mail_content = file_get_contents("{$url}{$email_template_content}", 1);	
		//	$message = $mail_header.$mail_content.$mail_footer;
		//	
		//	send_email($from , $from, $subject, $to, $to, $message);
        //
        //
        //
		//	### get email content
		//	$to = get_cfg("company_email");
		//	$from = get_cfg("company_email");
		//	$subject = "[ORDER STATUS] Order Update #".get_field("tbl_cart", "invoice_no", $cart_id)." (Admin Copy)";
		//	
		//	$url = get_cfg("company_website_address")."email-template/";
		//	$email_template_content = "order/status.php?cart_id=".$cart_id."&tracker_id=".$tracker_id."act=1";
		//	
		//	$email_template = "template-1/";
		//	$mail_header = file_get_contents("{$url}{$email_template}header.php", 1);
		//	$mail_footer = file_get_contents("{$url}{$email_template}footer.php", 1);					
		//	$mail_content = file_get_contents("{$url}{$email_template_content}", 1);	
		//	$message = $mail_header.$mail_content.$mail_footer;
		//	
		//	send_email($from, $from, $subject, $to, $to, $message);
		//	
		//}
	
	}
	
	if ($act == "2")
	{	////Create New Order///
		include("../main/erp_save.php");
		$dialog = "Successfully Created New Order.";
		$back_to = "../main/main.php?func_pg=$edit_page&id=$id";
		$Insert_Billing = "INSERT INTO tbl_order_billing_address (order_id) VALUES ({$id})";
		if(!mysql_query($Insert_Billing))
			$dialog .= "<br>".$Insert_Billing;
		$Insert_Shipping = "INSERT INTO tbl_order_shipping_address (order_id) VALUES ({$id})";
		if(!mysql_query($Insert_Shipping))
			$dialog .= "<br>".$Insert_Shipping;
	}
	
	if ($act == "3")
	{
	
		include("../main/std_save.php");
		$dialog = "Successfully deleted.";
		$back_to = "../main/main.php?func_pg=$list_page&pg_num=$pg_num&tab=$tab";
	
	}
	
	if ($act == "4")
	{
	
		include("../main/std_del.php");
		$dialog = "Successfully deleted.";
		$back_to = "../main/main.php?func_pg=$list_page&pg_num=$pg_num&tab=$tab";
	
	}	


	//*** dialog
	include("../main/dialog.php");
	

?>
