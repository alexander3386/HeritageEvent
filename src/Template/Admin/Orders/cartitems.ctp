<div class="cart-table">
	<div class="cart-items-process"></div>
	<?php foreach ($tickets as $ticket):?>  
		<?php 
			$ticket_price			=	 $this->Custom->applyAddtionalPrice($ticket['id'],$ticket['price'],$ticket['qty']);
			$total_price				=	($ticket_price*$ticket['qty']);
			$discount_total_price	=	 $this->Custom->applyDiscountPrice($ticket['id'],$total_price,$ticket['qty']);
		?>
		<h4><?php echo $ticket['title'];?></h4>
		<table class="table table-bordered">
			<thead>
				<tr>
					<th>Quantity</th>
					<th>Price</th>
					<th>Total</th>
					<th>Remove</th> 
				</tr>
			</thead>
			<tbody>
				<tr>
					<td class="quantity qty-custm">
						<?php echo $this->Form->create('Cart', [ 'url' => ['controller'=>'Orders', 'action' => 'ajaxupdatecartticket'],'class'=>'updatecartticket']); ?>
							<?php echo $this->Form->hidden('ticket_id',array('value' => base64_encode($ticket['id']),'class'=>'ticket_id')) ?>
							<div class="input-group spinner">
								<?php echo $this->Form->text('quantity', ['class' => 'form-control validate[required,custom[number]]', 'min' => 1,'max'=>20,'value'=>$ticket['qty']]) ?>
								<div class="input-group-btn-vertical">
									<button class="btn btn-default" type="button"><i class="fa fa-caret-up"></i></button>
									<button class="btn btn-default" type="button"><i class="fa fa-caret-down"></i></button>
								</div>
							</div>
							<span class="addtocart">
								<input class ="btn btn-primary btn-block btn-flat " name="update_to_cart" type="submit" value="<?php echo __('Update')?>">
							</span>
						<?php echo $this->Form->end() ?>
					</td>
					<td><?php echo $this->Custom->displayPriceHtml($ticket_price); ?></td>
					<td>
						<?php if($discount_total_price < $total_price):?>
							<span class="discount-price"><?php echo $this->Custom->displayPriceHtml($total_price);?></span>
							<span ><?php echo $this->Custom->displayPriceHtml($discount_total_price);?></span>
						<?php else: ?>	
							<span>
								<?php echo $this->Custom->displayPriceHtml($total_price);?>
							</span>
						<?php endif;?>
					</td>
					<td>
						<?php 
							$slug	=	'tickets||'.$ticket['id'];
							$code	=	base64_encode($slug);
						?>
						<a class="btn btn-danger btn-xs" href="<?php echo $this->Url->build(['controller' => 'orders', 'action' => 'removeItem']).'/'.$code?>">X</a>
					</td>
				</tr>	
			</tbody>
		</table>
	<?php endforeach;?>
	
	<?php if($products): ?>
		<?php foreach ($products as $product):?>
		<h4><?php echo $product['title'];?></h4>
		<table class="table table-bordered">
			<thead>
				<tr>
					<th>Quantity</th>
					<th>Price</th>
					<th>Total</th>
					<th>Remove</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td class="quantity qty-custm">
						<?php echo $this->Form->create('Cart', [ 'url' => ['controller'=>'orders', 'action' => 'ajaxupdatecartproduct'],'class'=>'updatecartproduct']); ?>
							<?php echo $this->Form->hidden('product_id',array('value' => base64_encode($product['id']),'class'=>'product_id')) ?>
							<div class="input-group spinner">
								<?php echo $this->Form->text('quantity', ['class' => 'form-control validate[required,custom[number]]', 'min' => 1,'max'=>20,'value'=>$product['qty']]) ?>
								<div class="input-group-btn-vertical">
									<button class="btn btn-default" type="button"><i class="fa fa-caret-up"></i></button>
									<button class="btn btn-default" type="button"><i class="fa fa-caret-down"></i></button>
								</div>
							</div>
							<span class="addtocart">
								<input class ="btn btn-primary btn-block btn-flat" name="update_to_cart" type="submit" value="<?php echo __('Update')?>">
							</span>
						<?php echo $this->Form->end() ?>
					</td>
					<td><?php echo $this->Custom->displayPriceHtml($product['price']); ?></td>
					<td><?php echo $this->Custom->displayPriceHtml($product['qty']*$product['price']);?></td>
					<td>
						<?php 
							$slug	=	'products||'.$product['id'];
							$code	=	base64_encode($slug);
						?>
						<a class="btn btn-danger btn-xs" href="<?php echo $this->Url->build(['controller' => 'Orders', 'action' => 'removeItem']).'/'.$code?>">X</a>
					</td>
				</tr>	
			</tbody>
		</table>
	<?php endforeach;?>
	<?php endif;?>
	<?php if($programs): ?>
		<?php foreach ($programs as $program):?>
		<h4><?php echo $program['title'];?></h4>
		<table class="table table-bordered">
			<thead>
				<tr>
					<th>Quantity</th>
					<th>Price</th>
					<th>Total</th>
					<th>Remove</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td class="quantity qty-custm">
						<?php echo $this->Form->create('Cart', [ 'url' => ['controller'=>'orders', 'action' => 'ajaxupdatecartprogram'],'class'=>'updatecartprogram']); ?>
							<?php echo $this->Form->hidden('program_id',array('value' => base64_encode($program['id']),'class'=>'program_id')) ?>
							<div class="input-group spinner">
								<?php echo $this->Form->text('quantity', ['class' => 'form-control validate[required,custom[number]]', 'min' => 1,'max'=>20,'value'=>$program['qty']]) ?>
								<div class="input-group-btn-vertical">
									<button class="btn btn-default" type="button"><i class="fa fa-caret-up"></i></button>
									<button class="btn btn-default" type="button"><i class="fa fa-caret-down"></i></button>
								</div>
							</div>
							<span class="addtocart">
								<input class ="btn btn-primary btn-block btn-flat" name="update_to_cart" type="submit" value="<?php echo __('Update')?>">
							</span>
						<?php echo $this->Form->end() ?>
					</td>
					<td><?php echo $this->Custom->displayPriceHtml($program['price']); ?></td>
					<td><?php echo $this->Custom->displayPriceHtml($program['qty']*$program['price']);?></td>
					<td>
						<?php 
							$slug	=	'programs||'.$program['id'];
							$code	=	base64_encode($slug);
						?>
						<a class="btn btn-danger btn-xs" href="<?php echo $this->Url->build(['controller' => 'Orders', 'action' => 'removeItem']).'/'.$code?>">X</a>
					</td>
				</tr>	
			</tbody>
		</table>
	<?php endforeach;?>
	<?php endif;?>	
