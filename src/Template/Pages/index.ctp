<?php //pr($event);?>
developement
<?php if($event): ?>
	<?php echo $this->element('event_slider'); ?>
	<?php if($event->status==1){ ?>
		<div class="container-fluid booking-page home">
			<div class="container">
				<div class="row">
					<div class="col-md-7 col-sm-6 left">
						<h2>BOOKING PAGE</h2>
						<p>Simply select from the options below and buy online.  We will post the tickets to you.</p>
						<p>If you experience any problems, please phone: <strong><?php echo $setting->contact_number; ?></strong></p>
					</div>
					<div class="col-md-5 col-sm-6 right">
						<div class="discount"> 
							<span class="img">
							<?php
								$filePath = 'uploads'.DS.strtolower($setting->source()).DS.'image'.DS.$setting->get('upload_dir').DS.$setting->get('image');
								$mime = @mime_content_type(WWW_ROOT.$filePath);
								$mimeArr = ['image/gif', 'image/png', 'image/jpg', 'image/jpeg'];
								if(in_array($mime,$mimeArr)){
									echo $this->Html->image('../uploads/'.strtolower($setting->source()).'/image/' .$setting->get('upload_dir'). '/' . $setting->get('image'));
								}
							?>
							</span> 
							<span class="txt"><?php echo $setting->offer_content; ?></span> 
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="container-fluid"><div class="container"><?php echo $this->Flash->render(); ?></div></div>
		<div class="container-fluid step_1">
			<?php $subTotal	=	$this->Custom->getCartSubTotal(); ?>
			<div class="basket-section"> 
				<span class="basket-area">
				<a href="<?php echo $this->Url->build(['controller' => 'carts', 'action' => 'cart'])?>"><i><img src="/img/cart-icon.png" ></i> BASKET</a> <strong><?php echo $this->Custom->displayPriceHtml($subTotal);?></strong>
				</span> 
				<span class="basket-checkout"><a href="<?php echo $this->Url->build(['controller' => 'carts', 'action' => 'checkout'])?>"><i><img src="/img/check-icon.png" ></i> CHECKOUT NOW</a></span> 
			</div>
			<div class="step-heading row">
				<h2><?php echo __('1. Choose your ticket type')?></h2>
			</div>
			<div class="container">
				<div class="row">
					<div class="shot-info">Do you want to sit casually with your friends and family or have dedicated seats near the front?</div>
					<?php if($event->tickets){ ?>
					<?php foreach($event->tickets as $k=>$ticket){ ?>
						<?php if($ticket['status']==0): continue; endif; ?>
						<div class="col-md-12">
							<div class="ticket-loop">
								<div class="row">
									<div class="col-sm-4">
										<div class="ticket-spotpic">
											<?php
												$filePath = 'uploads'.DS.strtolower($ticket->source()).DS.'image'.DS.$ticket->get('upload_dir').DS.$ticket->get('image');
												$mime = @mime_content_type(WWW_ROOT.$filePath);
												$mimeArr = ['image/gif', 'image/png', 'image/jpg', 'image/jpeg'];
												if(in_array($mime,$mimeArr)){
													echo $this->Html->image('../uploads/'.strtolower($ticket->source()).'/image/' .$ticket->get('upload_dir'). '/' . $ticket->get('image'));
												}
											?>
										</div>
										<?php $ticket_price	=	 $this->Custom->applyAddtionalPrice($ticket->id,$ticket['price']); ?>
										<div class="ticket-heading-mobile">
											<h2><?php echo $ticket['title']; ?></h2>
											<span class="price"><?php echo $this->Custom->displayPriceHtml($ticket_price); ?></span> 
										</div>
									</div>
									<div class="col-sm-8"> 
										<span class="icon_pic">
											<?php
												$filePath = 'uploads'.DS.strtolower($ticket->source()).DS.'icon_image'.DS.$ticket->get('icon_upload_dir').DS.$ticket->get('icon_image');
												$mime = @mime_content_type(WWW_ROOT.$filePath);
												$mimeArr = ['image/gif', 'image/png', 'image/jpg', 'image/jpeg'];
												if(in_array($mime,$mimeArr)){
													echo $this->Html->image('../uploads/'.strtolower($ticket->source()).'/icon_image/' .$ticket->get('icon_upload_dir'). '/' . $ticket->get('icon_image'));
												}
											?>
										</span>
										<div class="pro-dtls">
											<h2><?php echo $ticket['title']; ?></h2>
											<span class="price"><?php echo $this->Custom->displayPriceHtml($ticket_price); ?></span> <span class="shot-description"><?php echo $ticket['description']; ?></span>
											<?php if($this->Custom->checkAvailableTickets($event->id,$ticket['id'])){ ?>
												<?php echo $this->Form->create('Cart', [ 'url' => ['controller'=>'carts', 'action' => 'addTicket']]); ?>
												<?php echo $this->Form->hidden('ticket_id',array('value' => base64_encode($ticket['id']))) ?>
												<div class="quantity">
													<h4><?php echo __('Quantity')?></h4>
													<div class="input-group spinner">
														<?php echo $this->Form->text('quantity', ['class' => 'form-control validate[required,custom[number]]', 'min' => 1,'max'=>20,'value'=>1]) ?>
														<div class="input-group-btn-vertical">
															<button class="btn btn-default" type="button"><i class="fa fa-caret-up"></i></button>
															<button class="btn btn-default" type="button"><i class="fa fa-caret-down"></i></button>
														</div>
													</div>
													<span class="addtocart">
														<input name="add_to_cart" type="submit" value="<?php echo __('Add to Cart')?>">
													</span> 
													
													<?php if($ticket['ticket_type']==1): ?>
														<span class="request"><a href="#" data-toggle="modal" data-target="#myModal<?php echo $ticket['id'];?>"><i><img src="/img/request.png"></i> <?php echo __('SPECIAL REQUESTS')?></a></span> 
													<?php endif;?>
												</div>	
												<?= $this->Form->end() ?>
											<?php }else{ ?>
												<div class="sold-out"><span ><?php echo __('Sold out.');?></span></div>
											<?php } ?>
										</div>
										<?php if($ticket['ticket_type']==1): ?>
											<div id="myModal<?php echo $ticket['id'];?>" class="modal fade special-req common" role="dialog">
												  <div class="vertical-alignment-helper">
													<div class="modal-dialog vertical-align-center"> 
													      <div class="modal-content">
															<div class="modal-body">
																<div class="popup-title"><span class="icon"><img src="images/popup-img.png" alt=""/></span>
																	<h2>Do you have special requirements? </h2>
																	<div class="close"><a href="javascript:void(0)" data-dismiss="modal"><i><img src="images/close.png" alt=""/></i>Close</a></div>
																</div>
																<div class="select-desc"> <strong>Select from the list below.</strong>
																	<p>Please note: these seats cannot be guaranteed and are issued on a first come first served basis.</p>
																</div>
																<div class="form-popup">
																	<?php echo $this->Form->create('Cart', [ 'url' => ['controller'=>'carts', 'action' => 'addTicket']]); ?>
																	<?php echo $this->Form->hidden('ticket_id',array('value' => base64_encode($ticket['id']))) ?>
																	<div class="form-col qty">
																		<h4>Qty</h4>
																		<div class="input-group spinner">
																			<?php echo $this->Form->text('quantity', ['class' => 'form-control validate[required,custom[number]]', 'min' => 1,'max'=>20,'value'=>1]) ?>
																			<div class="input-group-btn-vertical">
																				<button class="btn btn-default" type="button"><i class="fa fa-caret-up"></i></button>
																				<button class="btn btn-default" type="button"><i class="fa fa-caret-down"></i></button>
																			</div>
																		</div>
																	</div>
																	<div class="form-col requirment">
																		<h4>Requirement </h4>
																		<?php 
																			$options = $this->Custom->getSpecialRequirementArray();
																			echo $this->Form->select('special_requirement', $options, ['class' => 'cs-select cs-skin-border'] ) 
																		?>
																	</div>
																	<div class="form-col submit-btn">
																		<input name="add_to_cart" type="submit" value="<?php echo __('book')?>">
																	</div>
																	<div class="form-col description">
																		<?php echo $this->Form->textarea('special_description', ['class' => 'form-control']) ?>
																	</div>
																	<div class="clearfix"></div>
																	<?= $this->Form->end() ?>
																</div>
															</div>
													      </div>
													</div>
												</div>
											</div>
										<?php endif;?>
									</div>
								</div>
							</div>
						</div>
						<?php } ?>
					<?php } ?>
					
				</div>
			</div>
		</div>
		<div class="container-fluid step_1 step_2">
			<div class="step-heading row">
				<h2><?php echo __('2. Choose food options')?></h2>
			</div>
			<div class="container">
				<div class="row">
					<div class="shot-info">Enhance your day and select our delicious food, seated or picnic style with vegetarian and children's options.</div>
					<?php if($event->products){ ?>
						<?php foreach($event->products as $k=>$product){ ?>	
							<?php if($product['status']==0): continue; endif; ?>
							<div class="col-md-12">
								<div class="ticket-loop">
									<div class="row">
										<div class="col-sm-4">
											<div class="ticket-spotpic">
												<?php
													$filePath = 'uploads'.DS.strtolower($product->source()).DS.'image'.DS.$product->get('upload_dir').DS.$product->get('image');
													$mime = @mime_content_type(WWW_ROOT.$filePath);
													$mimeArr = ['image/gif', 'image/png', 'image/jpg', 'image/jpeg'];
													if(in_array($mime,$mimeArr)){
														echo $this->Html->image('../uploads/'.strtolower($product->source()).'/image/' .$product->get('upload_dir'). '/' . $product->get('image'));
													}
												?>
											</div>
											<div class="ticket-heading-mobile">
												<h2><?php echo $product['title']; ?></h2>
												<span class="price"><?php echo $this->Custom->displayPriceHtml($product['price']); ?> <em><?php echo $product['price_postfix']; ?></em></span>
											</div>
										</div>
										<div class="col-sm-8"> 
											<span class="icon_pic">
												<?php
													$filePath = 'uploads'.DS.strtolower($product->source()).DS.'icon_image'.DS.$product->get('icon_upload_dir').DS.$product->get('icon_image');
													$mime = @mime_content_type(WWW_ROOT.$filePath);
													$mimeArr = ['image/gif', 'image/png', 'image/jpg', 'image/jpeg'];
													if(in_array($mime,$mimeArr)){
														echo $this->Html->image('../uploads/'.strtolower($product->source()).'/icon_image/' .$product->get('icon_upload_dir'). '/' . $product->get('icon_image'));
													}
												?>
											</span>
											<div class="pro-dtls">
												<h2><?php echo $product['title']; ?></h2>
												<span class="price"><?php echo $this->Custom->displayPriceHtml($product['price']); ?> <em><?php echo $product['price_postfix']; ?></em></span> 
												<span class="shot-description"><?php echo $product['description']; ?></span>
												<?php echo $this->Form->create('Cart', [ 'url' => ['controller'=>'carts', 'action' => 'addProduct']]); ?>
												<?php echo $this->Form->hidden('product_id',array('value' => base64_encode($product['id']))) ?>
												<div class="quantity">
													<h4><?php echo __('Quantity')?></h4>
													<div class="input-group spinner">
														<?php echo $this->Form->text('quantity', ['class' => 'form-control validate[required,custom[number]]', 'min' => 1,'max'=>20,'value'=>1]) ?>
														<div class="input-group-btn-vertical">
															<button class="btn btn-default" type="button"><i class="fa fa-caret-up"></i></button>
															<button class="btn btn-default" type="button"><i class="fa fa-caret-down"></i></button>
														</div>
													</div>
													<span class="addtocart">
														<input name="add_to_cart" type="submit" value="<?php echo __('Add to Cart')?>">
													</span> 
												</div>
												<?= $this->Form->end() ?>
											</div>
										</div>
									</div>
								</div>
							</div>
						<?php } ?>	
					<?php } ?>	
				</div>
			</div>
		</div>
		
		<div class="container-fluid step_1 step_2">
			<div class="step-heading row">
				<h2><?php echo __('3. Add programme')?></h2>
			</div>
			<div class="container">
				<div class="row">
					<div class="shot-info">Would you like to receive a ticket programme on the day?.</div>
					<?php if($event->programs){ ?>
						<?php foreach($event->programs as $k=>$program){ ?>	
							<?php if($product['status']==0): continue; endif; ?>
							<div class="col-md-12">
								<div class="ticket-loop">
									<div class="row">
										<div class="col-sm-4">
											<div class="ticket-spotpic">
												<?php
													$filePath = 'uploads'.DS.strtolower($program->source()).DS.'image'.DS.$program->get('upload_dir').DS.$program->get('image');
													$mime = @mime_content_type(WWW_ROOT.$filePath);
													$mimeArr = ['image/gif', 'image/png', 'image/jpg', 'image/jpeg'];
													if(in_array($mime,$mimeArr)){
														echo $this->Html->image('../uploads/'.strtolower($program->source()).'/image/' .$program->get('upload_dir'). '/' . $program->get('image'));
													}
												?>
											</div>
											<div class="ticket-heading-mobile">
												<h2><?php echo $program['title']; ?></h2>
												<span class="price"><?php echo $this->Custom->displayPriceHtml($program['price']); ?></span>
											</div>
										</div>
										<div class="col-sm-8"> 
											<span class="icon_pic">
												<?php
													$filePath = 'uploads'.DS.strtolower($program->source()).DS.'icon_image'.DS.$program->get('icon_upload_dir').DS.$program->get('icon_image');
													$mime = @mime_content_type(WWW_ROOT.$filePath);
													$mimeArr = ['image/gif', 'image/png', 'image/jpg', 'image/jpeg'];
													if(in_array($mime,$mimeArr)){
														echo $this->Html->image('../uploads/'.strtolower($program->source()).'/icon_image/' .$program->get('icon_upload_dir'). '/' . $program->get('icon_image'));
													}
												?>
											</span>
											<div class="pro-dtls">
												<h2><?php echo $program['title']; ?></h2>
												<span class="price"><?php echo $this->Custom->displayPriceHtml($program['price']); ?></span> 
												<span class="shot-description"><?php echo $program['description']; ?></span>
												<?php echo $this->Form->create('Cart', [ 'url' => ['controller'=>'carts', 'action' => 'addProgram']]); ?>
												<?php echo $this->Form->hidden('program_id',array('value' => base64_encode($program['id']))) ?>
												<div class="quantity">
													<h4><?php echo __('Quantity')?></h4>
													<div class="input-group spinner">
														<?php echo $this->Form->text('quantity', ['class' => 'form-control validate[required,custom[number]]', 'min' => 1,'max'=>20,'value'=>1]) ?>
														<div class="input-group-btn-vertical">
															<button class="btn btn-default" type="button"><i class="fa fa-caret-up"></i></button>
															<button class="btn btn-default" type="button"><i class="fa fa-caret-down"></i></button>
														</div>
													</div>
													<span class="addtocart">
														<input name="add_to_cart" type="submit" value="<?php echo __('Add to Cart')?>">
													</span> 
												</div>
												<?= $this->Form->end() ?>
											</div>
										</div>
									</div>
								</div>
							</div>
						<?php } ?>	
					<?php } ?>	
				</div>
			</div>
		</div>

		<div class="container-fluid step_1 step_3">
			<div class="step-heading row">
				<h2><?php echo __('4. Make Payment')?></h2>
			</div>
			<div class="container">
				<div class="payment_box">
					<p>You can edit or pay for your order on the next page</p>
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
						<a href="<?php echo $this->Url->build(['controller' => 'carts', 'action' => 'cart'])?>" class="btn"><?php echo __('View Cart')?></a> 
					</div>
				</div>
			</div>
		</div>
	<?php }else{ ?>	
		<div class="container-fluid booking-page">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<h2><?php echo $event->title;?></h2>
						<p><?php echo $event->description;?></p>
						<p>&nbsp;</p>
						<p>Sorry - these tickets are no longer available</p>
					</div>
				</div>
			</div>
		</div>
	<?php } ?>	
<?php else: ?>
		<div class="container-fluid booking-page">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<div class="error_msg"><p><?php echo __('No active event(s) available for bookings.')?></p></div>
					</div>
				</div>
			</div>
		</div>
<?php endif;?>
