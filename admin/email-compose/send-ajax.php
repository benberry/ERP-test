<?

	## include
	include("../include/init.php");
	
	## request
	extract($_REQUEST);
		
	$to = get_field("tbl_email_list", "email", $id);
		
	if ($to != ""){	
	## email
	
		## update 
		$sql = " insert into tbl_email_history(
			parent_id,	
			email_list_id,
			send_date,
			email,
			active
			
		)values(
			$email_id,
			$id,
			NOW(),
			'$to',
			1

		)";
		
		if (!mysql_query($sql))
			echo $sql;
			
		## email
			$to 			= $to;
			//$from			= get_cfg("company_email");
			$from			= "marketing@cameraparadise.com";
			$subject		= get_field("tbl_email_compose", "name_1", $email_id);
			

		## get email content
			$url 			= get_cfg("company_website_address")."email-template/";	
			$mail_template 	= "template-newsletter/";
			$content		= "newsletter/content.php?id=$email_id&email_list_id=$id";
			$mail_header 	= file_get_contents("{$url}{$mail_template}header.php", 1);
			$mail_footer 	= file_get_contents("{$url}{$mail_template}footer.php", 1);					
			$mail_content 	= file_get_contents("{$url}{$content}", 1);	
			$body 			= $mail_header.$mail_content.$mail_footer;
			

		## send email	
			send_email($from, $from, $subject, $to, $to, $body);
			
	}else{
	
		## update 
		$sql = " insert into tbl_email_history(
			parent_id,	
			email_list_id,
			send_date,
			email,
			active
			
		)values(
			$email_id,
			$id,
			NOW(),
			'$to',
			2
		)";
		
		if (!mysql_query($sql))
			echo $sql;	
	
	}


?>