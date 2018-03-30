<div class="box box-default">
	<div class="box-header with-border">
		<h3 class="box-title">Review Cart Items</h3>
		<span class="add_btn">
			<a href="<?php echo $this->Url->build(['controller' => 'orders', 'action' => 'clearcart'])?>" class="btn btn-success btn-sm">Clear Cart</a>
		</span>
		<span class="add_btn">
			<a href="<?php echo $this->Url->build(['controller' => 'orders', 'action' => 'add'])?>" class="btn btn-danger btn-sm">Back</a>
		</span>
	</div>
	<div class="box-body">
		<div class="row">
			<div class="col-md-12">
				<?php if (null!=$carts):?>
					<?php if($tickets): ?>
						<div class="cart-items-container">
							<?php echo $this->requestAction('/admin/orders/cartitems'); ?>	
						</div>
					<?php else: ?>	
						<p class="empty_cart"><?php echo __('You cart is empty. please add at-least one ticket(s) with food option(s).');?></p>
					<?php endif;?>	
				<?php else: ?>	
						<p class="empty_cart"><?php echo __('You cart is empty. please add at-least one ticket(s).');?></p>
				<?php endif;?>
			</div>
		</div>
	</div>
</div>
