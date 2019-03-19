var obj = null;

function submit_shipping_address(){

	$("#address_checkout_form").attr('action',base_url+'shopping_cart/address');
	$("#address_checkout_form").removeAttr('onsubmit');
	$("#address_checkout_form").submit();
}
function submit_shipping_address_guest(){

	$("#address_checkout_form2").attr('action',base_url+'shopping_cart/address_guest');
	$("#address_checkout_form2").removeAttr('onsubmit');
	$("#address_checkout_form2").submit();
}

function checkHover() {
	if (obj) {
		obj.find(":first-child").removeClass('selected');
    	obj.find('.dropdownNav').hide();
    }
}

function check_password_registered(email){
	$.ajax({
	   type: "POST",
	   url: base_url+'/change_password/check_password_registered',
	   data: 'email='+email,			  
	   success: function(temp){
	   		data=temp.split('|',2); 		
			if(data[0]==0){	
				//registered
				$("#error_place_sign_up").show();		
				$("#loader_sign_up").html('');				
				$("#error_field_sign_up").css('color','red');	
				$("#error_field_sign_up").html(data[1]);
				$("#changepass_form").attr("onsubmit","return false;");
			}
			else{
				$("#error_place_sign_up").hide();		
				$("#loader_sign_up").html('');		
				$("#error_field_sign_up").css('color','red');	
				$("#error_field_sign_up").html('');
				$("#changepass_form").removeAttr("onsubmit");
				//$("#register_form").submit();
			}
	   }
	});		
}


function check_email_registered(email){
	$.ajax({
	   type: "POST",
	   url: base_url+'/registration/check_email_registered',
	   data: 'email='+email,			  
	   success: function(temp){
	   		//data=temp.split('|',2); 		
			data=temp;
			//if(data[0]==0){	
			if(data=='2'){	
				//registered
				//$("#error_place_sign_up").show();		
				//$("#loader_sign_up").html('');				
				//$("#error_field_sign_up").css('color','red');	
				//$("#error_field_sign_up").html(data[1]);
				//$("#register_form").attr("onsubmit","return false;");
			}
			else{
				//$("#error_place_sign_up").hide();		
				//$("#loader_sign_up").html('');		
				//$("#error_field_sign_up").css('color','red');	
				//$("#error_field_sign_up").html('');
				//$("#register_form").attr("onsubmit","return false;");
				$("#register_form").removeAttr("onsubmit");
				//$("#register_form").submit();
			}
	   }
	});		
}

if($('.subscribe').length > 0){
		$('#email').focus();
	}

function check_email_newsletter_registered(email){
	$.ajax({
	   type: "POST",
	   url: base_url+'newsletter/check_email_newsletter_registered',
	   data: 'email='+email,			  
	   success: function(temp){
	   		//data=temp.split('|',2);
			data=temp; 		
			if(data=='2'){	
				//registered
				/*$("#error_place_sign_up").show();		
				$("#loader_sign_up").html('');				
				$("#error_field_sign_up").css('color','red');	
				$("#error_field_sign_up").html(data[1]);*/
				//$("#newsletter_form").attr("onsubmit","return false;");
			}
			else{
				/*$("#error_place_sign_up").hide();		
				$("#loader_sign_up").html('');		
				$("#error_field_sign_up").css('color','red');	
				$("#error_field_sign_up").html('');*/
				$("#newsletter_form").removeAttr("onsubmit");
				$("#newsletter_form2").removeAttr("onsubmit");
				//$("#newsletter_form").submit();
			}
	   }
	});		
}

function totHeight(){
	var heightTotal = $('.stampPopup').find('.stampPopupBox').height();
	$('.stampPopup').css('margin-top', -(heightTotal/2));
}

//fixed nav bar appearance
$(window).bind('scroll', function(){
	//console.log($(window).scrollTop());
	if($(window).scrollTop() > $('header').height()){
		$('.fixedHeader').fadeIn();
	}
	else{
		$('.fixedHeader').fadeOut();
	}
});

