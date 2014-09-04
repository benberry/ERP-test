<?
//echo "2user_id: ".$_SESSION['user_id']."project: ".$_SESSION['project']."project: "."<br/>";
function start_session($expire = 0)
{
    if ($expire == 0) {
        $expire = ini_get('session.gc_maxlifetime');
    } else {
        ini_set('session.gc_maxlifetime', $expire);
    }

    if (empty($_COOKIE['PHPSESSID'])) {
        session_set_cookie_params($expire);
        session_start();
    } else {
        session_start();
        setcookie('PHPSESSID', session_id(), time() + $expire);
    }
}

//	print_r(session_get_cookie_params());
//echo "<br/>".ini_get("session.gc_maxlifetime")."<br/>"; 

	//session_start();
	start_session(99999);
//echo "3user_id: ".$_SESSION['user_id']."project: ".$_SESSION['project']."project: "."<br/>";
	//print_r(session_get_cookie_params());
//echo "<br/>".ini_get("session.gc_maxlifetime");

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
