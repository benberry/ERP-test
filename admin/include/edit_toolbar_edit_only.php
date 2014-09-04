<div id="tool">
        <? if ($_SESSION["sys_write"]) { ?>
			<a class="boldbuttons" href="javascript:form_action(1)"><span>Save</span></a>
			
        <? } ?>
		
		<a class="boldbuttons" href="javascript:go_back('<?=$prev_page?>', '<?=$list_page_num?>')"><span>Back</span></a>
        
</div>