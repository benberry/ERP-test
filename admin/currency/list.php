<?
//*** Default
	$func_name = "Client";
	$tbl = "tbl_currency";
	$curr_page = "list";
	$edit_page = "edit";
	$action_page = "update";
	$page_item = 12;

//*** Request
	

//*** SQL Statement - start
	$sql = "
		select
			*
		from
			$tbl
		where
			deleted=0

		";
	
	//*** Order by start
	if (empty($_POST["order_by"]))
		$order_by = "sort_no"; 
	else
		$order_by = $_POST["order_by"];
	
	if (empty($_POST["ascend"]))
		$ascend = "asc";
	else
		$ascend = $_POST["ascend"];
	
	if (!empty($order_by))
	{
		$sql .= "
		order by
			$order_by
			$ascend
		";
	}
	//*** Order by end
//*** SQL Statement - end


if ($result=mysql_query($sql))
{

	$num_rows = mysql_num_rows($result);
	
	if ($num_rows > 0 )
		$pbar = paging_bar($page_item, $num_rows);

?>
			<script>	
			
				function set_sort_no(id, sort_act)
				{
					fr = document.frm
			
					window.location = '../main/std_sort_no.act.php?tbl=<?=$tbl?>&rtn_page=<?=$curr_page?>&sort_act='+sort_act+'&id='+id+'&pg_num='+fr.pg_num.value+'&order_by='+fr.order_by.value+'&ascend='+fr.ascend.value;
					
				}
				
				function form_search(){
				
					fr = document.frm
					
					fr.action = "<?=$_SERVER['PHP_SELF']?>?<?=$_SERVER['QUERY_STRING']?>";
					fr.method = "post";
					fr.target = "_self";
					fr.submit();
				
				}				
				
			</script>
			<form name="frm">
			<input type="hidden" name="tbl" value="<?=$tbl?>">
			<input type="hidden" name="act" value="">
			<input type="hidden" name="order_by" value="<?=$order_by?>">
			<input type="hidden" name="ascend" value="<?=$ascend?>">
			<input type="hidden" name="del_id" value="">

			<div id="list">
				<div id="title"><?=$func_name?></div>
				<!--<div id="search"></div>-->
				<div id="tool">
					<div id="paging">
						<?	
							echo $pbar[1];
							echo $pbar[2];
							echo $pbar[4];
							echo $pbar[3];
							echo $pbar[5];
						?>
					</div>
					<div id="button">
					<? include("../include/list_toolbar.php");	?>
					</div>
					<br class="clear">
				</div>
                <!--ul>
                    <li>Hongkong Dollar ( AUDHKD=x )</li>
                    <li>Other <br />
                        US Dollar ( AUDUSD=x )<br />
                        British Pounds ( AUDGBP=x )<br />
                        EURO ( AUDEUR=x )<br />
                    </li>
                </ul-->
				<table>
					<tr>
						<th width="50"><input class="checkbox" type="checkbox" name="select_all" onclick="checkbox_select_all(<?=$page_item?>)"></th>
						<th>Client Code</th>
						<th>Client Name<th>
						   <!--? set_sequence("Status","active", $order_by, $ascend, $curr_page) ?-->
						   Status
						</th>
					</tr>
				
				<?
				
					if ($num_rows > 0)
					{
					
				
						mysql_data_seek($result, $pbar[0]);
					
						for($i=0; $i < $page_item ;$i++)
						{
						
							if ($row = mysql_fetch_array($result))
							{
							?>
							<tr>
								<td><input class="checkbox" type="checkbox" name="cb_<?=$i?>" value="<?=$row[id]?>"></td>

								<td onclick="goto_page('<?=$edit_page?>', '<?=$row[id]?>')"><?=$row[name_1]?></td>
								<td onclick="goto_page('<?=$edit_page?>', '<?=$row[id]?>')"><?=$row[symbol_1]?></td>
								<td>
								<?=get_active_icon($tbl, $row[id], $row[active], $curr_page, $_REQUEST['pg_num'])?>
								<a href="javascript:set_sort_no('<?=$row[id]?>', 1)"><img src="../images/up.png" width="25" border="0" title="sequence up"></a>
								<a href="javascript:set_sort_no('<?=$row[id]?>', 2)"><img src="../images/down.png" width="25" border="0" title="sequence down"></a>									
								</td>
							</tr>
							<?
							}
					
						}
					
					}
					
				?>			
				</table>
	
			</div>

		</form>
		
	<?
	
}
else
	echo $sql;	

?>
