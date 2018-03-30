//var url = 'http://ec2-54-193-51-211.us-west-1.compute.amazonaws.com/admin_panel/';
var url = '/admin/';
function changeStatus(controller, row_id,type)
{
	if(confirm("Are you sure you want to update the status?"))
	{
		$.post(controller+"/updatestatus",{id:row_id,val:type},function(result){ 
			$("#status_"+row_id).html(result);
		});
	} 
}
function remove_more_price(row_id)
{
	jQuery('.more_price_row_'+row_id).remove();
}
function remove_group_price(row_id)
{
	jQuery('.group_price_row_'+row_id).remove();
}
function remove_hard_more_price(row_id,id,controller)
{
	if(confirm("Are you sure you want to remove this additional price? once removed you can't undo."))
	{
		jQuery('.more_price_row_'+row_id).remove();
		$.post('/admin/'+controller+"/remove_ticket_price",{id:id},function(result){ });
	} 
	
}
function remove_hard_group_price(row_id,id,controller)
{
	if(confirm("Are you sure you want to remove this group discount? once removed you can't undo."))
	{
		jQuery('.group_price_row_'+row_id).remove();
		$.post('/admin/'+controller+"/remove_group_ticket_price",{id:id},function(result){ });
	} 
	
}
$('document').ready(function(){
	$("#form_id").validationEngine({
		promptPosition:"topRight:-100",
	});
	$('.datetimepicker').datetimepicker({
		format: 'DD/MM/YYYY HH:mm:ss',
       });
	$('.datepicker').datetimepicker({
		format: 'DD/MM/YYYY',
       });
       jQuery(".removeImage").click(function(){
		if(confirm("Are you sure you want to remove this image? once removed you can't undo."))
		{
			var id	=	jQuery(this).attr("rel");
			var rel	=	jQuery(this).attr("rel");
			var controller	=	jQuery(this).attr("data-controller");
			jQuery(this).parent('li').remove();
			$.post('/admin/'+controller+"/removeImage",{id:id},function(result){ });
		} 
	});
	jQuery(".coupon_type").change(function(){
		if(jQuery(this).val()==4){
			jQuery(".tickets_option_container").show();
			jQuery(".products_option_container").hide();
			jQuery(".programs_option_container").hide();
		}else if(jQuery(this).val()==5){	
			jQuery(".tickets_option_container").hide();
			jQuery(".products_option_container").show();
			jQuery(".programs_option_container").hide();
		}else if(jQuery(this).val()==6){	
			jQuery(".tickets_option_container").hide();
			jQuery(".products_option_container").hide();
			jQuery(".programs_option_container").show();
		}else{
			jQuery(".tickets_option_container").hide();
			jQuery(".products_option_container").hide();
			jQuery(".programs_option_container").hide();
		}
	});
	$('.select2').select2();
	tinymce.init({ 
   		 // selector:'textarea.html_editor',
   		//  plugins: "fullpage",
        selector: 'textarea.html_editor',
        convert_urls : false,
        height: 300,
        theme: 'modern',
        images_reuse_filename: true,
        plugins: [
          'advlist autolink lists link image charmap print preview hr anchor pagebreak',
          'searchreplace wordcount visualblocks visualchars code fullscreen',
          'insertdatetime media nonbreaking save table contextmenu directionality',
          'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc',
          'image code'
        ],
        toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
        toolbar2: 'print preview media | forecolor backcolor emoticons | codesample | link image | code',
        image_advtab: true,
         // enable title field in the Image dialog
        image_title: true, 
        // enable automatic uploads of images represented by blob or data URIs
        automatic_uploads: true,
        // URL of our upload handler (for more details check: https://www.tinymce.com/docs/configure/file-image-upload/#images_upload_url)
        images_upload_url: url+'users/upload-image-tinymce',
        // here we add custom filepicker only to Image dialog
        file_picker_types: 'image', 
        // and here's our custom image picker
        file_picker_callback: function(cb, value, meta) {
          var input = document.createElement('input');
          input.setAttribute('type', 'file');
          input.setAttribute('accept', 'image/*');
          
          // Note: In modern browsers input[type="file"] is functional without 
          // even adding it to the DOM, but that might not be the case in some older
          // or quirky browsers like IE, so you might want to add it to the DOM
          // just in case, and visually hide it. And do not forget do remove it
          // once you do not need it anymore.

          input.onchange = function() {
            var file = this.files[0];
            
            // Note: Now we need to register the blob in TinyMCEs image blob
            // registry. In the next release this part hopefully won't be
            // necessary, as we are looking to handle it internally.
            var id = 'blobid' + (new Date()).getTime();
            var blobCache = tinymce.activeEditor.editorUpload.blobCache;
            var blobInfo = blobCache.create(id, file);
            blobCache.add(blobInfo);
            
            // call the callback and populate the Title field with the file name
            cb(blobInfo.blobUri(), { title: file.name });
          };
          
          input.click();
        },
        templates: [
          { title: 'Test template 1', content: 'Test 1' },
          { title: 'Test template 2', content: 'Test 2' }
        ],
        content_css: [
          '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
          '//www.tinymce.com/css/codepen.min.css'
        ]
   	});




});  

