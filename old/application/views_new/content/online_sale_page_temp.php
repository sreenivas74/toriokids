<style>

	.rightTextCon, .stayUpdate{
		background:url(<?php echo base_url()?>templates/images/donthavesale.jpg) no-repeat top center;
		width:700px;
		height:400px;
	}
	.stayUpdate{
		background:url(<?php echo base_url()?>templates/images/stayupdate.jpg) no-repeat top center;
		background-size:contain;
	}
		.mainText input[type="text"].emailInput{
			width:100%;
			box-sizing:border-box;
			text-align:center;
		}
		
		.rightText, .mainText{
			width:400px;
			float:right;
			margin-right:-55px;
			margin-top:80px;
		}
		.mainText{float:none;margin:0 auto 0;text-align:center;width:360px;padding:45px 0 0;}
			.rightText h3, .mainText h3{
				font-size:36px;
				margin-bottom:15px;
				color:#0071b7;
			}
			.rightText p, .mainText p{
				color:#2ca8dc;
				font-size:14px;
			}
</style>
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
                        <li><a href="<?php echo site_url('product/size'.'/'.$list['alias']);?>"><span><?php echo $list['name'];?></span></a></li> <?php }} ?>
            </ul>
        </div>
        <?php } ?>
        
        <?php $this->load->view('content/advertisement');?>
    </div>
</div>
<?php if($product){?>
<div class="products">
    <div class="productList">
        <?php if($product)foreach($product as $pro){?>
        <div class="productCon">
        	<?php if($pro['best_seller']==1){?><div class="best"></div><?php } ?>
			<?php if($pro['sale_product']==1 && $pro['discount']>0){?><div class="discFlag"><?php echo round($pro['discount'])?>% OFF</div><?php }?>
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
				<?php 
					if($pro['msrp']>$pro['price']){?>            
                    <span class="discount"><?php echo money($pro['price']);?></span>
                    <span class="afterDiscount"><?php echo money($pro['msrp']);?></span>
                    <?php }else{?>
                    <span class="normal"><?php echo money($pro['price']);?></span>
                <?php }?>
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
    
    
    <div class="contentRight">
        <div class="contentElement">
        	<?php  echo $content_page['content']?>
        </div>
        
    
        <div class="rightTextCon stayUpdate" style="width:640px">
            <div class="mainText">
                <h3>Stay Updated!</h3>
                <p>Want to know more about Torio?<br>
                   Enter your email to receive the latest information,
                   sales and promotions for all of our latest collections.</p>
                
                    <form id="newsletter_form2" name="newsletter_form2" method="post" action="#" onsubmit="return false;">
                        <input placeholder="Your email address"class="emailInput validate[custom[email],ajax[check_existing_email2]]" type="text" name="news_letter_email2" id="news_letter_email2" onchange="check_email_newsletter_registered(this.value);"/>
                        <input class="keepMe" type="submit" value="Keep Me Updated" id="newsletter_submit2"/>
                    </form>
       		</div>
        </div>
    </div>
	<?php }else{?>
    
    
    <div class="contentRight">
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