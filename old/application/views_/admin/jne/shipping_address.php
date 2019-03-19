<script>
function load_address(id){
	if(id==0){
	$("#recipient").val('');
	$("#phone").val('');
	$("#shipping").val('');
	$("#zipcode").val('');
	$("#area_code").val('');
	$("#mobile").val('');
	$("#select_province").val('0');
	$("#city").val('0');
	$("#uniform-select_province span").html('Select Province');
	$("#select_province option").removeAttr("selected", "selected");
	$("#uniform-city span").html('Select City');
	$("#city option").removeAttr("selected", "selected");
	load_shipping_method(0);
	}else{
	$.ajax({
		type: "POST",
		url: '<?php echo site_url('shopping_cart/load_address').'/';?>'+id,
		beforeSend:function(){
			$("#loader").html('<img src="<?php echo base_url();?>templates/images/ajax-loader.gif">');
		},
		success: function(temp){
		data=temp.split('|',8);
				$("#user_address_id").val(data[0]);
				$("#recipient").val(data[1]);
				$("#shipping").val(data[2]);
				$("#phone").val(data[3]);
				$("#mobile").val(data[4]);
				$("#select_province").val(data[5]);
				var province_temp = data[5];
				$("#select_province option").each(function(){
					if($(this).val()==province_temp){
						var act=$(this).attr('act');	
						$(this).attr("selected", "selected");
						$("#uniform-select_province span").html(act);
					}
				});
				$.ajax({
					type: "POST",
					url: '<?php echo site_url('shopping_cart/load_city2').'/';?>'+data[6],
					beforeSend:function(){
					$("#show_city").html('<img src="<?php echo base_url();?>templates/images/ajax-loader.gif">');
					},
					success: function(temp){
						$("#show_city").html(temp);
						$("#city").val(data[6]);
						var city_temp = data[6];
						$("#city option").each(function(){
							if($(this).val()==city_temp){
								var acti=$(this).attr('act');	
								$(this).attr("selected", "selected");
								$("#uniform-city span").html(acti);
							}
						});
						load_shipping_method(data[6]);
					}
				});
				$("#zipcode").val(data[7]);
				$("#loader").html('&nbsp;');
		}
	});
	}
}

function load_city(id){
	if(id!=0){
		$.ajax({
			type: "POST",
			url: '<?php echo site_url('shopping_cart/load_city').'/';?>'+id,
			beforeSend:function(){
			$("#show_city").html('<img src="<?php echo base_url();?>templates/images/ajax-loader.gif">');
			},
			success: function(temp){
				$("#city").val('0');
				$("#show_city").html(temp);
			}
		});
		}else {
			$("#city").val('0');
		}
}

function load_shipping_method(id){
	if(id!=0){
		$.ajax({
			type: "POST",
			url: '<?php echo site_url('shopping_cart/load_shipping_method').'/';?>'+id,
			beforeSend:function(){
			$("#ship_met").html('<img src="<?php echo base_url();?>templates/images/ajax-loader.gif">');
			},
			success: function(temp){
				$("#ship_met").html(temp);
			}
		});
		}else {
			$("#ship_method").val('0');
		}
}

function submit_form()
{
	if($("#ship_method").val()==0)
	{
		alert('Please select your shipping method');
		$("#address_checkout_form").attr("onsubmit","return false;");
	}else{
		$("#address_checkout_form").removeAttr("onsubmit");
	}
}
</script>
<div class="shopCartContent">
    <h2>Enter Shipping Address</h2>
    <div class="stepShopping">
        <div class="firstStepDone"><a href="<?php echo site_url('shopping_cart');?>">Review Your<br />Shopping Cart</a></div>
        <div class="otherStepDone">Enter Shipping<br />Information</div>
        <div class="otherStep">Review &amp; Confirm<br />Your Order</div>
        <div class="otherStep">Payment</div>
        <div class="lastStep">Finish!</div>
    </div>
