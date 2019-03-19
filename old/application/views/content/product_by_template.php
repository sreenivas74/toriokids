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
            <img src="<?php echo base_url() ?>userdata/smallbanner/before_flash_sale.png" alt="flashSaleImg" />
            <div class="beforeFsCd"></div>
        </a>
    </div>
    <div class="mobileFlashSale">
        <a href="#">
            <div class="beforeFsCd"></div>
        </a>
        <span class="flashSaleTxt">Tunggu tanggal 5 Februari 2015!</span>
    </div>
</div>
<?php }?>

<?php $this->load->view('content/mobile_menu')?><div class="categoriesWrap">
    <div class="categories">
        <div class="category"><h2><?php echo $template_detail['name']?></h2></div>
        <div class="shopBy">Shop By Category</div>
        <div class="subCategory">
            <ul><?php if($category)foreach($category as $list){?>
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
<div class="products">
	<h2><?php echo $template_detail['name']?></h2><br />
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
        	<?php if($pro['best_seller']==1){?><div class="best"></div><?php } ?>
			<?php if($pro['sale_product']==1 && $pro['discount']>0 && $schedule_sale){?><div class="discFlag"><?php echo round($pro['discount'])?>% OFF</div><?php }?>
            <div class="productImgBox">
                <div class="productImage">
                    <a href="<?php echo site_url('product/view_product_detail'.'/'.$pro['alias'])?>"  title="<?php echo $pro['name'];?>"><img src="<?php echo base_url();?>userdata/product/med/<?php echo find_2_prec('image', 'product_id', $pro['id'], 'product_image_tb');?>" alt="<?php echo $pro['name'];?>"/></a>
                    <?php /*?><a href="<?php echo site_url('product/view_product_detail'.'/'.$pro['alias']);?>" class="viewDetail" title="<?php echo $pro['name'];?>"></a><?php */?>
                    <a href="#" class="quickDetail" rel="<?php echo $pro['alias'];?>">Quick View</a>
                    <?php /*?><a href="<?php echo site_url('product/view_product_detail'.'/'.$pro['alias']);?>" class="quickDetail" title="<?php echo $pro['name'];?>"></a><?php */?>
                </div>   
            </div>                 
            <?php /*?><div class="item_loader">
                <img src="<?php echo base_url();?>templates/images/ajax-loader.gif" />
            </div><?php */?>
            <div class="productTxt">
                <h3 class="productName"><a href="<?php echo site_url('product/view_product_detail'.'/'.$pro['alias']);?>" title="<?php echo $pro['name'];?>"><b><?php echo $pro['name'];?></b></a></h3>

                <?php if($sale_id==0){?>
					<?php 
                    if($pro['msrp']>$pro['price'] && $schedule_sale){?>            
                    <span class="discount"><?php echo money($pro['price']);?></span>
                    <span class="afterDiscount"><?php echo money($pro['msrp']);?></span>
                    <?php }else{?>
                    <span class="normal"><?php echo money($pro['msrp']);?></span>
                    
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
<?php /*?>
<script>
	$(document).ready(function(){
		$(".productImage a img").each(function(){
			$(this).load(function(){
				$(this).parents('.productCon').find('.item_loader').hide();
				$(this).parents('.productCon').find('.productImage').fadeIn();
			});
		});
	});
</script>
<?php */?>