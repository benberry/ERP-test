<?
	### include
	// include("../include/init.php");
?>
<style>table td {font-size: 10px; font-family:"Century Gothic", Arial; padding: 0 5px; }</style>
<?
	
	### get records
	$sql="
		select
			pv.*,
			v.ip,
			v.http_referer

		from
			tbl_visitor_product_viewed pv
			left join tbl_visitor v on v.id=pv.visitor_id

		where
			(	select count(id) 
				from tbl_visitor_product_viewed 
				where product_id=pv.product_id
				and visitor_id=pv.visitor_id
			) > 1
			
		order by 
			pv.visitor_id
			
		limit 
			9999";
	
	### get record
	if ($result=mysql_query($sql)){
		
		$num_rows=mysql_num_rows($result);
		
		?><table cellpadding="0" cellspacing="0" border="1" bordercolor="#eee" style="border-collapse:collapse;" >
			<?
		
		echo "<h3>SOURCE FIX ... total: $num_rows</h3>";
		
		while ($row=mysql_fetch_array($result)){
			
			?><tr>
            <td><?=$row[create_date]; ?></td>
            <td><?=$row[id]; ?></td>            
            <td><?=$row[ip]; ?></td>            
            <td><?=$row[visitor_id]; ?></td>
            <td><?=$row[product_id]; ?></td>            
            <td><?=get_field("tbl_product", "name_1", $row[product_id]); ?></td>
            <td><?

			//sub_string($row[http_referer], 100);
            $referer_domain = $row[http_referer];

			$referer_domain = str_replace("http://", "", $referer_domain);
			
			echo substr($referer_domain, 0, strpos($referer_domain, "/"));
			
//			echo $referer_domain;

			?>
            </td>
            <td>
            	<? check_dup($row[visitor_id], $row[product_id], $row[id]); ?>
            </td>
            </tr>
			<?
			
		}

		?></table><?
			
	}else
		echo $sql;

		
	function check_dup($vid, $pid, $id){
		
		$sql = "select id
				from tbl_visitor_product_viewed 
				where product_id=$pid
				and visitor_id=$vid";

		if ($result = mysql_query($sql)){
			
			$num_rows = mysql_num_rows($result);
			
			if ($num_rows > 1){

				$sql = "delete from tbl_visitor_product_viewed where id=$id";
				
				if (mysql_query($sql))
					echo "DELETED";
				else
					echo "ERROR";
				
				

			}

		}else
			echo $sql;

	}
?>