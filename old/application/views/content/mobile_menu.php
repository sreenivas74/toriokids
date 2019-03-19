
<div class="searchMobile">
    <span>Search</span>
    <div class="searchMobileBox">
        <form name="search_form_mbl" id="search_form_mbl" method="get" action="<?php echo site_url('product/search');?>">
            <input type="text" name="search" id="search_mbl">
            <a class="searchBtn" id="search_btn_mbl" href="#">Search!</a>
        </form>
    </div>
</div>
<div class="categoriesMobile">
    <div class="categoryValueBox">
        <span class="categoryValueInput">
            <form action="">
                <select class="default_dropdown menu_selections" onchange="window.location=this.value;">
                
                <option value="" >New Arrivals</option>
                
           		 <optgroup label="">
                        <option value="<?php echo site_url('new_arrivals')?>" <?php if(isset($page) && $page=='new_arrivals')echo "selected"?>>New Arrival</option>
                                                   
                <option value="<?php echo site_url('product/sale')?>" <?php if(isset($page) && $page=='sale')echo "selected"?>>Sale</option>
                <option value="<?php echo site_url('product/best_seller')?>" <?php if(isset($page) && $page=='best_seller')echo "selected"?>>Best Seller</option>
                    </optgroup>
                
                
                
            	<?php if($category){?>
               <optgroup label="--shop by category--">
                <?php foreach($category as $list){?>
                <option value="<?php echo site_url('product/view_product_per_category'.'/'.$list['alias']);?>" <?php if($alias==$list['alias'])echo "selected"?>><?php echo $list['name'];?></option>
                <?php }?>
                </optgroup>
                <?php }?>
                
                <?php if($template){?>
                <optgroup label="--shop by size--">
                <?php foreach($template as $list){	if(check_product_size($list['id'])>0){?>
                    <option value="<?php echo site_url('product/size'.'/'.$list['alias']);?>" <?php if(isset($template_detail) && $template_detail['id']==$list['id'])echo 'selected'?>><?php echo $list['name']?></option>
                    <?php }}?>
				</optgroup>
					
			<?php		}?>
                    
                
                </select>
            </form>
        </span>
    </div>
    <?php /*?><div class="sizeValueBox">
        <span class="sizeValueInput">
            <form action="">
                <select class="default_dropdown size_selection">
                    <option value="default">--shop by size--</option><?php if($template)foreach($template as $list){	if(check_product_size($list['id'])>0){?>
                    <option value="<?php echo site_url('product/size'.'/'.$list['alias']);?>" <?php if(isset($template_detail) && $template_detail['id']==$list['id'])echo 'selected'?>><?php echo $list['name']?></option>
                    <?php }}?>
                </select>
            </form>
        </span>
    </div><?php */?>
</div>
<script>
$(document).ready(function(e) {
    $(".menu_selections").change(function(){
		if($(this).val()!='default'){
			window.location=$(this).val();
		}
	});
    $(".size_selection").change(function(){
		if($(this).val()!='default'){
			window.location=$(this).val();
		}
	});
	$("#search_btn_mbl").click(function(){
		
		var keyword = $('#search_mbl').val();
		if (keyword=="")
		{
	//		alert('Minimum 3 characters for search');
			return false;
		}
		else 
		{	
			$('#search_form_mbl').submit();
			return true;
		}
	});
});
</script>

