<?php
if(isset($_SESSION['notif'])){
	if($_SESSION['notif']==1)$notif="New Email and Confirm email do not match";
	else if($_SESSION['notif']==2)$notif="You are already request to change your email, resent request?";
	else $notif="Incorrect Password";
}
?>

<?php $this->load->view('content/my_account/my_account_menu');?>
<div class="editContainer">
	<?php $this->load->view('content/my_account/my_account_menu_mobile')?>
    <div class="noBg">
    <a href="<?php echo site_url('home');?>">Home </a>&gt;<a  href="<?php echo site_url('my_account');?>"> My Account </a>&gt;<a class="selectedBreadCrumb"> Change Email</a>
    </div>
    <div class="editAccCon">
    <form id="changeemail_form" name="changeemail_form" method="post" action="<?php echo site_url('change_email/do_edit');?>">
        <div class="editAccBox">
            <h2>Change Email</h2>
        <table>
        	<tr>
                <td width="30%">New Email</td>
                <td width="70%"><input class="inputTxt validate[required,custom[email],ajax[check_existing_email]]" type="text" id="email" name="email" onchange="check_email_registered(this.value);"/></td>
			</tr>
            <tr>
                <td>Confirm New Email</td>
                <td><input class="inputTxt validate[required,custom[email],equals[email]]" autocomplete="off" type="text" id="new_email" name="new_email" /></td>
            </tr>
            <tr>
                <td>Password</td>
                <td><input type="password" class="inputTxt validate[required,ajax[check_user_password]]" name="password" id="password" /></td>
            </tr>
            <?php if(isset($_SESSION['notif'])){?>
            <tr>
                <td>&nbsp;</td>
                <td><div id="" style="font-size: 11px; color: #f00;"><?php echo $notif;?></div></td>
            </tr>
            <?php }?>
            <tr id="notif_profile" style="display:none;">
                <td>&nbsp;</td>
                <td><div id="notif_profile_box" style="font-size: 11px; color: #f00;"></div></td>
            </tr>
        </table>
        </div>
        <input type="submit" id="changeemail_submit" class="btnBg" value="Change Email"/>
    </form>
    </div>
</div>               