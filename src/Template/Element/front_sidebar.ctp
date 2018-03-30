<div class="col-md-3 col-sm-4">
	<div class="side-bar-nav">
		<ul>
			<li>
				<?php echo $this->Html->link(__('Dashboard'), ['controller' => 'Customers', 'action' => 'index']); ?></li>
			<li>	<?php echo $this->Html->link(__('My Orders'), ['controller' => 'Orders', 'action' => 'index']); ?>
			</li>
			<li><?php echo $this->Html->link(__('Edit profile'), ['controller' => 'Customers', 'action' => 'editProfile']); ?>
			</li>
			<li><?php echo $this->Html->link(__('Change password'), ['controller' => 'Customers', 'action' => 'changepassword']); ?></li>
			<li><?php echo $this->Html->link(__('Logout'), ['controller' => 'Customers', 'action' => 'logout']); ?></li>
		</ul>
	</div>
</div>