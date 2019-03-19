<script>
function load_address(id){
	if(id==0){
	$("#recipient").val('');
	$("#phone").val('');
	$("#shipping").val('');
	$("#zipcode").val('');
	$("#area_code").val('');
	//$("#mobile").val('');
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
		dataType:"JSON",
		success: function(temp){
		//data=temp.split('|',8);
				<?php /*?>$("#user_address_id").val(data[0]);
				$("#recipient").val(data[1]);
				$("#shipping").val(data[2]);
				$("#phone").val(data[3]);
				$("#mobile").val(data[4]);
				$("#select_province").val(data[5]);
				var province_temp = data[5];<?php */?>
				
				
				
				$("#user_address_id").val(temp.id);
				$("#recipient").val(temp.recipient_name);
				$("#shipping").val(temp.shipping_address);
				$("#phone").val(temp.phone);
				$("#select_province").val(temp.province);
				var province_temp = temp.province;
				var city = temp.city;
				var zipcode = temp.zipcode;
				//var city = temp.city;
				
				
				$("#select_province option").each(function(){
					if($(this).val()==province_temp){
						var act=$(this).attr('act');	
						$(this).attr("selected", "selected");
						$("#uniform-select_province span").html(act);
					}
				});
				$.ajax({
					type: "POST",
					url: '<?php echo site_url('shopping_cart/load_city2').'/';?>'+province_temp,
					beforeSend:function(){
					$("#show_city").html('<img src="<?php echo base_url();?>templates/images/ajax-loader.gif">');
					},
					success: function(temp){
						$("#show_city").html(temp);
						$("#city").val(city);
						var city_temp = city;
						$("#city option").each(function(){
							if($(this).val()==city_temp){
								var acti=$(this).attr('act');	
								$(this).attr("selected", "selected");
								$("#uniform-city span").html(acti);
							}
						});
						load_shipping_method(city);
					}
				});
				$("#zipcode").val(zipcode);
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
	if($("#ship_method").val()=="")
	{
		alert('Please select your shipping method');
		$("#address_checkout_form").attr("onsubmit","return false;");
	}else{
		$("#address_checkout_form").removeAttr("onsubmit");
	}
}
</script>
<div class="shopCartContent">
    <h2>Shipping</h2>
    <div class="stepShopping">
        <a href="<?php echo site_url('shopping_cart');?>"><div class="firstStepDone">
            Shopping Cart
        </div>
        </a>
        <div class="otherStepDone">
            Shipping
        </div>
        <div class="lastStep">
            Payment
        </div>
    </div>
</div>
<div class="topShopCartInfo">
</div>
<form id="address_checkout_form" name="address_checkout_form" method="post" action="#" onsubmit="return false;">
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
                <dd>Recipient Name <span class="redStar">*</span></dd>
                <dt><input type="text" name="recipient" class="textTxt validate[required]" id="recipient" value="<?php if($detail)echo $detail['recipient_name']?>"/></dt>
            </div>
        </div>
        <div class="shippingCol">
            <div class="shipping">
                <dd id="loader">&nbsp;</dd>
                <dt>&nbsp;</dt>
            </div>
            <div class="shipping">
                <dd>Phone / Mobile <span class="redStar">*</span></dd>
                <dt><input type="text" class="textTxt validate[required]" name="phone" id="phone" value="<?php if($detail)echo $detail['phone']?>"/></dt>
            </div>
            <?php /*?><div class="shipping">
                <dd>Mobile <span class="redStar">*</span></dd>
                <dt><input type="text" class="textTxt validate[required]" name="mobile" id="mobile" value="<?php if($detail)echo $detail['mobile']?>"/></dt>
            </div><?php */?>
        </div>
    </div>
    <div class="shippingBox2">
        <div class="shippingCol">
            <div class="shipping">
                <dd>Shipping Address <span class="redStar">*</span></dd>
                <dt><textarea rows="3" name="shipping" id="shipping" class="addressTxt validate[required]"><?php if($detail)echo strip_tags($detail['shipping_address'])?></textarea></dt>
            </div>
            <div class="shipping">
            
			        <div style="display:block;overflow:hidden;">
                   		<span class="redStar">*</span> is required
                    </div>
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
                <dd>City <span class="redStar">*</span></dd>
                <dt id="show_city">
                
					<span class="shippingInfoCon">
                    <select class="recipient validate[required]" name="select_city" id="city" onchange="load_shipping_method(this.value);">
                        <option value="">Select City</option>
                        <?php if($city)foreach($city as $list2){
						//if($list2['jne_province_id']==$detail['province']){?>
                       <option value="<?php echo $list2['id'];?>" <?php if($detail)if($detail['city']==$list2['id'])echo "selected=\"selected\""?>><?php echo $list2['name']?></option>
						<?php }//}?>
                    </select><br/>
                    <span class="notifCity">Please <a href="<?php echo site_url('contact_us');?>" target="_blank">contact us</a> if your city isn't listed here</span>
                    </span>
                </dt>
            </div>
            <div class="shipping">
                <dd>Zip Code <span class="redStar">*</span></dd>
                <dt><input type="text" name="zipcode" id="zipcode" class="textTxt validate[required]" maxlength="5" value="<?php if($detail)echo $detail['zipcode']?>"/></dt>
            </div>
            <div class="shipping">
                <dd>Shipping Method <span class="redStar">*</span></dd>
                <dt id="ship_met">
                	<select class="recipient validate[required]" name="shipping_method" id="ship_method">
                        <?php if($sm['regular_fee']!=""){?><option value="<?php echo $sm['regular_fee'];?>">Regular (<?php if($sm['regular_fee']==0)echo "Free"." ".$sm['regular_etd']; else echo money($sm['regular_fee'])." ".$sm['regular_etd'];?>)</option><?php } ?>
     <?php if($sm['express_fee']!=""){?><option value="<?php echo $sm['express_fee'];?>">Express (<?php if($sm['express_fee']==0)echo "Free"." ".$sm['express_etd']; else echo money($sm['express_fee'])." ".$sm['express_etd'];?>)</option><?php } ?>
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
        <div class="proceed">
        <a href="javascript:void(0);" id="address_checkout_submit" onclick="submit_form();">Proceed to Next Step</a>
        </div>
    </div>
</div>
</form>