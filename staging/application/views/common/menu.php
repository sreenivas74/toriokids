<a href="#" class="burgericon">mobilemenu</a>
        <div class="mobilenavBox">
            <div class="mobilenavWrapper">
                <div class="mobilenavBtn">
                    <a href="<?php echo site_url('shopping_cart') ?>" class="mobilecartBtn">cartbutton</a>
                    <a href="#" class="mobilecloseBtn" onClick="hide_mobilenav(); return false;">closebutton</a>
                </div>
                <ul class="mobilenavCategory">
                    <?php if($category)foreach($category as $list){?>
                    <li><a class="DDtop" href="<?php echo site_url('product/view_product_per_category'.'/'.$list['alias']);?>" ><?php echo $list['name'];?></a>
                        <ul class="submenu">
                            <?php if($sub_category)foreach($sub_category as $slist){ 
                                if($slist['category_id']==$list['id']){ ?>
                            <li><a href="<?php echo site_url('product/view_product_per_sub_category'.'/'.$slist['alias'].'/'.$list['id']);?>"><?php echo $slist['name'];?></a></li>
                            <?php } } ?>
                        </ul>
                    </li>
                    <?php } ?>
                    <li><a href="<?php echo site_url('product/best_seller')?>">BEST SELLER</a></li>
                    <!-- <li><a href="<?php echo site_url('product/sale')?>">SALE</a></li> -->
                </ul>
                <!-- <a href="#" class="mobileSearch" onClick="show_search_popup();">mobilesearch</a> -->
                <div class="mobileFooter">
                    <ul>
                        <!-- <li><a href="#">Log in</a></li> -->
                        <!-- <li><a href="#">About us</a></li>
                        <li><a href="#">Contact us</a></li> -->
                        <!-- <li><a href="#">Need help</a></li>
                        <li><a href="#">Payment configuration</a></li> -->
                        <li><a href="<?php echo site_url('content/terms-n-conditions-5') ?>">Terms &amp; Conditions</a></li>
                        <li><a href="<?php echo site_url('content/privacy-policy-4') ?>">Privacy Policy</a></li>
                    </ul>
                    <!-- <div class="bankLink">
                        <p>Secure Payments via</p>
                        <img src="<?php echo base_url() ?>templates/images/bankicon.png">
                    </div> -->
                    <p class="copyright">Copyright 2016 &copy; Torio Kids. All rights reserved.</p>
                </div>
            </div>
        </div>
        <nav <?php if($this->uri->segment(1)=="" || $this->uri->segment(1)=="home") {  ?>class="homeNav" <?php } ?>> 
            <ul>
                <?php if($category)foreach($category as $list){?>
                <li><a class="DDtop" href="<?php echo site_url('product/view_product_per_category'.'/'.$list['alias']);?>" ><?php echo $list['name'];?></a>
                    <div class="dropdownMenu">
                        <ul>
                            <?php if($sub_category)foreach($sub_category as $slist){ 
                                if($slist['category_id']==$list['id']){ ?>
                            <li><a href="<?php echo site_url('product/view_product_per_sub_category'.'/'.$slist['alias'].'/'.$list['id']);?>"><?php echo $slist['name'];?></a></li>
                            <?php } } ?>
                        </ul>
                    </div>
                </li>
                <?php } ?>
                <li><a href="<?php echo site_url('product/best_seller')?>">BEST SELLER</a></li>
                <li><a href="<?php echo site_url('product/sale')?>">SALE</a></li>
            </ul>
        </nav>
        <div class="userNav">
            <ul>
                <li><a <?php if($this->session->userdata('user_logged_in')==true){ ?> href="<?php echo site_url('my_profile') ?>" <?php }else{ ?> href="<?php echo site_url('login') ?>"<?php } ?> class="profileIcon">profile</a></li>
                <li><a href="javascript:void(0)" class="searchIcon" onClick="show_search_popup();">search</a></li>
                <li><a href="<?php echo site_url('shopping_cart') ?>" class="cartIcon">cart</a></li>
            </ul>
        </div>