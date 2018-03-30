<?php if($event): ?>
	<?php echo $this->element('event_slider'); ?>
	<div class="container-fluid booking-page confirmation-page">
		<div class="step-heading row">
			<h2><?php echo __('Cart')?></h2>
		</div>
		<div class="container">
			<div class="row">
				<div class="col-md-8">
				<div class="process-message"></div>	
				<?php if (null!=$carts):?>
					<?php if($tickets): ?>
						<div class="cart-items-container">
							<?php echo $this->requestAction('/carts/cartitems'); ?>	
						</div>
					<?php else: ?>	
						<p class="empty_cart"><?php echo __('You cart is empty. please add at-least one ticket(s) with food option(s).');?></p>
					<?php endif;?>	
				<?php else: ?>	
						<p class="empty_cart"><?php echo __('You cart is empty. please add at-least one ticket(s).');?></p>
				<?php endif;?>			
				</div>
			</div>
		</div>
	</div>
	
	<?php if (null!=$carts){ ?>
		<?php if(@count($carts['products']) < 1){ ?>
			<?php if($event->products){ ?>
				<div id="myFoodsModel" class="modal fade confirm-food common" role="dialog">
					<div class="vertical-alignment-helper">
						<div class="modal-dialog vertical-align-center"> 
							<div class="modal-content">
								<div class="modal-body">
									 <div class="close"><a href="javascript:void(0)" data-dismiss="modal"><i><img src="img/close.png" alt=""/></i>Close</a></div>
									<h2>Are you sure you don’t want to add food? </h2>
									<p class="text">You can go back and adjust your order before buying.</p>
									<a href="<?php echo $this->Url->build(['controller' => 'carts', 'action' => 'cart'])?>" class="goback-btn">GO BACK</a> 
									<a href="<?php echo $this->Url->build(['controller' => 'carts', 'action' => 'checkout'])?>" class="checkout-btn">CHECKOUT</a>
									<div class="product-loop">
										<p class="text">Or simply add to your order below:</p>
										<ul>
											<?php foreach($event->products as $k=>$product){ ?>	
											<li>
												<h3>Classical Concert Dining</h3>
												<?php echo $this->Form->create('Cart', [ 'url' => ['controller'=>'carts', 'action' => 'ajaxupdatecartproduct'],'class'=>'updatecartproduct']); ?>
												<?php echo $this->Form->hidden('product_id',array('value' => base64_encode($product['id']),'class'=>'product_id')) ?>
													<div class="qty">
														<h4>Qty </h4>
														<div class="input-group spinner">
															<?php echo $this->Form->text('quantity', ['class' => 'form-control validate[required,custom[number]]', 'min' => 1,'max'=>20,'value'=>1]) ?>
															<div class="input-group-btn-vertical">
																<button class="btn btn-default" type="button"><i class="fa fa-caret-up"></i></button>
																<button class="btn btn-default" type="button"><i class="fa fa-caret-down"></i></button>
															</div>
														</div>
													</div>
													<div class="addtocart">
														<input name="add_to_cart" type="submit" value="<?php echo __('ADD TO CART')?>">
													</div> 
													<div class="price"> 
														<h4> Price</h4> <?php echo $this->Custom->displayPriceHtml($product['price']); ?> <em><?php echo $product['price_postfix']; ?></em> 
													</div>
													<div class="total"><h4> Total</h4>
														<span class="food_total_amount">£0</span>
													</div>
												<?php echo $this->Form->end() ?>
											</li>
											<?php } ?>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php } ?>
		<?php } ?>
	<?php } ?>
	<?php //echo $this->Form->end();?>
<?php else: ?>
	<?php echo __('Sorry something going wrong. Please try after some times.')?>
<?php endif;?>