</div>
<div class="topShopCartInfo">
</div>
<form id="address_checkout_form" name="address_checkout_form" method="post" action="<?php echo site_url('shopping_cart/address');?>">
<div class="shippingCon">
    <div class="shippingBox">
        <div class="shippingCol">
        	<div class="shipping">
                <dd>Select Recipient</dd>
                <dt>
                	<select class="recipient" name="select_recipient" onchange="load_address(this.value);">
                        <option value="">Create New</option>
                        <?php if($address)foreach($address as $list){?>
                       <option value="<?php echo $list['id'];?>" <?php if($detail)if($list['id']==$detail['id'])echo "selected=\"selected\"";?>><?php echo $list['recipient_name']?></option>
                        <?php }?>
                    </select>
                </dt>
            </div>
            <div class="shipping">
                <dd>Recipient Name</dd>
                <dt><input type="text" name="recipient" class="textTxt validate[required]" id="recipient" value="<?php if($detail)echo $detail['recipient_name']?>"/></dt>
            </div>
        </div>
        <div class="shippingCol">
            <div class="shipping">
                <dd id="loader">&nbsp;</dd>
                <dt>&nbsp;</dt>
            </div>
            <div class="shipping">
                <dd>Phone Number</dd>
                <dt><input type="text" class="textTxt validate[required]" name="phone" id="phone" value="<?php if($detail)echo $detail['phone']?>"/></dt>
            </div>
            <div class="shipping">
                <dd>Mobile</dd>
                <dt><input type="text" class="textTxt" name="mobile" id="mobile" value="<?php if($detail)echo $detail['mobile']?>"/></dt>
            </div>
        </div>
    </div>
    <div class="shippingBox2">
        <div class="shippingCol">
            <div class="shipping">
                <dd>Shipping Address</dd>
                <dt><textarea rows="3" name="shipping" id="shipping" class="addressTxt validate[required]"><?php if($detail)echo strip_tags($detail['shipping_address'])?></textarea></dt>
            </div>
        </div>
        <div class="shippingCol">
            <?php /*?><div class="shipping">
                <dd>Province</dd>
                <dt>
                    <select class="recipient" name="select_province" id="select_province" onchange="load_city(this.value);">
                        <option value="">Select Province</option>
                        <?php if($province)foreach($province as $list2){?>
                       <option value="<?php echo $list2['id'];?>" act="<?php echo $list2['name']?>" <?php if($detail)if($list2['id']==$detail['province'])echo "selected=\"selected\""?>><?php echo $list2['name']?></option>
                        <?php }?>
                    </select>
                </dt>
            </div><?php */?>
            <div class="shipping">
                <dd>City</dd>
                <dt id="show_city">
                    <select class="recipient" name="select_city" id="city" onchange="load_shipping_method(this.value);">
                        <option value="">Select City</option>
                        <?php if($city)foreach($city as $list2){
						//if($list2['jne_province_id']==$detail['province']){?>
                       <option value="<?php echo $list2['id'];?>" <?php if($detail)if($detail['city']==$list2['id'])echo "selected=\"selected\""?>><?php echo $list2['name']?></option>
						<?php }//}?>
                    </select>
                </dt>
                <dt>Please contact us if your city isn't listed here</dt>
            </div>
            <div class="shipping">
                <dd>Zip Code</dd>
                <dt><input type="text" name="zipcode" id="zipcode" class="textTxt validate[required]" value="<?php if($detail)echo $detail['zipcode']?>"/></dt>
            </div>
        </div>
    </div>
    <div class="shippingBox">
        <div class="shippingCol">
        	<div class="shipping">
                <dd>Shipping Method</dd>
                <dt id="ship_met">
                	<select class="recipient" name="shipping_method" id="ship_method">
                        <option value="">Shipping Method</option>
                        <?php if($sm['regular_fee']!=""){?><option value="<?php echo $sm['regular_fee'];?>">Regular (<?php echo money($sm['regular_fee'])." ".$sm['regular_etd'];?>)</option><?php } ?>
     <?php if($sm['express_fee']!=""){?><option value="<?php echo $sm['express_fee'];?>">Express (<?php echo money($sm['express_fee'])." ".$sm['express_etd'];?>)</option><?php } ?>
                    </select>
                </dt>
            </div>
        </div>
    </div>
</div>
<div class="topShopCartInfo"></div>
<div class="botShopCartInfo">
    <div class="botLeftCart">
        <p>Please enter your information and the shipping address information above. Review and ensure that the data is correct before you confirm your order. Torio is not responsible for failure of delivery in result of mistaken address and/or any other shipping information.</p>
    </div>
    <div class="botRightCartCon">
        <div class="proceed"><a href="javascript:void(0);" id="address_checkout_submit" onclick="submit_form();">Proceed to Next Step</a>
        </div>
    </div>
</div>
</form>