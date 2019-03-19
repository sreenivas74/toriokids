<script type="text/javascript">
$(document).ready(function(){
    $('.datepicker').datepicker({
            changeYear: true,
            dateFormat: "dd-mm-yy"
        });
}); 
</script>
<section>
        	<div class="contentWrapper">
            	<div class="mainWrapper nobanner">
                	<div class="profileWrapper">
                        <h3>payment confirmation</h3>
                        <?php $this->load->view('content/profile/my_profile_menu'); ?>
                        <div class="inputField">
                            <form method="post" id="form5" action="<?php echo site_url('payment_confirmation/do_confirm_payment') ?>">
                            <input class="defTxtInput <?php if(isset($error)){ ?> error <?php } ?>" name="order_number" placeholder="Order No." value="<?php if(isset($order_number)){ echo $order_number; } ?>">
                            <div class="errorBox">
                                <?php if(isset($error)){ ?>
                                <span class="errorMsg"><?php echo $error ?></span>
                                <?php } ?>
                            </div>
                            
                            <select name="bank_tujuan" id="bank_tujuan">
                                <option value="">Destination Bank</option>
                                <option value="BCA" <?php if(isset($bank_tujuan)){ if($bank_tujuan == "BCA"){ echo "selected"; } } ?> >BCA</option>
                            </select>
                            <div class="errorBox">
                                <?php if(isset($error_tujuan)){ ?>
                                <span class="errorMsg"><?php echo $error_tujuan ?></span>
                                <?php } ?>
                            </div>
                            <input class="defTxtInput <?php if(isset($error_bank)){ ?> error <?php } ?>" name="bank" placeholder="Your Bank Name" value="<?php if(isset($bank)){ echo $bank; } ?>">
                            <div class="errorBox">
                                <?php if(isset($error_bank)){ ?>
                                <span class="errorMsg"><?php echo $error_bank ?></span>
                                <?php } ?>
                            </div>

                            <input class="defTxtInput <?php if(isset($error_rek)){ ?> error <?php } ?>" name="account_name" placeholder="Your Bank Account Name" value="<?php if(isset($account_name)){ echo $account_name; } ?>">
                            <div class="errorBox">
                                <?php if(isset($error_rek)){ ?>
                                <span class="errorMsg"><?php echo $error_rek ?></span>
                                <?php } ?>
                            </div>
                            <?php /* ?>
                            <select name="metode" id="metode">
                                <option value="">Metode Transfer</option>
                                <option value="ATM" <?php if(isset($metode)){ if($metode == "ATM"){ echo "selected"; } } ?>>ATM</option>
                            </select>
                            <div class="errorBox">
                                <?php if(isset($error_metode)){ ?>
                                <span class="errorMsg"><?php echo $error_metode ?></span>
                                <?php } ?>
                            </div>
                            <?php */ ?>
                            <input class="defTxtInput <?php if(isset($error_nom)){ ?> error <?php } ?>" name="nominal" placeholder="Transfer Amount" value="<?php if(isset($nominal)){ echo $nominal; } ?>">
                            <div class="errorBox">
                                <?php if(isset($error_nom)){ ?>
                                <span class="errorMsg"><?php echo $error_nom ?></span>
                                <?php } ?>
                            </div>

                            <input class="defTxtInput datepicker <?php if(isset($error_date)){ ?> error <?php } ?>" name="date_transfer" placeholder="Transfer Date (DD/MM/YYYY)" value="<?php if(isset($date_transfer)){ echo $date_transfer; } ?>">
                            <div class="errorBox">
                                <?php if(isset($error_date)){ ?>
                                <span class="errorMsg"><?php echo $error_date ?></span>
                                <?php } ?>
                            </div>
                            <a href="javascript:void(0)" id="submit5" class="defBtn">CONFIRM PAYMENT</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

<script>
$('#submit5').click(function(){
    $('#form5').submit();
});
</script>
