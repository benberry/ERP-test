<?
if($_SERVER["HTTPS"] != "on")
{
    header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
    exit();
}

#request
extract($_REQUEST);

#include 
require_once("../../library/config.func.php");
require_once("../../library/common.func.php");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CMS</title>

	<link href="../css/style.css" rel="stylesheet" type="text/css" />
	<script language="JavaScript" src="../../js/utility.js"></script>
	<script language="JavaScript" src="../../js/validation.js"></script>

	<!-- jQuery -->
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>

	<!-- prettyForms -->
	<script type="text/javascript" src="../../plug-in/pretty-forms/prettyForms.js"></script>
	<link rel="stylesheet" href="../../plug-in/pretty-forms/prettyForms.css" type="text/css" media="screen" />

</head>

<script>

	function form_submit(){

		fr = document.frm

		if (js_is_empty(fr.user)){

		}else if (js_is_empty(fr.password)){

		}else{
			fr.submit();

		}

	}

</script>


<body id="login_container" bgcolor="#eee">
	<form action="login.act.php" method="post" target="_self" name="frm">
		<div align="center">
			<div style="height:200px"></div>
			
			<!--<h1><?=get_cfg("company_name");?></h1>-->
			<!--<div class="title">Content Management System</div>-->
			<div id="login">

				<div id="login-form" style="padding-left:40px;">
                
					<p><span class="fixed">LOGIN ID:</span><input type="text" id="user" name="user" maxlength="50" style="width:180px"><br class="clearAll" /></p>
                    
					<p><span class="fixed">PASSWORD:</span><input type="password" id="password" name="password" maxlength="50" style="width:180px"><br class="clearAll" /></p>
                    
					<input id="submit" type="submit" value="LOGIN" style=" float:right; margin-right:26px; ">
                    <br class="clear" />
                    
				</div>
                
				<div id="copyright" class="copyright"></div>
                
                <br class="clear" />
			</div>
		</div>
	</form>
</body>
</html>
