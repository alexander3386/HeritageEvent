<div  id ="successmsg" style="display:none;">
  
</div>


<div class="box box-default">
	<div class="box-header with-border">
		<h3 class="box-title">Review Cart Items</h3>
		<span class="add_btn">
			<a href="<?php echo $this->Url->build(['controller' => 'orders', 'action' => 'clearcart'])?>" class="btn btn-success btn-sm">Clear Cart</a>
		</span>
		<span class="add_btn">
			<a href="<?php echo $this->Url->build(['controller' => 'orders', 'action' => 'add'])?>" class="btn btn-danger btn-sm">Back</a>
		</span>
	</div>
	<?php echo $this->Form->create($form, ['id' => 'form_id']) ?>
	<div class="box-body">
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<label>Cart Items</label>
					<table class="table table-bordered">
					
					<tr>
						<th>#</th>
						<th>Item Name</th>
						<th>Item Type</th>
						<th>Quantity</th>
						<th>Price</th>
					</tr>
					<?php 
					//pr($carts);
					$i = 1;
					foreach ($carts as $key => $value) {
						
						foreach ($value as $keyT => $valueT){
							if($key == 'tickets'){
								$ticket = $ticketsModel->getTicketById($keyT);
								$name 	= $ticket['title'];
								$price 	= $ticket['price'];
							}
							if($key == 'products'){
								$product = $productsModel->getProductById($keyT);
								$name = $product['title'];
								$price = $product['price'];
							}
						?>
						<tr>
							<td><?php echo $i;?></td>
							<td><?php echo $name;?></td>
							<td><?php echo ucfirst($key);?></td>
							<td><?php echo $valueT['qty'];?></td>
							<td><?php echo $this->Custom->displayPriceHtml($valueT['qty']*$price);?></td>
						</tr>
						<?php 
						}
						
					}
					?>
						<tr>
							<td></td>
								<td></td>
								<td></td>
								<td>Sub Total</td>
								<td><?php echo $this->Custom->displayPriceHtml($valueT['qty']*$price);?></td>
						</tr>
						<tr>
							<td></td>
								<td></td>
								<td></td>
								<td>Total Discount</td>
								<td><?php echo $this->Custom->displayPriceHtml($valueT['qty']*$price);?></td>
						</tr>
						<tr>
							<td></td>
								<td></td>
								<td></td>
								<td>Total After Discount</td>
								<td><?php echo $this->Custom->displayPriceHtml($valueT['qty']*$price);?></td>
						</tr>
					</table>
				</div>
				
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label>Payment Gateway <span class="require">*</span></label>
					<div class="radio">
  						<label><input type="radio" name="payment_type" value="heritage_payment_gateway" checked />Heritage payment gateway</label>
					</div>
					<div class="radio">
  						<label><input type="radio" name="payment_type" value="leeds_castle_gateway"/>Leeds castle payment gateway</label>
					</div>
				</div>
			</div>
			<div class="col-md-6 payment_box">
				<div class="form-group">
					<label>Enter Promotional Code</label>
					<div class="code_view">
						<?php if($this->Custom->getCouponStatus()): ?>
							<input name="coupon_code" type="text" id="coupon_code" value="<?php echo $this->Custom->getCouponCode()?>" class="activeCoupon" />
						<?php else: ?>
							<input name="coupon_code" type="text" id="coupon_code" />
						<?php endif;?>
						<a href="javascript:void(0);"  class="btn apply_coupon" ><?php echo __('Apply')?></a>
						<div class="coupon_status_msg"></div>
					</div>
					<div class="total"> 
						<div class="cart-totals-container">
							<?php echo $this->requestAction('/carts/totals'); ?>
						</div>
						<div class="clearfix"></div>
						<a href="<?php echo $this->Url->build(['controller' => 'carts', 'action' => 'checkout'])?>" class="btn"><?php echo __('CheckOut')?></a> 
					</div>
				</div>
			</div>
			
			
		</div>
		
		<div class="box-tools pull-right">
			<?php echo $this->Form->button(__('Submit'), ['class' => 'btn btn-primary btn-block btn-flat']); ?>
		</div>

	</div>
	<?php echo $this->Form->end() ?>
</div>


<script type="text/javascript">
	function chooseCustomer()
	{
		var radioValue = $("input[name='customer_type']:checked"). val();
		if(radioValue == 'existing')
		{	$("#search_cust").css('display','block');
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
			$("#hidden-field").css('display','none	');
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
			$("#country").val('');
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
		$("#address1").val(add1);
		$("#address2").val(add2); 
		$("#town").val(town);
		$("#county").val(county);
		$("#country").val(country);
		$("#first_name").val(fname);
		$("#last_name").val(lname);
		$("#postcode").val(postcode);
		$("#email").val(email);
		$("#title_name").val(title);
		$("#contact_number").val(contact);
	}
	$("#search_exists_customer").keydown(function(){
	var search_customer = $(this).val();
		$.ajax({
			type:"POST",
			url:"<?php echo $this->Url->build(["prefix"=>'admin',"controller" => "Customers","action" => "search_existsing_customer"]);?>/"+search_customer ,
			dataType: 'text',
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
	});
	
	function addProductToCart(product,product_id)
	{
		
		$("#successmsg").css('display','none');
		var qty 		= $("#type_qty_val_"+product_id).val();
		if(qty > 0)
		{
			$.ajax({
				type:"POST",
				url:"<?php echo $this->Url->build(["prefix"=>'admin',"controller" => "Orders","action" => "addproduct"]);?>" ,
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
		var qty 		= $("#id_qty_val_"+ticket_id).val();

		if(qty > 0)
		{
			$.ajax({
				type:"POST",
				url:"<?php echo $this->Url->build(["prefix"=>'admin',"controller" => "Orders","action" => "addticket"]);?>" ,
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
</script>
