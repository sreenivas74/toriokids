<script type="text/javascript">
$(document).ready(function(){
    $('.datepicker').datepicker({
            changeYear: true,
            dateFormat: "yy-mm-dd"
        });
}); 
</script>
<section>
        	<div class="contentWrapper">
            	<div class="mainWrapper nobanner">
                	<div class="profileWrapper">
                        <h3>edit my profile</h3>
                        <?php $this->load->view('content/profile/my_profile_menu'); ?>
                        <div class="inputField existed">
                            <form method="post" id="formedit" action="<?php echo site_url('my_profile/do_edit_profile') ?>" enctype="multipart/form-data">
                        	<div class="userPP">
                            	<img id="image_preview" <?php if($account['profile_picture']!=""){ ?> src="<?php echo base_url() ?>userdata/profile_picture/<?php echo $account['profile_picture'] ?>" <?php }?> >
                                <input type="file" class="changePP" id="custom_upload" name="image">
                            </div>
                            <input class="defTxtInput <?php if(isset($error)){ ?> error <?php } ?>" id="name" name="name" placeholder="Name" value="<?php echo $account['full_name'] ?>">
                            <div class="errorBox">
                                <?php if(isset($error)){ ?>
                                <span class="errorMsg"><?php echo $error ?></span>
                                <?php } ?>
                            </div>
                            <input class="defTxtInput <?php if(isset($error_email)){ ?> error <?php } ?>" id="email" name="email" placeholder="Email" value="<?php echo $account['email'] ?>">
                            <div class="errorBox">
                                <?php if(isset($error_email)){ ?>
                                <span class="errorMsg"><?php echo $error_email ?></span>
                                <?php } ?>
                            </div>
                            <input class="defTxtInput <?php if(isset($error_phone)){ ?> error <?php } ?>" id="phone" name="phone" placeholder="Phone Number" value="<?php echo $account['mobile'] ?>">
                            <div class="errorBox">
                                <?php if(isset($error_phone)){ ?>
                                <span class="errorMsg"><?php echo $error_phone ?></span>
                                <?php } ?>
                            </div>
                            <input class="defTxtInput datepicker <?php if(isset($error_birthday)){ ?> error <?php } ?>" id="birthday" name="birthday" placeholder="Birthday" <?php if($account['date_of_birth']!='0000-00-00'){ ?> value="<?php echo $account['date_of_birth'] ?>" <?php } ?>>
                             <div class="errorBox">
                                <?php if(isset($error_birthday)){ ?>
                                <span class="errorMsg"><?php echo $error_birthday ?></span>
                                <?php } ?>
                            </div>
                            <a href="javascript:void(0)" id="submit_edit" class="defBtn">SAVE</a>
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

        function readURL(input) { 
            if (input.files && input.files[0]) { 
                var reader = new FileReader(); 
                reader.onload = function (e) { 
                    $('#image_preview').attr('src', e.target.result); 
                } 
                    reader.readAsDataURL(input.files[0]); 
                } 
        } 
        $("#custom_upload").change(function(){ 
            readURL(this); 
        });

         $('#submit_edit').click(function(){
                $("#formedit").submit();
        });
</script>