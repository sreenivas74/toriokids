
<div class="boxConNoBg">
	
    <h2>Thank You for Shopping with TorioKids.com!</h2>
    <div class="orderNo">
        <p>Your order no.: <span class="orderNoTxt"><?php echo $order_number;?></span></p>
    </div>
    <p>You will receive an order confirmation email with details of your order and a link to track its progress.
    <br><br>
    If you have an account, you can view your order status and history from the "<a href="<?php echo site_url('my_order');?>" target="_blank">My Orders</a>" menu in your profile.</p>
    <p>&nbsp;</p>
    <p>Click here to <a target="_blank" href="<?php echo site_url('shopping_cart/print_order_detail/'.$order_id)?>">print a copy</a> of your order confirmation.</p>
    <p>&nbsp;</p>
    <h3 style="color:#D4155B">WISHING YOU AND YOUR LOVED ONES A JOYFUL DAY!</h3>
    
    
    <?php if($order_detail['payment_type']==1){?>
    
    <div class="transferInfo" style="text-align:left; margin:50px 110px 0;">
        <h3 style="color:#8CC63F">Bank Transfer Information</h3><br>
        <p>Langkah pembayaran dengan Manual Transfer BCA:</p>
        <ol>
            <li><p>Catatlah nomor order Anda: <?php echo $order_number;?>.</p></li>
            <li><p>Transfer jumlah total ke account<br>
                <strong style="color:#9E005D;">
                a/n PT Torio Multi Nasional<br>
                253.351.3000<br>
                BCA Green Garden</strong><br>
                Masukan nomor order Anda di keterangan dan simpan struk/email sebagai bukti.<br>
                Pembayaran harus dilakukan paling lambat dua hari dari tanggal order, atau order otomatis dibatalkan.</p></li>
                
                <?php if($this->session->userdata('user_logged_in')){?>
            <li><p>Konfirmasi pembayaran Anda di <a href="<?php echo site_url('my_order/confirm_payment').'/'.$order_id?>">halaman konfirmasi dengan mengklik link ini</a>.</p></li>
            <?php }else{?>
            <li><p>Konfirmasi pembayaran Anda di <a href="<?php echo site_url('confirm_payment')?>">halaman konfirmasi dengan mengklik link ini</a>.</p></li>
            <?php }?>
            <li><p>Setelah Anda mengkonfirmasi, maka kami baru memulai memproses order Anda. Update status order akan dikabarkan melalui email.
                <!--or-->
                <?php if($this->session->userdata('user_logged_in')){?>
                
                Anda dapat melakukan <a href="<?php echo site_url('my_order/detail').'/'.$order_id?>">tracking order di halaman ini</a>.
                <?php }else{?>
                
            	Bila Anda <a href="#registerSection">mendaftarkan diri sebagai member</a>, Anda dapat melakukan tracking order.
                <br>
                <?php }?>
                </p></li>
        </ol>
    </div>
    <?php }?>
    
    
    
    <?php if(!$this->session->userdata('user_logged_in') && isset($_SESSION['guest_checkout']) && $_SESSION['guest_checkout']==1){?>
    <br><br><br>
    <h2>What's Next?</h2>
    With an account, you will gain more benefits and be able to access your order history for easy reorders.<br>
    </p>
    <div class="accountCon">
        <div class="accountLeft">
            <form id="2regist_form" name="2regist_form" action="#" method="post">
            <table>
                <tr>
                    <td>Password</td>
                    <td><input type="password" id="password" name="password" class="validate[required]" /></td>
                </tr>
                <tr>
                    <td>Confirm Password</td>
                    <td><input type="password" id="cpassword" name="cpassword" class="validate[required,equals[password]]" /></td>
                </tr>
                <tr>
                    <td></td>
                    <td><a href="#" class="createAccBtn" id="2regist_submit">Create Account</a></td>
                </tr>	
            </table>
            </form>
        </div>
        <div class="accountRight">
            <h4>Benefits of having an account:</h4>
            <ul>
                <li>View your order status</li>
                <li>Get promotions directly to your email</li>
                <li>Get updates faster than anyone else</li>
                <li>Shop faster and easier!</li>
            </ul>
        </div>
    </div>
    <?php }?>
    
</div>

<div class="btnBg"><a href="<?php echo site_url('home');?>">Back to Homepage</a></div>
