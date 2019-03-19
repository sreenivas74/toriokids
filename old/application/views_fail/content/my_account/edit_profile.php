<script>
$(window).load(function(){
	$(".combodate select").uniform();
});
$(function(){
	$('#dob').combodate({
		firstItem: 'name',	
		errorClass:'error_date',
		maxYear:<?php echo date("Y");?>,
		minYear:1920
	});
});
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
	<?php $this->load->view('content/my_account/my_account_menu_mobile')?>
    <div class="noBg">
    <a href="<?php echo site_url('home');?>">Home </a>&gt;<a  href="<?php echo site_url('my_account');?>"> My Account </a>&gt;<a class="selectedBreadCrumb"> Edit Profile</a>
    </div>
    <div class="editAccCon">
    <form id="account_form" name="account_form" method="post" action="<?php echo site_url('my_account/do_edit');?>" >
        <div class="editAccBox">
            <h2>Edit Your Profile</h2>
        <table>
            <tr>
                <td width="30%">Full Name <span class="redStar">*</span></td>
                <td width="70%"><input class="inputTxt validate[required]" type="text" name="fullname" id="fullname" value="<?php echo $account['full_name'];?>"/></td>
            </tr>
            <tr>
                <td>Date of Birth <span class="redStar">*</span></td>
                <td>
                    <input id="dob" data-format="YYYY-MM-DD" data-template="D MMM YYYY" name="dob" value="<?php if($account['date_of_birth']!="0000-00-00")echo $account['date_of_birth'];?>" type="text">
                </td>
            </tr>
            <tr>
                <td>Phone / Mobile<span class="redStar">*</span></td>
                <td><input class="inputTxt validate[required]" type="text" name="telephone" id="telephone" value="<?php echo $account['telephone'];?>" /></td>
            </tr>
            <?php /*?><tr>
                <td>Phone Number <span class="redStar">*</span></td>
                <td><input type="text" name="telephone" id="telephone" value="<?php echo $account['telephone'];?>"  class="inputTxt validate[required]" /></td>
            </tr><?php */?>
            <tr>
                <td class="address">Address <span class="redStar">*</span></td>
                <td><textarea rows="10" name="address" id="address" class="addTxt validate[required]"><?php echo strip_tags($account['address'])?></textarea></td>
            </tr>
            <?php /*?><tr>
                <td>Province</td>
                <td>
                <select class="recipient" name="select_province" id="province" onchange="load_city(this.value);">
                    <option value="">Select Province</option>
                    <?php if($province)foreach($province as $list){?>
                   <option value="<?php echo $list['id'];?>" <?php if($account['province']==$list['id'])echo "selected=\"selected\""?>><?php echo $list['name']?></option>
                    <?php }?>
                </select>
                </td>
            </tr><?php */?>
            <tr>
                <td>City <span class="redStar">*</span></td>
                <td id="show_city">
                    <script>
					
					$(function() {
						$("#autokecamatan").autocomplete({	
							source: '<?php echo site_url('shopping_cart/get_kecamatan')?>',
							max:30,
							select: function( event, de ) {
								$("#city").val(de.item.id);								
							}
						});
					});	
					</script>
                    
                    <input type="text" class="inputTxt" id="autokecamatan" value="<?php echo find('name',$account['city'],'jne_city_tb');?>"></input>
                    <input type="hidden" name="select_city" id="city" value="<?php echo $account['city']?>" />  
                
                
                <?php /*?><select class="recipient validate[required]" name="select_city" id="city">
                    <option value="">Select City</option>
                    <?php if($city)foreach($city as $list2){
						//if($list2['jne_province_id']==$account['province']){?>
                   <option value="<?php echo $list2['id'];?>" <?php if($account['city']==$list2['id'])echo "selected=\"selected\""?>><?php echo $list2['name']?></option>
                    <?php }//}?>
                </select><?php */?><span class="notifCity">Please <a href="<?php echo site_url('contact_us');?>" target="_blank">contact us</a> if your city isn't listed here</span>
                </td>
            </tr>
            <tr>
                <td>Zipcode <span class="redStar">*</span></td>
                <td><input class="inputTxt validate[required]" type="text" name="postcode" id="postcode" maxlength="5" value="<?php echo $account['postcode'];?>" /></td>
            </tr>
            <tr>
                <td></td>
                <td><div style="display:block;overflow:hidden;">
					<span class="redStar">*</span> is required
				</div></td>
            </tr>
        </table>
        </div>
        <input type="submit" id="account_submit" class="btnBg" value="Edit Profile"/>
    </form>
    </div>
</div>               