<?php if($totalDiscount > 0 || $shippingAmount > 0): ?>
	<div class="cart-total">
		<span>Sub Total : </span>
		<strong><?php echo $this->Custom->displayPriceHtml($subTotal);?></strong>
	</div>	
	<?php if($totalDiscount > 0): ?>
		<div class="cart-total">
			<span>Total Discount: </span>
			<strong><?php echo $this->Custom->displayPriceHtml($totalDiscount);?></strong>
		</div>	
	<?php endif;?>
	<?php if($shippingAmount > 0): ?>
		<div class="cart-total">
			<span>Shipping : </span>
			<strong><?php echo $this->Custom->displayPriceHtml($shippingAmount);?></strong>
		</div>	
	<?php endif;?>
	<div class="cart-total">
		<span>Total: </span>
		<strong><?php echo $this->Custom->displayPriceHtml($totalAmount);?></strong>
	</div>	
<?php else: ?>
	<div class="cart-total">
		<span>Total : </span>
		<?php $subTotal	=	$this->Custom->getCartSubTotal(); ?>
		<strong><?php echo $this->Custom->displayPriceHtml($subTotal);?></strong>
	</div>
<?php endif;?>
