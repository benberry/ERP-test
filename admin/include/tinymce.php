<!-- Start TinyMCE -->
<script type="text/javascript" src="../../plug-in/tiny_mce/tiny_mce.js"></script>
<script language="JavaScript">
<!--
/************************************************************************************************************************************
********************* TinyMCE
************************************************************************************************************************************/

	tinyMCE.init(
	{
		// General options
		mode : "textareas",
		editor_selector : "richeditor",
		theme : "advanced",
		language : "en",
		width:	600,
		height:	300,
		
		document_base_url:"http://192.168.1.112",
        remove_script_host:false,
		relative_urls:false,

		plugins : 		"safari, pagebreak, style, layer, table, save, advhr, advlink, advimage, emotions, iespell, inlinepopups, insertdatetime, preview, media, searchreplace, print, contextmenu, paste, directionality, fullscreen, noneditable, visualchars, nonbreaking, xhtmlxtras, template, attribs, ",

		// Theme options
		theme_advanced_buttons1 : "	bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect,|,forecolor,backcolor",
		// Theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image",
		// Theme_advanced_buttons3 : "tablecontrols,|,removeformat,visualaid,|,sub,sup,|,charmap,media",
		// Theme_advanced_buttons4 : ",cleanup,code,|,insertdate,inserttime,preview,|,forecolor,backcolor,|,fullscreen,|,insertlayer,moveforward,movebackward,absolute,styleprops,|,emotions,attribs,pagebreak,advhr",


		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,
		theme_advanced_resize_horizontal : false,

		// Example content CSS (should be your site CSS)
		//content_css : "css/content.css" + new Date().getTime(),

		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "lists/template_list.js",
		external_link_list_url : "lists/link_list.js",
		external_image_list_url : "lists/image_list.js",
		media_external_list_url : "lists/media_list.js",


		// file manager
		file_browser_callback : "call_file_manager",


		// Replace values for the template plugin
		template_replace_values : {
		// username : "Some User",
		// staffid : "991234"
			username : "",
			staffid : ""			
		}
	}
	);

	function call_file_manager(field_name, url, type, win){
		/*
		* Path to the jv_file_manager.php, either absolute or relative(to the tiny's plug-in page)
		*/
		var popup_url = "/<?=get_cfg("project_folder")?>admin/file-upload/pop_image_mgnt.list.php";

		switch(type){
			case "image":
				popup_url += "?type=image";
				break;
			
			case "media":
			case "flash":
			case "file":
				popup_url += "?type=file";
				break;
		}

		jv_win = win;
		jv_field_name = field_name;

		window.open(popup_url, "file_manager", "modal,width=800,height=600,scrollbars=1");

		return false;

	}
//-->
<!-- End TinyMCE -->
</script>