</div>
<div class="clearfix"></div>
<div class="payment_box" >
	
	<div class="col-md-12 code_view">
		<div class="col-md-5 ">
			<label>Enter Promotional Code</label>
			<div class="text-field">
			<?php if($this->Custom->getCouponStatus()): ?>
			<input  name="coupon_code" type="text" id="coupon_code" value="<?php echo $this->Custom->getCouponCode()?>" class="activeCoupon form-control" />
		<?php else: ?>
			<input name="coupon_code" type="text" id="coupon_code" class="form-control"/>
		<?php endif;?>
		<div class="coupon_status_msg"></div>
			</div>
			<a href="javascript:void(0);"  class="btn btn-success apply_coupon" ><?php echo __('Apply')?></a>
		</div>
		
		<div class="col-md-4 ">
		
		<?php if(isset($settings) && $settings['is_shipping']==1): ?>
				<div class="receive_ticket">
					<h4>Do you also want to receive physical ticket by shipping.  </h4>
					<p>
						<?php if($this->Custom->getShippingStatus()):?>
							<?php echo $this->Form->checkbox('is_shipping', ['value'=>1,'class'=>'apply_shipping','checked'=>'checked']) ?> 
						<?php else: ?>	
							<?php echo $this->Form->checkbox('is_shipping', ['value'=>1,'class'=>'apply_shipping']) ?> 
						<?php endif; ?>	
						<span>Send me physical ticket(s).</span>
					 </p>
				</div>
			<?php endif; ?>
		</div>
		
		<div class="col-md-3 ">
		
		<div class="total"> 
		<div class="cart-totals-container">
			<?php echo $this->requestAction('admin/orders/totals'); ?>
		</div>
		
		
	</div>
		</div>
		
	</div>
	
	
	<div class="clearfix"></div>
	<?php 
	echo $this->Form->create(null,['url' => 'admin/orders/proceedtocheckout',    'type' => 'post']) ?>
			<div class="col-md-10 payment">
				<div class="form-group">
					<label>Payment Gateway <span class="require">*</span></label>
					
					<input type="radio" name="payment_type" value="override" checked class="payment_type"/><span class="title">Direct order without payment</span>

					<input type="radio" name="payment_type" value="heritage_worldpay" class="payment_type"/><span class="title">Heritage Worldpay
					
					<input type="radio" name="payment_type" value="leedcasttle_streamline" class="payment_type"/><span class="title">Leeds castle Streamline
					
				</div>
			</div>
			<div id="worldpay" style="display:none">
				<div class="col-md-12">
					<div class="form-group">
						<input type="text" name="cardholder_name" id="cardholder_name" class="form-control"	placeholder="Name On Card"  maxlength ="50"/>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<select name="cardholder_type" id="cardholder_type" class="form-control"	>
							<option value="">Card Type</option>
							<option value="visa">Visa</option>
							<option value="Mastero">Mastero</option>
							<option value="Mastercard">Mastercard</option>
							<option value="JCB">JCB</option>
							<option value="Visa Debit">Visa Debit</option>
							<option value="American Express">American Express</option>
							<option value="Visa Purchasing">Visa Purchasing</option>	
						</select>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<input type="text" name="card_number" id="card_number" class="form-control"	placeholder="Card Number" autocomplete="off" maxlength ="20" />
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<?php echo $this->Form->month('exp_month',['class'=>'form-control','id'=>'exp_month','empty'=>'Expiry Month']);?>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<?php echo $this->Form->year('exp_year',['class'=>'form-control','id'=>'exp_year','empty'=>'Expiry Year']);?>
					</div>
				</div>
				<div class="col-md-2">
					<div class="form-group">
						<?php echo $this->Form->password('cvv',['class'=>'form-control','id'=>'cvv','maxlength'=>3,'autocomplete'=>"off","placeholder"=>"CVV"]);?>
					</div>
				</div>
			</div>

			<div class="col-md-12">
			<?php echo $this->Form->submit('Proceed',['class'=>'btn btn-primary','id'=>'proceed']);?>
			
			</div>
	<?php echo $this->Form->end() ?>
			
</div>
<script type="text/javascript">
$(".payment_types").change(function(){
	var payment = $(this).val();
	if(payment == 'worldpay_direct_payment')
	{
		$("#worldpay").css('display','block');
	}
	else
	{
		$("#worldpay").css('display','none');
	}
});
$("#proceeds").click(function(){

	var payment = $("input[name='payment_type']:checked"). val();
	if(payment == 'worldpay_direct_payment')
	{
		var cardholder_name = $("#cardholder_name").val();
		var card_number = $("#card_number").val();
		var cardholder_type = $("#cardholder_type option:selected").val();
		var exp_month = $("#exp_month option:selected").val();$
		var exp_year = $("#exp_year option:selected").val();
		var cvv = $("#cvv").val();
		
		if(cardholder_name!= '' && card_number!= '' && cardholder_type!= '' && exp_month!= '' && exp_year!= '' && cvv!= '' )
		{
			return true;
		}
		else
		{
			alert("Please fill your all card details");
			return false;
		}
	}
	else
	{
		return true;
	}
});

</script>