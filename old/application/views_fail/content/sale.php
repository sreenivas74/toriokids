<?php if($clock_end){ ?>
<div class="flashSale">
    <a href="#">
        <img src="<?php echo base_url() ?>userdata/smallbanner/flash_sale.png" />
        <span class="flashSaleTxt">Come & Get it! This Day Only!  <span id="clock"></span></span>
    </a>
</div>
<?php }?>
<?php $this->load->view('content/mobile_menu')?><div class="categoriesWrap">
	<div class="categories">
        <div class="category"><h2>Sale Product</h2></div>
        <div class="shopBy">Shop By Category</div>
        <div class="subCategory">
            <ul>
                <?php if($category)foreach($category as $list){?>
                <li><a href="<?php echo site_url('product/view_product_per_category'.'/'.$list['alias']);?>"><?php echo $list['name'];?></a>
                    <ul>
                        <?php /*if(check_new_arrival($list['name'])>0){?>
                        <li><a href="<?php echo site_url('product/view_new_arrival'.'/'.$list['alias']);?>"><span>New Arrivals</span></a></li>
                        <?php }*/?> 
                        <?php if($sub_category)foreach($sub_category as $slist){
                                    if($slist['category_id']==$list['id']){	?>
                        <li><a href="<?php echo site_url('product/view_product_per_sub_category'.'/'.$slist['alias'].'/'.$list['id']);?>"><span><?php echo $slist['name'];?></span></a></li> <?php }} ?>
                    </ul>
                </li>
                <?php } ?>
                 
                 <li><a href="<?php echo site_url('product/sale');?>">Sale Items</a></li>
                <li><a href="<?php echo site_url('product/best_seller')?>">Best Seller</a></li>
            </ul>
        </div>
        
            
        <?php if($template){?>
        <div class="shopBy">Shop By Size</div>
        <div class="subCategory">
            <ul>
				<?php if($template)foreach($template as $list){	if(check_product_size($list['id'])>0){?>
                <li><a href="<?php echo site_url('product/size'.'/'.$list['alias']);?>"><span><?php echo $list['name'];?></span></a></li> 
				<?php }} ?>
            </ul>
        </div>
        <?php } ?>
        
        <?php $this->load->view('content/advertisement');?>
    </div>
</div>
<?php if($product){?>
<div class="products">
	<div class="productTitle">
	<h2>Sale Products</h2>
    </div>
    <div class="productList">
        <?php if($product)foreach($product as $pro){?>
         <?php 
		//flash sale
		$sale_id=0; if($sale_array){ 
			foreach($sale_array as $sale){ 
				if($sale['product_id']==$pro['id'])
				{ 
					$sale_id=$sale['flash_sale_id'];
				}
			}
		}?>
        <div class="productCon">
        	<?php if(!$sale_array){?>
				<?php if($pro['best_seller']==1){?><div class="best"></div><?php } ?>
                <?php if($pro['sale_product']==1 && $pro['discount']>0){?><div class="discFlag"><?php echo round($pro['discount'])?>% OFF</div><?php }?>
            <?php }?>
            <div class="productImgBox">
                <div class="productImage">
                    <a href="<?php echo site_url('product/view_product_detail'.'/'.$pro['alias'])?>"><img alt="<?php echo $pro['name'];?>" src="<?php echo base_url();?>userdata/product/med/<?php echo find_2_prec('image', 'product_id', $pro['id'], 'product_image_tb');?>"/></a>
                    <?php /*?><a href="<?php echo site_url('product/view_product_detail'.'/'.$pro['alias']);?>" class="viewDetail" title="<?php echo $pro['name'];?>"></a><?php */?>
                    <a href="#" class="quickDetail" rel="<?php echo $pro['alias'];?>">Quick View</a>
                    <?php /*?><a href="<?php echo site_url('product/view_product_detail'.'/'.$pro['alias']);?>" class="quickDetail" title="<?php echo $pro['name'];?>"></a><?php */?>
                </div>
            </div>
            <div class="productTxt">
                <h3 class="productName"><a href="<?php echo site_url('product/view_product_detail'.'/'.$pro['alias']);?>"><b><?php echo $pro['name'];?></b></a></h3>
                <?php if(!$sale_array){ ?>
					<?php 
                        if($pro['msrp']>$pro['price']){?>            
                        <span class="discount"><?php echo money($pro['price']);?></span>
                        <span class="afterDiscount"><?php echo money($pro['msrp']);?></span>
                        <?php }else{?>
                        <span class="normal"><?php echo money($pro['price']);?></span>
                    <?php }?>
                <?php }else{?>
                	<?php $percentage = find('percentage',$sale_id,'flash_sale_tb'); ?>
                    <span class="discount"><?php echo money($pro['msrp']-($pro['msrp']*$percentage/100));?></span>
                    <span class="afterDiscount"><?php echo money($pro['msrp']);?></span>
                <?php }?>
				<div class="ageRange"><?php echo $pro['template_name']?></div>
            </div>
        </div>
        <?php } ?>
    </div>
    
    
    <?php if($pagination){?>
    <div class="paging">
    	<?php echo $pagination;?>
    </div>
    <?php }?>
</div>
<?php }else{?>
	<?php if($content_page['active']==1){?>
    <div class="contentElement">
        
        <?php  echo $content_page['content']?>
    </div>
	<?php }else{?>
    <div class="contentElement" style="width:700px;">
        <div class="rightTextCon">
            <div class="rightText">
                <h3>Sorry!!</h3>
                <p>at this moment we don't have any sale <br>
                    but, don't worry moms, <br>
                    we will keep you update <br>
                    just insert your email address below</p>
                
                    <form id="newsletter_form2" name="newsletter_form2" method="post" action="#" onsubmit="return false;">
                        <input placeholder="Your email address"class="emailInput validate[custom[email],ajax[check_existing_email2]]" type="text" name="news_letter_email2" id="news_letter_email2" onchange="check_email_newsletter_registered(this.value);"/>
                        <input class="keepMe" type="submit" value="Keep Me Updated" id="newsletter_submit2"/>
                    </form>
            </div>
        </div>
    </div>
<?php }
}?>