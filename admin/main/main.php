<?
//echo "1.5user_id: ".$_SESSION['user_id']."project: ".$_SESSION['project']."project: "."<br/>";
include("../include/init.php");
include("../include/excel_reader2.php");
include("../include/html_head.php");

//*** sys func
	$func_id = func_id();


//*** func page
	$func_pg = func_pg();


//*** get function page
	if ($func_id == 0 && empty($func_pg)){
	
		$func_page = "welcome";
		$func_folder = "main";
		
	}else{
		$func_page = $func_pg;
		$func_folder = get_field('sys_function', 'folder', $func_id);
		
	}


//*** get user right
	$_SESSION["sys_read"] 	= get_field("sys_function_right", "sys_read", get_group_right_id($_SESSION['func_id']));
	$_SESSION["sys_write"] 	= get_field("sys_function_right", "sys_write", get_group_right_id($_SESSION['func_id']));
	$_SESSION["sys_delete"] = get_field("sys_function_right", "sys_delete", get_group_right_id($_SESSION['func_id']));
	$_SESSION["sys_print"] 	= get_field("sys_function_right", "sys_print", get_group_right_id($_SESSION['func_id']));
	$_SESSION["sys_export"] = get_field("sys_function_right", "sys_export", get_group_right_id($_SESSION['func_id']));


?>
<body>

	<div id="container">

		<!-- header start -->
		<div id="header">
			<div id="sys_info">
				<div id="left">
					<!--div><h2 style="line-height:20px; margin:4px"><?=get_cfg("company_name")?></h2></div-->
					<div>User: <?=$_SESSION['user']?></div>
					<div>User Group: <?=$_SESSION['user_group'] ?></div>
				</div>
				<div id="right">
				<?php
				if ( isset($_SERVER["HTTP_X_FORWARDED_FOR"]) )  
					echo "<div>IP:".$_SERVER['HTTP_X_FORWARDED_FOR']."</div>";
				else
					echo "<div>IP:".$_SERVER['REMOTE_ADDR']."</div>";
				?>
					<!--<div>REMOTE IP: <?=$_SERVER['REMOTE_ADDR']?></div>-->
					<div><a class="boldbuttons" href="../system/logout.php" style="color:#FFFFFF"><span>Logout</span></a></div>
				</div>
				<br class="clear">
			</div>
		</div>
		<!-- header end -->


		<!-- menu start -->
		<div id="main_menu">
			<? include("../include/top_menu.php"); ?>
			<br class="clear">
		</div>
		<!-- menu end-->


		<!-- content start -->
		<div id="content">
			<div id="content-curvy-corners">
				<div id="content-curvy-corners-min-height">
					<?
					
						if (file_exists("../".$func_folder."/".$func_page.".php"))
							include("../".$func_folder."/".$func_page.".php");

						else
							include("../main/welcome.php");
						
					?>
				</div>
			</div>
		</div>
		<!-- content end -->
        
		<br class="clear" />
        
	</div>
	
	<!-- footer start -->
	<div id="footer" class="copyright">

	</div>		
	<!-- footer end -->	

</body>
<?
include("../include/html_footer.php");
?>