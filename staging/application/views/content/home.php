
        <section>
            <div class="contentWrapper">
                <?php if($home_banner) foreach($home_banner as $home){  ?>
                <div class="homeBanner">
                    <img src="<?php echo base_url() ?>userdata/home_banner/<?php echo $home['image'] ?>">
                    <div class="caption">
                        <!-- <p>See Our</p>
                        <h3>NEW COLLECTION</h3>
                        <p>Lorem ipsum dolor sit amet</p> -->
                        <!--<a href="product_list.html" class="collectionBtn">See our Collection</a>-->
                    </div>
                </div>
                <?php } ?>
                <!--<div class="brownBox">
                    <p>FREE SHIPPING &amp; RETURN. <a href="#">LEARN MORE</a></p>
                </div>-->
                <div class="productCategory">
                    <div class="genderCategory">
                        <ul>
                            <li>
                                <div class="imageWrapper">
                                    <img src="<?php echo base_url() ?>userdata/boyscategoryBG.jpg">
                                </div>
                                <div class="panelTab">
                                    <ul>
                                        <li><a href="<?php echo site_url('product/filter?category_name=Boys&size%5B%5D=1&size%5B%5D=6&size%5B%5D=2') ?>"><span>BABY BOYS</span><p>(0-3 years)</p></a></li>
                                        <li><a href="<?php echo site_url('product/filter?category_name=Boys&size%5B%5D=5&size%5B%5D=3&size%5B%5D=4') ?>"><span>BOYS</span><p>(3-8 years)</p></a></li>
                                        <li><a href="<?php echo site_url('product/view_product_per_category/boys_1') ?>"><span>VIEW ALL <p>BOYS COLLECTION</p></span></a></li>
                                    </ul>
                                </div>
                            </li>
                            <li>
                                <div class="imageWrapper">
                                    <img src="<?php echo base_url() ?>userdata/girlscategoryBG.jpg">
                                </div>
                                <div class="panelTab">
                                    <ul>
                                        <li><a href="<?php echo site_url('product/filter?category_name=Girls&size%5B%5D=1&size%5B%5D=6&size%5B%5D=2') ?>"><span>BABY GIRLS</span><p>(0-3 years)</p></a></li>
                                        <li><a href="<?php echo site_url('product/filter?category_name=Girls&size%5B%5D=5&size%5B%5D=3&size%5B%5D=4') ?>"><span>GIRLS</span><p>(3-8 years)</p></a></li>
                                        <li><a href="<?php echo site_url('product/view_product_per_category/girls_2') ?>"><span>VIEW ALL<p>GIRLS COLLECTION</p></span></a></li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="featured">
                        <ul>
                            <!--<li>
                                <img src="../userdata/saleBG.jpg">
                                <div class="featuredOverlay"></div>
                                <div class="caption">
                                    <div class="category">
                                        <h2>SALE</h2>
                                    </div>
                                    <a href="#">SHOP NOW</a>
                                </div>
                            </li>-->
                            <?php if($second) foreach ($second as $small) { ?>
                            <li>
                                <img src="<?php echo base_url() ?>userdata/home_banner/<?php echo $small['image'] ?>">
                                <div class="featuredOverlay"></div>
                                <div class="caption">
                                    <div class="category">
                                        <h2><?php echo $small['name'] ?></h2>
                                    </div>
                                    <a <?php if($small['link']){ ?>href="<?php echo $small['link'] ?>"<?php } ?>>SHOP NOW</a>
                                </div>
                            </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
                <!--<div class="mediaBox">
                    <div class="subscribeBox">
                        <input placeholder="Sign Up Your Email &amp; Get Updates">
                        <a href="#" class="subscribeBtn">SUBSCRIBE</a>
                    </div>
                    <div class="fbLink">
                        <p>Get Connected with Us</p>
                        <a href="#" class="facebookBtn">Facebook</a>
                    </div>
                </div>-->
                <!-- <div class="storechannelBtn">
                    <a href="<?php echo site_url('e_store') ?>">STORE</a>
                    <a href="<?php echo site_url('e_channel') ?>">E-CHANNEL</a>
                </div> -->
                <div class="storepartnerSection">
                    <p>Find Out the Quality of Torio Kids at</p>
                    <div class="storeList">
                        <!--<ul>
                            <li><a href="#"><img src="../userdata/iconsogo.png"></a></li>
                            <li><a href="#"><img src="../userdata/iconcentral.png"></a></li>
                            <li><a href="#"><img src="../userdata/iconlotte.png"></a></li>
                            <li><a href="#"><img src="../userdata/iconlotus.png"></a></li>
                            <li><a href="#"><img src="../userdata/iconaeonmall.png"></a></li>
                        </ul>-->
                        <ul>
                            <?php if($store)foreach ($store as $list) { ?>
                            <li><a <?php if($list['link']){ ?>href="<?php echo $list['link'] ?>" <?php } ?>><img src="<?php echo base_url() ?>/userdata/e-store/<?php echo $list['image'] ?>"></a></li>
                            <?php } ?>
                        </ul>
                    </div>
                    <!-- <div class="directChannel"><a href="#" class="orangeLink">Find Out Our Direct Channel</a></div> -->
                    <p>Our Products are also Available at</p>
                    <div class="partnerList">
                        <ul>
                            <?php if($channel) foreach ($channel as $a) { ?>
                            <li><a href="<?php echo $a['link'] ?>" target="_blank"><img src="<?php echo base_url() ?>/userdata/e-channel/<?php echo $a['image'] ?>"></a></li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
                
            </div>


        </section>