<footer id="footerCon">
    <div class="footerBox">
        <div class="footerTop">
            <div class="footer400">
                <div class="footerImg">
                </div>
                <div class="torioUpdate">
                    <h3 class="blueFooter">Get Torio Updates</h3>
                    <div class="longBar"></div>
                    <p class="blue14">Put Your Email Below</p>
                    <form id="newsletter_form" name="newsletter_form" method="post" action="#" onsubmit="return false;">
                        <input placeholder="Your email address" class="emailTxt validate[custom[email],ajax[check_existing_email2]]" type="text" name="news_letter_email" id="news_letter_email" value="<?php echo $newsletter_email;?>" onchange="check_email_newsletter_registered(this.value);"/>
                        <input class="emailBtn" type="submit" value="" id="newsletter_submit"/>
                    </form>
                    <p class="blue10">and get special updates from Torio.</p>
                </div>
            </div>
            
            <div class="footer160">
                <h3 class="blueFooter">Help</h3>
                
                <div class="shortBar"></div>
                <ul>
                	<li><a href="<?php echo site_url('confirm_payment');?>">Payment Confirmation</a></li>
                    <?php if($help)foreach($help as $help){?>
                    <?php if($help['link']){?><li><a href="<?php echo prep_url($help['link'])?>"><?php echo $help['name']?></a></li><?php }} ?>
                	<li><a href="http://www.toriokids.com/content/terms-n-conditions-5#pengembalian">Free Return</a></li>
                </ul>
            </div>
            <div class="footer160">
                <h3 class="blueFooter">About Torio Kids</h3>
                <div class="shortBar"></div>
                <ul>
                	<?php if($about_us)foreach($about_us as $au){?>
                    <?php if($au['link']){?><li><a href="<?php echo prep_url($au['link'])?>"><?php echo $au['name']?></a></li><?php }} ?>
                </ul>
            </div>
            <div class="footer160">
                <h3 class="blueFooter">Connect With Us</h3>
                <div class="shortBar"></div>
                <ul>
                    <?php if($connect_us)foreach($connect_us as $cu){?>
                    <?php if($cu['name']!='Pinterest'){if($cu['link']){?><li <?php if($cu['name']=='Facebook')echo "class=\"iconFB\""; else if($cu['name']=='Twitter')echo "class=\"iconTW\""; else echo"";?>><a target="_blank" href="<?php echo $cu['link']?>"><?php echo $cu['name']?></a></li><?php }}} ?>
                </ul>
            </div>
        </div>
        <div class="footerBot">
            <div class="footerLeft">
                <img alt="BCA, VISA, MasterCard Logo" title="Torio accepts payment from BCA, VISA and MasterCard" src="<?php echo base_url();?>templates/images/bank-logo.png">
            </div>
            <div class="footerRight">
                Copyright 2013 © Torio Kids. All rights reserved. | Website by <a href="http://www.isysedge.com" target="_blank">ISYS</a>
            </div>
         </div>
    </div>
</footer>