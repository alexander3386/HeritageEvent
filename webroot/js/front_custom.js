// For Mobile Dropdown
if (document.documentElement.clientWidth < 768) {
	jQuery(document).ready(function() {
		var addNewSpan = '<small class="open"></small>';
		jQuery('.navigation .dropdown-menu').before(addNewSpan);
		jQuery("small.open").click(function() {
			var current = jQuery(this).next('ul');
			jQuery("small.open").next('ul').each(function() {
				if (current.attr('id') != jQuery(this).attr("id") && jQuery(this).attr("id")) {
					jQuery(this).prev('small.open').removeClass("active");
					jQuery(this).hide('slow');
				}
			});
			jQuery(this).toggleClass('active');
			jQuery(this).next('ul').slideToggle(500);
		});
	});
}
jQuery(document).ready(function() {
	$("#form_id").validationEngine({
		promptPosition:"topRight:-100",
	});
	[].slice.call( document.querySelectorAll( 'select.cs-select' ) ).forEach( function(el) {	
		new SelectFx(el);
	} );
	if (jQuery('#home-slider').length) {
	        jQuery('#home-slider').owlCarousel({
			loop: false,
			margin: 0,
			responsiveClass: true,
			nav: false,
			dots: true,
			autoplay: true,
			//touchDrag: false,
			//mouseDrag: false,
			smartSpeed: 2000,
			delay: 5000000,
			responsive: {
				0: {
					items: 1
				}
			}
		});
	}
	
	jQuery('body').on('click','.spinner .btn:first-of-type', function() {
		var btn = $(this);
		var input = btn.closest('.spinner').find('input');
		if (input.attr('max') == undefined || parseInt(input.val()) < parseInt(input.attr('max'))) {
			input.val(parseInt(input.val(), 10) + 1);
		} else {
			btn.next("disabled", true);
		}
	});
	jQuery('body').on('click','.spinner .btn:last-of-type', function() {
		var btn = $(this);
		var input = btn.closest('.spinner').find('input');
		if (input.attr('min') == undefined || parseInt(input.val()) > parseInt(input.attr('min'))) {
			input.val(parseInt(input.val(), 10) - 1);
		} else {
			btn.prev("disabled", true);
		}
	}); 
	
	jQuery("body").on('click','.apply_coupon',function(){	
		var coupon_code	=	jQuery("#coupon_code").val();
		jQuery.ajax({
			type:"POST",
			url:"/carts/applycoupon/"+coupon_code ,
			type: 'post',
			dataType: 'json',
			async:true,
			success: function(response){
				jQuery(".coupon_status_msg").removeClass('success');
				jQuery(".coupon_status_msg").removeClass('error');
				if(response.status){
					jQuery(".coupon_status_msg").addClass('success');
				}else{
					jQuery(".coupon_status_msg").addClass('error');
				}
				jQuery(".coupon_status_msg").html(response.message+" <a class=\"remove_coupon\" href=\"javascript:void(0)\" >X</a>");
				jQuery("#coupon_code").attr("readonly","readonly");
				jQuery(".cart-totals-container").html(response.cart_totals);
			},
			error: function (response) {
				alert('something going wrong.');
			}
		});
	});
	jQuery("body").on('click','.remove_coupon',function(){
		var coupon_code	=	jQuery("#coupon_code").val();
		jQuery.ajax({
			type:"POST",
			url:"/carts/removecoupon/"+coupon_code ,
			type: 'post',
			dataType: 'json',
			async:false,
			success: function(response){
				jQuery(".coupon_status_msg").html("");
				jQuery("#coupon_code").removeAttr("readonly");
				jQuery("#coupon_code").val('');
				jQuery(".cart-totals-container").html(response.cart_totals);
			},
			error: function (response) {
				alert('something going wrong.');
			}
		});
	});
	if(jQuery(".activeCoupon").length > 0){
		jQuery(".apply_coupon").trigger("click");
	}
	jQuery("body").on('submit','.updatecartticket',function(){	
		jQuery.ajax({
			type:"POST",
			url:"/carts/ajaxupdatecartticket",
			data: jQuery(this).serialize(),
			type: 'post',
			dataType: 'json',
			async:false,
			beforeSend:function(){
				jQuery(".cart-items-process").addClass("active");
			},
			success: function(response){
				jQuery(".cart-totals-container").html(response.cart_totals);
				jQuery(".cart-items-container").html(response.cart_items);
				jQuery(".process-message").html("<div class=\"message "+response.status+"\">"+response.message+"</div>");

				return false;
			},
			complete:function(){
				jQuery(".cart-items-process").removeClass("active");
			},
			error: function (response) {
				alert('something going wrong.');
			}
		});
		return false;
	});
	jQuery("body").on('submit','.updatecartproduct',function(){	
		var thisEvent	=	 jQuery(this);
		jQuery.ajax({
			type:"POST",
			url:"/carts/ajaxupdatecartproduct",
			data: jQuery(this).serialize(),
			type: 'post',
			dataType: 'json',
			async:false,
			beforeSend:function(){
				jQuery(".cart-items-process").addClass("active");
			},
			success: function(response){
				jQuery(".cart-totals-container").html(response.cart_totals);
				jQuery(".cart-items-container").html(response.cart_items);
				jQuery(".process-message").html("<div class=\"message success\">"+response.message+"</div>");
				thisEvent.find('.food_total_amount').html(jQuery('#table_p_'+response.c_p+' .item_total').html());
				return false;
			},
			complete:function(){
				jQuery(".cart-items-process").removeClass("active");
			},
			error: function (response) {
				alert('something going wrong.');
			}
		});
		return false;
	});
	jQuery("body").on('submit','.updatecartprogram',function(){	
		var thisEvent	=	 jQuery(this);
		jQuery.ajax({
			type:"POST",
			url:"/carts/ajaxupdatecartprogram",
			data: jQuery(this).serialize(),
			type: 'post',
			dataType: 'json',
			async:false,
			beforeSend:function(){
				jQuery(".cart-items-process").addClass("active");
			},
			success: function(response){
				jQuery(".cart-totals-container").html(response.cart_totals);
				jQuery(".cart-items-container").html(response.cart_items);
				jQuery(".process-message").html("<div class=\"message success\">"+response.message+"</div>");
				return false;
			},
			complete:function(){
				jQuery(".cart-items-process").removeClass("active");
			},
			error: function (response) {
				alert('something going wrong.');
			}
		});
		return false;
	});
	
	jQuery("body").on('click','.apply_shipping',function(){	
		if(jQuery('.apply_shipping').is(":checked")){
			var val	=	1;
		}else{
			var val	=	0;
		}
		jQuery.ajax({
			type:"POST",
			url:"/carts/applyshipping/"+val ,
			type: 'post',
			dataType: 'json',
			async:true,
			success: function(response){
				jQuery(".cart-totals-container").html(response.cart_totals);
			},
			error: function (response) {
				alert('something going wrong.');
			}
		});
	});
	
	jQuery("body").on('submit','.checkout',function(){	
		jQuery.ajax({
			type:"POST",
			url:		"/carts/ajaxprocesscheckout",
			data: 	jQuery(this).serialize(),
			type: 	'post',
			dataType: 'json',
			async:false,
			beforeSend:function(){
				jQuery(".cart-items-process").addClass("active");
				jQuery(".process-message").html('');
			},
			success: function(response){
				if(response.status==true){
					if(response.urlslug!=undefined && response.urlslug){
						jQuery(".process-message").html("<div class=\"message success\">"+response.message+"</div>");
						window.location.href		=	'carts/'+response.urlslug;
					}
				}else{
					jQuery(".process-message").html("<div class=\"message error\">"+response.message+"</div>");
					if(response.action!=undefined && response.action){
						if(response.action=='login'){
							jQuery(".checkout-login").addClass("active");
						}
					}
					jQuery("html, body").animate({scrollTop: jQuery('.process-message').offset().top-105 }, 2000);
				}
			},
			complete:function(){
				jQuery(".cart-items-process").removeClass("active");
			},
			error: function (response) {
				alert('something going wrong.');
			}
		});
		return false;
	});

	jQuery("body").on('click','.showlogin',function(){	
		jQuery(".checkout-login").toggleClass("active");
	});
	
	jQuery("body").on('submit','.ajaxloginform',function(){	
		jQuery.ajax({
			type:"POST",
			url:		"/user/customers/ajaxlogin",
			data: 	jQuery(this).serialize(),
			type: 	'post',
			dataType: 'json',
			async:false,
			beforeSend:function(){
				jQuery(".process-message").html('');
			},
			success:function(response){
				if(response.status==true){
					window.location.reload();
				}else{
					jQuery(".process-message").html("<div class=\"message error\">"+response.message+"</div>");
					jQuery("html, body").animate({scrollTop: jQuery('.process-message').offset().top-105 }, 2000);
				}
			},
			error: function (response) {
				alert('something going wrong.');
			}
		});	
		return false;
	});
});

