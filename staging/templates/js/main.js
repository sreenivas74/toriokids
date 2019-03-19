function show_search_popup(){
	$('.popupWrapper, #searchPopup, .overlay').fadeIn();
	$('html, body').css('overflow','hidden');
	$('#searchText').focus();
	return false;
}
function hide_popup(){
	$('.popupWrapper').fadeOut();
	$('html, body').css('overflow','auto');
	return false;
}
function hide_filter(){
	$('.filterBox').slideUp();
	return false;
}
function hide_mobilenav(){
	$('.mobilenavBox').animate({right:'-320px'},700);
	return false;
}
function show_temporarycart(){
	$('.cartsidenavBox, .cartsideNav .header, .cartnavSummary').animate({right:'0'},700);
	$('html, body').css('overflow','hidden');
	$('.itemWrapper').animate({ scrollTop:0 },"slow");

	return false;
}
function hide_temporarycart(){
	$('.cartsidenavBox, .cartsideNav .header, .cartnavSummary').animate({right:'-480px'},700);
	$('html, body').css('overflow','auto');
	return false;
}

function addCommas(nStr)
{
	nStr += '';
	x = nStr.split('.');
	x1 = x[0];
	x2 = x.length > 1 ? '.' + x[1] : '';
	var rgx = /(\d+)(\d{3})/;
	while (rgx.test(x1)) {
	x1 = x1.replace(rgx, '$1' + ',' + '$2');
	}
	return x1 + x2;
}
function add_item_to_cart(){
	var imageUrl = $('#img_url').val();
	var productName = $('#product_name').val();
	var productPrice = $('#price').val();
	var removeUrl = $('#img_url').val();
	//console.log(imageUrl);
	if($("#sku_id_d").val()>0){
		$.ajax({
				type: "POST",
				url: base_url+'shopping_cart/add_to_cart',
				data: $("#buy_form_d").serialize(),
				dataType:"JSON",		  
				success: function(temp){
					if(temp.status==1){
						alert('error');
					}
					else if(temp.status==2){
						alert('error 404');
					}
					else if(temp.status==3){
						alert('sku salah');
					}
					else if(temp.status==4){
						alert('stok habis');
					}
					else if(temp.status==5){
						alert('produk sama');
					}
					else{
					qty=temp.qty;
					price=temp.price;
					size=temp.size;	
					show_temporarycart();	   
					setTimeout(function(){
						$('.itemWrapper').prepend('<div id="cart_'+temp.cart_id+'" class="itemPanel"><div class="itemBox"><div class="image"><img width="100%" alt="'+productName+'" src="'+imageUrl+'"></div><div class="data"><p class="productName">'+productName+'</p><p class="productCategory">Size: '+size+'</p><p class="productPrice">Rp '+addCommas(temp.product_price)+'</p><a href="javascript:void(0)" class="trashicon" onclick="deletecart('+temp.cart_id+')"></a></div></div></div>');
						$("#cart_"+temp.cart_id).hide();
						$("#cart_"+temp.cart_id).fadeIn(500);
					}, 700);
					$('#total_cart').val(temp.price);
					$('#cart_tot').html(addCommas(temp.price));
					}
				}
		});	
		
	}
	else{
		alert('Please select your size');
	}
	
}
function update_total(totalPrice){
	$('#totalPrice').html(totalPrice);
}

var bannerHeight;
var bannerimgHeight;
var thresholdHeight;

var itempanelWidth;

