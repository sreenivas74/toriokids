
<?php $this->load->view('content/my_account/my_account_menu');?>
<div class="editContainer">
    <div class="noBg">
    <a href="<?php echo site_url('home');?>">Home </a>&gt;<a  href="<?php echo site_url('my_account');?>"> My Account </a>&gt;<a class="selectedBreadCrumb"> Change Password</a>
    </div>
    <div class="editAccCon">
    <form id="changepass_form" name="changepass_form" method="post" action="<?php echo site_url('change_password/do_edit');?>" >
        <div class="editAccBox">
            <h2>Change Password</h2>
            <?php if(isset($_SESSION['update_profile_msg'])){?><div class="messageCon"><p><?php echo $_SESSION['update_profile_msg'];?></p></div><br />
            <?php $_SESSION['update_profile_msg']=NULL;}?>
        <table>
            <tr>
                <td width="30%">Current Password</td>
                <td width="70%"><input class="inputTxt validate[required,ajax[check_existing_password]]" type="password" name="password" id="password" /></td>
            </tr>
            <tr>
                <td>New Password</td>
                <td><input type="password" class="inputTxt validate[required]" name="newpassword" id="newpassword" /></td>
            </tr>
            <tr>
                <td>Confirm New Password</td>
                <td><input type="password" class="inputTxt validate[required,equals[newpassword]] " name="confirmpassword" id="confirmpassword" /></td>
            </tr>
        </table>
        </div>
        <input type="submit" id="changepass_submit" class="btnBg" value="Change Password"/>
    </form>
    </div>
</div>               