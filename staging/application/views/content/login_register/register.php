<section>
        	<div class="contentWrapper">
            	<div class="mainWrapper nobanner">
                	<div class="inputWrapper">
                        <h3>create account</h3>
                        <div class="inputField">
                            <a href="javascript:void(0)" class="facebookBtn facebook_login">register WITH FACEBOOK</a>
                            <span class="or">OR</span>
                            <form id="formID2" method="post" action="<?php echo site_url('registration/do_register') ?>">
                            <input class="defTxtInput <?php if(isset($error)){ ?> error <?php } ?>" id="name" name="name" placeholder="Name" value="<?php if(isset($name)){ echo $name; } ?>">
                            <div class="errorBox">
                                <?php if(isset($error)){ ?>
                                <span class="errorMsg"><?php echo $error ?></span>
                                <?php } ?>
                            </div>
                            <input class="defTxtInput <?php if(isset($error_phone)){ ?> error <?php } ?>" id="phone" name="phone" placeholder="Phone Number" value="<?php if(isset($phone)){ echo $phone; } ?>">
                                <div class="errorBox">
                                <?php if(isset($error_phone)){ ?>
                                    <span class="errorMsg"><?php echo $error_phone ?></span>
                                <?php } ?>
                                </div>
                            <input class="defTxtInput <?php if(isset($error_email)){ ?> error <?php } ?>" id="email" name="email" placeholder="Email" value="<?php if(isset($email)){ echo $email; } ?>">
                                <div class="errorBox">
                                <?php if(isset($error_email)){ ?>
                                    <span class="errorMsg"><?php echo $error_email ?></span>
                                <?php } ?>
                                </div>
                            <input class="defTxtInput <?php if(isset($error_password)){ ?> error <?php } ?>" type="password" id="password" name="password" placeholder="Password" value="<?php if(isset($password)){ echo $password; } ?>">
                                <div class="errorBox">
                                <?php if(isset($error_password)){ ?>
                                    <span class="errorMsg"><?php echo $error_password ?></span>
                                <?php } ?>
                                </div>
                                <input type="hidden" name="register_type" value="<?php echo $register_type ?>">
                                <input type="hidden" name="login_type" id="login_type" value="<?php echo $register_type ?>">
                            <a href="javascript:void(0)" id="submit2" class="defBtn">CREATE</a>
                            <form>
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

        // if($("#name").val()==""){
        //     alert('Nama harus di isi');
        // }
        // else if($("#phone").val()==""){
        //     alert('No Telepon harus di isi');
        // }
        // else if(isNaN($("#phone").val())){
        //     alert('No Telepon harus angka');
        // }
        // else if($("#email").val()==""){
        //     alert('Email harus di isi');
        // }
        // else if(!validateEmail($("#email").val())){
        //     alert('Format email salah');
        // }
        // else if($("#password").val()==""){
        //     alert('Password harus di isi');
        // }
        // else{
            $("#formID2").submit();
        //}
    });
</script>