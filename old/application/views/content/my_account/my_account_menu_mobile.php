
    <div class="profileMobile">
        <h3>My Account</h3>
        <div class="profileMobileComboBox">
            <select class="default_dropdown" onChange="window.location=this.value;">
                <option value="<?php echo site_url('my_account/dashboard');?>" <?php if($this->uri->segment(2)=="dashboard")echo 'selected'?>>Dashboard</option>
                <option value="<?php echo site_url('my_account/edit_profile');?>" <?php if($this->uri->segment(2)=="edit_profile")echo 'selected'?>>Edit Profile</option>
                <option value="<?php echo site_url('change_password');?>" <?php if($this->uri->segment(1)=="change_password")echo 'selected'?>>Change Password</option>
                <option value="<?php echo site_url('change_email');?>" <?php if($this->uri->segment(1)=="change_email")echo 'selected'?>>Change Email</option>
                <option value="<?php echo site_url('my_order');?>" <?php if($this->uri->segment(1)=="my_order")echo 'selected'?>>My Orders</option>
                <option value="<?php echo site_url('my_addresses');?>" <?php if($this->uri->segment(1)=="my_addresses")echo 'selected'?>>My Addresses</option>
            </select>
        </div>
    </div>
