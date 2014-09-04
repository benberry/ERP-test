<fieldset>

    <legend>Product without options</legend>
    
    <? if ($_SESSION["sys_delete"]) { ?>
	    <p><label>Export:</label><input type="button" value="Download" onclick="location='../product-export/export.php'" /></p>
    
    <? } ?>
    
    <? if ($_SESSION["sys_delete"]) { ?>
    	<p><label>Import:</label><input type="file" name="temp_file_1"><input type="button" value="Upload" onclick="javascript:form_action(1)" /></p>
    
    <? } ?>

	<? if ($_SESSION["sys_delete"]) { ?>
    	<p><label>client Import:</label><input type="file" name="temp_client_file_1"><input type="button" value="Upload" onclick="javascript:form_action(5)" /></p>
    
    <? } ?>    
	
	

</fieldset>

<!--
<fieldset>

	<legend>Product with options</legend>
	
	<p><label>Export::</label><input type="button" value="Download" /></p>
    
    <p><label>Import:</label><input type="file" name=""><input type="button" value="Upload"  onclick="javascript:form_action(2)" /></p>	

</fieldset>
-->