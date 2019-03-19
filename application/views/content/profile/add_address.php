<script>
$(function() {
        $("#city").autocomplete({ 
          source: '<?php echo site_url('shopping_cart/get_kecamatan')?>',
           max:30,
            select: function( event, de ) {
                //alert(de.item.id);
                //console.log(de.item);
                $("#city_billing").val(de.item.id)
                                            
            }
                
        });
    });     
</script>
<section>
        	<div class="contentWrapper">
            	<div class="mainWrapper nobanner">
                	<div class="inputWrapper">
                        <h3>Add Address</h3>
                        <br>
                        <div class="inputField addAddress">
                            <form method="post" id="formedit" action="<?php echo site_url('my_profile/do_add_address') ?>" >
                            <input class="defTxtInput <?php if(isset($error_label)){ ?> error <?php } ?>" name="label" placeholder="Label*" value="<?php if(isset($label)){ echo $label; } ?>">
                            <div class="errorBox">
                                <?php if(isset($error_label)){ ?>
                                <span class="errorMsg"><?php echo $error_label ?></span>
                                <?php } ?>
                            </div>
                            <input class="defTxtInput <?php if(isset($error_name)){ ?> error <?php } ?>" id="name" name="name" placeholder="Name*" value="<?php if(isset($name)){ echo $name; } ?>" >
                            <div class="errorBox">
                                <?php if(isset($error_name)){ ?>
                                <span class="errorMsg"><?php echo $error_name ?></span>
                                <?php } ?>
                            </div>
                            <input class="defTxtInput <?php if(isset($error_phone)){ ?> error <?php } ?>" id="phone" name="phone" placeholder="Phone Number*" value="<?php if(isset($phone)){ echo $phone; } ?>" >
                            <div class="errorBox">
                                <?php if(isset($error_phone)){ ?>
                                <span class="errorMsg"><?php echo $error_phone ?></span>
                                <?php } ?>
                            </div>
                            <textarea class="defTxtInput <?php if(isset($error_address)){ ?> error <?php } ?>" id="address" name="shipping_address" placeholder="Address*"><?php if(isset($address)){ echo $address; } ?></textarea>
                            <div class="errorBox">
                                <?php if(isset($error_address)){ ?>
                                <span class="errorMsg"><?php echo $error_address ?></span>
                                <?php } ?>
                            </div>
                            <input class="defTxtInput <?php if(isset($error_city)){ ?> error <?php } ?>" id="city" name="city" placeholder="City*" value="<?php if(isset($city_name)){ echo $city_name; } ?>" >
                            <div class="errorBox">
                                <?php if(isset($error_city)){ ?>
                                <span class="errorMsg"><?php echo $error_city ?></span>
                                <?php } ?>
                            </div>
                            <input type="hidden" name="address_type" value="<?php echo $address_type ?>">
                            <input type="hidden" name="user_id" value="<?php echo $this->session->userdata('user_id'); ?>">
                            <input type="hidden" name="personal_city" id="city_billing" value="<?php if(isset($city)){ echo $city; } ?>" />
                            <input class="defTxtInput half <?php if(isset($error_zipcode)){ ?> error <?php } ?> " id="zipcode" name="zipcode" placeholder="ZIP Code*" value="<?php if(isset($zipcode)){ echo $zipcode; } ?>">
                            <div class="errorBox">
                                <?php if(isset($error_zipcode)){ ?>
                                <span class="errorMsg"><?php echo $error_zipcode ?></span>
                                <?php } ?>
                            </div>
                            <a href="javascript:void(0)" id="submit_edit" class="defBtn">CREATE</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <script>
        $('#submit_edit').click(function(){
            $("#formedit").submit();
        });
        </script>