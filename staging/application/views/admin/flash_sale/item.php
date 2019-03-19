<div id="content">
    <h2>Flash Sale &raquo; <?php echo find('name',$this->uri->segment(4),'flash_sale_tb') ?> &raquo; Items</h2>
    <div id="submenu">
        <ul>
            <li><a class="defBtn" href="<?php echo site_url('torioadmin/sale/flash_sale') ?>">Back</a></li>
        </ul>
    </div>
    <?php //echo count($product)?>
	<dl>
    	<dd></dd>
        <dt><label><input type="checkbox" class="checkbox_selector"> Select All</label></dt>
    </dl>
    <form name="sale_item_form" id="sale_item_form" method="post" enctype="multipart/form-data" action="<?php echo site_url('torioadmin/sale/add_item') ?>">
    <input type="hidden" name="flash_sale_id" value="<?php echo $this->uri->segment(4); ?>" />
    <dl>
    	<dd><h2>Product</h2></dd>
        <dt>
			<?php if($product) foreach($product as $list){ 
					$check=0;
					if($item){
						foreach($item as $list2){
							if($list2['product_id']==$list['id']) $check=1;
						}
					}?>
                <label><input type="checkbox" class="checkall" name="id[]" id="id_<?php echo $list['id'] ?>" value="<?php echo $list['id'] ?>" <?php if($check==1) echo "checked"; ?> /> <?php echo $list['name'] ?></label><br>
            <?php }?>
    	</dt>
    </dl>
    <dl>
    	<dd></dd>
        <dt><input type="submit" value="Submit" /></dt>
    </dl>
    </form>
</div>

<script>
$(document).ready(function(){
	$(".checkbox_selector").click(function(){
		if($(this).attr('checked')=='checked'){
			$(".checkall").each(function(){
				$(".checkall").attr('checked','checked');			
			});		
		}
		else{
			$(".checkall").each(function(){
				$(".checkall").removeAttr('checked');			
			});		
		}
	});
});
</script>