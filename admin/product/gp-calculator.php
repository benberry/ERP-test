<div style=" width:500px; float:left;">
	<script>
        function cal_gp(){

            $.get('../product/gp-calculator-result.php', {

                    cal_unit_cost: $("#cal_unit_cost").val(),
                    cal_gp_percent:  $("#cal_gp_percent").val(),
                    cal_price_balancer: $("#cal_price_balancer").val(),
//                    cal_price_adjustment: $("#cal_price_adjustment").val(),
                    cal_price_profit: $("#cal_price_profit").val(),
                    cal_rate: $("#cal_rate").val(),
                    cal_weight: $("#cal_weight").val()

                }, function(data){
					
                $("#cal_result").html(data);

            });

        }

        function update_to_product(){
            fr = document.frm;
            //fr.price_1.value 			= fr.cal_result_display_price.value;
            fr.unit_cost.value 			= fr.cal_unit_cost.value;
            // fr.gp_percent.value 		= fr.cal_gp_percent.value;
            fr.price_profit.value 		= fr.cal_price_profit.value;		
            fr.price_balancer.value 	= fr.cal_price_balancer.value;
            // fr.price_adjustment.value= fr.cal_price_adjustment.value;
			
        }

    </script>

    <table width="100%" border="1" bordercolor="#eee" style="border-collapse:collapse">
        <tr>
            <td colspan="2"><b>Price Calculator</b></td>
        </tr>
        <tr>
            <td>Unit Cost (HKD):</td>
            <td align="right"><input type="text" name="cal_unit_cost" id="cal_unit_cost" value="<?=$row[unit_cost]; ?>" style="width:100px; text-align:right; " /></td>
        </tr>
        <!--
        <tr>
            <td>G/P:</td>
            <td align="right"><input type="text" name="cal_gp_percent" id="cal_gp_percent" value="<?//=$row[gp_percent]; ?>" style="width:100px; text-align:right;" /></td>
        </tr>
        -->
        <tr>
            <td>Profit (HKD)(+/-):</td>
            <td align="right"><input type="text" name="cal_price_profit" id="cal_price_profit" value="<?=$row[price_profit]; ?>" style="width:100px; text-align:right;" /></td>
        </tr>
        <tr>
            <td>Balancer (HKD)(+/-):</td>
            <td align="right"><input type="text" name="cal_price_balancer" id="cal_price_balancer" value="<?=$row[price_balancer]; ?>" style="width:100px; text-align:right; " /></td>
        </tr>
        <tr>
            <td>Rate:</td>
            <td align="right">
            	<input type="hidden" name="cal_rate" id="cal_rate" value="<?=get_rate(); ?>" />
                <?=get_rate(); ?>
			</td>
        </tr>
        <tr>
            <td>Weight:</td>
            <td align="right">
            	<input type="hidden" name="cal_weight" id="cal_weight" value="<?=$row[weight]; ?>" />
                <?=$row[weight]; ?>kg
            </td>
        </tr>
        <tr>
            <td><input type="button" value="update price" onclick="update_to_product();" /></td>
            <td align="right"><input type="button" value="calculate" onclick="cal_gp(); "/></td>
        </tr>
    </table>
    
    <br />
    
    <div id="cal_result"></div>
    <script>cal_gp();</script>
</div>