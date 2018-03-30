<div class="box box-default">
<div class="box-header with-border">
		<h3 class="box-title">Edit Ticket</h3>
	</div>
	<?php echo $this->Form->create($ticket, ['id' => 'form_id','type' => 'file']) ?>
	<div class="box-body">
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label>Event Name <span class="require">*</span></label>
					<?php echo $this->Form->input('event_id', ['type'=>'select','options'=>$event_arr,'class'=>'form-control', 'id'=>'event_id', 'label'=>false, 'templates' => ['inputContainer'=>'{{content}}'],'empty' => 'Select Event']); ?>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label>Ticket Type <span class="require">*</span></label>
					<?php 
						$options = ['1' => 'Seated Ticket', '2' => 'Picnic Ticket'];
						echo $this->Form->select('ticket_type', $options, ['class' => 'form-control'] ) 
					?>
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group">
					<label>Ticket Name <span class="require">*</span></label>
					<?php echo $this->Form->text('title', ['class' => 'form-control validate[required]', 'maxlength' => 200]) ?>
				</div>
			</div>
			
			<div class="col-md-6">
				<div class="form-group">
					<label>Description <span class="require">*</span></label>
					<?php echo $this->Form->textarea('description', ['class' => 'form-control validate[required]']) ?>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label>Item code <span class="require">*</span></label>
					<?php echo $this->Form->text('item_code', ['class' => 'form-control validate[required]', 'maxlength' => 12]) ?>
				</div>
			</div>
			<div class="clear"></div>
			<div class="col-md-4">
				<div class="form-group">
					<label>Price <span class="require">*</span></label>
					<div class="input-group col-md-4">
					 <span class="input-group-addon"><?php echo CURRENCY_SYMBOL; ?></span>
					 <?php $price	=	$this->Custom->displayPrice($ticket['price']);?>
					<?php echo $this->Form->text('price', ['class' => 'form-control validate[required,custom[number]]', 'maxlength' => 8,'placeholder'=>'0.00','value'=>$price]) ?>
					</div>
				</div>
			</div>
			<!--<div class="col-md-4">
				<div class="form-group">
					<label>Shipping Only</label>
					<div class="input-group col-md-4">
					<?php 
						$options = ['0' => 'No', '1' => 'Yes'];
						echo $this->Form->select('shipping_only', $options, ['class' => 'form-control'] ) 
					?>
					</div>
					<span>(Extra price to print ticket and post to customer.)</span>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label>Shipping Price </label>
					<div class="input-group col-md-4">
					 <span class="input-group-addon"><?php echo CURRENCY_SYMBOL; ?></span>
					 <?php $shipping_price	=	$this->Custom->displayPrice($ticket['shipping_price']);?>
					<?php echo $this->Form->text('shipping_price', ['class' => 'form-control validate[custom[number]]', 'maxlength' => 8,'placeholder'=>'0.00','value'=>$shipping_price]) ?>
					</div>
				</div>
			</div>-->
			
			<div class="clear"></div>
			<div class="col-md-12">
				<div class="row">
					<div class="col-md-12"><h5><label>Additional Price In Date Range : <span class="require">(** Addition price will be applicable on the base price of ticket )</span></label></h5></div>
					<?php $ticket_price_counter	=	0;?>	
					<?php if(count($ticket['ticket_prices']) > 0){ ?>
						<?php foreach($ticket['ticket_prices'] as $ticket_price){ ?>
						<div class="more_price_row_<?php echo $ticket_price_counter;?>">
							<div class="col-md-10">
								<div class="row">
									<?php echo $this->Form->hidden("ticket_prices.$ticket_price_counter.id", ['value'=>$ticket_price['id']]) ?>
									<div class="col-md-3">
										<div class="form-group">
											<label>Form</label>
											<div class='input-group date datepicker' >
												<?php  $date_from	=	$this->Custom->inputDateTimeFormat($ticket_price['date_from']); ?>
												<?php echo $this->Form->text("ticket_prices.$ticket_price_counter.date_from", ['class' => 'form-control','placeholder'=>'dd/mm/YYYY','value'=>$date_from]) ?>
												<span class="input-group-addon">
													<span class="glyphicon glyphicon-calendar"></span>
												</span>
											</div>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label>To</label>
											<div class='input-group date datepicker' >
												<?php  $date_to	=	$this->Custom->inputDateTimeFormat($ticket_price['date_to']); ?>
												<?php echo $this->Form->text("ticket_prices.$ticket_price_counter.date_to", ['class' => 'form-control','placeholder'=>'dd/mm/YYYY','value'=>$date_to]) ?>
												<span class="input-group-addon">
													<span class="glyphicon glyphicon-calendar"></span>
												</span>
											</div>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label>Additional Price</label>
											<?php $extra_price	=	$this->Custom->displayPrice($ticket_price['extra_price']);?>
											<?php echo $this->Form->text("ticket_prices.$ticket_price_counter.extra_price",['class' => 'form-control validate[custom[number]]','placeholder'=>'0.00','value'=>$extra_price]) ?>
										</div>
									</div>
									
									<div class="col-md-3">
										<div class="form-group">
											<label>Additional Price In</label>
											<?php 
												$options = [0 => 'Fixed Cost', 1 => 'In percent(%)'];
												echo $this->Form->select("ticket_prices.$ticket_price_counter.extra_price_type", $options, ['class' => 'form-control','value'=>$ticket_price['extra_price_type']] ) 
											?>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label>&nbsp;</label><br />
									<a href="javascript:void(0)" onclick="remove_hard_more_price('<?php echo $ticket_price_counter;?>','<?php echo $ticket_price['id'];?>','tickets');"class="remove_more_price" rel="<?php echo $ticket_price_counter;?>"><i class="glyphicon glyphicon-remove"></i></a>
								</div>
							</div>
						</div>
						<?php $ticket_price_counter++;?>
						<?php } ?>
						<div class="col-md-10">&nbsp;</div>
						<div class="col-md-2">
							<label>&nbsp;</label><br />
							<span class="button btn btn-primary btn-flat" id="add_more_price">Add More Price</span>
						</div>
					<?php } else { ?>	
						<div class="col-md-10">
							<div class="row">
								<div class="col-md-3">
									<div class="form-group">
										<label>Form</label>
										<div class='input-group date datepicker' >
											<?php echo $this->Form->text('ticket_prices.0.date_from', ['class' => 'form-control','placeholder'=>'dd/mm/YYYY']) ?>
											<span class="input-group-addon">
												<span class="glyphicon glyphicon-calendar"></span>
											</span>
										</div>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label>To</label>
										<div class='input-group date datepicker' >
											<?php echo $this->Form->text('ticket_prices.0.date_to', ['class' => 'form-control','placeholder'=>'dd/mm/YYYY']) ?>
											<span class="input-group-addon">
												<span class="glyphicon glyphicon-calendar"></span>
											</span>
										</div>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label>Additional Price</label>
										<?php echo $this->Form->text('ticket_prices.0.extra_price',['class' => 'form-control validate[custom[number]]','placeholder'=>'0.00','value'=>'0.00']) ?>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label>Additional Price In</label>
										<?php 
											$options = [0 => 'Fixed Cost', 1 => 'In percent(%)'];
											echo $this->Form->select('ticket_prices.0.extra_price_type', $options, ['class' => 'form-control','value'=>0] ) 
										?>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-2">
							<label>&nbsp;</label><br />
							<span class="button btn btn-primary btn-flat" id="add_more_price">Add More Price</span>
						</div>
					<?php } ?>
					<div class="col-md-12">
						<div class="row" id="extra_prices">
						</div>
					</div>
				</div>
			</div>
			<div class="clear"></div>
			<div class="col-md-12">
				<div class="row">
					<div class="col-md-12"><h5><label>Discount In Group Tickets : <span class="require">(** Discount price will be applicable on the price which will be get after additional price calculation of ticket )</span></label></h5></div>
					<?php $ticket_group_price_counter	=	0;?>	
					<?php if(count($ticket['ticket_group_prices']) > 0){ ?>
						<?php foreach($ticket['ticket_group_prices'] as $ticket_group_price){ ?>
							<div class="group_price_row_<?php echo $ticket_group_price_counter;?>">
								<div class="col-md-10">
									<?php echo $this->Form->hidden("ticket_group_prices.$ticket_group_price_counter.id", ['value'=>$ticket_group_price['id']]) ?>
									<div class="row">
										<div class="col-md-4">
											<div class="form-group">
												<label>Group Tickets Qty.</label>
												<?php echo $this->Form->text("ticket_group_prices.$ticket_group_price_counter.ticket_qty", ['class' => 'form-control validate[custom[onlyNumberSp]','value'=>$ticket_group_price['ticket_qty']]) ?>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label>Additional Discount Price</label>
												<?php $discount_price	=	$this->Custom->displayPrice($ticket_group_price['discount_price']);?>
												<?php echo $this->Form->text("ticket_group_prices.ticket_group_price_counter.discount_price",['class' => 'form-control validate[custom[number]]','placeholder'=>'0.00','value'=>$discount_price]) ?>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label>Additional Discount Price In</label>
												<?php 
													$options = [0 => 'Fixed Cost', 1 => 'In percent(%)'];
													echo $this->Form->select("ticket_group_prices.ticket_group_price_counter.discount_type", $options, ['class' => 'form-control','value'=>$ticket_group_price['discount_type']] ) 
												?>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<label>&nbsp;</label><br />
										<a href="javascript:void(0)" onclick="remove_hard_group_price('<?php echo $ticket_group_price_counter;?>','<?php echo $ticket_group_price['id'];?>','tickets');"class="remove_group_price" rel="<?php echo $ticket_group_price_counter;?>"><i class="glyphicon glyphicon-remove"></i></a>
									</div>
								</div>
							</div>
							<?php $ticket_group_price_counter++;?>
						<?php } ?>
						<div class="col-md-10">&nbsp;</div>
						<div class="col-md-2">
							<label>&nbsp;</label><br />
							<span class="button btn btn-primary btn-flat" id="add_group_price">Add Group Discount</span>
						</div>
					<?php } else { ?>	
						<div class="col-md-10">
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<label>Group Tickets Qty.</label>
										<?php echo $this->Form->text('ticket_group_prices.0.ticket_qty', ['class' => 'form-control validate[custom[onlyNumberSp]']) ?>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label>Additional Discount Price</label>
										<?php echo $this->Form->text('ticket_group_prices.0.discount_price',['class' => 'form-control validate[custom[number]]','placeholder'=>'0.00','value'=>'0.00']) ?>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label>Additional Discount Price In</label>
										<?php 
											$options = [0 => 'Fixed Cost', 1 => 'In percent(%)'];
											echo $this->Form->select('ticket_group_prices.0.discount_type', $options, ['class' => 'form-control','value'=>0] ) 
										?>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-2">
							<label>&nbsp;</label><br />
							<span class="button btn btn-primary btn-flat" id="add_group_price">Add Group Discount</span>
						</div>
					<?php } ?>
					<div class="col-md-12">
						<div class="row" id="ticket_group_prices">
						</div>
					</div>
				</div>
			</div>
			<div class="clear"></div>
			<div class="col-md-6">
				<div class="form-group">
					<label>Featured Image <span class="require">*</span></label>
					<?php echo $this->Form->input('image', ['type'=>'file','class'=>'form-control',  'label'=>false, 'templates' => ['inputContainer'=>'{{content}}'],'error'=>false]); ?>
				</div>
				<div class="form-group">
					<?php
						$filePath = 'uploads'.DS.strtolower($ticket->source()).DS.'image'.DS.$ticket->get('upload_dir').DS.$ticket->get('image');
						$sizeArr = @getimagesize(WWW_ROOT.$filePath);
						$mimeArr = ['image/gif', 'image/png', 'image/jpg', 'image/jpeg'];
						echo $this->Html->image('../uploads/'.strtolower($ticket->source()).'/image/' .$ticket->get('upload_dir'). '/square_' . $ticket->get('image'));
					?>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label>Icon Image</label>
					<?php echo $this->Form->input('icon_image', ['type'=>'file','class'=>'form-control',  'label'=>false, 'templates' => ['inputContainer'=>'{{content}}'],'error'=>false]); ?>
				</div>
				<div class="form-group">
					<?php
						$filePath = 'uploads'.DS.strtolower($ticket->source()).DS.'icon_image'.DS.$ticket->get('icon_upload_dir').DS.$ticket->get('icon_image');
						$sizeArr = @getimagesize(WWW_ROOT.$filePath);
						$mimeArr = ['image/gif', 'image/png', 'image/jpg', 'image/jpeg'];
						echo $this->Html->image('../uploads/'.strtolower($ticket->source()).'/icon_image/' .$ticket->get('icon_upload_dir'). '/square_' . $ticket->get('icon_image'));
					?>
				</div>
			</div>
			<div class="clear"></div>
			<div class="col-md-6">
				<div class="form-group">
					<label>Status <span class="require">*</span></label>
					<?php 
						$options = ['1' => 'Active', '0' => 'Inactive'];
						echo $this->Form->select('status', $options, ['class' => 'form-control'] ) 
					?>
				</div>
			</div>
		</div>
		<div class="box-tools pull-right">
			<?php echo $this->Form->button(__('Submit'), ['class' => 'btn btn-primary btn-block btn-flat']); ?>
		</div>
	</div>
	<?php echo $this->Form->end() ?>
</div>
<script>
	var rowCount = '<?php echo $ticket_price_counter;?>';
	$("#add_more_price").click(function(){
		rowCount++;
		$.ajax({
			type:"POST",
			url:"<?php echo $this->Url->build(["prefix"=>'admin',"controller" => "Tickets","action" => "add_more_price_field"]);?>/"+rowCount ,
			dataType: 'text',
			async:false,
			success: function(response){
				$('#extra_prices').append(response);
				$('.datepicker').datetimepicker({
					format: 'DD/MM/YYYY',
			       });
			},
			error: function (response) {
				alert('error');
			}
		});
	});
	var rowGroupCount =  '<?php echo $ticket_group_price_counter;?>';
	$("#add_group_price").click(function(){
		rowGroupCount++;
		$.ajax({
			type:"POST",
			url:"<?php echo $this->Url->build(["prefix"=>'admin',"controller" => "Tickets","action" => "add_group_price_field"]);?>/"+rowGroupCount ,
			dataType: 'text',
			async:false,
			success: function(response){
				$('#ticket_group_prices').append(response);
			},
			error: function (response) {
				alert('error');
			}
		});
	});
</script>

