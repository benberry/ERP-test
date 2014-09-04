<?

	#init
	include("init.php");
	
	$gateway_ip = $_SERVER['REMOTE_ADDR'];
	// PHP 4.1
	
	// read the post from PayPal system and add 'cmd'
	$req = 'cmd=_notify-validate';
	
	foreach ($_POST as $key => $value) {
		$value = urlencode(stripslashes($value));
		$req .= "&$key=$value";

	}
	
	// post back to PayPal system to validate
	$header .= "POST /cgi-bin/webscr HTTP/1.0\r\n";
	$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
	$header .= "Content-Length: ".strlen($req)."\r\n\r\n";
	
	$fp = fsockopen ('ssl://www.paypal.com', 443, $errno, $errstr, 30);
	// $fp = fsockopen ('ssl://www.sandbox.paypal.com', 443, $errno, $errstr, 30);
	
	// assign posted variables to local variables
	$invoice = $_POST['invoice'];
	$item_name = $_POST['item_name'];
	$item_number = $_POST['item_number'];
	$payment_status = $_POST['payment_status'];
	$payment_amount = $_POST['mc_gross'];
	$payment_currency = $_POST['mc_currency'];
	$txn_id = $_POST['txn_id'];
	$receiver_email = $_POST['receiver_email'];
	$payer_email = $_POST['payer_email'];
    
    
	if (!$fp) {
	
	// HTTP ERROR
	echo "HTTP ERROR";
	
	} else {
	
		fputs ($fp, $header.$req);
		
		while (!feof($fp)) {
		
			$res = fgets ($fp, 1024);
			
			if (strcmp ($res, "VERIFIED") == 0) {
				echo "VERIFIED";
				// check the payment_status is Completed
				// check that txn_id has not been previously processed
				// check that receiver_email is your Primary PayPal email
				// check that payment_amount/payment_currency are correct
				// process payment
				
				if ($payment_status=="Completed"){

					
					#### get_cart_id 
						$sql = " select * from tbl_cart where invoice_no='$invoice' ";
						
						if ($result = mysql_query($sql)){
	
							$row = mysql_fetch_array($result);
							
							$cart_id = $row[id];
							
							if ($cart_id > 0){
							
								$sql  = " update tbl_cart set ";
								$sql .= " order_status_id=7, ";
								$sql .= " payment_gateway_ip='$gateway_ip', ";			
								$sql .= " payment_gateway_ref='$txn_id', ";
								$sql .= " payment_gateway_status='$payment_status', ";
								$sql .= " payment_gateway_date=NOW(), ";
								$sql .= " payment_gateway_amt=$payment_amount, ";
								$sql .= " payment_gateway_cur='$payment_currency', ";
								$sql .= " payment_gateway_payer_email='$payer_email' ";
								// $sql .= " payment_gateway_payment_method='$pay_method' ";
								$sql .= " where invoice_no='$invoice'";
								
								if (!mysql_query($sql))
									echo $sql;
							
								
								#### update order tracker
									$sql="insert into tbl_cart_order_tracker 
									(
										cart_id, 
										order_status_id,
										email_sent,
										remarks,
										create_date
										
									)values(
										$cart_id, 
										7,
										1,
										'Order Confirmation',
										NOW()
									
									)";
			
									if (!mysql_query($sql))
										echo $sql;
								#### update order tracker - end
								
								
								#### update product stock
								
								
								#### update best selling
								function update_best_selling($cart_id){
								
									$sql = " select * from tbl_cart_item where id = $cart_id ";
									
									if ($result = mysql_query($sql)){
									
										while ($row = mysql_fetch_array($result)){
										
											$bestselling = get_field("tbl_product", "bestselling", $row[product_id]);
											$bestselling++;
											set_field_data("tbl_product", "bestselling", $row[product_id], $bestselling);
											
										}
										
									}
									
								}
								
								update_best_selling($cart_id);
								
								#### get_cart_id - end
								$to = get_field("tbl_cart", "email", $cart_id);
								$from = get_cfg("company_email");
								$subject = "[NEW ORDER] Order Confirmation No. ".get_field("tbl_cart", "invoice_no", $cart_id);
									
								$url = get_cfg("company_website_address")."email-template/";
								$email_template_content = "order/confirmation.php?cart_id=".$cart_id."&act=1";
								
								$email_template = "template-1/";
								$mail_header = file_get_contents("{$url}{$email_template}header.php", 1);
								$mail_footer = file_get_contents("{$url}{$email_template}footer.php", 1);					
								$mail_content = file_get_contents("{$url}{$email_template_content}", 1);	
								$message = $mail_header.$mail_content.$mail_footer;
						
								send_email($from, $from, $subject, $to, $to, $message);
		
						
								### get email content
								$to = get_cfg("company_email");
								$from = get_cfg("company_email");
								$subject = "[NEW ORDER] Order Confirmation No. ".get_field("tbl_cart", "invoice_no", $cart_id)." (Admin Copy)";
							
								$url = get_cfg("company_website_address")."email-template/";
								$email_template_content = "order/confirmation.php?cart_id=".$cart_id."&act=1";
								
								$email_template = "template-1/";
								$mail_header = file_get_contents("{$url}{$email_template}header.php", 1);
								$mail_footer = file_get_contents("{$url}{$email_template}footer.php", 1);					
								$mail_content = file_get_contents("{$url}{$email_template_content}", 1);	
								$message = $mail_header.$mail_content.$mail_footer;
						
								send_email($from, $from, $subject, $to, $to, $message);
                                
							}

						}else{
							
							echo $sql;
	
						}
						
				}else{
				
					$sql  = " update tbl_cart set ";
					$sql .= " order_status_id=1, ";
					$sql .= " payment_gateway_ip='$gateway_ip', ";			
					$sql .= " payment_gateway_ref='$txn_id', ";
					$sql .= " payment_gateway_status='$payment_status', ";
					$sql .= " payment_gateway_date=NOW(), ";
					$sql .= " payment_gateway_amt='$payment_amount', ";
					$sql .= " payment_gateway_cur='$payment_currency', ";
					$sql .= " payment_gateway_payer_email='$payer_email' ";
	//				$sql .= " payment_gateway_payment_method='$pay_method' ";
					$sql .= " where invoice_no='$invoice'";
					
					if (!mysql_query($sql))
						echo $sql;	
						
						
					## get_cart_id 
					$sql = " select * from tbl_cart where invoice_no='$invoice' ";
					
					if ($result = mysql_query($sql)){

						$row = mysql_fetch_array($result);
						
						$cart_id = $row[id];
						
						
						## update order tracker
						$sql = "insert into tbl_cart_order_tracker(
							cart_id, 
							order_status_id,
							email_sent,
							remarks,
							create_date
							
						)values(
							$cart_id, 
							1,
							0,
							'Payment Reversed',
							NOW()
						
						)";

						if (!mysql_query($sql))
							echo $sql;

					}else{

						echo $sql;

					}									
				
				}
					
								
	
			}elseif (strcmp ($res, "INVALID") == 0) {
				// log for manual investigation
				echo "INVALID";

			}
	
		}

		fclose ($fp);

	}

?>
