<div class="box box-default">
	<div class="box-header with-border">
		<h3 class="box-title">Edit Profile</h3>
	</div>
	<?php echo $this->Form->create($form, ['id' => 'form_id']) ?>
	<div class="box-body">
		<div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<label>Email *</label>
					<?php echo $this->Form->text('email', ['class' => 'form-control validate[required, custom[email]]', 'maxlength' => 200, 'value' => $data['email'] ]) ?>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label>First Name *</label>
					<?php echo $this->Form->text('first_name', ['class' => 'form-control validate[required]', 'maxlength' => 50, 'value' => $data['first_name']]) ?>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label>Last Name *</label>
					<?php echo $this->Form->text('last_name', ['class' => 'form-control validate[required]', 'maxlength' => 50, 'value' => $data['last_name']] )?>
				</div>
			</div>
		</div>
		<div class="row">
			
		</div>
	<div class="box-tools pull-right">
		<?php echo $this->Form->button(__('Submit'), ['class' => 'btn btn-primary btn-block btn-flat']); ?>
	</div>
	</div>
	<?php echo $this->Form->end() ?>
</div>

<!-- /.box -->
