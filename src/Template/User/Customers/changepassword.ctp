<div class="container-fluid booking-page confirmation-page">
	<div class="step-heading row">
		<h2><?php echo __('Change Password')?></h2>
	</div>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="my-account-items-container">
					<div class="row">
						<?php echo $this->element('front_sidebar'); ?>
						<div class="col-md-9 col-sm-8">
							<div class="box box-default">	
								<?php echo $this->Flash->render(); ?>
								<?php echo $this->Form->create($form, ['id' => 'form_id']) ?>
								<div class="box-body">
									<div class="row">
										<div class="col-md-8">
											<div class="form-group">
												<label>Old Password <span class="require">*</span></label>
												<?php echo $this->Form->password('old_pass', ['class' => 'form-control validate[required]', 'maxlength' => 20 ]) ?>
											</div>	
										</div>
										<div class="col-md-8">
											<div class="form-group">
												<label>New Password <span class="require">*</span></label>
												<?php echo $this->Form->password('password', ['class' => 'form-control validate[required,minSize[6]]', 'maxlength' => 20, 'id' => 'password']) ?>
											</div>
										</div>
										<div class="col-md-8">
											<div class="form-group">
												<label>Confirm Password <span class="require">*</span></label>
												<?php echo $this->Form->password('confirm_password', ['class' => 'form-control validate[required,equals[password]]', 'maxlength' => 20] )?>
											</div>
										</div>
									</div>
									<div class="box-tools pull-left">
										<?php echo $this->Form->button(__('Submit'), ['class' => 'btn btn-primary btn-block btn-flat']); ?>
									</div>
								</div>
								<?php echo $this->Form->end() ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- /.box -->
