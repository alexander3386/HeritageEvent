<div class="container-fluid booking-page confirmation-page">
	<div class="step-heading row">
		<h2><?php echo __('Login Panel')?></h2>
	</div>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="user-items-container login-item-container">
					<div class="box box-default">
						<?php echo $this->Flash->render(); ?>
						<?php echo $this->Form->create() ?>
							<p class="login-box-msg"><?php echo __('Sign in to access my account section') ?></p>
							<div class="form-group has-feedback">
								<?php echo $this->Form->text('email', ['class' => 'form-control', 'placeholder' => 'Email address']) ?>
								<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
							</div>
							<div class="form-group has-feedback">
								<?php echo $this->Form->password('password', ['class' => 'form-control', 'placeholder' => 'Password']) ?>	
								<span class="glyphicon glyphicon-lock form-control-feedback"></span>
							</div>
							<div class="row">
								<div class="col-md-4">
									<?php echo $this->Form->button(__('Sign In'), ['class' => 'btn btn-primary btn-block btn-flat']); ?>
								</div>
								<div class="col-md-8 pull-right forgot-link">
									<?php echo $this->Html->link(__('Forgot Password?'), ['controller' => 'Customers', 'action' => 'forgotPassword']); ?>
								</div>
							</div>
							
							<div class="col-md-12 pull-right forgot-link signup-up-link">
								Not having account? <?php echo $this->Html->link(__('click here'), ['controller' => 'Customers', 'action' => 'signup']); ?> to signup.
							</div>
							
						<?php echo $this->Form->end() ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>