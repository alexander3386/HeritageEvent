<div class="container-fluid booking-page confirmation-page">
	<div class="step-heading row">
		<h2><?php echo __('Edit Profile')?></h2>
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
										<div class="col-md-6">
											<div class="form-group">
												<label>Title <span class="require">*</span></label>
												<?php 
													$options = $this->Custom->getCutomerTitleArray();
													echo $this->Form->select('title', $options, ['class' => 'form-control', 'value' => $data['title']] ) 
												?>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>First Name <span class="require">*</span></label>
												<?php echo $this->Form->text('first_name', ['class' => 'form-control validate[required]', 'maxlength' => 50, 'value' => $data['first_name']]) ?>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>Last Name <span class="require">*</span></label>
												<?php echo $this->Form->text('last_name', ['class' => 'form-control validate[required]', 'maxlength' => 50, 'value' => $data['last_name']] )?>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>Email <span class="require">*</span></label>
												<?php echo $this->Form->text('email', ['class' => 'form-control validate[required, custom[email]]', 'maxlength' => 200, 'value' => $data['email'] ]) ?>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>Telephone <span class="require">*</span></label>
												<?php echo $this->Form->text('contact_number', ['class' => 'form-control validate[required,custom[phone]]', 'maxlength' => 14, 'value' => $data['contact_number']]) ?>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>Address <span class="require">*</span></label>
												<?php echo $this->Form->text('address1', ['class' => 'form-control validate[required]', 'maxlength' => 100, 'value' => $data['address1']]) ?>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>Address 2</label>
												<?php echo $this->Form->text('address2', ['class' => 'form-control', 'maxlength' => 100, 'value' => $data['address2']]) ?>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>Town <span class="require">*</span></label>
												<?php echo $this->Form->text('town', ['class' => 'form-control validate[required]', 'maxlength' => 40, 'value' => $data['town']]) ?>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>County <span class="require">*</span></label>
												<?php echo $this->Form->text('county', ['class' => 'form-control validate[required]', 'maxlength' => 40, 'value' => $data['county']]) ?>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>Country <span class="require">*</span></label>
												<?php 
													$options = $this->Custom->getCountriesArray();
													echo $this->Form->select('country', $options, ['class' => 'form-control validate[required]','empty'=>'Select Country', 'value' => $data['country']] ) 
												?>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>Postcode <span class="require">*</span></label>
												<?php echo $this->Form->text('postcode', ['class' => 'form-control validate[required]', 'maxlength' => 14, 'value' => $data['postcode']]) ?>
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
