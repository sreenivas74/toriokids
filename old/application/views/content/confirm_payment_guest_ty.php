<?php if($this->session->userdata('user_logged_in')){
$this->load->view('content/my_account/my_account_menu');}?>
    	<div class="boxConNoBg">
       	  	<h2>Thank You!</h2>
            <p>We have successfully received your payment confirmation.<br>
            Our team will process this shortly and we will update you soon.<br><br>
            If you have an account, you can view your order status and history from the "<a href="<?php echo site_url('my_order');?>">My Orders</a>" menu in your profile.
            <?php if(!$this->session->userdata('user_logged_in') && $ok_register==1){?>
            <br><br><br>
            <h2>What's Next?</h2>
            With an account, you will gain more benefits and be able to access your order history for easy reorders.<br>
            </p>
            <div class="accountCon">
            	<div class="accountLeft">
                	<form id="2regist_form" name="2regist_form" action="#" method="post">
                	<table>
                    	<tr>
                        	<td>Password</td>
                            <td><input type="password" id="password" name="password" class="validate[required]" /></td>
                        </tr>
                        <tr>
                        	<td>Confirm Password</td>
                            <td><input type="password" id="cpassword" name="cpassword" class="validate[required,equals[password]]" /></td>
                        </tr>
                        <tr>
                        	<td></td>
                            <td><a href="#" class="createAccBtn" id="2regist_submit">Create Account</a></td>
                        </tr>	
                    </table>
                    </form>
                </div>
                <div class="accountRight">
                	<h4>Benefits of having an account:</h4>
                    <ul>
                    	<li>View your order status</li>
                        <li>Get promotions directly to your email</li>
                        <li>Get updates faster than anyone else</li>
                        <li>Shop faster and easier!</li>
                    </ul>
                </div>
            </div>
            <?php }?>
        </div>
        <div class="btnBgThx"><a href="<?php echo base_url();?>">Back to Homepage</a></div>