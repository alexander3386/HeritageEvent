<div class="container-fluid booking-page confirmation-page">
	<div class="step-heading row">
		<h2><?php echo __('My Orders')?></h2>
	</div>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="my-account-items-container">
					<div class="row">
						<?php echo $this->element('front_sidebar'); ?>
						<div class="col-md-9 col-sm-8">
							<div class="box-body">
								<table class="table table-bordered">
									 <tr>
										<th class="sno">#</th>
										<th>Event Name</th>
										<th>Event Date</th>
										<th>Total</th>
										<th>Order Date</th>
										<th class="status">Status</th>
										<th class="action">Action</th>
									 </tr>
									<?php 
									if($orders) {
										$i	=1;
										foreach($orders as $item) {
											$id = $item['id'];
										?>    
										<tr>
											<td><?php echo $i; ?></td>
											<td><?php echo $item->event['title']; ?></td>
											<td><?php echo $this->Custom->displayDateFormat($item->event['date_time']); ?></td>
											<td><?php echo $this->Custom->displayPriceHtml($item->total_amount); ?></td>
											<td><?php echo $this->Custom->displayDateFormat($item->created); ?></td>
											<td><?php echo ucfirst($item->order_status); ?></td>
											<td align="center" class="action">
												<a class="btn btn-info btn-xs" title="View Detail" href="<?php echo $this->Url->build(['controller' => 'orders', 'action' => 'details/'.$id])?>"><i class="glyphicon glyphicon-eye-open"></i></a>
												
											</td>
										</tr>
										<?php 
											$i++;
										}
									}else {
										echo '<tr><td  colspan="7" align="center"><i>No orders found!</i></td></tr>';
									}
								?>
								</table>
							</div>
						</div>
					</div>	
				</div>
			</div>
		</div>
	</div>
</div>


