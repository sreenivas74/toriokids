<?php if($clock_end && $flash_sale_type==2){ ?>
<div class="flashSale">
    <div class="desktopFlashSale">
        <a href="#">
            <img src="<?php echo base_url() ?>userdata/smallbanner/flash_sale.png" alt="flashSaleImg" />
            <div class="fsCd"></div>
        </a>
    </div>
    <div class="mobileFlashSale">
        <a href="#">
            <div class="fsCd"></div>
        </a>
        <span class="flashSaleTxt">Ayo belanja! Produk terbatas! Hanya 3 jam saja!</span>
    </div>
</div>
<?php }?>

<?php if($upcoming_time && $flash_sale_type==2){ ?>
<div class="beforeFlashSale">
    <div class="desktopFlashSale">
        <a href="#">
            <img src="<?php echo base_url() ?>userdata/smallbanner/new_flash_sale.jpg" alt="flashSaleImg" />
            <div class="beforeFsCd"></div>
        </a>
    </div>
    <div class="mobileFlashSale">
        <a href="#">
            <div class="beforeFsCd"></div>
        </a>
        <span class="flashSaleTxt">Tunggu tanggal <?php echo date('d F Y', strtotime($upcoming_sale['start_time'])) ?>!</span>
    </div>
</div>
<?php }?>

<?php if($upcoming_cd_time && $upcoming_cd){ ?>
<div class="beforeFlashSale">
    <div class="desktopCountdown">
        <a href="#">
            <img src="<?php echo base_url() ?>userdata/countdown/<?php echo $upcoming_cd['image'] ?>" alt="flashSaleImg" />
            <div class="beforeCd"></div>
        </a>
    </div>
    <div class="mobileCountdown">
        <a href="#">
        	<img src="<?php echo base_url() ?>userdata/countdown/mobile/<?php echo $upcoming_cd['image_mobile'] ?>" alt="flashSaleImg" />
            <div class="beforeCd"></div>
        </a>
        <?php /*?><span class="flashSaleTxt">Tunggu tanggal <?php echo date('d F Y', strtotime($upcoming_cd['start_time'])) ?>!</span><?php */?>
    </div>
</div>
<?php }?>

<div id="banner" class="headBanner">
	<?php if($home_banner)foreach($home_banner as $list){?>
    <a <?php if($list['link']){?>href="<?php echo prep_url($list['link']);?>"<?php } ?> target="_blank"><img alt="<?php echo $list['name'];?>" src="<?php echo base_url();?>userdata/home_banner/large/<?php echo $list['image'];?>" />
    </a>
    <?php }?>
</div>

<?php if($ads_desktop){ ?>
	<div class="lazada_desktop">
    	<?php echo $ads_desktop['value'] ?>
    </div>
<?php }?>

<?php if($ads_mobile){ ?>
	<div class="lazada_mobile">
    	<?php echo $ads_mobile['value'] ?>
    </div>
<?php }?>

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
                             	<?php if($list['sale_product']==1 && $schedule_sale){?><div class="sale"></div><?php } ?>
                        <div class="productImage">
                            <a href="<?php echo site_url('product/view_product_detail'.'/'.$list['alias'])?>"><img alt="" title="" src="<?php echo base_url();?>userdata/product/med/<?php echo find_2_prec('image', 'product_id', $list['id'], 'product_image_tb');?>"/></a>
                            <a href="<?php echo site_url('product/view_product_detail'.'/'.$list['alias'])?>" class="viewDetail"></a>
                         
                        </div>
                        <div class="productTxt">
                			<h3 class="productName"><a title="" href="<?php echo site_url('product/view_product_detail'.'/'.$list['alias'])?>"><b><?php echo $list['name']?></b></a></h3>
                           <?php 
							$sale_id=0; if($sale_array){ 
								foreach($sale_array as $sale){ 
									if($sale['product_id']==$list['id'])
									{ 
										$sale_id=$sale['flash_sale_id'];
									}
								}
							}
							
							if($sale_id==0)
							{
								if($list['msrp']>$list['price'] && $schedule_sale){?>            
								<span class="discount"><?php echo money($list['price']);?></span>
								<span class="afterDiscount"><?php echo money($list['msrp']);?></span>
								<?php }else{?>
								<span class="normal"><?php echo money($list['msrp']);?></span>
								<?php }
							}else{?>
								<?php $percentage = find('percentage',$sale_id,'flash_sale_tb'); ?>
                                <span class="discount"><?php echo money($list['msrp']-($list['msrp']*$percentage/100));?></span>
                                <span class="afterDiscount"><?php echo money($list['msrp']);?></span>
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