$(document).ready(function() {
	$('.overlay').css('opacity', '0.7');
	$('.stampPopup').css({'marginLeft':-($(".stampPopupBox").width()*0.5)});
	
	if($('.contentScroll').length > 1){
		$('#contentScroll').jScrollPane({
			verticalDragMinHeight: 35,
			verticalDragMaxHeight: 35,
		});
	}
	$('#overlay').click(function(){
		$('.popup, .popup2').fadeOut();
		$('#overlay').fadeOut();
		$('.stampPopup').fadeOut();
	});
	$('#overlay').bind('click');
	$('.close').click(function(){
		$('.popup, .stampPopup').fadeOut();
		$('#overlay').fadeOut();
	});
	$('.close2').click(function(){
		$('.popup2').fadeOut();
		$('#overlay').fadeOut();
	});
	$('.creditCard').click(function(){
		$('#overlay').fadeIn();
		$('#paymentPopup').fadeIn();
		$('#overlay').unbind('click');
		return false;
	});
	$('.productImage').mouseenter(function(){
		$('.quickDetail', this).animate({height:"30px"}, {queue:false,duration:200});
		$('.quickDetail', this).css("display","block");
		return false;
	});
	$('.productImage').mouseleave(function(){
		$('.quickDetail').animate({height:"0px"},{queue:false,duration:200});
		return false;
	});
	$('.quickDetail').click(function(){
		$('.overlay').fadeIn();
		alias=$(this).attr('rel');
		$.ajax({
		   type: "POST",
		   url: base_url+'product/product_detail',
		   data: 'alias='+alias,			  
		   success: function(temp){
			   	$("#quick_pop_up").html('');
				$("#quick_pop_up").html(temp);
				$("html, body").animate({ scrollTop: 0 }, 600);
				$('#quickPopup').fadeIn();
		   }
		});	
		return false;
	});
	$('.navMenu ul > li').hover(function() {
		if (obj) {
			obj.find(":first-child").removeClass('selected');
			obj.find('.dropdownNav').hide();
			obj = null;
		}
		$(this).find(":first").addClass('selected');
		if($(this).find('.dropdownNav ul li').length >0){
	 	$(this).find('.dropdownNav').show();//console.log($(this).find('.dropdownNav ul li').length);
		}
  	}, function() {
		obj = $(this);
		setTimeout("checkHover()",500);
  	});
	$('.navMenu ul > li ul li').hover(function(){
		return false;
	}, function(){
		setTimeout("checkHover()",500);
	});
	
    $('.faqsQuestion').click(function(){
        $(this).next('.faqsAnswer').slideToggle("slow", function(){
		});
		return false;
    });
	$('#stamp_btn').click(function(){
		$('.stampPopup').animate({
			'top':'50%'
		});
		$('#overlay, .stampPopup').fadeIn(500, function(){
			totHeight();
			if($('#spp').length>0){
				$('#contentScroll').jScrollPane({
					verticalDragMinHeight: 35,
					verticalDragMaxHeight: 35,
				});
			}
		});
		return false;
	});
	$('#voucher_btn').click(function(){
		$('#promo_start').fadeOut(500, function(){
			$('.voucherCon').fadeIn(500);
		});
		return false;
	});
	
	/*$('.buttonCon a:first-child').click(function(){
		$('.voucherCon').fadeOut(500, function(){
			$('.buttonBox').fadeIn(500);
		});
		return false;
	});*/
	
	$("#cancel_coupon").click(function(){
		$('.voucherCon').fadeOut(500, function(){
			$('#promo_start').fadeIn(500);
		});
		return false;
	});
	
	//payment method
	if($('.botRightCartPayment input[value="bank_transfer"]').attr('checked') == 'checked'){
		$('#bankTransferInfo').slideDown();
	}
	else{
		$('#bankTransferInfo').slideUp();
	}
	$('.botRightCartPayment input[name="paymentMethod"]').change(function(){
		if($('.botRightCartPayment input[value="bank_transfer"]').attr('checked') == 'checked'){
			$('#bankTransferInfo').slideDown();
		}
		else{
			$('#bankTransferInfo').slideUp();
		}
	});
	
	if($('#banner img').length > 1){
		$("#banner").slidesjs({
			height:400,
			play: {
				active: false,
				effect: "slide",
				interval: 10000,
				auto: true,
				swap: true,
				pauseOnHover: true,
				restartDelay: 5000
			},
			pagination: {
				active: true
			},
			navigation: {
				active: false
			}
		});
	}
	$('.backToTop').click(function () {
			$('body, html').animate({scrollTop: 0}, 500);
			return false;
		});
	if($('#recItemsSlider').length > 0){
		if($(window).width()>0){
			var slider = $('#recItemsSlider').bxSlider({
				slideWidth:184,
				minSlides: 2,
				maxSlides: 5,
				moveSlides: 1,
				infiniteLoop: false,
				responsive: true,
				pager: false,
				hideControlOnEnd: true
			});
		}
		/*else{
			var slider = $('#recItemsSlider').bxSlider({
				slideWidth:192,
				minSlides: 2,
				maxSlides: 4,
				moveSlides: 1,
				infiniteLoop: false,
				responsive: true,
				pager: false,
				hideControlOnEnd: true
			});
		}*/
	}
	
	if($('.bxProduct').length > 0){	
		if($(window).width()>800){
			$('.bxProduct').bxSlider({
				slideWidth:460,
				minSlides: 1,
				maxSlides: 1,
				pager: false,
				infiniteLoop: false,
				hideControlOnEnd: true
			});
		}
		else{
			$('.bxProduct').bxSlider({
			slideWidth:0,
			minSlides: 1,
			maxSlides: 1,
			pager: false,
			infiniteLoop: false,
			hideControlOnEnd: true
			});
		}
	}
	
	if($("select.recipient").length>0)
	$("select.recipient").uniform();
	
	if($("#account_form").length > 0){
		$("#account_form").validationEngine('attach');
		$("#account_submit").click(function(){
			$("#account_form").submit();
		})
	}
	if($("#account_form2").length > 0){
		$("#account_form2").validationEngine('attach');
		$("#account_submit2").click(function(){
			$("#account_form2").submit();
		})
	}
	if($("#address_form").length > 0){
		$("#address_form").validationEngine('attach');
		$("#address_submit").click(function(){
			$("#address_form").submit();
		})
	}if($("#create_account_form").length > 0){
		$("#create_account_form").validationEngine('attach');
		$("#create_account_submit").click(function(){
			code = $("#code").val();
			user_id = $("#user_id").val();
			$("#create_account_form").attr('action',base_url+'registration/do_create_account/'+code+'/'+user_id);
			$("#create_account_form").removeAttr('onsubmit');
			$("#create_account_form").submit();
		})
	}
	if($("#address_checkout_form").length > 0){
		$("#address_checkout_form").validationEngine('attach');
		/*$("#address_checkout_submit").click(function(){
			$("#address_checkout_form").attr('action',base_url+'shopping_cart/address');
			$("#address_checkout_form").removeAttr('onsubmit');
			$("#address_checkout_form").submit();
		})*/
	}
	if($("#address_checkout_form2").length > 0){
		$("#address_checkout_form2").validationEngine('attach');
		/*$("#address_checkout_submit2").click(function(){
			$("#address_checkout_form2").attr('action',base_url+'shopping_cart/address_guest');
			$("#address_checkout_form2").removeAttr('onsubmit');
			$("#address_checkout_form2").submit();
		})*/
	}
	if($("#voucher_form").length > 0){
		$("#voucher_form").validationEngine('attach');
		$("#changepass_submit").click(function(){
			$("#voucher_form").submit();
		})
	}if($("#changepass_form").length > 0){
		$("#changepass_form").validationEngine('attach');
		$("#changepass_submit").click(function(){
			$("#changepass_form").submit();
		})
		
	}if($("#changeemail_form").length > 0){
		$("#changeemail_form").validationEngine('attach');
		$("#changeemail_submit").click(function(){
			$("#changeemail_form").submit();
		})
	}
	if($("#login_form").length > 0){
		$("#login_form").validationEngine('attach');
		$("#login_submit").click(function(){
			$("#login_form").attr('action',base_url+'login/process');
			$("#login_form").removeAttr('onsubmit');
			$("#login_form").submit();
		})
	}
	if($("#forgot_form").length > 0){
		$("#forgot_form").validationEngine('attach');
		$("#forgot_submit").click(function(){
			$("#forgot_form").attr('action',base_url+'forgot_password/process');
			$("#forgot_form").removeAttr('onsubmit');
			$("#forgot_form").submit();
		})
	}
	if($("#register_form").length > 0){
		$("#register_form").validationEngine('attach');
		$("#register_submit").click(function(){
			$("#register_form").attr('action',base_url+'registration/process');
			$("#register_form").removeAttr('onsubmit');
			$("#register_form").submit();
		})
	}
	if($("#newsletter_form").length > 0){
		$("#newsletter_form").validationEngine('attach');
		$("#newsletter_submit").click(function(){
			if($("#news_letter_email").val()!=""){
			$("#newsletter_form").attr('action',base_url+'newsletter/process');
			$("#newsletter_form").removeAttr('onsubmit');
			$("#newsletter_form").submit();
			}
		})
	}
	if($("#newsletter_form2").length > 0){
		$("#newsletter_form2").validationEngine('attach');
		$("#newsletter_submit2").click(function(){
			if($("#news_letter_email2").val()!=""){
			$("#newsletter_form2").attr('action',base_url+'newsletter/process2');
			$("#newsletter_form2").removeAttr('onsubmit');
			$("#newsletter_form2").submit();
			}
		})
	}
	if($("#search_form").length > 0){
		$("#search_form").validationEngine('attach');
		$("#search_submit").click(function(){
			$("#search_form").submit();
		})
	}
	if($("#contact_us_form").length > 0){
		$("#contact_us_form").validationEngine('attach');
		$("#contact_us_submit").click(function(){
			$("#contact_us_form").attr('action',base_url+'contact_us/process_email');
			$("#contact_us_form").removeAttr('onsubmit');
			$("#contact_us_form").submit();
		})
	}
	if($("#confirm_payment_form").length > 0){
		$("#confirm_payment_form").validationEngine('attach');
		$("#confirm_payment_submit").click(function(){
			
			$("#confirm_payment_form").attr('action',base_url+'confirm_payment/check');
			$("#confirm_payment_form").removeAttr('onsubmit');
			$("#confirm_payment_form").submit();
		})
	}
	if($("#confirm_payment_form2").length > 0){
		$("#confirm_payment_form2").validationEngine('attach');
		$("#confirm_payment_submit2").click(function(){
			//if(confirm('Confirm Payment?')){
			$("#confirm_payment_form2").attr('action',base_url+$("#action").val());
			$("#confirm_payment_form2").removeAttr('onsubmit');
			$("#confirm_payment_form2").submit();
			//}
		});
			
		$("#trigger_btn").click(function(){
			if($("#bank").val()!="" && $("#account_name").val()!="" && $("#date_transfer").val()!=""){
				if(confirm('Confirm Payment?')){
					$("#confirm_payment_submit2").trigger('click');
				}
			}
		});
	}
	
	if($("#2regist_form").length > 0){
	
		$("#2regist_form").validationEngine('attach');
		$("#2regist_submit").click(function(){
			$("#2regist_form").attr('action',base_url+'registration/guest_mode');
			$("#2regist_form").removeAttr('onsubmit');
			$("#2regist_form").submit();
		});	
	}
	
	$(".fbShare").click(function(){		
		var url_to_open=$(this).attr('url');
		var txt=$(this).attr('txt');	
		var width = 900; 	
		var height = 550;
		var left = parseInt((screen.availWidth/2) - (width/2));
		var top = parseInt((screen.availHeight/2) - (height/2));
		window.open(url_to_open, "Facebook", 'height=350,width=700,left=' + left + ',top=' + top + ',screenX=' + left + ',screenY=' + top);
		return false;
	});
	
	$(".twShare").click(function(){	
		var url=$(this).attr('url');
		var txt=$(this).attr('txt');		
		var url_to_open='http://twitter.com/share?url=&text='+txt;
		
		var width = 900; 	
		var height = 550;
		var left = parseInt((screen.availWidth/2) - (width/2));
		var top = parseInt((screen.availHeight/2) - (height/2));
		window.open(url_to_open, "Tweet", 'height=350,width=700,left=' + left + ',top=' + top + ',screenX=' + left + ',screenY=' + top);
		return false;
	});
	
	if($("select.default_dropdown").length>0)
	$('select.default_dropdown').customSelect();
	
	var selScrollable = '.sideMenuPopup';
	
	/*menuMobile*/
	$('.menuMobile').click(function(e){
		$('.overlayTrans, .sideMenuPopup').show();
		$('.sideMenuBox').animate({left:0});
		/*$('#container').css({
			'height':$(window).height()
		});*/
		$('body, html').css('overflow','hidden');
		/*$('body').bind('touchmove', function(e){e.preventDefault()});*/
		
		/*start*/
		// Uses document because document will be topmost level in bubbling
		$(document).on('touchmove',function(e){
		  e.preventDefault();
		});
		// Uses body because jQuery on events are called off of the element they are
		// added to, so bubbling would not work if we used document instead.
		$('body').on('touchstart', selScrollable, function(e) {
		  if (e.currentTarget.scrollTop === 0) {
			e.currentTarget.scrollTop = 1;
		  } else if (e.currentTarget.scrollHeight === e.currentTarget.scrollTop + e.currentTarget.offsetHeight) {
			e.currentTarget.scrollTop -= 1;
		  }
		});
		// Stops preventDefault from being called on document if it sees a scrollable div
		$('body').on('touchmove', selScrollable, function(e) {
			 if($(this)[0].scrollHeight > $(this).innerHeight()) {
				e.stopPropagation();
			}
		});
		/*end*/
		
		if($('.sideMenuContent').height() <= $(window).height()){
			$('.sideMenuBox').css('height','100%');
		}
		else{
			$('.sideMenuBox').css('height','auto');
		}
		return false;
	})
	
	$('.overlayTrans').click(function(){
		/*$('#container').css({
			'height':'auto'
		});*/
		$(document).unbind('touchmove');
		if($(window).width() < 420){
			$('.sideMenuBox').animate({left:'-70%'}, function(){
				$('.sideMenuPopup').hide();
			});
		}
		else{
			$('.sideMenuBox').animate({left:'-50%'}, function(){
				$('.sideMenuPopup').hide();
			});
		}
		$('body, html').css('overflow','auto');
		$('.overlayTrans').hide();
	})
	
	if($(window).width() < 800){
		$('.mobileLoginCon').css({
			'height':$('#loginMobile').height()+$('#regMobile').height()+60
		});
		$('#regMobile, #loginMobile').css({
			'width':$('.mobileLoginCon').width()
		});
	}
	
	/*autocomplete*/
	
});

