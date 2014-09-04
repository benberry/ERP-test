<?

	session_start();
	
	require_once("../../library/config.func.php");
	require_once("../../library/common.func.php");
	require_once("../../library/main.func.php");
	require_once("../../library/date.func.php");
	require_once("../../library/sql.func.php");
	require_once("../../library/paging.func.php");	
	require_once("../../library/sys-right.func.php");
	require_once("../../library/file-upload.func.php");	

	require_once("../../library/item.func.php");
	require_once("../../library/category.func.php");
	require_once("../../library/member.func.php");
	require_once("../../library/product.func.php");	
	require_once("../../library/order-management.func.php");	

	check_system_user_login();


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CMS</title>
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="../../js/utility.js"></script>
<script language="javascript" src="../../js/validation.js"></script>