<div class="menuProfile">
    <div class="myAcc">My Account</div>
        <ul>
        	<li><a href="<?php echo site_url('my_account/dashboard');?>" <?php if($this->uri->segment(2)=="dashboard"){?>class="selectedBg"<?php } ?>>Account Summary</a></li>
            <li><a href="<?php echo site_url('my_account/edit_profile');?>" <?php if($this->uri->segment(2)=="edit_profile"){?>class="selectedBg"<?php } ?>>Edit Profile</a></li>
            <li><a href="<?php echo site_url('change_password');?>" <?php if($this->uri->segment(1)=="change_password"){?>class="selectedBg"<?php } ?>>Change Password</a></li>
            <li><a href="<?php echo site_url('change_email');?>" <?php if($this->uri->segment(1)=="change_email"){?>class="selectedBg"<?php } ?>>Change Email</a></li>
            <li><a href="<?php echo site_url('my_order');?>" <?php if($this->uri->segment(1)=="my_order"){?>class="selectedBg"<?php } ?>>My Orders</a></li>
            <li><a href="<?php echo site_url('my_addresses');?>" <?php if($this->uri->segment(1)=="my_addresses"){?>class="selectedBg"<?php } ?>>My Addresses</a></li>
            
          <?php /*?>  <li><a href="<?php echo site_url('stamps');?>" <?php if($this->uri->segment(1)=="stamps"){?>class="selectedBg"<?php } ?>>Stamps</a></li>
<?php */?>
        </ul>
</div>