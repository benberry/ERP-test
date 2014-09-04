<?

 ## init
 include("../include/init.php");
 $tbl = "tbl_attribute";
 
 
 ## request
 extract($_REQUEST);


 
 ## get record
 $sql = "
 	select 
		* 
	from 
		$tbl
	
	where 
		active=1
		and deleted=0
		and cat_id=$cat_id
		
	order by
		sort_no

	";
	
	
  //echo $sql."<br />";
	
  if($result = mysql_query($sql)){
  
  	$num_rows = mysql_num_rows($result);
	
	if ($num_rows > 0){
	
	  ?>
	  
	  	<div>
			<table width="100%" style="margin:10px">
				<tr>
					<th width="100"></th>
					<th>Name</th>
					<th width="100">Weight(kg)</th>
					<th width="100">Price($)</th>
				</tr>
				<?

					while ($row=mysql_fetch_array($result)){

						?>
						<tr onclick="set_lookup_<?=$obj_name?>('<?=$row[id];?>', '<?=$row[user];?> (<?=$row[first_name]; ?> <?=$row[last_name]; ?>)')">
							<td><input type="checkbox" name="add_attribute_<?=$row[id]; ?>" value="1"></td>						
							<td><?=$row[name_1]; ?></td>
							<td><?=number_format($row[weight], 2);?></td>
							<td><?=number_format($row[price_1], 2);?></td>
						</tr>
						<?

					}

				?>
			</table>
            <input type="button" value="Add" style="float:left" onclick="add_attribute();">
	  	</div>
	  <?
	  
	}else{

	  ?>
	  	<center>
			
			<div style="margin:100px;"><b>no record</b></div>

		</center>
	  <?

	}
  
  }else{
  	//echo $sql;
  }

?>