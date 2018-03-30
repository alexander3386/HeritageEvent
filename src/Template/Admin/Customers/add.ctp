<div class="box box-default">
	<div class="box-header with-border">
		<h3 class="box-title">Add Customer</h3>
	</div>
	<?php echo $this->Form->create($form, ['id' => 'form_id','type' => 'file']) ?>
	<div class="box-body">
		<div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<label>Title <span class="require">*</span></label>
					<?php 
						$options = $this->Custom->getCutomerTitleArray();
						echo $this->Form->select('title', $options, ['class' => 'form-control','value'=>1] ) 
					?>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label>First Name <span class="require">*</span></label>
					<?php echo $this->Form->text('first_name', ['class' => 'form-control validate[required]', 'maxlength' => 50]) ?>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label>Last Name <span class="require">*</span></label>
					<?php echo $this->Form->text('last_name', ['class' => 'form-control validate[required]', 'maxlength' => 50]) ?>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label>Email <span class="require">*</span></label>
					<?php echo $this->Form->text('email', ['class' => 'form-control validate[required,custom[email]]', 'maxlength' => 80]) ?>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label>Password <span class="require">*</span></label>
					<?php echo $this->Form->password('password', ['class' => 'form-control validate[required,minSize[6]]', 'maxlength' => 20, 'id' => 'password']) ?>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label>Confirm Password <span class="require">*</span></label>
					<?php echo $this->Form->password('confirm_password', ['class' => 'form-control validate[required,equals[password]]', 'maxlength' => 20] )?>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label>Contact Number</label>
					<?php echo $this->Form->text('contact_number', ['class' => 'form-control validate[custom[phone]]', 'maxlength' => 14]) ?>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label>Address</label>
					<?php echo $this->Form->text('address1', ['class' => 'form-control', 'maxlength' => 100]) ?>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label>Address 2</label>
					<?php echo $this->Form->text('address2', ['class' => 'form-control', 'maxlength' => 100]) ?>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label>Town</label>
					<?php echo $this->Form->text('town', ['class' => 'form-control', 'maxlength' => 40]) ?>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label>County</label>
					<?php echo $this->Form->text('county', ['class' => 'form-control', 'maxlength' => 40]) ?>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label>Country</label>
					<?php 
						$options = $this->Custom->getCountriesArray();
						echo $this->Form->select('country', $options, ['class' => 'form-control','empty'=>'Select Country'] ) 
					?>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label>Postcode</label>
					<?php echo $this->Form->text('postcode', ['class' => 'form-control', 'maxlength' => 14]) ?>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label>Status <span class="require">*</span></label>
					<?php 
						$options = ['1' => 'Active', '0' => 'Inactive'];
						echo $this->Form->select('status', $options, ['class' => 'form-control','value'=>1] ) 
					?>
				</div>
			</div>
			<div class="clear"></div>
			<div class="box-tools pull-right">
				<?php echo $this->Form->button(__('Submit'), ['class' => 'btn btn-primary btn-block btn-flat']); ?>
			</div>
		</div>
		<?php echo $this->Form->end() ?>
	</div>