function chooseCustomer()
  {
    var radioValue = $("input[name='customer_type']:checked"). val();
    if(radioValue == 'existing')
    { $("#search_cust").css('display','block');
      $("#first_name").attr('readonly',true);
      $("#last_name").attr('readonly',true);
      $("#password").css('display','none');
      $("#confirm_password").css('display','none');
      $("#pass_created").css('display','none');
      $("#email").attr('readonly',true);
      $("#title_name").attr('readonly',true);
      $("#contact_number").attr('readonly',true);
      $("#title").css('display','none');
      $('#title_name').css('display','block');
      $("#hidden-field").css('display','none  ');
    }
    else
    {
      $("#hidden-field").css('display','block');
      $("#title").css('display','block');
      $("#search_cust").css('display','none');
      $('#title_name').css('display','none');
      $("#first_name").attr('readonly',false);
      $("#last_name").attr('readonly',false);
      $("#email").attr('readonly',false);
      $("#title").attr('readonly',false);
      $("#contact_number").attr('readonly',false);

      $("#password").css('display','block');
      $("#confirm_password").css('display','block');
      $("#pass_created").css('display','block');

      $("#address1").val('');
      $("#address2").val(''); 
      $("#town").val('');
      $("#county").val('');
      //$("#country").val('');
      $('select[name^="country"] option:selected').attr("selected",null);
      $("#first_name").val('');
      $("#last_name").val('');
      $("#postcode").val('');
      $("#email").val('');
      $("#contact_number").val('');
      $("#searched_Customer").css('display','none');
    }
  }
  function choosePassword()
  {
    var radioValue = $("input[name='password_type']:checked"). val();
    if(radioValue == 'mannual')
    {
      $("#password_show").css('display','block');
    }
    else
    {
      $("#password_show").css('display','none');
      
    }
  }
  function getSelectedCustomer(id,fname,lname,add1,add2,town,county,country,postcode,email,title,contact)
  {
    var radioValue = $("input[name='selected_user']:checked"). val();
    $("#address1").val(unescape(add1));
    $("#address2").val(unescape(add2)); 
    $("#town").val(unescape(town));
    $("#county").val(unescape(county));
    //$("#country").val(unescape(country));
    $('select[name^="country"] option[value="'+unescape(country)+'"]').attr("selected","selected");

//$('select[name^="country"] option:selected').attr("selected",unescape(country));


    $("#first_name").val(unescape(fname));
    $("#last_name").val(unescape(lname));
    $("#postcode").val(unescape(postcode));
    $("#email").val(unescape(email));
    $("#title_name").val(unescape(title));
    $("#contact_number").val(unescape(contact));
  }
  $("#search_exists_customer").keyup(function(){
    var search_customer = $(this).val();
    if(search_customer.length > 2){
      $("#searched_Customer").css('display','block');
      $("#searched_Customer").html("Searching is in-progress");
      $.ajax({
        type:"POST",
        url:url+"customers/search_existsing_customer/" ,
        dataType: 'text',
        data:{search_customer: search_customer},
        async:false,
        success: function(response){
          $("#hidden-field").css('display','block');
          $("#searched_Customer").css('display','block');
          $("#searched_Customer").html(response);
        },
        error: function (response) {
          $("#hidden-field").css('display','none');
          $("#searched_Customer").html(response);
        }
      });
    }
  });
  
  function addProductToCart(product,product_id)
  {
    
    $("#successmsg").css('display','none');
    var qty     = $("#type_qty_val_"+product_id).val();
    if(qty > 0)
    {
      $.ajax({
        type:"POST",
        url:url+"orders/addproduct" ,
        dataType: 'text',
        data:{product_id : product , quantity: qty},
        success: function(response){
          var response = JSON.parse(response)
          if(response.status == "true")
          $("#successmsg").removeClass('alert alert-danger');
          $("#successmsg").addClass('alert alert-success');
          $("#successmsg").css('display','block');
          $("#successmsg").html("<strong>Product successfully added to cart</strong>");
        },
        error: function (response) {
          $("#successmsg").css('display','block');
          $("#successmsg").addClass('alert alert-danger');
          $("#successmsg").removeClass('alert alert-success');
          $("#successmsg").html("<strong>Unable to add product to cart</strong>");
        }
      });
    }
  }

  function addTicketToCart(ticket,ticket_id)
  {
    $("#successmsg").css('display','none');
    var qty     = $("#id_qty_val_"+ticket_id).val();

    if(qty > 0)
    {
      $.ajax({
        type:"POST",
        url:url+"orders/addticket" ,
        dataType: 'text',
        data:{ticket_id : ticket , quantity: qty},
        success: function(response){
          var response = JSON.parse(response)
          if(response.status == "true")
          $("#successmsg").removeClass('alert alert-danger');
          $("#successmsg").addClass('alert alert-success');
          $("#successmsg").css('display','block');
          $("#successmsg").html("<strong>Ticket successfully added to cart</strong>");
        },
        error: function (response) {
          $("#successmsg").css('display','block');
          $("#successmsg").addClass('alert alert-danger');
          $("#successmsg").removeClass('alert alert-success');
          $("#successmsg").html("<strong>Unable to add ticket to cart</strong>");
        }
      });
    }
  }
  function addProgramToCart(program,program_id)
  {
    $("#successmsg").css('display','none');
    var qty     = $("#program_qty_val_"+program_id).val();
    if(qty > 0)
    {
      $.ajax({
        type:"POST",
        url:url+"orders/addprogram" ,
        dataType: 'text',
        data:{program_id : program , quantity: qty},
        success: function(response){
          var response = JSON.parse(response)
          if(response.status == "true")
          $("#successmsg").removeClass('alert alert-danger');
          $("#successmsg").addClass('alert alert-success');
          $("#successmsg").css('display','block');
          $("#successmsg").html("<strong>Program successfully added to cart</strong>");
        },
        error: function (response) {
          $("#successmsg").css('display','block');
          $("#successmsg").addClass('alert alert-danger');
          $("#successmsg").removeClass('alert alert-success');
          $("#successmsg").html("<strong>Unable to add ticket to cart</strong>");
        }
      });
    }
  }
