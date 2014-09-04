<?

 ## init
 include("../include/init.php");
 $tbl = "tbl_product";
 
 
 ## request
 extract($_REQUEST);



 ## get member record
 $sql = "
 	select 
		p.*

	from
		$tbl p
		left join tbl_product_category pc on pc.id = p.cat_id
	
	where 
		p.active=1
		and p.deleted=0
		and pc.active=1
		and pc.deleted=0
	";
	
	
	## search keyword
	if ($keyword != '')
		$sql .= " and (
			p.name_1 like '%$keyword%'
		)
		";
		
 $sql .= " order by p.name_1 ";
  echo $sql."<br />";
	
  if($result = mysql_query($sql)){
  
  	$num_rows = mysql_num_rows($result);
	
	if ($num_rows > 0){
	
	  ?>
	  	<style>
			.lookup-table tr:hover{ background-color:#FFC; cursor: pointer; }
		</style>
	  	<div class="lookup-table">
			<h3>please enter the keyword (eg. product_code, name)</h3>
			<table width="100%">
				<tr>
					<th>Name</th>
					<th align="right">Price</th>
					<th align="right">Weight</th>
					<th>Status</th>                    
				</tr>
				<?

					while ($row=mysql_fetch_array($result)){

						?>
						<tr onclick="set_lookup_<?=$obj_name?>('<?=$row[id];?>', '<?=$row[name_1];?>'); ">
							<td style="text-align:left; "><?=$row[name_1]; ?></td>
							<td style="text-align:right; "><?=number_format(get_price($row[id]), 2); ?></td>
							<td style="text-align:right; "><?=$row[weight]; ?></td>
							<td><?=get_stock_status($row[stock_status]); ?></td>
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