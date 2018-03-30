<div class="container-fluid booking-page confirmation-page">
	<div class="step-heading row">
		<h2><?php echo __('Sign up')?></h2>
	</div>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="user-items-container">
					<div class="box box-default">
						<?php echo $this->Flash->render(); ?>
						<?php echo $this->Form->create($form, ['id' => 'form_id']) ?>
						<div class="box-body">
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label>Title <span class="require">*</span></label>
										<?php 
											$options = $this->Custom->getCutomerTitleArray();
											echo $this->Form->select('title', $options, ['class' => 'form-control','value'=>1] ) 
										?>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>First Name <span class="require">*</span></label>
										<?php echo $this->Form->text('first_name', ['class' => 'form-control validate[required]', 'maxlength' => 50]) ?>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Last Name <span class="require">*</span></label>
										<?php echo $this->Form->text('last_name', ['class' => 'form-control validate[required]', 'maxlength' => 50]) ?>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Email <span class="require">*</span></label>
										<?php echo $this->Form->text('email', ['class' => 'form-control validate[required,custom[email]]', 'maxlength' => 80]) ?>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Password <span class="require">*</span></label>
										<?php echo $this->Form->password('password', ['class' => 'form-control validate[required,minSize[6]]', 'maxlength' => 20, 'id' => 'password']) ?>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Confirm Password <span class="require">*</span></label>
										<?php echo $this->Form->password('confirm_password', ['class' => 'form-control validate[required,equals[password]]', 'maxlength' => 20] )?>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Telephone <span class="require">*</span></label>
										<?php echo $this->Form->text('contact_number', ['class' => 'form-control validate[required,custom[phone]]', 'maxlength' => 14]) ?>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Address <span class="require">*</span></label>
										<?php echo $this->Form->text('address1', ['class' => 'form-control validate[required]', 'maxlength' => 100]) ?>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Address 2</label>
										<?php echo $this->Form->text('address2', ['class' => 'form-control', 'maxlength' => 100]) ?>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Town <span class="require">*</span></label>
										<?php echo $this->Form->text('town', ['class' => 'form-control validate[required]', 'maxlength' => 40]) ?>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>County <span class="require">*</span></label>
										<?php echo $this->Form->text('county', ['class' => 'form-control validate[required]', 'maxlength' => 40]) ?>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Country <span class="require">*</span></label>
										<?php 
											$options = $this->Custom->getCountriesArray();
											echo $this->Form->select('country', $options, ['class' => 'form-control validate[required]','empty'=>'Select Country'] ) 
										?>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Postcode <span class="require">*</span></label>
										<?php echo $this->Form->text('postcode', ['class' => 'form-control validate[required]', 'maxlength' => 14]) ?>
									</div>
								</div>
								<div class="clear"></div>
								<div class="col-md-6">
									<div class="box-tools pull-left">
										<?php echo $this->Form->button(__('Sign up'), ['class' => 'btn btn-primary btn-block btn-flat']); ?>
									</div>
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

