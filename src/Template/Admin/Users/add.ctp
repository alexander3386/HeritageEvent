<div class="box box-default">
	<div class="box-header with-border">
		<h3 class="box-title">Add User</h3>
	</div>
	<?php echo $this->Form->create($form, ['id' => 'form_id','type' => 'file']) ?>
	<div class="box-body">
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label>First Name <span class="require">*</span></label>
					<?php echo $this->Form->text('first_name', ['class' => 'form-control validate[ ]', 'maxlength'=>'50']) ?>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label>Last Name <span class="require">*</span></label>
					<?php echo $this->Form->text('last_name', ['class' => 'form-control validate[required]', 'maxlength'=>'50']) ?>
				</div>
			</div>
                        <div class="col-md-6">
				<div class="form-group">
					<label>Email <span class="require">*</span></label>
					<?php echo $this->Form->email('email', ['class' => 'form-control validate[required]', 'maxlength'=>'100']) ?>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label>Password <span class="require">*</span></label>
					<?php echo $this->Form->password('password', ['class' => 'form-control validate[required]', 'maxlength'=>'50', 'minlength'=>'4']) ?>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label>Confirm Password <span class="require">*</span></label>
					<?php echo $this->Form->password('confirm_password', ['class' => 'form-control validate[required]', 'maxlength'=>'50', 'minlength'=>'4']) ?>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label>Role <span class="require">*</span></label>
					<?php 
					 $options = ['superadmin' => 'Superadmin', 'heritage_admin' => 'Heritage Admin','lead_castle_admin'=>'Lead Castle Admin'];
					$role	='superadmin';
					if(isset($this->request->data['role'])){
						$role	=	$this->request->data['role'];
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
					$status	='inactive';
					if(isset($this->request->data['status'])){
						$status	=	$this->request->data['status'];
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
