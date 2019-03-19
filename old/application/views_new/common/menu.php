<script type="text/javascript">
function validate()
{
	var keyword = $('#search').val();
	if (keyword=="")
	{
//		alert('Minimum 3 characters for search');
		return false;
	}
	else 
	{	
		$('#search_form').submit();
		return true;
	}
}
</script>
<nav id="navCon">
    <div class="navBox">
        <div class="navMenu">
            <ul>
            	<li><a href="<?php echo site_url('new_arrivals')?>" <?php if(isset($page) && $page=='new_arrivals')echo "class=\"active\""?>>New Arrivals</a></li>
            	<?php if($category)foreach($category as $list){?>
                <li><a href="<?php echo site_url('product/view_product_per_category'.'/'.$list['alias']);?>" <?php if($alias==$list['alias']){?>class="active"<?php }?>><?php echo $list['name'];?></a>
                    <ul><?php /*if(check_new_arrival($list['name'])>0){?>
                        <li><a href="<?php echo site_url('product/view_new_arrival'.'/'.$list['alias']);?>"><span>New Arrivals</span></a></li>
                        <?php }*/?>
                        <?php if($sub_category)foreach($sub_category as $slist){
									if($slist['category_id']==$list['id']){	?>
                        <li><a href="<?php echo site_url('product/view_product_per_sub_category'.'/'.$slist['alias'].'/'.$list['id']);?>"><span><?php echo $slist['name'];?></span></a></li> <?php }} ?>
                    </ul>
                </li>
                <?php } ?>
                <?php /*?><li class="staticMenu"><a href="<?php echo base_url()."about_us"?>" <?php if($this->uri->segment(2)=="the_torio_story_1" or $this->uri->segment(1)=="about_us")echo "class=\"active\"";?>>About Torio</a></li>
                <li class="staticMenu"><a href="<?php echo base_url()."contact_us"?>" <?php if($this->uri->segment(1)=="contact_us")echo "class=\"active\"";?>>Contact Us</a></li><?php */?>
            	<?php /*?><li><a href="<?php echo site_url('content/find-a-store-6')?>">Location</a></li><?php */?>
            </ul>
        </div>
    
    
        <ul class="sellContainer">
            <li><a href="<?php echo site_url('product/sale')?>" class="saleBtn">Sale</a></li>
            <li><a href="<?php echo site_url('product/best_seller')?>" class="bestSellerBtn">Best Seller</a></li>
        </ul>
        <div class="searchBox">
            <div class="searchBoxLeft">Search</div>
            <div class="searchBoxRight">
            <form name="search_form" id="search_form" method="get" action="<?php echo site_url('product/search');?>">
                <input class="searchBoxInputTxt" type="text" name="search" id="search"/><input class="searchBoxInputBtn" type="submit" onclick="return validate();" title="Search Items"/>
            </form>
            </div>
        </div>
    </div>
</nav>