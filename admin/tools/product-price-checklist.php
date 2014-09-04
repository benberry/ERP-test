<?
	### include
	    //include("../include/init.php");

?>
<style>
	body{ font-size:10px;}
	table{ font-size:10px;}	
</style>
<body>
<h1>Product Price Checklist - (Source from Phoenix)</h1>
<table>
	<tr>
    	<td width="600" valign="top">
            <table width="100%">
            	<tr>
                	<td>Digital Camera</td>
                    <td align="right">Price(HKD rate 7.8)</td>
            	</tr>
                <?
                		
					$sql = "
						select
							*
						from
							tbl_product
						where 
							cat_id=3
							and brand_id=23
							and active=1
							and deleted=0
						order by
							name_1	
					";
					
					if ($result = mysql_query($sql)){
					
						while ($row = mysql_fetch_array($result)){
							
							?>
							<tr>
								<td><?=$row[name_1]; ?></td>
								<td align="right"><?=number_format(($row[price_1]*7.8), 2);?></td>
							</tr>
							<?

						}
					
					}
					
				?>
            </table>
        </td>
    </tr>
    <tr>
    	<td width="600" valign="top">
        	<table width="100%">
            	<tr>
                	<td>DSLR</td>
                    <td align="right">Price(HKD rate 7.8)</td>
            	</tr>
                <?
                		
					$sql = "
						select
							*
						from
							tbl_product
						where 
							cat_id=5
							and brand_id=23
							and active=1
							and deleted=0
						order by
							name_1	
					";
					
					if ($result = mysql_query($sql)){
					
						while ($row = mysql_fetch_array($result)){
							
							?>
							<tr>
								<td><?=$row[name_1]; ?></td>
								<td align="right"><?=number_format(($row[price_1]*7.8), 2);?></td>
							</tr>
							<?

						}
					
					}
					
				?>
            </table>
        
        </td>
    </tr>
    <tr>        
    	<td width="600" valign="top">
        	<table width="100%">
            	<tr>
                	<td>Lenses</td>
                    <td align="right">Price(HKD rate 7.8)</td>
            	</tr>
                <?
                		
					$sql = "
						select
							*
						from
							tbl_product
						where 
							cat_id=10
							and brand_id=23
							and active=1
							and deleted=0
						order by
							name_1	
					";
					
					if ($result = mysql_query($sql)){
					
						while ($row = mysql_fetch_array($result)){
							
							?>
							<tr>
								<td><?=$row[name_1]; ?></td>
								<td align="right"><?=number_format(($row[price_1]*7.8), 2);?></td>
							</tr>
							<?

						}
					
					}
					
				?>
            </table>
        
        </td>
    </tr>
</table>
</body>