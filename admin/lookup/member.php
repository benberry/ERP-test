<?

 ## init
 include("../include/init.php");
 $tbl = "tbl_member";
 
 
 ## request
 extract($_REQUEST);


 
 ## get member record
 $sql = "
 	select 
		* 
	from 
		tbl_member	
	
	where 
		active=1
		and deleted=0

	";
	
	
	## search keyword
	if ($keyword != '')
		$sql .= " and (
			user like '%$keyword%'
			or first_name like '%$keyword%'
			or last_name like '%$keyword%'
			or phone_1 like '%$keyword%'
			or phone_2 like '%$keyword%'
			or email like '%$keyword%'
			
		)
		";
	
  echo $sql."<br />";
	
  if($result = mysql_query($sql)){
  
  	$num_rows = mysql_num_rows($result);
	
	if ($num_rows > 0){
	
	  ?>
	  
	  	<div class="lookup-table">
			Member Lookup | <span style="font-size:9px">please enter the keyword (eg. member id, name, phone, email...)</span>
			
			<table width="100%" style="margin-top:5px">
				<tr>
					<th></th>
					<th>Name</th>
					<th>Phone</th>
					<th>Email</th>
				</tr>
				<?

					while ($row=mysql_fetch_array($result)){

						?>
						<tr onclick="set_lookup_<?=$obj_name?>('<?=$row[id];?>', '<?=$row[user];?> (<?=$row[first_name]; ?> <?=$row[last_name]; ?>)')">
							<td><input type="checkbox"></td>						
							<td><?=$row[first_name]; ?>&nbsp;<?=$row[last_name]; ?></td>
							<td><?=$row[phone_1]; ?></td>
							<td><?=$row[email]; ?></td>
						</tr>
						<?

					}

				?>
			</table>
	  	</div>
	  <?
	  
	}else{

	  ?>
	  	<center>
			
			<div style="margin:100px;"><b>no record</b></div>

		</center>
	  <?

	}
  
  }else
  	echo $sql;

?>