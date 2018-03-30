<div class="box box-default">
	<div class="box-header with-border">
		<h3 class="box-title">Edit User</h3>
	</div>
	<?php echo $this->Form->create($user, ['id' => 'form_id','type' => 'file']) ?>
	<div class="box-body">
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label>First Name <span class="require">*</span></label>
					<?php echo $this->Form->text('first_name', ['class' => 'form-control validate[required]', 'maxlength' => 50]) ?>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label>Last Name <span class="require">*</span></label>
					<?php echo $this->Form->text('last_name', ['class' => 'form-control validate[required]', 'maxlength' => 50] )?>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label>Email <span class="require">*</span></label>
					<?php echo $this->Form->text('email', ['class' => 'form-control validate[required, custom[email]]', 'maxlength' => 100 ]) ?>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label>Role <span class="require">*</span></label>
					<?php 
					$options = ['superadmin' => 'Superadmin', 'heritage_admin' => 'Heritage Admin','lead_castle_admin'=>'Lead Castle Admin'];
					$role	='superadmin';
					if(isset($user['role'])){
						$role	=	$user['role'];
					}
					echo $this->Form->select('role', $options, ['class' => 'form-control validate[required]','value'=>$role] )
					?>
					
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label>Status <span class="require">*</span></label>
					<?php 
					$options = ['1' => 'Active', '0' => 'Inactive'];
					$status	='0';
					if(isset($user['status'])){
						$status	=	$user['status'];
					}
					echo $this->Form->select('status', $options, ['class' => 'form-control validate[required]','value'=>$status] )
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

<!-- /.box -->
