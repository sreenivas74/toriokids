<section>
        	<div class="contentWrapper">
            	<div class="mainWrapper nobanner">
                	<div class="profileWrapper">
                        <h3>EDIT PASSWORD</h3>
                        <?php $this->load->view('content/profile/my_profile_menu'); ?>
                        <div class="inputField">
                            <form method="post" id="formpass" action="<?php echo site_url('my_profile/do_edit_password') ?>">
                            <input class="defTxtInput <?php if(isset($error_cur)){ ?> error <?php } ?>" type="password" id="current_pass" name="current_pass" placeholder="Current Password" value="<?php if(isset($cur)){ echo $cur; } ?>">
                            <div class="errorBox">
                                <?php if(isset($error_cur)){ ?>
                                <span class="errorMsg"><?php echo $error_cur ?></span>
                                <?php } ?>
                            </div>
                            <input class="defTxtInput <?php if(isset($error_new)){ ?> error <?php } ?>" type="password" id="new_pass" name="new_pass" placeholder="New Password" value="<?php if(isset($new)){ echo $new; } ?>">
                            <div class="errorBox">
                                <?php if(isset($error_new)){ ?>
                                <span class="errorMsg"><?php echo $error_new ?></span>
                                <?php } ?>
                            </div>
                            <input class="defTxtInput <?php if(isset($error_con)){ ?> error <?php } ?>" type="password" id="confirm_pass" name="confirm_pass" placeholder="Confirm New Password" value="<?php if(isset($con)){ echo $con; } ?>">
                            <div class="errorBox">
                                <?php if(isset($error_con)){ ?>
                                <span class="errorMsg"><?php echo $error_con ?></span>
                                <?php } ?>
                            </div>
                            <a href="javascript:void(0)" id="edit_pass" class="defBtn">change password</a>
                            </form>
                            <!--<div class="notifBubble success"></div>-->
                        </div>
                    </div>
                </div>
            </div>
        </section>

<script>
    $('#edit_pass').click(function(){
                $('#formpass').submit();
    });
</script>