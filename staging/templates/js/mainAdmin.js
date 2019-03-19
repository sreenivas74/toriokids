
function toggleContainer(toggleId){
	$('#'+toggleId).slideToggle(function(){
		var isVisible = $('.formToggleContainer').is(':visible');
		$('a.defToggleBtn').html(isVisible ? 'Cancel' : 'Add');
	});
}
$(document).ready(function(){
	$('.prodStatus thead').css({
		'width':$('.prodStatus').width()
	});
	$('#content_redactor').redactor({
			imageUpload: base_url+'torioadmin/content_page/add_image'
		});
		
		$('.content_redactor_multiple').redactor({
			//imageUpload: base_url+'dutaadmin/content/do_add_company_history'
		});
		
	if($("#add_home_banner_form").length > 0){	
		$("#add_home_banner_form").validationEngine('attach');
		$('#add_home_banner_submit').click(function(){		
			$("#add_home_banner_form").submit();				
	});
	}
	
	$('.date').datepicker({
		numberOfMonths: 1,
		showButtonPanel: true,
		yearRange: "-80:+80",
		changeYear: true,
		dateFormat: "yy-mm-dd",
		minDate: "-80y"
	});
	
	if($("#edit_home_banner_form").length > 0){	
			$("#edit_home_banner_form").validationEngine('attach');
			$('#edit_home_banner_submit').click(function(){
				if($("#flag").val()==1) 
				$("#edit_home_banner_form").removeAttr('onsubmit');
				$("#edit_home_banner_form").submit();
		});
	}	
	
	if($("#add_featured_item_form").length > 0){	
		$("#add_featured_item_form").validationEngine('attach');
		$('#add_featured_item_submit').click(function(){		
			$("#add_featured_item_form").submit();				
	});
	}
	
	if($("#edit_featured_item_form").length > 0){	
			$("#edit_featured_item_form").validationEngine('attach');
			$('#edit_featured_item_submit').click(function(){
				if($("#flag").val()==1) 
				$("#edit_featured_item_form").removeAttr('onsubmit');
				$("#edit_featured_item_form").submit();
		});
	}
	
	if($("#add_faq_form").length > 0){	
		$("#add_faq_form").validationEngine('attach');
		$('#add_faq_submit').click(function(){		
			$("#add_faq_form").submit();				
	});
	}
	
	if($("#edit_faq_form").length > 0){	
		$("#edit_faq_form").validationEngine('attach');
		$('#edit_faq_submit').click(function(){		
			$("#edit_faq_form").submit();				
	});
	}
	
	if($("#add_faq_category_form").length > 0){	
		$("#add_faq_category_form").validationEngine('attach');
		$('#add_faq_category_submit').click(function(){		
			$("#add_faq_category_form").submit();				
	});
	}	
	
	if($("#edit_faq_category_form").length > 0){	
		$("#edit_faq_category_form").validationEngine('attach');
		$('#edit_faq_category_submit').click(function(){		
			$("#edit_faq_category_form").submit();				
	});
	}	
	
	if($("#add_product_form").length > 0){	
		$("#add_product_form").validationEngine('attach');
		$('#add_product_submit').click(function(){		
			$("#add_product_form").submit();				
	});
	}	
	
	if($("#edit_product_form").length > 0){	
		$("#edit_product_form").validationEngine('attach');
		$('#edit_product_submit').click(function(){		
			$("#edit_product_form").submit();				
	});
	}	
	
	if($("#add_province_form").length > 0){	
		$("#add_province_form").validationEngine('attach');
		$('#add_province_submit').click(function(){		
			$("#add_province_form").submit();				
	});
	}	
	
	if($("#edit_province_form").length > 0){	
		$("#edit_province_form").validationEngine('attach');
		$('#edit_province_submit').click(function(){		
			$("#edit_province_form").submit();				
	});
	}	
	
	if($("#add_city_form").length > 0){	
		$("#add_city_form").validationEngine('attach');
		$('#add_city_submit').click(function(){		
			$("#add_city_form").submit();				
	});
	}	
	
	if($("#edit_city_form").length > 0){	
		$("#edit_city_form").validationEngine('attach');
		$('#edit_city_submit').click(function(){		
			$("#edit_city_form").submit();				
	});
	}	
	
	if($("#add_discount_form").length > 0){	
		$("#add_discount_form").validationEngine('attach');
		$('#add_discount_submit').click(function(){		
			$("#add_discount_form").submit();				
	});
	}	
	
	if($("#edit_discount_form").length > 0){	
		$("#edit_discount_form").validationEngine('attach');
		$('#edit_discount_submit').click(function(){		
			$("#edit_discount_form").submit();				
	});
	}	
});

$(window).bind('scroll', function(){
	//console.log($(window).scrollTop());
	if($(window).scrollTop() > ($('#header').height()+55+$('.prodStatus thead').height())){
		$('.prodStatus thead').css({
			'position':'fixed',
			'top':0,
			'width':$('.prodStatus').width()
		});
	}
	else{
		$('.prodStatus thead').css({
			'position':'relative'
		});
	}
});
