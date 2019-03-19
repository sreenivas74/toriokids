<?php /* //this is breadcrumb?><div class="noBg">
    <a href="<?php echo site_url('home');?>">Home </a>&gt;<a class="selectedBreadCrumb"> Register &amp; Login</a>
</div><?php */?>
<div class="loginCon mobileLoginCon">
<form id="register_form" name="register_form" method="post" action="#" onsubmit="return false;">
    <div class="loginBox" id="regMobile">
        <h2>Register</h2>
        <span>Put your email below to register in Torio Kids Online Shop</span>
        <input type="text" class="loginTxt validate[required,custom[email]]" name="email" id="email" value="<?php echo $email;?>" placeholder="Enter your email"/>
        <table>
            <tr>
                <td>*</td>
                <td>A verification email will be sent to your email address, please check your inbox after signing up</td>
            </tr>
            <tr>
                <td>**</td>
                <td>If you do not receive any email from us, try checking your Spam Folder or contact us for any assistance</td>
            </tr>
            <p style="color:#F00"><?php if(isset($err))echo "<div class=\"errorMsg\">$err</div>";?></p>
        </table>
        <input type="submit" class="btnBg" id="register_submit" value="Register"/>
    </div>
</form>
<form id="login_form" name="login_form" method="post" action="#" onsubmit="return false;">
    <div class="loginBox" id="loginMobile">
        <h2>Login</h2>
        <span>Login to your Torio Kids Online Shop account</span>
        <input type="text" class="loginTxt validate[required]" name="loginEmail" id="loginEmail" placeholder="Enter your email"/>
        <input type="password" class="loginTxt validate[required]" name="loginPass" id="loginPass" placeholder="Enter your password"/>
        <?php if(isset($errLogin))echo "<br><div class=\"errorMsg\">$errLogin</div>";?>
        <input type="submit" class="btnBg" id="login_submit" value="Login"/>
        <div class="forgetPsss"><a href="<?php echo site_url('forgot_password');?>">Forget Password?</a> | <a href="<?php echo site_url('contact_us');?>">Can't Access Your Account?</a>
        <input type="button" class="btnBgFb"  onclick="facebookLogin();" value="Login with Facebook"></input>
        </div>
         
    </div>
    <div class="separate"></div>
</form>
</div>