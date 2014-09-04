<script>
	
	function form_send_email(){
	
		win = window.open("", "UOLMBAAA","width=500,height=300,scrollbars=no,location=no,menubar=no,status=no,titlebar=no,toolbar,directories=no");
		win.focus();
	
		fr = document.frm;
		
		fr.action = "../email-compose/send.php";
		fr.target = "UOLMBAAA";
		fr.method = "post"
		fr.submit();
	
	}
	
</script>


<fieldset>
	<legend>Select Group</legend>
	<p>
	<?

		function get_email_group(){
	
		$sql = " select * from tbl_email_group where active=1 and deleted=0 order by name_1";
		
		if ($result = mysql_query($sql)){
		
			while ($row = mysql_fetch_array($result)){
			
				?><input type="checkbox" name="email_group_<?=$row[id]?>" id="email_group_<?=$row[id]?>" value="1"><?=$row[name_1]; ?><br/><?
			
			}
		
		}else
			echo $sql;
			
		}
		
		get_email_group();
		
	?>
	</p>
	<p><label></label>
	<a href="../../email-template/newsletter/index.php?id=<?=$id?>" target="_blank"><input type="button" value="Preview"></a><input type="button" value="Send" onClick="form_send_email();">
	</p>
</fieldset>


<fieldset>
	<legend>History</legend>
	<div class="inner_list">
	<table width="100%">

		<?
		
		function get_mail_history($id){
		
			$sql = " select * from tbl_email_history where parent_id=$id";
			
			if ($result = mysql_query($sql)){
			
				?>
				<tr>
                    <td>Total:</td>
                    <td><?=mysql_num_rows($result);?></td>
                    <td></td>
                </tr>
                <tr>
                    <th>Send Date</td>
                    <th>Email</td>
                    <th>Status</td>						
                </tr>
				<?
			
				while ($row = mysql_fetch_array($result)){
		
					?>	
					<tr>
						<td><?=$row[send_date]?></td>
						<td><?=$row[email]?></td>
						<td><?=$row[active]?></td>
					</tr>
					<?
			
				}
		
			}
		
		}
		
		get_mail_history($id);
		
		?>
	</table>
	</div>
</fieldset>
