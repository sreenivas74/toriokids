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

	<h2>Product &raquo; Edit</h2>
	<form method="post" name="edit_product_form" id="edit_product_form" enctype="multipart/form-data" action="<?php echo site_url('torioadmin/product/do_edit_product'.'/'.$id);?>">
    <?php if($detail){ ?>
    <dl>
        <dd>Template </dd>
        <dt>
            <select class="txtField" name="template_id" id="template_id">
                <option value="" label="-- Select Template --">-- Select Template --</option>
                <?php if($template)foreach($template as $list){?>
                <option value="<?php echo $list['id']?>" <?php if($list['id']==$detail['template_id'])echo "selected=\"selected\""?>><?php echo $list['name']?></option>
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
                        <input id="inlineCheckbox<?php echo $list['id'];?>" type="checkbox"  value="<?php echo $list['name'];?>" name="category_name[]" onclick="get_category_downlink(<?php echo $list['id'];?>)" <?php if(in_array($list['name'],$category_name))echo "checked=\"checked\"";?>/> <?php echo $list['name'];?>
                	</label></p>
					<?php 
					if($sub_category) foreach ($sub_category as $slist){
						if($slist['category_id']==$list['id']){?>
                	<label class="downlink<?php echo $list['id'];?>" <?php if(in_array($list['name'],$category_name))echo 'style="padding-left:15px;"';else echo 'style="display:none;padding-left:15px;"';?>>
                        <input type="checkbox" value="<?php echo $slist['name'];?>" name="sub_category_name[]" <?php if(in_array($slist['name'],$sub_category_name))echo "checked=\"checked\"";?>/> <?php echo $slist['name'];?>
                	</label>
            	<?php 
						}
					}
				} ?>
           	</dt>
        </dl>
        <dl>
            <dd>New Product</dd>
            <dt><label><input class="radioBtn" type="radio" name="flag" id="flag" value="1" <?php if($detail['flag']==1)echo "checked=\"checked\""?>/> Yes </label></br>
                <label><input class="radioBtn" type="radio" name="flag" id="flag" value="0" <?php if($detail['flag']==0)echo "checked=\"checked\""?>/> No </label>
            </dt>
        </dl>
      
        <dl>
            <dd>Best Seller</dd>
            <dt><label><input class="radioBtn" type="radio" name="best_seller" id="best_seller" value="1" <?php if($detail['best_seller']==1)echo "checked=\"checked\""?>/> Yes </label></br>
                <label><input class="radioBtn" type="radio" name="best_seller" id="best_seller" value="0" <?php if($detail['best_seller']==0)echo "checked=\"checked\""?>/> No </label>
            </dt>
        </dl>
          <dl>
            <dd>Featured Product</dd>
            <dt><label><input class="radioBtn" type="radio" name="featured" id="featured" value="1"  <?php if($detail['featured']==1)echo "checked=\"checked\""?> /> Yes </label></br>
                <label><input class="radioBtn" type="radio" name="featured" id="featured" value="0" <?php if($detail['featured']==0)echo "checked=\"checked\""?> /> No </label>
            </dt>
        </dl>
        <dl>
            <dd>Name</dd>
            <dt><input class="txtField validate[required]" type="text" name="name" value="<?php echo $detail['name']?>"/></dt>
        </dl>
        <dl>
            <dd>Weight (kg)</dd>
            <dt><input class="txtField validate[required]" type="text" name="weight" id="weight" value="<?php echo $detail['weight']?>"/></dt>
        </dl>
        <dl>
            <dd>MSRP</dd>
            <dt><input class="txtField validate[required] msrp_price" type="text" name="msrp" id="msrp" onkeyup="get_discount_selling();" value="<?php echo $detail['msrp']?>"/></dt>
        </dl>
         <dl>
            <dd>Discount</dd>
            <dt><input class="txtField validate[required] discount_price" type="text" name="discount" id="discount" onkeyup="get_discount_selling();" value="<?php echo $detail['discount']?>"/></dt>
        </dl>
        
        <dl>
            <dd>Selling Price</dd>
            <dt><input class="txtField validate[required] selling_price" type="text" name="price" id="price" onkeyup="get_total_discount();" value="<?php echo $detail['price']?>"/></dt>
        </dl>
        <dl>
            <dd>Description</dd>
            <dt><textarea class="txtField validate[required]" type="text" name="description"><?php echo $detail['description']?></textarea></dt>
        </dl>
    <dl>
        <dd></dd>
       <dt><input type="submit" class="defBtn" id="edit_product_submit" value="Submit"/> <input type="button" class="defBtn" value="Back" onclick="window.location='<?php echo site_url('torioadmin/product');?>';" /></dt>
    </dl>
    <?php } ?>
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
  
 