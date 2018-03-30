<?php if($event): ?>
	<?php echo $this->element('event_slider'); ?>
	<div class="container-fluid booking-page confirmation-page">
		<div class="step-heading row">
			<h2><?php echo __('Checkout')?></h2>
		</div>
		<div class="container">
			<div class="row">
				<div class="col-md-8">
					<div class="process-message"></div>
					<div class="checkout-login">
						<?php echo $this->Form->create('',['class'=>'ajaxloginform']) ?>
						<div class="row">	
							<div class="col-md-4 col-sm-4">
								<?php echo $this->Form->text('email', ['class' => 'form-control', 'placeholder' => 'Email address']) ?>
							</div>
							<div class="col-md-4 col-sm-4">
								<?php echo $this->Form->password('password', ['class' => 'form-control', 'placeholder' => 'Password']) ?>	
							</div>
							<div class="col-md-4 col-sm-4">
								<?php echo $this->Form->button(__('Sign In'), ['class' => 'btn btn-primary btn-block btn-flat']); ?>
							</div>
						</div>
						<div class="row">	
							<div class="col-md-6 pull-left">
								<?php echo $this->Html->link(__('Forgot Password?'), ['controller' => 'Customers', 'action' => 'forgotPassword']); ?>
							</div>
						</div>
						<?php echo $this->Form->end() ?>
					</div>
					<div class="checkout-items-container">
					
					
					<?php if (null!=$carts):?>
						<?php if(isset($carts['tickets']) && count($carts['tickets']) > 0):  ?>
							<?php echo $this->Form->create($form, ['id' => 'form_id','class'=>'checkout']) ?>
								<div class="box-body">
									<div class="cart-items-process"> <i class="fa fa-spinner fa-spin"></i></div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>Title <span class="require">*</span></label>
												<?php 
													$options = $this->Custom->getCutomerTitleArray();
													echo $this->Form->select('title', $options, ['class' => 'form-control','value'=>1] ) 
												?>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>First Name <span class="require">*</span></label>
												<?php echo $this->Form->text('first_name', ['class' => 'form-control validate[required]', 'maxlength' => 50]) ?>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>Last Name <span class="require">*</span></label>
												<?php echo $this->Form->text('last_name', ['class' => 'form-control validate[required]', 'maxlength' => 50]) ?>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>Email <span class="require">*</span></label>
												<?php if(isset($form['email']) && !empty($form['email'])): ?>	
													<?php echo $this->Form->text('email', ['class' => 'form-control validate[required,custom[email]]', 'maxlength' => 80,'readonly'=>'readonly']) ?>
												<?php else: ?>	
													<?php echo $this->Form->text('email', ['class' => 'form-control validate[required,custom[email]]', 'maxlength' => 80]) ?>
												<?php endif; ?>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>Telephone <span class="require">*</span></label>
												<?php echo $this->Form->text('contact_number', ['class' => 'form-control validate[required,custom[phone]]', 'maxlength' => 14]) ?>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>Address <span class="require">*</span></label>
												<?php echo $this->Form->text('address1', ['class' => 'form-control validate[required]', 'maxlength' => 100]) ?>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>Address 2</label>
												<?php echo $this->Form->text('address2', ['class' => 'form-control', 'maxlength' => 100]) ?>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>Town <span class="require">*</span></label>
												<?php echo $this->Form->text('town', ['class' => 'form-control validate[required]', 'maxlength' => 40]) ?>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>County <span class="require">*</span></label>
												<?php echo $this->Form->text('county', ['class' => 'form-control validate[required]', 'maxlength' => 40]) ?>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>Country <span class="require">*</span></label>
												<?php 
													$options = $this->Custom->getCountriesArray();
													echo $this->Form->select('country', $options, ['class' => 'form-control validate[required]','empty'=>'Select Country'] ) 
												?>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>Postcode <span class="require">*</span></label>
												<?php echo $this->Form->text('postcode', ['class' => 'form-control validate[required]', 'maxlength' => 14]) ?>
											</div>
										</div>
										<div class="col-md-12">
											<h4>Privacy Settings </h4>
											<p>
												<?php echo $this->Form->checkbox('hseoptin', ['value'=>'y']) ?> <span>I would like to receive marketing / product related information by email or post.</span>
											 </p>
											<p><?php echo $this->Form->checkbox('hostoptin', ['value'=>'y']) ?> <span>I would like to receive marketing / product related information from the event host.</span> 
											</p>
										</div>
										<?php if(isset($settings) && $settings['is_shipping']==1): ?>
											<div class="col-md-12">
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
										<div class="col-md-12 payment_box">
											<div class="total"> 
												<div class="cart-totals-container">
													<?php echo $this->requestAction('/carts/totals'); ?>
												</div>
												<div class="clearfix"></div>
												<div class="box-tools pull-left">
													<?php //echo $this->Form->button(__('Pay Now'), ['class' => 'btn btn-primary btn-block btn-flat']); ?>
												</div>
											</div>	
										</div>	
										<div class="clear"></div>
									</div>
								</div>
								
								<?php echo $this->Form->end() ?>
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
	</div>
	<?php //echo $this->Form->end();?>
<?php else: ?>
	<?php echo __('Sorry something going wrong. Please try after some times.')?>
<?php endif;?>