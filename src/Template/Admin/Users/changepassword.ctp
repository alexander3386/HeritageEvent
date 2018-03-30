<div class="box box-default">
	<div class="box-header with-border">
		<h3 class="box-title">Change Password</h3>
	</div>
	<?php echo $this->Form->create($form, ['id' => 'form_id']) ?>
	<div class="box-body">
		<div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<label>Old Password <span class="require">*</span></label>
					<?php echo $this->Form->password('old_pass', ['class' => 'form-control validate[required]', 'maxlength' => 20 ]) ?>
				</div>	
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label>New Password <span class="require">*</span></label>
					<?php echo $this->Form->password('password', ['class' => 'form-control validate[required,minSize[6]]', 'maxlength' => 20, 'id' => 'password']) ?>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
				<label>Confirm Password <span class="require">*</span></label>
				<?php echo $this->Form->password('confirm_password', ['class' => 'form-control validate[required,equals[password]]', 'maxlength' => 20] )?>
			</div>
		</div>
	</div>
	<div class="box-tools pull-right">
		<?php echo $this->Form->button(__('Submit'), ['class' => 'btn btn-primary btn-block btn-flat']); ?>
	</div>
	</div>
	<?php echo $this->Form->end() ?>
</div>

<!-- /.box -->
