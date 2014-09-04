<fieldset class='single-form'>
<table>
	<tr>
		<td width="200"><br></td>
		<td width="20"><br></td>                    
		<td width="*"><br></td>                    
	</tr>
	<tr>
		<td align="right">Seasonal Discount:</td>
		<td></td>
		<td>
			<?=set_checkbox("promo_item", get_field("tbl_product", "promo_item", $id), 1); ?>
			<input type="hidden" name="promo_discount" value="<?=get_field("tbl_discount", "discount", 1); ?>">
			<input type="hidden" name="promo_start_date" value="<?=get_field("tbl_discount", "from_date", 1); ?>">
			<input type="hidden" name="promo_end_date" value="<?=get_field("tbl_discount", "to_date", 1); ?>">			
		</td>
	</tr>
	<tr>
		<td><br></td>
		<td><br></td>                    
		<td><br></td>
	</tr>	
</table>
</fieldset>

