//	category
	function goto_parent(page, cat_id){
		window.location = "../main/main.php?func_pg="+page+"&cat_id="+cat_id;
	}
	
	function add_category(page, cat_id){
		window.location = "../main/main.php?func_pg="+page+"&cat_id="+cat_id;	
	}		
	
	function edit_category(page, cat_id, pid){
		window.location = "../main/main.php?func_pg="+page+"&cat_id="+cat_id+"&id="+pid;
	}
	
	function delete_category(tbl, cat_id, id)
	{
		fr = document.frm
		ans = confirm("OK to delete?")

		if (ans){
			window.location = '../main/main.php?func_pg=cat-delete&act=3&tbl='+tbl+'&id='+id+'&cat_id='+cat_id;

		}
	
	}	
	
	function sort_category(tbl, cat_id, id, sort_act){
		fr = document.frm
		if (fr.pg_num)
			pg_num = fr.pg_num.value
		else
			pg_num = 1

		window.location = '../' + folder + '/cat-sort.php?sort_act='+sort_act+'&tbl='+tbl+'&cat_id='+cat_id+'&id='+id+'&pg_num='+pg_num;
		
	}			



//	item
	function goto_item(page, cat_id, pid){
		fr = document.frm
		if (fr.pg_num)
			pg_num = fr.pg_num.value
		else
			pg_num = 1			

		window.location = "../main/main.php?func_pg="+page+"&cat_id="+cat_id+"&id="+pid+"&pg_num="+pg_num;
		
	}	
	
	function add_item(page, cat_id){

		window.location = "../main/main.php?func_pg="+page+"&cat_id="+cat_id;

	}
	
	function sort_item(tbl, cat_id, id, sort_act)
	{

		fr = document.frm

		window.location = '../' + folder + '/item-sort.php?sort_act='+sort_act+'&tbl='+tbl+'&cat_id='+cat_id+'&id='+id+'&pg_num='+fr.pg_num.value;
		
	}
	
	
	function add_option_to_product(page, num){

		fr = document.frm
		
		checkbox_del_id(num);
		
		if (fr.del_id.value == '')
		{
			alert("Please select items")
			return
			
		}
			
		fr.method = "post";
		fr.target = "_self";
		fr.action = "../main/main.php?func_pg=add-options";
		fr.submit()			
	
	}
	