<div class="left_section">&nbsp;</div>
<div class="right_section login">
   <p class="login-box-msg"><?php echo __('Reset Password') ?></p>
    <div class="myform">
        <?php echo $this->Flash->render(); ?>
        <?php echo $this->Form->create($user) ?>
            <div class="form-group">
                <label for="inputdefault">Password :</label>
                <?php echo $this->Form->input('password', ['class'=>'form-control','autofocus' => true, 'label' => false,'required' => true, 'autofocus' => true,'error'=>false]); ?>
            </div>
            <div class="form-group">
                <label for="inputdefault">Confirm Password :</label>
                <?php echo $this->Form->input('confirm_password', ['class'=>'form-control','autofocus' => true, 'label' => false,'type' => 'password', 'required' => true]);?>
            </div>
            <div class="form-group">
                <label for="inputdefault">&nbsp;</label>
                <?php echo $this->Form->submit(__('Submit'), array('class'=>'button')); ?>
            </div>
        <?php echo $this->Form->end(); ?>
    </div>
</div>
<div class="clearfix"></div>