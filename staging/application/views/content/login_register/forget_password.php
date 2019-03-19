<section>
        	<div class="contentWrapper">
            	<div class="mainWrapper nobanner">
                	<div class="inputWrapper">
                        <h3>FORGET PASSWORD</h3>
                        <p>Please enter your email address below, and we will help you!</p>
                        <div class="inputField">
                            <form id="formID2" method="post" action="<?php echo site_url('forget_password/process') ?>">
                            <input class="defTxtInput <?php if(isset($error_email)){ ?> error <?php } ?>" id="email" name="email" placeholder="Email" value="<?php if(isset($email)){ echo $email; } ?>">
                                <div class="errorBox">
                                <?php if(isset($error_email)){ ?>
                                    <span class="errorMsg"><?php echo $error_email ?></span>
                                <?php } ?>
                                </div>
                            <a href="javascript:void(0)" id="submit2" class="defBtn">SEND REQUEST</a>
                            </form>
                        </div>
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