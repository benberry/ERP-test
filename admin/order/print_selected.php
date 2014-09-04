<?
   
   header("Content-type: text/html; charset=utf-8"); 

## init
	include("../include/init.php");
	
?>
<style type="text/css">
	table th,table td{padding:10px;;}
 </style>
<?
	$image_path = get_cfg("company_website_address")."en/images/";
	//$id = trim($_GET['del_id']);
	//$id = trim(str_replace("/,/",",",$_GET['del_id']));
	$id = "";
	foreach ( $_GET as $key => $value ) 
	{
		if(substr($key,0,3) == "cb_")
			$id .= $value.",";
		//echo 'Index : ' . $key . ' & Value : ' . $value;
	}
	$id = substr($id, 0, -1);

## request
	extract($_REQUEST);

## non-member
	//$first_name = get_field("tbl_cart", "first_name",$id);
	//$last_name = get_field("tbl_cart", "last_name",$id);
	
	//function update_status($cart_id){
	//
	//	 //update table tbl_cart
	//	$update_sqlx ="UPDATE tbl_cart SET
	//	order_status_id = '2',
	//	modify_date = NOW() ,
	//	modify_by = '7'
	//	WHERE id=".$cart_id;
	//	
	//	mysql_query($update_sqlx);
	//	
	//}


## get order record
	//$sql1 = " select * from tbl_cart where order_status_id='1' and member_create_date >= '$start_date' and invoice_no is not null and invoice_no!='NULL' ";
	$sql1 = "select * from tbl_cart where id IN ($id)";
	 //echo $sql1;
	$result1 = mysql_query($sql1);
	$my_count = 1;
	$num_rowz = mysql_num_rows($result1);
	
	while($row=mysql_fetch_array($result1)){
	    //update_status($row['id']);
 ?>
 
<div style="width:750px">
    <h1 style="font-size: 16px; line-height:20px;">Invoice (Order ID: <?=$row[invoice_no]; ?>)
	</h1>
  <table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px; color:#666666">
		  <tr>
			<td><h2 style="font-size: 14px; line-height:20px; border-bottom:1px solid #ccc; margin-right: 20px; margin-top:20px; border-left: 5px #ccc solid; padding-left: 10px;">Order Details</h2></td>
		  </tr>
		  <tr>
			<td style="padding-right:20px">
			
			  <table width="100%" border="1" bordercolor="#cccccc" style="border-collapse:collapse; font-family:Arial, Helvetica, sans-serif; font-size:11px; color:#666666">
                <tr bgcolor="#333333"> 
                    <!--<th align="center" style="color:#ffffff">Wrapped</th>-->
					<th align="center" style="color:#ffffff">Code No.</th>
					<th align="center" style="color:#ffffff">Brand</th>
					<th align="center" style="color:#ffffff">Bar Code</th>
                    <th align="center" style="color:#ffffff">Item</th>
                    <th align="center" style="color:#ffffff">Price(HK$)</th>
                    <th align="center" style="color:#ffffff">Quantity</th>
                    <th align="center" style="color:#ffffff">Subtotal</th>
					<th align="center" style="color:#ffffff">加/减/取消/item</th>
                </tr>

				<?
			
					$sql = "
							SELECT a.remark,a.unit_price, a.qty, b.name_1 as pname, b.codeno, b.product_code, c.name_1 as bname
							FROM tbl_cart_item a
							JOIN tbl_product b
							JOIN tbl_brand c
							where
								a.cart_id = '{$row['id']}' and a.product_id = b.id
								and a.qty > 0
								and c.id = b.brand_id

							";
							
					//echo $sql;
					if ($result = mysql_query($sql)){
					
						while ($row1 = mysql_fetch_array($result)){
						
							
						
							?>
							
								<tr>
                                	
									<td><?=$row1["codeno"] ?></td>
									<td><?=$row1["bname"] ?></td>
									<td><?=$row1["product_code"] ?></td>
									<td><?=$row1["pname"] ?></td>
									<td>$<?=$row1["unit_price"] ?></td>
									<td><?=$row1["qty"] ?></td>
									<td>$<?=$row1["unit_price"]*$row1["qty"] ?></td>
                                    <td><?=$row1["remark"] ?></td>
                                </tr> 
							<? 
							
							}
						
					}
			
				?> 
				
				<?
					
					 $sql5 = "
								SELECT sum(a.qty) as total_qty,sum(a.unit_price*a.qty) as total_price
								FROM tbl_cart_item a
								where
									a.cart_id = '{$row['id']}'

								";
					
					 $result5=mysql_query($sql5);
					 
					 $row5 = mysql_fetch_array($result5);
					
					?>
					
					 <tr>
						  
						   <td colspan="5"></td>
						   <td>
							<?=$row5["total_qty"] ?>
						   </td>
						   <td style="padding-right:10px;text-align:right;" colspan="2"><div style="font-size:18px; font-weight:bold;">Order Total:HK$<?=number_format($row5["total_price"],2) ?></div></td>
						
						</tr>
					
			  </table>
			  
			  <br /><br />
            
			  <table align="left" width="450">
				<tr>
					<td style="text-align:center;padding-top:100px;font-size:60px;color:red;">
						<?
							if($row[status2] == 1){
						?>
						M
						<?
							}
						?>
					</td>
				</tr>
			</table>
             
			 <?
						   
						   	$sql3 = "
								SELECT *
								FROM tbl_cart
								where
									id = '{$row['id']}'

								";
							
							$result3 = mysql_query($sql3);
							$row3 = mysql_fetch_array($result3);
							
						?>
			 
            <table border="1" bordercolor="#eee" style="font-family:Arial, Helvetica, sans-serif; font-size:11px; color:#666666; border-collapse:collapse; " align="right">
            	<tr>
                    
                    <td align="right">Sales</td>
                    <td align="right"><?=get_field("tbl_payment_method","name_1",$row3["sales_id"]) ?></td>
                   
                </tr>
                <tr>
                    <td align="right">Client Code / Name: </td>
                    <td align="right" width="100">
						<?=get_field("tbl_currency","name_1",$row3["client_id"]) ?>/<?=get_field("tbl_currency","symbol_1",$row3["client_id"]) ?>
					</td>
                </tr>
                <tr>
                    
                    <td align="right">Remarks</td>
                    <td align="right"><?=$row3["instruction"] ?></td>
                   
                </tr> 
				<tr>
                    
                    <td align="right">Order Number</td>
                    <td align="right"><?=$row3["invoice_no"] ?></td>
                   
                </tr> 
				<tr>
                    
                    <td align="right">Date</td>
                    <td align="right"><?=$row3["member_create_date"] ?></td>
                   
                </tr> 
            </table>
		  </td>
        </tr>
        
      </table>
    
	
	<!-- Billing & Shipping -->
	<!--<p>For any enquiry, please contact <a href="mailto:info@cameraparadise.com">info@cameraparadise.com</a></p>-->
</div>
<?php if($my_count<$num_rowz) {
    ?>
<DIV style="page-break-after:always;"></DIV>
  <?php } $my_count++; }?>
  <script>
	window.print();
</script>