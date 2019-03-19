<section>
        	<div class="contentWrapper">
            	<div class="mainWrapper nobanner">
                	<div class="inputWrapper">
                        <h3>complete profile</h3>
                        <div class="inputField">
                            <form id="formID2" method="post" action="<?php echo site_url('registration/do_complete_profile') ?>">
                            <input class="defTxtInput <?php if(isset($error)){ ?> error <?php } ?>" id="name" name="name" value="<?php echo $this->session->userdata('name'); ?>" placeholder="Name">
                            <div class="errorBox">
                                <?php if(isset($error)){ ?>
                                <span class="errorMsg"><?php echo $error ?></span>
                                <?php } ?>
                            </div>
                            <input class="defTxtInput <?php if(isset($error_phone)){ ?> error <?php } ?>" id="phone" name="phone" placeholder="Phone Number">
                            <div class="errorBox">
                                <?php if(isset($error_phone)){ ?>
                                <span class="errorMsg"><?php echo $error_phone ?></span>
                                <?php } ?>
                            </div>
                            <input type="hidden"  name="user_id" value="<?php echo $this->session->userdata('user_id'); ?>">
                            <input class="defTxtInput <?php if(isset($error_email)){ ?> error <?php } ?>" id="email" name="email" value="<?php echo $this->session->userdata('email'); ?>" placeholder="Email">
                            <div class="errorBox">
                                <?php if(isset($error_email)){ ?>
                                <span class="errorMsg"><?php echo $error_email ?></span>
                                <?php } ?>
                            </div>
                            <input type="hidden" name="login_type" value="<?php echo $login_type ?>">
                            <a href="javascript:void(0)" id="submit2" class="defBtn">SUBMIT</a>
                            </form>
                        </div>
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