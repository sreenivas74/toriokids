<div class="shopCartContent">
    <h2>Payment</h2>
    <div class="stepShopping">
        <div class="firstStepDone">Shopping Cart</div>
        <div class="otherStepDone">Shipping</div>
        <div class="lastStepDone">Payment</div>
    </div>
</div>
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