<fieldset class='single-form'>
<p><label>ebay Main Photo:</label><? get_image_upload_box($tbl, $id, 3, "vie_crop", "", $curr_page); ?></p>
<p>
    <textarea class="ebay-product-template">
        <table width="900" align="center" cellpadding="0" cellspacing="0" style=" border: 1px #999 solid; ">
            <tr>
                <td style="padding:20px;">
                    <h1 style="margin-top:20px; margin-bottom:30px; border-left: 10px #eee solid; border-bottom:1px #eee solid; padding-left:20px; font-family:Arial, Helvetica, sans-serif; color: #111; "><?=get_field("tbl_product", "name_1", $id)?></h1>
                    <!-- Product -->
                    <table width="100%" cellpadding="0" cellspacing="0" style="font-size: 12px; font-family:Arial, Helvetica, sans-serif">
                        <tr>
                            <td width="" valign="top">
                            
                            <table>
                                <tr>
                                    <td>
                                        <? if (get_field("tbl_product", "photo_3", $id) != ''){ ?>
                                        	<img src="http://cameraparadise.com/data/tbl_product/vie_crop/<?=$id?>_3/<?=get_field("tbl_product", "photo_3", $id); ?>" alt="" />
                                        <? } ?>
                                    </td>
                                    <td>
                                        <?=get_field("tbl_product", "content_1", $id); ?>
                                        <br style="clear: both;" />
                                    </td>
                            
                                </tr>
                            </table>
                            
                            <!-- End of Product Details -->
                            	
                                <? if (get_field("tbl_product", "content_2", $id) != ''){ ?>
                                	<h2 style="border-bottom:1px #eee solid; border-left:5px solid #eee; padding-left:10px; color: #222;">Details</h2>
                                	<?=get_field("tbl_product", "content_2", $id); ?>
                                    <br style="clear:both" />
                                <? } ?>
                                
                                <? if (get_field("tbl_product", "content_3", $id) != ''){ ?>
                                	<h2 style="border-bottom:1px #eee solid; border-left:5px solid #eee; padding-left:10px; color: #222;">What&acute;s in the Box</h2>
                                    <?=get_field("tbl_product", "content_3", $id); ?>
                                    <br style="clear:both" />
								<? } ?>
                            	
                            
                                <div style="padding:10px; text-align:justify; ">
                                    <p>Free Shipping to Australia : Express to Australia, 2 - 5 working days Shipping to other areas : 3 - 21 working days, please kindly contact us with your full address.</p>
                                </div>
                            
                                <br style="clear:both" />
                            
                                <!-- Other Information -->
                                <h2 style="border-bottom:1px #eee solid; border-left:5px solid #eee; padding-left:10px; color: #222;">Import Tax / Fee</h2>
                                <ul style="text-align:justify; line-height:20px;">
                                    <li>Import duties, taxes and related charges are not included in the item price or shipping charges. Those charges are the buyer's responsibility.</li>
                                    <li>Please check with your country's customs office to determine what these additional costs will be prior to bidding / buying.</li>
                                    <li>Other information a seller may wish to include: These charges are normally collected by the delivering freight (shipping) company or when you pick the item up - do not confuse them for additional shipping charges.</li>
                                    <li>If buyer rejects the item upon arrival due to TAX/DUTY reasons, we will charge buyer 5% Final Value amount for handling fee. Buyer is responsible for cost of return shipping. We do NOT refund shipping and insurance charges.</li>
                                </ul>
                                
                                <br style="clear:both" />
                                
                                <h2 style="border-bottom:1px #eee solid; border-left:5px solid #eee; padding-left:10px; color: #222;">Payment Method</h2>
                                <ul style="text-align:justify; line-height:20px;">
                                    <li>We accept PayPal only (with verified and confirm address).</li>
                                    <li>The Paypal must be paid within 7 days. Bidder who fail to pay will be reported to ebay.</li>
                                    <li>Payment must be received, in full, prior to the item being sent out.</li>
                                    <li>No sending money & cheque overseas.</li>
                                    <li>We do not accept any other forms of payment.</li>
                                </ul>
                                
                                <br style="clear:both" />                            
                                
                                <h2 style="border-bottom:1px #eee solid; border-left:5px solid #eee; padding-left:10px; color: #222;">Returns</h2>
                                <ul style="text-align:justify; line-height:20px;">
                                    <li>We offers a 7 days exchange policy only if the item sold is found to be defective by the manufacturers.</li>
                                    <li>The manufacturer defective item will be exchanged for the same model only if the return guidelines are followed:</li>
                                    <li>The item must be returned in NEW condition and with all the original manufacturers packaging, including cartons, boxes, instruction manuals and blank warranty cards and copy of customer sales invoice, and any other gifts we might have provided.</li>
                                    <li>All returns must be boxed and packed securely for shipping.</li>
                                    <li>Buyer must ship the item back under insured delivery and label as defective return, the shipping cost will not be refunded.</li>
                                </ul>
                                
                                <br style="clear:both" />                            
                                
                                <h2 style="border-bottom:1px #eee solid; border-left:5px solid #eee; padding-left:10px; color: #222;">Warranty</h2>
                                <ul style="text-align:justify; line-height:20px;">
                                    <li>Buyer is responsible for the cost of shipping the item back to us and for the returning of the item.</li>
                                    <li>Defective items must be returned within the 7 working day upon receiving the item.</li>
                                    <li>International warranty can be arrange for extra fees, please contact us for more details.</li>
                                </ul>
                                
                                <br style="clear:both" />                            
                                
                                <h2 style="border-bottom:1px #eee solid; border-left:5px solid #eee; padding-left:10px; color: #222;">Shipping</h2>
                                <ul style="text-align:justify; line-height:20px;">
                                    <li>We are happy to ship worldwide except India, South Africa, and Martinique.</li>
                                    <li>Phone number must be provided before we ship, for safer and swift shipping experiences.We ship to Paypal address only.</li>
                                    <li>For express shipping methods please kindly contact us with your full address so we can check accurately.Insurance fee is not included, please contact us if you wish for insured delivery.</li>
                                    <li>We are happy to ship to PO BOX, APO address but must first consult us Delivery generally takes 7-14 working days. Shipping via post office may take longer. Couriers Express: Delivery generally takes 2-3 workding days.</li>
                                </ul>
                                
                                <!-- End of Other Information -->                        
                            
                            </td>
                        </tr>
                    </table>
                    
                    <!-- End of Product -->
    
                </td>
            </tr>
        </table>
    </textarea>
</p>
</fieldset>