/*$(window).bind('load', function(){
	if($(window).width() < 800){
		$('ul.recItemsSlider').find('li').css({
			'width':0.48*$(window).width(),
			'margin':0.01*$(window).width()
		})
	}
});*/
var id;
/*function doneResizing(){
  $('ul.recItemsSlider').find('li').css({
		'width':0.48*$(window).width(),
		'margin':0.01*$(window).width()
	}) 
}*/

$(window).bind('resize', function(){
	if($('.sideMenuContent').height() <= $(window).height()){
		$('.sideMenuBox').css('height','100%');
	}
	else{
		$('.sideMenuBox').css('height','auto');
	}
	
	if($(window).width() < 800){
		$('.mobileLoginCon').css({
			'height':$('#loginMobile').height()+$('#regMobile').height()+60
		});
		$('#regMobile, #loginMobile').css({
			'width':$('.mobileLoginCon').width()
		});
	}
	else{
		$('.mobileLoginCon').css({
			'height':'auto'
		});
		$('#regMobile, #loginMobile').css({
			'width':400
		})
	}
});

$(window).bind('load', function(){
	if($(window).width() < 800){
		$('.mobileLoginCon').css({
			'height':$('#loginMobile').height()+$('#regMobile').height()+60
		});
		$('#regMobile, #loginMobile').css({
			'width':$('.mobileLoginCon').width()
		});
	}
});
/*$(window).bind('resize', function(){
	if($(window).width() < 800){
		flag=2;
		clearTimeout(id);
    	id = setTimeout(doneResizing, 500);
	}
	else{
		clearTimeout(id);
    	id = setTimeout(doneResizingDesc, 500);
		
		//closepoup in desktop
		$('.sideMenuPopup').css('display','none');	
		$('.sideMenuBox').css({
			'left': '-50%'
		});
	}
	
	
});*/


