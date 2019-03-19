<section id="content">
    	<?php $this->load->view('content/my_account/my_account_menu');?>
        <div class="confirmPaymentCon">
	<?php $this->load->view('content/my_account/my_account_menu_mobile')?>
        	<table class="table_account">
                <tr>
                    <td>
                        <h3>Confirm Payment</h3>
                        <table>
                        
                          <form method="POST" action="#" id="confirm_payment_form2" name="confirm_payment_form2" onsubmit="return false;">							 
                          <input type="hidden" name="order_id" value="<?php echo $order_detail['id'] ?>" />
                         <input type="hidden" name="order_number" value="<?php echo $order_detail['order_number']?>" />
                         <input type="hidden" id="action" value="my_order/do_confirm_payment" />
                        	<tr>
                                <td>Order No./Email</td>
                                <td><?php echo $shipping['order_number'];?>/<?php echo $account['email']?></td>
                            </tr>
                            <tr>
                                <td>Total Amount</td>
                                <td><?php //pre($order_detail);?> <?php //echo money($order_detail['total']-$order_detail['discount_price']+$order_detail['shipping_cost']);?> <?php echo money($order_detail['total']) ?></td>
                            </tr>
                            <tr>
                                <td>Bank <span class="ast">*</span></td>
                                <td>
                                    <select name="bank" id="bank" class="validate[required]">
                                        <option value="bca" >BCA</option>
                                    </select>
                                </td>
                            </tr>
                            
                            
                            <tr>
                                <td>Transfer Date <span class="ast">*</span></td>
                                <td><input class="validate[required] date_picker" style="width:100px;margin-right:5px;" type="text" name="date_transfer" id="date_transfer" readonly="readonly" /></td>
                            </tr>
                            <tr>
                                <td>Account Name <span class="ast">*</span></td>
                                <td><input type="text" class="validate[required]" name="account_name" id="account_name"><p class="desc">The owner name of the account that you used to transfer the amount of payment</p></td>
                            </tr>
                            <tr>
                                <td>Additional Notes</td>
                                <td><input type="text" name="note"><p class="desc">Any specific note or special requests for your order</p></td>
                            </tr>
                            
                            <tr>
                                <td></td>
                                <td><span class="ast">*</span>) is required</td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td><input type="submit" value="Confirm" class="addToCart" id="trigger_btn"></td>
                            </tr>
                            
                        </form>
                        <input type="submit" id="confirm_payment_submit2" style="display:none;" />
                        </table>
                        
                    </td>
                </tr>
            </table>
        </div>
    </section>
<script>
$(document).ready(function(){
	$('.date_picker').datepicker({
		showOn: "button",
		buttonImage: base_url+"templates/images/calendar.gif",
		buttonImageOnly: true,
		buttonText: "Select Date",
		numberOfMonths: 1,
		showButtonPanel: true,
		yearRange: "-80:+80",
		changeYear: true,
		dateFormat: "yy-mm-dd",
		minDate: "-100"
	});
		
	});
</script>