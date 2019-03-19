<?php if($clock_end){ ?>
<div class="flashSale">
    <a href="#">
        <img src="<?php echo base_url() ?>userdata/smallbanner/flash_sale.png" />
        <span class="flashSaleTxt">Come & Get it! This Day Only!  <span id="clock"></span></span>
    </a>
</div>
<?php }?>

<div id="banner" class="headBanner">
	<?php if($home_banner)foreach($home_banner as $list){?>
    <a <?php if($list['link']){?>href="<?php echo prep_url($list['link']);?>"<?php } ?> target="_blank"><img alt="<?php echo $list['name'];?>" src="<?php echo base_url();?>userdata/home_banner/large/<?php echo $list['image'];?>" />
    </a>
    <?php }?>
</div>

        

<?php if($second){?>
<div class="smallBanner">
    <a <?php if($second['link']){?>href="<?php echo prep_url($second['link']);?>"<?php }?> target="_blank"><img alt="<?php echo $list['name'];?>" src="<?php echo base_url();?>userdata/home_banner/small/<?php echo $second['image'];?>" /></a>
</div>
<?php }?>
<div class="categoryMenu">
    <a class="orange" href="javascript:void(0);">Shop Now</a> <span class="babyGreen size20">&bull;</span>
    <?php if($category)foreach($category as $list){?>
    <a class="<?php echo alternator('babyBlue', 'babyPink');?>" href="<?php echo site_url('product/view_product_per_category'.'/'.$list['alias']);?>" target="_blank"><?php echo $list['name'];?></a> <span class="babyGreen size20">&bull;</span>
    <?php } ?>
</div>

<div class="product">
<?php if ($product_featured){ ?>
        	<ul class="recItemsSlider" id="recItemsSlider">
            <?php if($product_featured)foreach($product_featured as $list){?>
                <li>
                    <div class="productCon2">
                    	<?php if($list['best_seller']==1){?><div class="best"></div><?php } ?>
                             	<?php if($list['sale_product']==1){?><div class="sale"></div><?php } ?>
                        <div class="productImage">
                            <a href="<?php echo site_url('product/view_product_detail'.'/'.$list['alias'])?>"><img alt="" title="" src="<?php echo base_url();?>userdata/product/med/<?php echo find_2_prec('image', 'product_id', $list['id'], 'product_image_tb');?>"/></a>
                            <a href="<?php echo site_url('product/view_product_detail'.'/'.$list['alias'])?>" class="viewDetail"></a>
                         
                        </div>
                        <div class="productTxt">
                			<h3 class="productName"><a title="" href="<?php echo site_url('product/view_product_detail'.'/'.$list['alias'])?>"><b><?php echo $list['name']?></b></a></h3>
                           <?php 
							if($list['msrp']>$list['price']){?>            
							<span class="discount"><?php echo money($list['price']);?></span>
							<span class="afterDiscount"><?php echo money($list['msrp']);?></span>
							<?php }else{?>
							<span class="normal"><?php echo money($list['price']);?></span>
							
							<?php }?>
							<div class="ageRange"><?php echo $list['template_name']?></div>
                        </div>
                    </div>
                </li>  
                <?php } ?>
            </ul>
        </div>
<?php } ?>
<div class="feature">
	<?php if($featured)foreach($featured as $list){?>
    <div class="featureBox">
        <a class="featImg" <?php if($list['link']){?>href="<?php echo prep_url($list['link']);?>"<?php }?> target="_blank"><img alt="<?php echo $list['title'];?>" src="<?php echo base_url();?>userdata/featured/<?php echo $list['image'];?>" /></a>
        <h3><?php if($list['link']){?><a href="<?php echo prep_url($list['link']);?>" target="_blank"><?php echo $list['title'];?></a><?php } else echo $list['title'];?></h3>
        <p><?php echo $list['description'];?></p>
    </div>
    <?php } ?>
</div>


<?php if($footer_banner){?>
<div class="smallBanner2">
    <a <?php if($footer_banner['link']){?>href="<?php echo prep_url($footer_banner['link']);?>"<?php }?> target="_blank"><img alt="<?php echo $footer_banner['name'];?>" src="<?php echo base_url();?>userdata/small_footer_banner/<?php echo $footer_banner['image'];?>" /></a>
</div>
<?php }?>