 <?php echo $this->Form->create() ?>
	<p class="login-box-msg"><?php echo __('Enter your email to recover forgot password') ?></p>
	<div class="form-group has-feedback">
		<?php echo $this->Form->text('email', ['class' => 'form-control', 'placeholder' => 'Email address','autofocus' => true, 'label' => false, 'required' => true]) ?>
		<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
	</div>
	<div class="row">
		<div class="col-xs-8">
			<?php echo $this->Form->button(__('Send Reset Email'), ['class' => 'btn btn-primary btn-block btn-flat']); ?>
		</div>
	</div>
	 <div class="form-group">
                <label for="inputdefault">&nbsp;</label>
                <?php echo $this->Html->link(__('<< Back to login panel'), ['controller' => 'Users', 'action' => 'login']); ?>
            </div>
<?php echo $this->Form->end() ?>