<div class="box box-default">
	<div class="box-header with-border">
		<h3 class="box-title">Add Ticket</h3>
	</div>
	<?php echo $this->Form->create($form, ['id' => 'form_id','type' => 'file']) ?>
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
						echo $this->Form->select('ticket_type', $options, ['class' => 'form-control','value'=>1] ) 
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
					<?php echo $this->Form->text('price', ['class' => 'form-control validate[required,custom[number]]', 'maxlength' => 8,'placeholder'=>'0.00']) ?>
					</div>
				</div>
			</div>
			<!--
			<div class="col-md-4">
				<div class="form-group">
					<label>Shipping Only</label>
					<div class="input-group col-md-4">
					<?php 
						$options = ['0' => 'No', '1' => 'Yes'];
						echo $this->Form->select('shipping_only', $options, ['class' => 'form-control','value'=>1] ) 
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
					<?php echo $this->Form->text('shipping_price', ['class' => 'form-control validate[custom[number]]', 'maxlength' => 8,'placeholder'=>'0.00']) ?>
					</div>
				</div>
			</div> -->
			
			<div class="clear"></div>
			<div class="col-md-12">
				<div class="row">
					<div class="col-md-12"><h5><label>Additional Price In Date Range : <span class="require">(** Addition price will be applicable on the base price of ticket )</span></label></h5></div>
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
					<div class="col-md-12">
						<div class="row" id="ticket_group_prices">
						</div>
					</div>
				</div>
			</div>
			
			<div class="col-md-6">
				<div class="form-group">
					<label>Featured Image <span class="require">*</span></label>
					<?php echo $this->Form->input('image', ['type'=>'file','class'=>'form-control validate[required]',  'label'=>false, 'templates' => ['inputContainer'=>'{{content}}'],'error'=>false]); ?>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label>Icon Image</label>
					<?php echo $this->Form->input('icon_image', ['type'=>'file','class'=>'form-control',  'label'=>false, 'templates' => ['inputContainer'=>'{{content}}'],'error'=>false]); ?>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label>Status <span class="require">*</span></label>
					<?php 
						$options = ['1' => 'Active', '0' => 'Inactive'];
						echo $this->Form->select('status', $options, ['class' => 'form-control','value'=>1] ) 
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
	var rowCount = 0;
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
	var rowGroupCount = 0;
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
