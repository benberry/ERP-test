<?

	### include
	include("../include/init.php");
	include("../include/html_head.php");
	

?>
<body>
<?
	
	### request
	extract($_REQUEST);
	
	$email_id = $id;
		
	
	### get group
	$sql = " select * from tbl_email_group where active=1 and deleted=0 order by name_1";

	if ($result = mysql_query($sql)){
	
		$int = 1;
		
		while ($row = mysql_fetch_array($result)){
		
			if ($_REQUEST["email_group_".$row[id]] == 1){
			
				if ($int==1)
					$where .= " cat_id=".$row[id];

				else
					$where .= " or cat_id=".$row[id];
					
				$int++;	

			}
		
		}

	
	}else
		echo $sql;
		
		
	if ($where != ''){
		
	
		### get email_list
		$sql = "
				select 
					* 
					
				from 
					tbl_email_list 
					
				where 
					active=1 
					and deleted=0 
					and ($where)
					
				order by
					first_name
					
				";
		
		if ($result = mysql_query($sql)){
			
			$num_rows=mysql_num_rows($result);
			
			$int = 1;
		
			while ($row = mysql_fetch_array($result)){
			
				?>
				
					<script>
						
						$(document).ready(function(){
						
							$.get("send-ajax.php", {id: '<?=$row[id];?>', email_id: '<?=$email_id?>'}, function(data){
							
								$("#current").text('<?=$int;?>');
								$("#error").append(data);
									
								<? if ($num_rows==$int){?>
									$("#loading").css("display", "none");
									$("#status").text("Completed");
									$("#button").val("CLOSE");
									$("#current").val("<?=$num_rows?>");
								<? } ?>
							
							});
						
						});
										
					</script>
				
				<?
				
				$int++;
			
			}
		
		}else
			echo $sql;
?>
	<br />
	<center>
		<img id="loading" src="../images/loading.gif" border="0" width="100">
		<h1><span id="status">Sending</span> ... <span id="current">0</span>/<span id="total"><?=$num_rows?></span></h1>
		<div id="error"></div>
		<div><input type="button" id="button" value="STOP" onClick="window.close();"></div>
	</center>	

<?

	}else{
	
		?>
	<br />
	<center>
		<h1><span id="status">Please select group</span></h1>
		<div id="error"></div>
		<div><input type="button" id="button" value="CLOSE" onClick="window.close();"></div>
	</center>	
		
		<?
		
	}

?>
</body>