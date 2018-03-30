<div class="row">
  <div class="col-md-12">
	<div class="box">
		<div class="box-header with-border">
			<h3 class="box-title">View Order Details</h3>
			<span class="add_btn">
				<a href="<?php echo $this->Url->build(['controller' => 'orders', 'action' => 'add'])?>" class="btn btn-success btn-sm">Create New Order</a>
			</span>
			<span class="add_btn">
			<a href="<?php echo $this->Url->build(['controller' => 'orders', 'action' => 'index'])?>" class="btn btn-danger btn-sm">Back</a>
		</span>
		</div>
		<div class="box-body orderdetail">
			<div class="row">
				<div class="col-md-12">
					
					<h3><?php echo $event['title'];?></h3>
				</div>
			</div>
			<div class="row flex">
				<div class="col-md-6 customer-details">
				<div class="">
					<h4>Customer Details </h4>
					
					<h5>
						<?php 
						$name = $order['customers']['title'].' '.$order['customers']['first_name'].' '.$order['customers']['last_name'];
						echo $name;
						?> 
					</h5>
					
					<label>Email: </label><span><strong></strong> <?php echo $order['customers']['email'];?></span>
					<br>
					<label>Order Status:</label> <span><?php echo ucfirst($order['order_status']);?></span>
					<br>
					<label>Transaction Id: </label><span><?php echo $order['tnx_id'];?></span>
					<br>
					<label>Shipping: </label><span><?php echo ($order['is_shipping']=='y')? 'Yes': 'No';?></span>
					<br>
					<?php
					if($order['coupon_code']!='')
					{?>
					<label>Coupon Code: </label><span><?php echo $order['coupon_code'];?></span>
					<?php
					} ?>

					</div>
				</div>

				<div class="col-md-6 customer-address">
				<div class="">
					<h4>Address Details</h4>
					
					<label>Street Address:</label><span><?php 
						$address = $order['address1'].', '.$order['address2'].', '.$order['town'];
						echo ucfirst($address);
					?> </span>
					<br>
					<label>County: </label><span><?php echo $order['county'];?></span><br>
					<label>Country: </label><span><?php echo $this->Custom->displayCountryName($order['country']);?></span><br>
					<label>Postcode: </label><span><?php echo $order['postcode'];?></span>
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
							<?php 
							foreach($tickets as $ticket) {
								?>
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
								<?php
							}
							?>
							<?php 
							foreach($products as $product) {
								?>
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
								<?php
							}
							?>
							<?php 
							foreach($programs as $program) {
								?>
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
								<?php
							}
							?>
					</tbody>
					</table>
							<div class="row btm-table">
						<div class="col-md-6">
						<?php 
							foreach($tickets as $tic) {
								if($tic['special_requirement']!='')
								{
								?>
								<table width="100%" class="table" >
									<tr>
										<td width="52%" style="background:rgba(240,238,244, 0.6)"><strong>Special Requirements</strong></td>
										<td width="48%"><?php echo $tic['item_name'].' - '.$tic['special_requirement'];?></td>
										
								  </tr>
									<tr>
										<td width="52%" style="background:rgba(240,238,244, 0.6)"><strong>Comments</strong></td>
										<td width="48%"><?php echo $tic['special_description'];?><br>
								      <br></td>
										
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
									<td width="52%" style="background:rgba(240,238,244, 0.6)"><strong>Sub Total</strong></td>
									<td width="48%"><?php echo $this->Custom->displayPriceHtml($order['subtotal_amount']);?></td>
									
							  </tr>
								<tr>
									<td width="52%" style="background:rgba(240,238,244, 0.6)"><strong>Shipping Amount</strong></td>
									<td width="48%"><?php echo $this->Custom->displayPriceHtml($order['shipping_amount']);?></td>
									
							  </tr>
								<tr>
									<td width="52%" style="background:rgba(240,238,244, 0.6)"><strong>Discount Amount</strong></td>
									<td width="48%"><?php echo $this->Custom->displayPriceHtml($order['discount_amount']);?></td>
									
							  </tr>
								<tr>
									<td width="52%" style="background:rgba(240,238,244, 0.6)"><strong>Total Amount</strong></td>
									<td width="48%"><?php echo $this->Custom->displayPriceHtml($order['total_amount']);?></td>
									
							  </tr>
							</table>
  </div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>