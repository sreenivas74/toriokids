<?php if($this->session->userdata('user_logged_in')){
$this->load->view('content/my_account/my_account_menu');}?>
        <div class="confirmPaymentCon">
        <form action="#" method="post" onSubmit="return false;" id="confirm_payment_form" name="confirm_payment_form"> 
        	<table class="table_account">
                <tr>
                    <td>
                        <h3>Confirm Payment</h3>
                        <table>
                        	<tr>
                                <td>Order No.</td>
                                <td><input type="text" name="order_number" id="order_number" class="validate[required]" /><p class="desc">The order number that you paid for. Please carefully check and make sure that it is correct</p></td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td><input type="text" name="email_address" id="email_address" class="validate[required,custom[email]]" /></td>
                            </tr>
                            <?php $notif=$this->session->flashdata('notif');
							if($notif){?><tr>
                                <td></td>
                                <td><span class="errorMsg2"><?php echo $notif;?></span></td>
                            </tr><?php }?>
                            <tr>
                                <td>&nbsp;</td>
                                <td><input type="submit" value="Next" class="addToCart" id="confirm_payment_submit"></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            </form>
        </div>