<?php echo $this->Form->create() ?>
	<p class="login-box-msg"><?php echo __('Sign in to start your session') ?></p>
	<div class="form-group has-feedback">
		<?php echo $this->Form->text('email', ['class' => 'form-control', 'placeholder' => 'Email address']) ?>
		<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
	</div>
	<div class="form-group has-feedback">
		<?php echo $this->Form->password('password', ['class' => 'form-control', 'placeholder' => 'Password']) ?>	
		<span class="glyphicon glyphicon-lock form-control-feedback"></span>
	</div>
	<div class="row">
		<div class="col-xs-8">
		</div>
		<div class="col-xs-4">
			<?php echo $this->Form->button(__('Sign In'), ['class' => 'btn btn-primary btn-block btn-flat']); ?>
		</div>
	</div>
	 <div class="form-group">
                <label for="inputdefault">&nbsp;</label>
                <?php echo $this->Html->link(__('Forgot Password?'), ['controller' => 'Users', 'action' => 'forgotPassword']); ?>
            </div>
<?php echo $this->Form->end() ?>