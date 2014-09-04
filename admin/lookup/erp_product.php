<?

 ## init
 include("../include/init.php");
 $tbl = "tbl_erp_product";
 
 
 ## request
 extract($_REQUEST);




 ## get product record
 $sql = "
 	select 
		*, current_qty-so_qty+po_qty ava_qty

	from
		$tbl 
	where   id>0
	
	";
	
	
	## search keyword
	if ($keyword != '')
		$sql .= " and (
			name like '%".addslashes($keyword)."%' or sku like '%".addslashes($keyword)."%'
		)
		";
		
 $sql .= " order by sku LIMIT 100";
  //echo $sql."<br />";
	
  if($result = mysql_query($sql)){
  
  	$num_rows = mysql_num_rows($result);
	
	if ($num_rows > 0){
	
	  ?>
	  	<style>
			.lookup-table tr:hover{ background-color:#FFC; cursor: pointer; }
		</style>
	  	<div class="lookup-table">
			<h3>please enter the keyword (eg. SKU, name)</h3>
			<table width="100%">
				<tr>
					<th>SKU</th>
					<th>Name</th>
					<th align="right">Current Stock</th>
					<th align="right">SO Qty</th> 
					<th align="right">PO Qty</th>                   
					<th align="right">Available Qty</th>                   
				</tr>
				<?

					while ($row=mysql_fetch_array($result)){

						?>
						<tr onclick="set_lookup_<?=$obj_name?>('<?=$row[id];?>', '<?=addslashes($row[sku]).", ".addslashes($row[name]);?>'); ">
							<td style="text-align:left; "><?=$row[sku]; ?></td>
							<td style="text-align:left; "><?=$row[name]; ?></td>						<td style="text-align:right; "><?=$row[current_qty]; ?></td>
							<td style="text-align:right; "><?=$row[so_qty]; ?></td>
							<td style="text-align:right; "><?=$row[po_qty]; ?></td>
							<td style="text-align:right; "><?=$row[ava_qty]; ?></td>
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