jQuery(document).ready(function() {
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
    var coupon_code = jQuery("#coupon_code").val();
    jQuery.ajax({
      type:"POST",
      url:url+"orders/applycoupon/"+coupon_code ,
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
    var coupon_code = jQuery("#coupon_code").val();
    jQuery.ajax({
      type:"POST",
      url:url+"orders/removecoupon/"+coupon_code ,
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
      url:url+"orders/ajaxupdatecartticket",
      data: jQuery(this).serialize(),
      type: 'post',
      dataType: 'json',
      async:false,
      beforeSend:function(){
        jQuery(".cart-items-process").html("Cart processing...");
      },
      success: function(response){
        jQuery(".cart-totals-container").html(response.cart_totals);
        jQuery(".cart-items-container").html(response.cart_items)
        return false;
      },
      error: function (response) {
        alert('something going wrong.');
      }
    });
    return false;
  });
  jQuery("body").on('submit','.updatecartproduct',function(){ 
    jQuery.ajax({
      type:"POST",
      url:url+"orders/ajaxupdatecartproduct",
      data: jQuery(this).serialize(),
      type: 'post',
      dataType: 'json',
      async:false,
      beforeSend:function(){
        jQuery(".cart-items-process").html("Cart processing...");
      },
      success: function(response){
        jQuery(".cart-totals-container").html(response.cart_totals);
        jQuery(".cart-items-container").html(response.cart_items)
        return false;
      },
      error: function (response) {
        alert('something going wrong.');
      }
    });
    return false;
  });
  jQuery("body").on('submit','.updatecartprogram',function(){ 
    var thisEvent =  jQuery(this);
    jQuery.ajax({
      type:"POST",
      url:url+"orders/ajaxupdatecartprogram",
      data: jQuery(this).serialize(),
      type: 'post',
      dataType: 'json',
      async:false,
      beforeSend:function(){
        jQuery(".cart-items-process").addClass("active");
      },
      success: function(response){
        jQuery(".cart-totals-container").html(response.cart_totals);
        jQuery(".cart-items-container").html(response.cart_items)
        return false;
      },
      error: function (response) {
        alert('something going wrong.');
      }
    });
    return false;
  });
  jQuery("body").on('click','.apply_shipping',function(){ 
      if(jQuery('.apply_shipping').is(":checked")){
        var val = 1;
      }else{
        var val = 0;
      }
      jQuery.ajax({
          type:"POST",
          url:url+"orders/applyshipping/"+val ,
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

  $("#saveOrderDet").click(function(){
    var first_name = $("#first_name").val();
    var last_name = $("#last_name").val();
    var email = $("#email").val();
    var contact_number = $("#contact_number").val();
    var address1 = $("#address1").val();
    var address2 = $("#address2").val();
    var town = $("#town").val();
    var county = $("#county").val();
    var country = $("#country").val();
    var postcode = $("#postcode").val();

    var radioValue = $("input[name='customer_type']:checked"). val();
      if(radioValue == 'existing')
      {
        if((first_name == '') && (last_name == '') && (email == '') && (contact_number != true) && (address1 == '') && (address2 =='') && (town == '') && (address1 == ''))
        {
          alert('Please fill customer details to proceed checkout.');
          return false;
        }
      }
      else
      {
        if((first_name == '') && (last_name == '') && (email == '') && (contact_number != true) && (address1 == '') && (address2 =='') && (town == '') && (address1 == ''))
        {
          alert('Please fill customer details to proceed checkout.');
           return false;
        }
      }
  });

  $('#email').change(function(){
    var email = $(this).val();
    $.ajax({
        type:"POST",
        url:url+"customers/checkemailexists",
        data: {email : email},
        type: 'post',
        dataType: 'json',
        async:false,
        success: function(response){
          if(response.status == true)
          {
            alert(response.msg);
            return false;
          }
        },
        error: function (response) {
          alert('something went wrong.');
        }
      });
  });
  $('#event_id').change(function(){
    var event_id = $(this).val();
    $.ajax({
        type:"POST",
        url:url+"tickets/getticketsbyeventid",
        data: {event_id : event_id},
        type: 'post',
        //dataType: 'json',
        async:false,
        success: function(response){
          $("#ticketdrop").html(response);
        },
        error: function (response) {
          $("#ticketdrop").html(response);
        }
      });
  });
});   