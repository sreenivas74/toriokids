<script type="text/javascript">
$(document).ready(function(){
	$('#dob').datepicker({
			numberOfMonths: 1,
			showButtonPanel: true,
			yearRange: "-80:+80",
			changeYear: true,
			dateFormat: "dd MM yy",
			minDate: "-80y"
		});
});	
</script>
<?php /*?><div class="noBg">
    <a href="<?php echo site_url('home');?>">Home </a>&gt;<a> Create Account</a>
</div><?php */?>
<form id="create_account_form" name="create_account_form" method="post" action="#" onsubmit="return false;">
<input type="hidden" id="code" name="code" value="<?php echo $code;?>">
<input type="hidden" id="user_id" name="user_id" value="<?php echo $user_id;?>">
<div class="createAccCon">
    <div class="createAccBox">
        <h2>Create Your Account</h2>
        <span>Fill in the required information below to create your account and enjoy the benefits<br/>
from shopping with Torio Kids Online Shop.</span>
    <table>
    	<tr>
            <td>Email Address</td>
            <td><input type="text" class="inputTxt" readonly="readonly" name="email" value="<?php echo $email;?>"/></td>
        </tr>
        <tr>
            <td>Full Name</td>
            <td><input type="text" class="inputTxt validate[required]" name="fullname" id="fullname"/></td>
        </tr>
    	<tr>
            <td>Password</td>
            <td><input type="password" class="inputTxt validate[required]" name="password" id="password" /></td>
        </tr>
        <tr>
            <td>Confirm Password</td>
            <td><input type="password" class="inputTxt validate[required,equals[password]] " name="confirmpassword" id="confirmpassword" /></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td><input name="newsleter" type="checkbox"> Receive special promotions and updates from Torio Kids</td>
        </tr>
    </table>
    </div>
</div>
<input type="submit" class="btnBg" id="create_account_submit" value="Create Your Account">
</form>