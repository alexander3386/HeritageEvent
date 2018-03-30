<div class="box box-default">
	<div class="box-header with-border">
		<h3 class="box-title">Add Coupon</h3>
	</div>
	<?php echo $this->Form->create($form, ['id' => 'form_id','type' => 'file']) ?>
	<div class="box-body">
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label>Coupon Code <span class="require">*</span></label>
					<?php echo $this->Form->text('coupon_code', ['class' => 'form-control validate[required,custom[onlyLetterNumber]] coupon_code', 'maxlength' => 6]) ?>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label>Coupon Description <span class="require">*</span></label>
					<?php echo $this->Form->text('title', ['class' => 'form-control validate[required]', 'maxlength' => 200]) ?>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label>Coupon Expiry Date <span class="require">*</span></label>
					<div class='input-group date datepicker' >
						<?php echo $this->Form->text('expire_date', ['class' => 'form-control validate[required]','placeholder'=>'dd/mm/YYYY']) ?>
						<span class="input-group-addon">
							<span class="glyphicon glyphicon-calendar"></span>
						</span>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label>Coupon applicable to <span class="require">*</span></label>
					<?php 
						$options = $this->Custom->getCouponTypeArray();
						echo $this->Form->select('type', $options, ['class' => 'form-control coupon_type','value'=>0] ) 
					?>
				</div>
			</div>
			<div class="col-md-12 tickets_option_container" style="display:none;">
				<div class="form-group">
					<label>Select Tickets <span class="require">*</span></label>
					<?php echo $this->Form->input('ticket_ids', ['type'=>'select','options'=>$ticket_arr,'class'=>'form-control validate[required]', 'id'=>'ticket_ids', 'label'=>false,  'multiple' => 'multiple']); ?>
				</div>
			</div>
			<div class="col-md-12 products_option_container" style="display:none;">
				<div class="form-group">
					<label>Select Products <span class="require">*</span> </label>
					<?php echo $this->Form->input('product_ids', ['type'=>'select','options'=>$product_arr,'class'=>'form-control validate[required]', 'id'=>'product_ids', 'label'=>false,  'multiple' => 'multiple']); ?>
				</div>
			</div>
			<div class="col-md-12 programs_option_container" style="display:none;">
				<div class="form-group">
					<label>Select Programs <span class="require">*</span> </label>
					<?php echo $this->Form->input('program_ids', ['type'=>'select','options'=>$program_arr,'class'=>'form-control validate[required]', 'id'=>'program_ids', 'label'=>false,  'multiple' => 'multiple']); ?>
				</div>
			</div>
			<div class="clear"></div>
			<div class="col-md-6">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label>Discount Price <span class="require">*</span></label>
							<?php echo $this->Form->text('discount_price',['class' => 'form-control validate[required,custom[number]]','placeholder'=>'0.00']) ?>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Discount Price In <span class="require">*</span></label>
							<?php 
								$options = [0 => 'Fixed Cost', 1 => 'In percent(%)'];
								echo $this->Form->select('discount_type', $options, ['class' => 'form-control validate[required]','value'=>0] ) 
							?>
						</div>
					</div>
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

