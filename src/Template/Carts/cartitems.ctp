<div class="cart-table">
	 <div class="cart-items-process"> <i class="fa fa-spinner fa-spin"></i></div>
	<?php foreach ($tickets as $ticket):?>
		<?php 
			$ticket_price			=	 $this->Custom->applyAddtionalPrice($ticket['id'],$ticket['price'],$ticket['qty']);
			$total_price				=	($ticket_price*$ticket['qty']);
			$discount_total_price	=	 $this->Custom->applyDiscountPrice($ticket['id'],$total_price,$ticket['qty']);
		?>
		 <div class="loop-table">
		<h4><?php echo $ticket['title'];?></h4>
			<table class="table" id="table_t_<?php echo $ticket['id'];?>">
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
						<td class="quantity">
							<?php echo $this->Form->create('Cart', [ 'url' => ['controller'=>'carts', 'action' => 'ajaxupdatecartticket'],'class'=>'updatecartticket']); ?>
								<?php echo $this->Form->hidden('ticket_id',array('value' => base64_encode($ticket['id']),'class'=>'ticket_id')) ?>
								<div class="input-group spinner dark">
									<?php echo $this->Form->text('quantity', ['class' => 'form-control validate[required,custom[number]]', 'min' => 1,'max'=>20,'value'=>$ticket['qty']]) ?>
									<div class="input-group-btn-vertical">
										<button class="btn btn-default" type="button"><i class="fa fa-caret-up"></i></button>
										<button class="btn btn-default" type="button"><i class="fa fa-caret-down"></i></button>
									</div>
								</div>
								<span class="update">
									<input name="update_to_cart" type="submit" value="<?php echo __('Update')?>">
								</span>
							<?php echo $this->Form->end() ?>
						</td>
						<td><?php echo $this->Custom->displayPriceHtml($ticket_price); ?></td>
						<td class="item_total">
							<?php if($discount_total_price < $total_price):?>
								<span class="discount-price"><?php echo $this->Custom->displayPriceHtml($total_price);?></span>
								<span ><?php echo $this->Custom->displayPriceHtml($discount_total_price);?></span>
							<?php else: ?>	
								<span>
									<?php echo $this->Custom->displayPriceHtml($total_price);?>
								</span>
							<?php endif;?>
						</td>
						<td class="cross">
							<?php 
								$slug	=	'tickets||'.$ticket['id'];
								$code	=	base64_encode($slug);
							?>
							<a href="<?php echo $this->Url->build(['controller' => 'carts', 'action' => 'removeItem']).'/'.$code?>">X</a>
						</td>
					</tr>	
				</tbody>
			</table>
		</div>
	<?php endforeach;?>
	
	<?php if($products): ?>
		<?php foreach ($products as $product):?>
		 <div class="loop-table">
			<h4><?php echo $product['title'];?></h4>
			<table class="table" id="table_p_<?php echo $product['id'];?>">
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
						<td class="quantity">
							<?php echo $this->Form->create('Cart', [ 'url' => ['controller'=>'carts', 'action' => 'ajaxupdatecartproduct'],'class'=>'updatecartproduct']); ?>
								<?php echo $this->Form->hidden('product_id',array('value' => base64_encode($product['id']),'class'=>'product_id')) ?>
								<div class="input-group spinner dark">
									<?php echo $this->Form->text('quantity', ['class' => 'form-control validate[required,custom[number]]', 'min' => 1,'max'=>20,'value'=>$product['qty']]) ?>
									<div class="input-group-btn-vertical">
										<button class="btn btn-default" type="button"><i class="fa fa-caret-up"></i></button>
										<button class="btn btn-default" type="button"><i class="fa fa-caret-down"></i></button>
									</div>
								</div>
								<span class="update">
									<input name="update_to_cart" type="submit" value="<?php echo __('Update')?>">
								</span>
							<?php echo $this->Form->end() ?>
						</td>
						<td><?php echo $this->Custom->displayPriceHtml($product['price']); ?></td>
						<td class="item_total"><?php echo $this->Custom->displayPriceHtml($product['qty']*$product['price']);?></td>
						<td class="cross">
							<?php 
								$slug	=	'products||'.$product['id'];
								$code	=	base64_encode($slug);
							?>
							<a href="<?php echo $this->Url->build(['controller' => 'carts', 'action' => 'removeItem']).'/'.$code?>">X</a>
						</td>
					</tr>	
				</tbody>
			</table>
		</div>
		<?php endforeach;?>
	<?php endif;?>	
	
	
	
	<?php if($programs): ?>
		<?php foreach ($programs as $program):?>
			 <div class="loop-table">
				<h4><?php echo $program['title'];?></h4>
				<table class="table" id="table_p_<?php echo $program['id'];?>">
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
							<td class="quantity">
								<?php echo $this->Form->create('Cart', [ 'url' => ['controller'=>'carts', 'action' => 'ajaxupdatecartprogram'],'class'=>'updatecartprogram']); ?>
									<?php echo $this->Form->hidden('program_id',array('value' => base64_encode($program['id']),'class'=>'program_id')) ?>
									<div class="input-group spinner dark">
										<?php echo $this->Form->text('quantity', ['class' => 'form-control validate[required,custom[number]]', 'min' => 1,'max'=>20,'value'=>$program['qty']]) ?>
										<div class="input-group-btn-vertical">
											<button class="btn btn-default" type="button"><i class="fa fa-caret-up"></i></button>
											<button class="btn btn-default" type="button"><i class="fa fa-caret-down"></i></button>
										</div>
									</div>
									<span class="update">
										<input name="update_to_cart" type="submit" value="<?php echo __('Update')?>">
									</span>
								<?php echo $this->Form->end() ?>
							</td>
							<td><?php echo $this->Custom->displayPriceHtml($program['price']); ?></td>
							<td class="item_total"><?php echo $this->Custom->displayPriceHtml($program['qty']*$program['price']);?></td>
							<td class="cross">
								<?php 
									$slug	=	'programs||'.$program['id'];
									$code	=	base64_encode($slug);
								?>
								<a href="<?php echo $this->Url->build(['controller' => 'carts', 'action' => 'removeItem']).'/'.$code?>">X</a>
							</td>
						</tr>	
					</tbody>
				</table>
			</div>
		<?php endforeach;?>
	<?php endif;?>
	
	
	<?php if(!$products): ?>
		<div class="nofoodcart">
			<h2><?php echo __('You haven\'t added any food options yet.') ?></h2>
			<p><?php echo __('You can go back and adjust your order before buying.') ?></p>
			<span class="addtocart">
				<a href="#"  data-toggle="modal" data-target="#myFoodsModel"><?php echo __('Add Food');?></a>
			</span> 
		</div>	
	<?php endif ;?>	
	
		
</div>
<div class="payment_box" style="max-width:100%;">
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

