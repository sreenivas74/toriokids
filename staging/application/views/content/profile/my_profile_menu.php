                        <div class="profileMenu">
                        	<ul>
                            	<li <?php if($this->uri->segment(1)=="my_profile" && $this->uri->segment(2)==""){ ?> class="active" <?php } ?>><a href="<?php echo site_url('my_profile') ?>">MY PROFILE</a></li>
                                <li <?php if($this->uri->segment(2)=="edit_profile"){ ?>class="active" <?php } ?>><a href="<?php echo site_url('my_profile/edit_profile') ?>">edit my PROFILE</a></li>
                                <?php if($this->session->userdata('login_via')=='manual'){ ?>
                                <li <?php if($this->uri->segment(2)=="edit_password"){ ?>class="active" <?php } ?>><a href="<?php echo site_url('my_profile/edit_password') ?>">Edit password</a></li>
                                <?php } ?>
                                <li <?php if($this->uri->segment(2)=="my_address"){ ?>class="active" <?php } ?>><a href="<?php echo site_url('my_profile/my_address') ?>">ADDRESS BOOK</a></li>
                                <li <?php if($this->uri->segment(1)=="my_order"){ ?>class="active" <?php } ?>><a href="<?php echo site_url('my_order') ?>">MY ORDERS</a></li>
                                <li <?php if($this->uri->segment(1)=="payment_confirmation"){ ?>class="active" <?php } ?>><a href="<?php echo site_url('payment_confirmation') ?>">PAYMENT CONFIRMATION</a></li>
                                <li><a href="<?php echo site_url('logout') ?>">LOGOUT</a></li>
                            </ul>
                        </div>