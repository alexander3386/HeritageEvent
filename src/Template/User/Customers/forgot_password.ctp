<div class="container-fluid booking-page confirmation-page">
	<div class="step-heading row">
		<h2><?php echo __('Forgot Password')?></h2>
	</div>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="user-items-container login-item-container">
					<div class="box box-default">
						<?php echo $this->Flash->render(); ?>
						<?php echo $this->Form->create() ?>
							<p class="login-box-msg"><?php echo __('Enter your email to recover forgot password') ?></p>
							<div class="form-group has-feedback">
								<?php echo $this->Form->text('email', ['class' => 'form-control', 'placeholder' => 'Email address','autofocus' => true, 'label' => false, 'required' => true]) ?>
								<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
							</div>
							<div class="row">
								<div class="col-md-4">
									<?php echo $this->Form->button(__('Send Reset Email'), ['class' => 'btn btn-primary btn-block btn-flat']); ?>
								</div>
								<div class="col-md-8  pull-right forgot-link">
									<?php echo $this->Html->link(__('<< Back to login panel'), ['controller' => 'Customers', 'action' => 'login']); ?>
								</div>
							</div>
						<?php echo $this->Form->end() ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>