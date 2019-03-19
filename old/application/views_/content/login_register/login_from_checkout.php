
    	<div class="noBg">
            <a href="<?php echo base_url();?>">Home </a>&gt;<a href="#" class="selectedBreadCrumb"> New Customer or Login</a>
        </div>
        <div class="loginCon">
        	<div class="loginBox">
            	<h2>New Customer</h2>
                <p>If this is your first time shopping at Torio Kids, you don't need an account to checkout and get the goods</p>
                <input type="submit" class="btnBg" value="Continue to Checkout" onClick="window.location='<?php echo site_url('shopping_cart/shipping');?>';"></input>
            </div>
        <form id="login_form" name="login_form" method="post" action="#" onsubmit="return false;">
    <div class="loginBox">
        <h2>Login</h2>
        <span>Login to your Torio Kids Online Shop account</span>
        <input type="text" class="loginTxt validate[required]" name="loginEmail" id="loginEmail" placeholder="Enter your email"/>
        <input type="password" class="loginTxt validate[required]" name="loginPass" id="loginPass" placeholder="Enter your password"/>
        <input type="submit" class="btnBg" id="login_submit" value="Login" style="margin-top:36px;"/>
        <?php if(isset($errLogin))echo "<div class=\"errorMsg\">$errLogin</div>";?>
        <div class="forgetPsss"><a href="<?php echo site_url('forgot_password');?>">Forget Password?</a> | <a href="<?php echo site_url('contact_us');?>">Can't Access Your Account?</a>
        <input type="button" class="btnBgFb"  onclick="facebookLogin();" value="Login with Facebook"></input>
        </div>
         
    </div>
    <div class="separate"></div>
</form>
        </div>