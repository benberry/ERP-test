<?php
if($_SERVER["HTTPS"] != "on")
{
    header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>ERP</title>
<link type="text/css" href="../css/style.css" rel="stylesheet" />
<link type="text/css" href="../../plug-in/SexyButtons/sexybuttons.css" rel="stylesheet" />

<!-- General -->
	<script language="javascript" src="../../js/utility.js"></script>
    <script language="javascript" src="../../js/validation.js"></script>

<!-- jQuery -->	
	<script src="https://code.jquery.com/jquery-1.8.0.min.js" type="text/javascript"></script>

<!-- jQuery-ui -->
<link type="text/css" href="../../plug-in/jquery-ui/css/custom-theme/jquery-ui-1.7.2.custom.css" rel="stylesheet" />	
	<script type="text/javascript" src="../../plug-in/jquery-ui/js/jquery-ui-1.7.2.custom.min.js"></script>

<!-- ddsmoothmenu -->

<!--<link rel="stylesheet" type="text/css" href="../../plug-in/ddsmoothmenu/ddsmoothmenu.css" />-->
	<script type="text/javascript" src="../../plug-in/ddsmoothmenu/ddsmoothmenu.js"></script>

<!-- JSCal2-1.7 -->
	<script src="../../plug-in/JSCal2-1.7/src/js/jscal2.js"></script>
    <script src="../../plug-in/JSCal2-1.7/src/js/lang/en.js"></script>
	<link rel="stylesheet" type="text/css" href="../../plug-in/JSCal2-1.7/src/css/jscal2.css" />
<!-- JSCal2-1.7 -->

<!-- ptTimeSelect -->
    <link rel="stylesheet" type="text/css" href="../../plug-in/ptTimeSelect/example/ui.core.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="../../plug-in/ptTimeSelect/example/ui.theme.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="../../plug-in/ptTimeSelect/example/css/timecntr/jquery-ui-1.7.1.custom.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="../../plug-in/ptTimeSelect/src/jquery.ptTimeSelect.css" media="screen" />
    <script type="text/javascript" language="JavaScript" src="../../plug-in/ptTimeSelect/src/jquery.ptTimeSelect.js"></script>
<!-- ptTimeSelect -->

<!-- colorPicker -->
	<script language="javascript" src="../../js/colorpicker.js"></script>
<!-- colorPicker -->

</head>