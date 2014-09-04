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
	$redirect_page = $_POST["thispage"];
	
	if (isset($_POST['order_cart_id']))
	{
		$my_data = array();
		$shipping_tracking_codez = array();
		if(isset($_POST['order_cart_id'])){
			$shipping_tracking_codez = $_POST['shipping_tracking_code'];
			
			foreach($_POST['order_cart_id'] as $key => $my_order_cart_id){
				if(trim($shipping_tracking_codez[$key])!="")
				$my_data[] = (object)array(
				'order_cart_id'=>$my_order_cart_id,
				'shipping_tracking_code'=>$shipping_tracking_codez[$key]
				);
			}
		}
		
		if(count($my_data)>0){
			foreach($my_data as $this_order){
				$cart_id = $this_order->order_cart_id;
				$shipping_tracking_code = $this_order->shipping_tracking_code;
				$shipping_company_id = 3;   //DPEX
				$order_status_id = 4;      //Shipped
				$email_sent = 1; //send email
				$remarks = str_replace("2185010",$shipping_tracking_code,get_field("tbl_cart_order_status", "content_1", $order_status_id)) ;
				$user_id = $_SESSION['user_id'];
				
				//update table tbl_cart
				$update_sqlx ="UPDATE tbl_cart SET
				order_status_id = $order_status_id,
				shipping_company_id = $shipping_company_id,
				shipping_tracking_code = '$shipping_tracking_code',
				remarks = '$remarks',
				modify_date = NOW() ,
				modify_by = $user_id
				WHERE id=$cart_id ";
				$update_result = mysql_query($update_sqlx);
				
				//insert in table tbl_cart_order_tracker
				$insert_sqlx ="INSERT INTO tbl_cart_order_tracker(
								cart_id,order_status_id,remarks,email_sent,create_date,create_by,modify_date,modify_by
				)VALUES(
				$cart_id,$order_status_id,'$remarks',$email_sent, NOW(), $user_id, NOW(), $user_id
				)";
				$insert_result = mysql_query($insert_sqlx);
				$tracker_id = mysql_insert_id();
				
				//send mail to client
				$to = get_field("tbl_cart", "email", $cart_id);
				//$to = 'duncan@twigahost.com';
				$from = get_cfg("company_email");
				$subject = "[ORDER STATUS] Order Update #".get_field("tbl_cart", "invoice_no", $cart_id);
				
				$url = get_cfg("company_website_address")."email-template/";
				$email_template_content = "order/order_status.php?cart_id=".$cart_id."&tracker_id=".$tracker_id."act=1";
				
				$email_template = "template-1/";
				$mail_header = file_get_contents("{$url}{$email_template}header.php", 1);
				$mail_footer = file_get_contents("{$url}{$email_template}footer.php", 1);
				$mail_content = file_get_contents("{$url}{$email_template_content}", 1);
				$message = $mail_header.$mail_content.$mail_footer;
				
				send_email($from , $from, $subject, $to, $to, $message);
				$subject = "[ORDER STATUS] Order Update #".get_field("tbl_cart", "invoice_no", $cart_id).' (Admin Copy)';
				send_email($from , $from, $subject, $from, $from, $message);
			}
		}
		
		$dialog = "Successfully marked as shipped.";
		$back_to = "../main/main.php?$redirect_page";
		
	}

	//*** dialog
	include("../main/dialog.php");
	

?>
