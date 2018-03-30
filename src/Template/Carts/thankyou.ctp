<?php if($event): ?>
	<?php echo $this->element('event_slider'); ?>
	<div class="container-fluid booking-page confirmation-page thankyou-page">
		<div class="step-heading row">
			<h2><?php echo __('Thank you')?></h2>
		</div>
		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<div class="orders-items-container">
						<h3><?php echo __('You have purchased tickets for the following:');?></h3>	
						<p class="evetn_title"><span>Event:</span> <?php echo $event->title;?></p>
						<p class="date"><span>Date:</span> <?php echo $this->Custom->displayDateFormat($event->date_time); ?></p>
						<div class="your-order"><?php echo __('Your Order');?></div>
						<?php if($tickets): ?>
							<?php foreach ($tickets as $item):?>
								<?php 
									$item_price			=	$item->item_price;
									$item_quantity		=	$item->item_quantity;
									$item_total			=	$item->item_total;
								?>
								<div class="loop-table">
									<h4><?php echo $item->tickets['title'];?></h4>
									<table class="table" >
										<thead>
											<tr>
												<th>Quantity</th>
												<th>Price</th>
												<th>Total</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td class="quantity"><?php echo $item_quantity;?></td>
												<td><?php echo $this->Custom->displayPriceHtml($item_price); ?></td>
												<td class="item_total"><span><?php echo $this->Custom->displayPriceHtml($item_total);?></span></td>
											</tr>	
										</tbody>
									</table>
								</div>
							<?php endforeach;?>
						<?php endif;;?>
						<?php if($products): ?>
							<?php foreach ($products as $item):?>
								<?php 
									$item_price			=	$item->item_price;
									$item_quantity		=	$item->item_quantity;
									$item_total			=	$item->item_total;
								?>
								<div class="loop-table">
									<h4><?php echo $item->products['title'];?></h4>
									<table class="table" >
										<thead>
											<tr>
												<th>Quantity</th>
												<th>Price</th>
												<th>Total</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td class="quantity"><?php echo $item_quantity;?></td>
												<td><?php echo $this->Custom->displayPriceHtml($item_price); ?></td>
												<td class="item_total"><span><?php echo $this->Custom->displayPriceHtml($item_total);?></span></td>
											</tr>	
										</tbody>
									</table>
								</div>
							<?php endforeach;?>
						<?php endif;;?>
						
						<div class="payment_box">
							<div class="total"> 
								<div class="cart-totals-container">
									<div class="cart-total">
										<span>Total paid: </span>
										<?php $Total	=	$order->total_amount; ?>
										<strong><?php echo $this->Custom->displayPriceHtml($Total);?></strong>
									</div>
								</div>
								<div class="clearfix"></div>
							</div>	
						</div>	
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php //echo $this->Form->end();?>
<?php else: ?>
	<?php echo __('Sorry something going wrong. Please try after some times.')?>
<?php endif;?>