$(document).ready(function(){
	if($(window).width() >= 640){
		$('.homeBanner').css({
			height: bannerHeight
		});
	}
	else {
		$('.homeBanner').css({
			height: bannerimgHeight
		});
	}
	
	$('.storeList ul li').each(function(){
		var imgSrc = $(this).find('img').attr('src');
		$(this).css('background-image', 'url('+imgSrc+')');
		$('.storeList ul li img').css({opacity:0});
	});
	
	$('.partnerList ul li a').each(function(){
		var imgSrc = $(this).find('img').attr('src');
		$(this).css('background-image', 'url('+imgSrc+')');
		$('.partnerList ul li a img').css({opacity:0});
	});
	
	if($('nav').hasClass('homeNav')){
		$(window).bind('scroll', function(){
			if($(window).scrollTop() > thresholdHeight-300){
				$('nav').fadeIn();
				$('#homeHeader').css({
					'box-shadow':'0 0 5px 0 #716558',
					'background':'#fff'
				});
			}
			else{
				$('nav').fadeOut();
				$('#homeHeader').css({
					'background':'none',
					'box-shadow':'none',
				});
			}
		})
	}
	$('nav ul li a.DDtop').click(function(){
		$(this).siblings('.dropdownMenu').slideToggle();
		return false;
	})
	$('.dropdownMenu').mouseleave(function(){
		$('.dropdownMenu').slideUp();
		return false;
	})
	$('.burgericon').click(function(){
		$('.mobilenavBox').animate({right:'0'},700);
		return false;
	})
	$('.filterslideBtn').click(function(){
		$('.filterBox').slideToggle();
		return false;
	})
	
	var itempanelWidth = ($('.itemBox .image').width());
	$('.itemBox .image').css({height:itempanelWidth+'px'});
	
	variable1 = 0;
	variable2 = 0;
	variable3 = 0;	
	variable4 = 0;
	
	$('.faqQuestion').click(function(){
		if (variable1==0) {
			$(this).siblings('.faqAnswer').slideToggle();
			$(this).addClass('close');
			variable1=1;
			return false;
		}
		else if (variable1==1) {
			$(this).siblings('.faqAnswer').slideToggle();
			$(this).removeClass('close');
			variable1=0;
			return false;
		}
	});
	$('.mobilenavCategory li a.DDtop').click(function(){
		if (variable1==0) {
			$(this).siblings('.mobilenavCategory .submenu').slideToggle();
			$(this).addClass('open');
			variable1=1;
			return false;
		}
		else if (variable1==1) {
			$(this).siblings('.mobilenavCategory .submenu').slideToggle();
			$(this).removeClass('open');
			variable1=0;
			return false;
		}
	});
	$('.categoryTab h4').click(function(){
		if($(window).width() <= 768){
			if (variable1==0) {
				$(this).siblings('.optionBox').slideToggle();
				$(this).addClass('open');
				variable1=1;
				return false;
			}
			else if (variable1==1) {
				$(this).siblings('.optionBox').slideToggle();
				$(this).removeClass('open');
				variable1=0;
				return false;
			}
		}
	});
	$('.customerData .type:last-child p').click(function(){
		if (variable1==0) {
			$('.logGuest').show();
			$(this).addClass('open');
			variable1=1;
			return false;
		}
		else if (variable1==1) {
			$('.logGuest').hide();
			$(this).removeClass('open');
			variable1=0;
			return false;
		}
	});
	$('.profileMenu ul li.active').click(function(){
		if($(window).width() <= 768){
			$('.profileMenu ul li').css('display','table');
			return false;
		}
	});
	
	$("select").selectOrDie({
		cycle: true,
		size: 5
  	});
	$('.productSlider').bxSlider({
		pagerCustom: '#bx-pager',
		slideWidth: 450
	});
});

$(window).load(function(){
	bannerHeight = parseInt($(window).height()-$('.brownBox').height());
	bannerimgHeight = parseInt($('.homeBanner img').height());
	thresholdHeight = parseInt($(window).height());
	if($(window).width() >= 640){
		$('.homeBanner').css({
			height: bannerHeight
		});
	}
	else {
		$('.homeBanner').css({
			height: bannerimgHeight
		});
	}
});

$(window).bind('resize', function(){
	bannerHeight = parseInt($(window).height()-$('.brownBox').height());
	bannerimgHeight = parseInt($('.homeBanner img').height());
	thresholdHeight = parseInt($(window).height());
	if($(window).width() >= 640){
		$('.homeBanner').css({
			height: bannerHeight
		});
	}
	else {
		$('.homeBanner').css({
			height: bannerimgHeight
		});
	}
	console.log(bannerimgHeight);
})