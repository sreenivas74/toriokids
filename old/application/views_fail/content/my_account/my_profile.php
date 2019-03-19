
<?php $this->load->view('content/my_account/my_account_menu');?>
<div class="editContainer">
	<?php $this->load->view('content/my_account/my_account_menu_mobile')?>
    <div class="noBg">
    <a href="<?php echo site_url('home');?>">Home </a>&gt;<a  href="<?php echo site_url('my_account');?>"> My Account </a>&gt;<a class="selectedBreadCrumb"> My Profile</a>
    </div>
    <div class="editAccCon">
        <div class="editAccBox">
            <h2>My Profile</h2>
            <?php /*if(isset($_SESSION['flag2'])){?><div class="messageCon"><p>Your password unsuccessfully changed,please input correct password</p></div><br /><?php $_SESSION['flag2']=NULL;} else if(isset($_SESSION['flag3'])){?><div class="messageCon"><p>Your password has been successfully changed.</p></div><br /><?php $_SESSION['flag3']=NULL;}*/?>
            
            <?php if(isset($_SESSION['update_profile_msg'])){?><div class="messageCon"><p><?php echo $_SESSION['update_profile_msg'];?></p></div><br />
            <?php $_SESSION['update_profile_msg']=NULL;}?>
        <table>
            <tr>
                <td width="30%">Full Name</td>
                <td width="70%"><input class="inputTxt" disabled="disabled" type="text" name="fullname" id="fullname" value="<?php echo $account['full_name'];?>"/></td>
            </tr>
            <tr>
                <td>Date of Birth</td>
                <td><input class="inputTxt" type="text" disabled="disabled" name="dob" id="dob" value="<?php if($account['date_of_birth']!="0000-00-00")echo date("d F Y",strtotime($account['date_of_birth']));?>" /></td>
            </tr>
            <?php /*?><tr>
                <td>Mobile</td>
                <td><input class="inputTxt" type="text" disabled="disabled" name="mobile" id="mobile" value="<?php echo $account['mobile'];?>" /></td>
            </tr><?php */?>
            <tr>
                <td>Phone / Mobile</td>
                <td><input type="text" name="telephone" disabled="disabled" id="telephone" value="<?php echo $account['telephone'];?>"  class="inputTxt" /></td>
            </tr>
            <tr>
                <td class="address">Address</td>
                <td><textarea rows="10" name="address" disabled="disabled" id="address" class="addTxt validate[required]"><?php echo strip_tags($account['address']);?></textarea></td>
            </tr>
            <?php /*?><tr>
                <td>Province</td>
                <td><input class="inputTxt" type="text" disabled="disabled" name="province" id="province" value="<?php echo find('name', $account['province'], 'jne_province_tb');?>" /></td>
            </tr><?php */?>
            <tr>
                <td>City</td>
                <td><input class="inputTxt" type="text" disabled="disabled" name="city" id="city" value="<?php echo find('name', $account['city'], 'jne_city_tb');?>" /></td>
            </tr>
            <tr>
                <td>Zipcode</td>
                <td><input class="inputTxt" type="text" disabled="disabled" name="postcode" id="postcode" value="<?php echo $account['postcode'];?>" /></td>
            </tr>
        
        </table><input type="submit" id="account_submit" class="btnBg" value="Edit Profile" onclick="window.location='<?php echo site_url('my_account/edit_profile');?>';"/>
        </div>
    </div>
</div>               