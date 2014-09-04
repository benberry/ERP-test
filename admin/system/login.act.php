<? 

//session_start(); 
//$lifeTime = 3600;   //
//setcookie(session_name(), session_id(), time() + $lifeTime, "/");   

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

start_session(99999);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title> CMS </title>
<link href="../css/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<?
require_once("../../library/config.func.php");
require_once("../../library/common.func.php");

$func_id = get_cfg("login_redirect_id");
$func_pg = get_cfg("login_redirect_page");

$user = $_POST["user"];
$pwd = $_POST["password"];
$pwd = base64_encode($pwd);

$sql = " select * from sys_user 
		 where user='$user' 
		 and password='$pwd' 
		 and deleted=0 
		 and active=1 
		 and '$user'<>'' 
		 and '$pwd'<>'' ";
		 
@mysql_query($sql) or die('Could not connect: ' . mysql_error());

if ($rows = mysql_query($sql))
{

	if (mysql_num_rows($rows) > 0)
	{
	
		$row = mysql_fetch_array($rows);
		
		$_SESSION['project']=get_cfg("project");
		$_SESSION['user']=$row[user];
		$_SESSION['user_id']=$row[id];
		$_SESSION['user_group']=get_field('sys_user_group', 'name_1', $row[sys_user_group_id]);
		$_SESSION['user_group_id']=$row[sys_user_group_id];

		$curr_page = 1;
		
		/*
		echo $sql."<br>";
		echo mysql_num_rows($rows)."<br>";
		echo $_SESSION['user']."<br>";
		echo $_SESSION['user_id']."<br>";
		echo $_SESSION['user_group']."<br>";
		echo $_SESSION['user_group_id']."<br>";
		*/
		//echo "1user_id: ".$_SESSION['user_id']."project: ".$_SESSION['project']."project: ".get_cfg("project")."<br/>";
		echo "
		
		<script>
			//alert('../main/main.php?func_id={$func_id}&func_pg={$func_pg}')
			window.location = '../main/main.php?func_id={$func_id}&func_pg={$func_pg}';
//window.location = 'http://www.android-enjoyed.com/export/erp/admin/main/main.php?func_id=143&func_pg=oms.so';
		</script>
		";
		
	}
	else
	{
	
		echo "
		<script>
			alert('Login name or password is incorrect.')
			window.location = '../system/login.php';
		</script>		
		";
	
	}	
	
}else{
	echo $sql;

}

?>
</body>
</html>