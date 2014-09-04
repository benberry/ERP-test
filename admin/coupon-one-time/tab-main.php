<fieldset>
	<!--<legend></legend>-->
    
	<p><label>Name:</label><input type="text" name="name_1" value="<?=$row[name_1]; ?>"></p><br />
    
    <p>
	   <? if ($row[id] > 0){?>
    		<label>Code:</label><input type="text" name="code" value="<?=$row[code]; ?>">
       <? }else{ ?>
	    	<label>Code:</label><input type="text" name="code" value="<?=get_coupon_id(); ?>">
       <? } ?>
    </p>
    <br />
    
    <p><label>Discount($):</label><input type="text" name="amount" value="<?=$row[amount]; ?>"></p><br />
    
    <p><label>Start Date:</label><? get_calendar("start_date", $row[start_date]); ?></p><br />
    
    <p><label>End Date:</label><? get_calendar("end_date", $row[end_date]); ?></p><br />
    
	<p><label>Available:</label>
       <input type="radio" name="active" value="1" <?=set_checked($row[active], 1); ?>>Yes
       <input type="radio" name="active" value="0" <?=set_checked($row[active], 0); ?>>No
	</p>    
    
    
</fieldset>
<?

function get_coupon_id(){
	
	$coupon_code = "FP".base64_encode(date("Ymd").get_random_password(10));
	
	$sql = " select * from tbl_coupon_one_time where code = '$coupon_code'";
	
	if ($result =  mysql_query($sql)){

		$num_rows = mysql_num_rows($result);

		if ($num_rows < 1){
			return $coupon_code;
		}

	}else
		echo $sql;

}

?>