<?

//*** default
	$list_page = "order.list";
	$edit_page = "order.edit";


//*** requset	
	$act = $_POST["act"];
	$tbl = $_POST["tbl"];
	$id = $_POST["id"];
	$del_id = $_POST["del_id"];
	$pg_num = $_POST['pg_num'];
	$tab = $_POST["tab"];
	$email_sent = $_POST["email_sent"];
	$cart_id = $id;


	
	if ($act == "1")
	{
	
		include("../main/std_save.php");
		$dialog = "Successfully saved.";
		$back_to = "../main/main.php?func_pg=$edit_page&id=$id&pg_num=$pg_num&tab=$tab";

		
		## order tracker
		$id = '';
		$tbl = "tbl_cart_order_tracker";
		include("../main/std_save.php");
		
		$tracker_id = $id;
		
		
		## email to customer
		if ($email_sent==1){

			
			#### get_cart_id - end
			$to = get_field("tbl_cart", "email", $cart_id);
			$from = get_cfg("company_email");
			$subject = "[ORDER STATUS] Order Update #".get_field("tbl_cart", "invoice_no", $cart_id);
			
			$url = get_cfg("company_website_address")."email-template/";
			$email_template_content = "order/status.php?cart_id=".$cart_id."&tracker_id=".$tracker_id."act=1";
			
			$email_template = "template-1/";
			$mail_header = file_get_contents("{$url}{$email_template}header.php", 1);
			$mail_footer = file_get_contents("{$url}{$email_template}footer.php", 1);					
			$mail_content = file_get_contents("{$url}{$email_template_content}", 1);	
			$message = $mail_header.$mail_content.$mail_footer;
			
			send_email($from , $from, $subject, $to, $to, $message);



			### get email content
			$to = get_cfg("company_email");
			$from = get_cfg("company_email");
			$subject = "[ORDER STATUS] Order Update #".get_field("tbl_cart", "invoice_no", $cart_id)." (Admin Copy)";
			
			$url = get_cfg("company_website_address")."email-template/";
			$email_template_content = "order/status.php?cart_id=".$cart_id."&tracker_id=".$tracker_id."act=1";
			
			$email_template = "template-1/";
			$mail_header = file_get_contents("{$url}{$email_template}header.php", 1);
			$mail_footer = file_get_contents("{$url}{$email_template}footer.php", 1);					
			$mail_content = file_get_contents("{$url}{$email_template_content}", 1);	
			$message = $mail_header.$mail_content.$mail_footer;
			
			send_email($from, $from, $subject, $to, $to, $message);
			
		}
	
	}
	
	if ($act == "2")
	{
	

	
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
