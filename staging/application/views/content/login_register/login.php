<section>
        	<div class="contentWrapper">
            	<div class="mainWrapper nobanner">
                	<div class="inputWrapper">
                        <h3>LOGIN</h3>
                        <div class="inputField">
                            <a href="javascript:void(0)" class="facebookBtn facebook_login">LOGIN WITH FACEBOOK</a>
                            <span class="or">OR</span>
                            <form id="formID2" method="post" action="<?php echo site_url('login/process') ?>">
                            <input class="defTxtInput <?php if(isset($error)){ ?> error <?php } ?>" id="email" name="loginEmail" placeholder="Email" value="<?php if(isset($email)){ echo $email; } ?>">
                            <div class="errorBox">
                                <?php if(isset($error)){ ?>
                                <span class="errorMsg"><?php echo $error ?></span>
                                <?php } ?>
                            </div>
                            <input type="hidden" id="login_type" name="login_type" value="<?php echo $login_type ?>">
                            <input class="defTxtInput <?php if(isset($error_pass)){ ?> error <?php } ?>" type="password" id="pass" name="loginPass" placeholder="Password" value="<?php if(isset($password)){ echo $password; } ?>">
                            <div class="errorBox">
                                <?php if(isset($error_pass)){ ?>
                                <span class="errorMsg"><?php echo $error_pass ?></span>
                                <?php } ?>
                            </div>
                            <div class="errorBox">
                                <?php if(isset($error_invalid)){ ?>
                                <span class="errorMsg"><?php echo $error_invalid ?></span>
                                <?php } ?>
                            </div>
                            <a href="javascript:void(0)" id="submit2" class="defBtn">SIGN IN</a>
                            </form>
                        </div>
                        <a href="<?php echo site_url('forget_password') ?>">Forget Password?</a>
                        <br><br><br>
                        <p class="smallHelp">Don’t have account? Create Account <a href="<?php echo site_url('registration') ?>">here</a></p>
                    </div>
                </div>
            </div>
        </section>

<script>
function validateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

$("#submit2").click(function() {

            $("#formID2").submit();
    });

</script>