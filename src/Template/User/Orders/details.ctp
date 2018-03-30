<div class="container-fluid booking-page confirmation-page">
	<div class="step-heading row">
		<h2><?php echo __('Order Details')?></h2>
	</div>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="my-account-items-container">
					<div class="row">
						<?php echo $this->element('front_sidebar'); ?>
						<div class="col-md-9 col-sm-8">
							<?php if($order): ?>
								<div class="box-body orderdetail">
									<div class="row">
										<div class="col-md-12">
											<h2>Event: <?php echo  $order['event']['title'];?></h2>
										</div>
									</div>
									<div class="row flex">
										<div class="col-md-6">
											<div class="customer-details">
												<h4>Customer Details </h4>
												<h5>
													<?php 
														$name = $order['customer']['title'].' '.$order['customer']['first_name'].' '.$order['customer']['last_name'];
														echo $name;
													?> 
												</h5>
												<p><span><strong>Email : </strong> <?php echo $order['customer']['email'];?></span></p>
												<p><span><strong>Order Status : </strong> <?php echo ucfirst($order['order_status']);?></span></p>
												<p><span><strong>Shipping Request : </strong> <?php echo ($order[' 	is_shipping']=='y') ? "Yes" : "No" ;?></span></p>
											</div>
										</div>
										<div class="col-md-6">
											<div class="customer-address">
												<h4>Address Details</h4>
												<p>
												<label>Address : </label>
												<span>
													<?php 
														$addressArr		=	array();
														$addressArr[]	=	$order['address1'];
														$addressArr[]	=	$order['address2'];
														$addressArr[]	=	$order['town'];
														echo implode(", ",$addressArr);
													?> 
												</span>
												</p>
												<p><label>County : </label> <span><?php echo $order['county'];?></span></p>
												<p><label>Postcode : </label> <span><?php echo $order['postcode'];?></span></p>
												<p><label>Country : </label> <span><?php echo $this->Custom->displayCountryName($order['country']);?></span></p>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<table class="table table-bordered">
												<thead>
													<tr>
														<th>Name</th>
														<th>Quantity</th>
														<th>Item Total</th>
													</tr>
												</thead>
												<tbody>
													<?php if($tickets): ?>
														<?php foreach($tickets as $ticket) { ?>
															<tr>
																<td class="quantity qty-custm">
																	<?php echo $ticket['item_name'];?>
																</td>
																<td class="quantity qty-custm">
																	<?php echo $ticket['item_quantity'];?>
																</td>
																<td class="quantity qty-custm">
																	<?php echo $this->Custom->displayPriceHtml($ticket['item_total']);?>
																</td>
															</tr>
														<?php } ?>
													<?php endif;?>
													
													<?php if($products): ?>
														<?php foreach($products as $product) { ?>
															<tr>
																<td class="quantity qty-custm">
																	<?php echo $product['item_name'];?>
																</td>
																<td class="quantity qty-custm">
																	<?php echo $product['item_quantity'];?>
																</td>
																<td class="quantity qty-custm">
																	<?php echo $this->Custom->displayPriceHtml($product['item_total']);?>
																</td>
															</tr>
														<?php }?>
													<?php endif;?>
													<?php if($programs): ?>
														<?php foreach($programs as $program) { ?>
															<tr>
																<td class="quantity qty-custm">
																	<?php echo $program['item_name'];?>
																</td>
																<td class="quantity qty-custm">
																	<?php echo $program['item_quantity'];?>
																</td>
																<td class="quantity qty-custm">
																	<?php echo $this->Custom->displayPriceHtml($program['item_total']);?>
																</td>
															</tr>
														<?php }?>
													<?php endif;?>
												</tbody>
											</table>
											<div class="row btm-table">
												<div class="col-md-6">
													<?php 
														foreach($tickets as $tic) {
															if($tic['special_requirement']!=''){ ?>
																<table width="100%" class="table" >
																	<tr>
																		<td width="52%" style="background:rgba(240,238,244, 0.6)">
																		<strong>Special Requirements</strong></td>
																		<td width="48%"><?php echo $tic['item_name'].' - '.$tic['special_requirement'];?></td>
																	</tr>
																	<tr>
																		<td width="52%" style="background:rgba(240,238,244, 0.6)"><strong>Comments</strong></td>
																		<td width="48%"><?php echo $tic['special_description'];?></td>
																	</tr>
																</table>
																<?php
															}
														}
													?>
												</div>
												<div class="col-md-6">
													<table width="100%" class="table">
														<tr>	
															<td width="52%" style="background:rgba(240,238,244, 0.6)"><strong>Sub Total : </strong></td>
															<td width="48%"><?php echo $this->Custom->displayPriceHtml($order['subtotal_amount']);?></td>
														</tr>
														<tr>
															<td width="52%" style="background:rgba(240,238,244, 0.6)"><strong>Shipping Amount : </strong></td>
															<td width="48%"><?php echo $this->Custom->displayPriceHtml($order['shipping_amount']);?></td>
														</tr>
														<tr>
															<td width="52%" style="background:rgba(240,238,244, 0.6)"><strong>Discount Amount : </strong></td>
															<td width="48%"><?php echo $this->Custom->displayPriceHtml($order['discount_amount']);?></td>
														</tr>
														<tr>
															<td width="52%" style="background:rgba(240,238,244, 0.6)"><strong>Total Amount  : </strong></td>
															<td width="48%"><?php echo $this->Custom->displayPriceHtml($order['total_amount']);?></td>
														</tr>
													</table>
												</div>
											</div>
										</div>
									</div>
								</div>
							<?php else:?>	
								<?php echo __('This order not longer exist.')?>
							<?php endif;?>	
						</div>
					</div>	
				</div>
			</div>
		</div>
	</div>
</div>


