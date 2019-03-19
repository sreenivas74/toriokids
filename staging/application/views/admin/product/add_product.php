<script type="text/javascript">
function get_category_downlink(id){
	if($("#inlineCheckbox"+id).attr('checked'))	{
		$('.downlink'+id).show();
	}else{
		$('.downlink'+id).hide();
	}
}
</script>
<div id="content">
	<h2>Product &raquo; Add</h2>
	<form method="post" name="add_product_form" id="add_product_form" enctype="multipart/form-data" action="<?php echo site_url('torioadmin/product/do_add_product');?>">
    <dl>
        <dd>Template </dd>
        <dt>
            <select class="txtField" name="template_id" id="template_id">
                <option value="" label="-- Select Template --">-- Select Template --</option>
                <?php if($template)foreach($template as $list){?>
                <option value="<?php echo $list['id']?>"><?php echo $list['name']?></option>
                <?php } ?>
            </select>
        </dt>
    </dl>
    	<dl>
            <dd>Category</dd>
            <dt>
            	<?php 
				if($category) foreach ($category as $list){?>
                	<p><label>
                        <input id="inlineCheckbox<?php echo $list['id'];?>" type="checkbox"  value="<?php echo $list['id'];?>" name="category_name[]" onclick="get_category_downlink(<?php echo $list['id'];?>)"/> <?php echo $list['name'];?>
                	</label></p>
					<?php 
					if($sub_category) foreach ($sub_category as $slist){
						if($slist['category_id']==$list['id']){?>
                	<label class="downlink<?php echo $list['id'];?>" style="display:none;padding-left:15px;">
                        <input type="checkbox" value="<?php echo $slist['id'];?>" name="sub_category_name[]"/> <?php echo $slist['name'];?>
                	</label>
            	<?php 
						}
					}
				} ?>
           	</dt>
        </dl>
        <dl>
            <dd>New Product</dd>
            <dt><label><input class="radioBtn" type="radio" name="flag" id="flag" value="1" /> Yes </label></br>
                <label><input class="radioBtn" type="radio" name="flag" id="flag" value="0" /> No </label>
            </dt>
        </dl>
       
        <dl>
            <dd>Best Seller</dd>
            <dt><label><input class="radioBtn" type="radio" name="best_seller" id="best_seller" value="1" /> Yes </label></br>
                <label><input class="radioBtn" type="radio" name="best_seller" id="best_seller" value="0" /> No </label>
            </dt>
        </dl>
         <dl>
            <dd>Featured Product</dd>
            <dt><label><input class="radioBtn" type="radio" name="featured" id="featured" value="1" /> Yes </label></br>
                <label><input class="radioBtn" type="radio" name="featured" id="featured" value="0" /> No </label>
            </dt>
        </dl>
        <dl>
            <dd>Name</dd>
            <dt><input class="txtField validate[required]" type="text" name="name" id="name"/></dt>
        </dl>
        <dl>
            <dd>SKU</dd>
            <dt><input class="txtField" type="text" name="sku" id="sku"/></dt>
        </dl>
        <dl>
            <dd>Weight (kg)</dd>
            <dt><input class="txtField validate[required]" type="text" name="weight" id="weight"/></dt>
        </dl>
      
        <dl>
            <dd>MSRP</dd>
            <dt><input class="txtField validate[required]" type="text" name="msrp" id="msrp" value="0" class="msrp_price" onkeyup="get_discount_selling();"/></dt>
        </dl>
         <dl>
            <dd>Discount</dd>
            <dt><input class="txtField validate[required]" type="text" name="discount" id="discount" value="0" class="discount_price" onkeyup="get_discount_selling();"/></dt>
        </dl>
        
        <dl>
            <dd>Selling Price</dd>
            <dt><input class="txtField validate[required]" type="text" name="price" id="price" value="0" class="selling_price" onkeyup="get_total_discount();"/></dt>
        </dl>
       
      
        <dl>
            <dd>Description</dd>
            <dt><textarea class="txtField" type="text" name="description"></textarea></dt>
        </dl>
        <dl>
            <dd>Active/Inactive</dd>
            <dt><label><input class="radioBtn" type="radio" name="active" id="featured" value="1" selected /> Yes </label></br>
                <label><input class="radioBtn" type="radio" name="active" id="featured" value="0" /> No </label>
            </dt>
        </dl>
    <dl>
        <dd></dd>
       <dt><input type="submit" class="defBtn" id="add_product_submit" value="Submit"/> <input type="button" class="defBtn" value="Back" onclick="window.location='<?php echo site_url('torioadmin/product');?>';" /></dt>
    </dl>
    </form>
</div>
<script>
  	function get_discount_selling(){
		//alert('a');
		var msrp =$('#msrp').val();
		var discount =$('#discount').val();
		discount=parseInt(discount);
		selling_price=(msrp*(100-discount)/100);
		if(!isNaN(selling_price))
		$('#price').val(selling_price);	
		else 
		$('#price').val(0);		
	}
	
	function get_total_discount(){
		
		selling_price=$("#price").val();
		selling_price=parseInt(selling_price);
		
		msrp_price=$("#msrp").val();
		msrp_price=parseInt(msrp_price);
		
		discount=((msrp_price-selling_price)/msrp_price)*100;
		discount=discount.toFixed(2);
		console.log(discount);
		if(!isNaN(discount))
		$("#discount").val(discount);
		else 
		$("#discount").val(0);
	}
</script>
  
 