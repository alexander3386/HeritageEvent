<div class="container-fluid booking-page confirmation-page">
	<div class="step-heading row">
		<h2><?php echo __('Reset Password')?></h2>
	</div>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="user-items-container login-item-container">
					<div class="box box-default">	     
						<?php echo $this->Flash->render(); ?>
						<?php echo $this->Form->create($customer) ?>
						<div class="box-body">
							<div class="row">
								<div class="col-md-8">
									<div class="form-group">
										<label for="inputdefault">Password :</label>
										<?php echo $this->Form->input('password', ['class'=>'form-control','autofocus' => true, 'label' => false,'required' => true, 'autofocus' => true,'error'=>false]); ?>
									</div>
								</div>
								<div class="col-md-8">
									<div class="form-group">
										<label for="inputdefault">Confirm Password :</label>
										<?php echo $this->Form->input('confirm_password', ['class'=>'form-control','autofocus' => true, 'label' => false,'type' => 'password', 'required' => true]);?>
									</div>
								</div>
							</div>	
							<div class="row">
								<div class="col-md-4">
									<div class="box-tools pull-left">
										<?php echo $this->Form->button(__('Submit'), ['class' => 'btn btn-primary btn-block btn-flat']); ?>
									</div>
								</div>
								<div class="col-md-8  pull-right forgot-link">
									<?php echo $this->Html->link(__('<< Back to login panel'), ['controller' => 'Customers', 'action' => 'login']); ?>
								</div>
							</div>
							
						</div>
						<?php echo $this->Form->end(); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>