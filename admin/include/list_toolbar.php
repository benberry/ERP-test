				
		<? if ($_SESSION["sys_write"]) { ?>
			<a class="boldbuttons" href="javascript:add_new('<?=$edit_page?>')"><span>Add</span></a> 
			
        <? } ?>
        
        <? if ($_SESSION["sys_delete"]) { ?>
			<a class="boldbuttons" href="javascript:del_item('<?=$action_page?>', '<?=$page_item?>')"><span>Delete</span></a> 

        <? } ?>
		
		
        <!--
        <input type="button" value="New" class="tool1" onclick="add_new('<?=$edit_page?>')">
        <input type="button" value="Delete" class="tool1" onclick="del_item('<?=$action_page?>', '<?=$page_item?>')">        
				
        <input type="button" value=" 列印 " class="tool1">
        <input type="button" value=" to pdf " class="tool1">        
        <input type="button" value=" to excel " class="tool1">
		
        -->