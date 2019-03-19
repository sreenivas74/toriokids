<script>
function load_city(id){
	if(id!=0){
		$.ajax({
			type: "POST",
			url: '<?php echo site_url('my_addresses/load_city').'/';?>'+id,
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
</script>
<?php $this->load->view('content/my_account/my_account_menu');?>        
<div class="editContainer">
    <div class="noBg">
    <a href="<?php echo site_url('home');?>">Home </a>&gt;<a href="<?php echo site_url('my_account');?>"> My Account </a>&gt;<a href="<?php echo site_url('my_addresses');?>"> My Addresses </a>&gt;<a class="selectedBreadCrumb"> Edit Address</a>
    </div>
    <div class="editAccCon">
        <div class="editAccBox">                    
    		<h2>Edit Address</h2>
    <form id="address_form" name="address_form" method="post" action="<?php echo site_url('my_addresses/do_edit/'.$address['id']);?>" >
    <input type="hidden" name="user_id" value="<?php echo $this->session->userdata('user_id');?>" />
        <table>
            <tr>
                <td width="30%">Recipient Name <span class="redStar">*</span></td>
                <td width="70%"><input class="inputTxt validate[required]" type="text" name="recipient" id="recipient" value="<?php echo $address['recipient_name'];?>" /></td>
            </tr>
            <tr>
                <td>Mobile / Phone<span class="redStar">*</span></td>
                <td><input class="inputTxt validate[required]" type="text" name="phone" id="phone" value="<?php echo $address['phone'];?>" /></td>
            </tr>
            <?php /*?><tr>
                <td>Mobile <span class="redStar">*</span></td>
                <td><input class="inputTxt validate[required]" type="text" name="mobile" id="mobile" value="<?php echo $address['mobile'];?>" /></td>
            </tr><?php */?>
            <tr>
                <td>Shipping Address <span class="redStar">*</span></td>
                <td><textarea rows="3" name="shipping" id="shipping" class="addTxt validate[required]"><?php echo strip_tags($address['shipping_address'])?></textarea></td>
            </tr>
            <?php /*?><tr>
                <td>Province</td>
                <td>
                <select class="recipient" name="select_province" id="province" onchange="load_city(this.value);">
                    <option value="">Select Province</option>
                    <?php if($province)foreach($province as $list){?>
                   <option value="<?php echo $list['id'];?>" <?php if($address['province']==$list['id'])echo "selected=\"selected\""?>><?php echo $list['name']?></option>
                    <?php }?>
                </select>
                </td>
            </tr><?php */?>
            <tr>
                <td>City <span class="redStar">*</span></td>
                <td id="show_city">
                <select class="recipient validate[required]" name="select_city" id="city">
                    <option value="">Select City</option>
                    <?php if($city)foreach($city as $list2){
						//if($list2['jne_province_id']==$address['province']){?>
                   <option value="<?php echo $list2['id'];?>" <?php if($address['city']==$list2['id'])echo "selected=\"selected\""?>><?php echo $list2['name']?></option>
                    <?php }//}?>
                </select><br/><span class="notifCity">Please <a href="<?php echo site_url('contact_us');?>" target="_blank">contact us</a> if your city isn't listed here</span>
                </td>
            </tr>
            <tr>
                <td>Zipcode <span class="redStar">*</span></td>
                <td><input class="inputTxt validate[required]" type="text" name="zipcode" id="zipcode" maxlength="5" value="<?php echo $address['zipcode'];?>" /></td>
            </tr>
        <tr>
            <td></td>
            <td><div style="display:block;overflow:hidden;">
                        		<span class="redStar">*</span> is required
                            </div></td>
        </tr>
    </table>
                        	
    	<input class="btnBg" type="submit" value="Submit" id="address_submit" />
    </form>
		</div>
    </div>
</div>               