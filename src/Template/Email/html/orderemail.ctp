<style>
	body{font-family: arial; font-size: 14px;}
	table.main{border: 1px solid #ccc; margin-top: 30px;}	
	table.main td{padding:4px 15px;}
	table.main th{padding:15px 15px}
	table.main td.logo{padding: 0 0 15px 0}
	.bill-table td{ border-left:0; border-top::;  }
	.important-msg{line-height: 150%; font-size: 11px;}
	
	</style>

<table width="500" border="0" align="center" cellpadding="0" cellspacing="0" class="main">
  	<tbody>
	    <tr>
	      <td class="logo"><img src="<?php echo SITE_URL;?>/img/emailbanner/logo.jpg" width="500" height="99" alt=""/></td>
	    </tr>
	    <tr>
	      <td>Dear <?php echo $name;?> </td>
	     </tr>
	    <tr>
	      <td><p>Thank   you for your purchase for the <?php echo $event;?> which is itemised below:</p></td>
	    </tr>
	    <tr>
	      	<td valign="top" style="padding:0">
	      		<table width="100%" cellspacing="0" cellpadding="20" class="bill-table">
		       		<tbody>
			          	<tr>
				            <th height="0" align="left" bgcolor="#eeeeee"><strong>Description </strong></th>
				            <th height="0" align="center" bgcolor="#eeeeee"><strong>Quantity </strong></th>
				            <th height="0" align="center" bgcolor="#eeeeee"><strong>Amount </strong></th>
			          	</tr>
		          		<?php 
						//pr($tickets);die;
						foreach ($tickets as $ticket){

						$ticket_price			=	 $this->Custom->applyAddtionalPrice($ticket['id'],$ticket['item_price'],$ticket['item_quantity']);
						$total_price				=	($ticket_price*$ticket['item_quantity']);
						$discount_total_price	=	 $this->Custom->applyDiscountPrice($ticket['id'],$total_price,$ticket['item_quantity']);
						
						?>
						<tr>
							<td height="30"><?php echo $ticket['item_name'];?></td>
							<td height="30" align="center"><?php echo $ticket['item_quantity'];?></td>
							<td height="30" align="center">
								<?php 
								if($discount_total_price < $total_price){
									 echo $this->Custom->displayPriceHtml($discount_total_price);
								}
								else
								{
									 echo $this->Custom->displayPriceHtml($total_price);
								}
								?>
							</td>
						</tr>
						<?php 
						} 
						foreach ($products as $product){?>
						
						<tr>
							<td height="30"><?php echo $product['item_name'];?></td>
							<td height="30" align="center"><?php echo $product['item_quantity'];?></td>
							<td height="30" align="center"><?php echo $this->Custom->displayPriceHtml($product['item_total']);?></td>
						</tr>
						<?php } 
						foreach ($programs as $program){
						?>
						
						<tr>
							<td height="30"><?php echo $program['item_name'];?></td>
							<td height="30" align="center"><?php echo $program['item_quantity'];?></td>
							<td height="30" align="center"><?php echo $this->Custom->displayPriceHtml($program['item_total']);?></td>
						</tr>
						<?php }?>

		          		<?php 
						if($totalDiscount > 0 || $shippingAmount > 0): ?>
				          	<tr>
				            	<td height="30">&nbsp;</td>
				            	<td height="30" align="center" bgcolor="#eee"><strong>Sub Total</strong></td>
				            	<td height="30" align="center" bgcolor="#eee">
				            		<strong><?php echo $this->Custom->displayPriceHtml($subTotal);?></strong>
								</td>
				          	</tr>
				          	<?php if($totalDiscount > 0): ?>
					          	<tr>
					            	<td height="30">&nbsp;</td>
					            	<td height="30" align="center" bgcolor="#eee"><strong>Total Discount</strong></td>
					            	<td height="30" align="center" bgcolor="#eee">
					            		<strong><?php echo $this->Custom->displayPriceHtml($totalDiscount);?></strong>
									</td>
					          	</tr>
				          	<?php endif;?>
							<?php if($shippingAmount > 0): ?>
								<tr>
					            	<td height="30">&nbsp;</td>
					            	<td height="30" align="center" bgcolor="#eee"><strong>Shipping</strong></td>
					            	<td height="30" align="center" bgcolor="#eee">
					            		<strong><?php echo $this->Custom->displayPriceHtml($shippingAmount);?></strong>
									</td>
					          	</tr>
					        <?php endif;?>
						    <tr>
					            	<td height="30">&nbsp;</td>
					            	<td height="30" align="center" bgcolor="#eee"><strong>Total</strong></td>
					            	<td height="30" align="center" bgcolor="#eee">
					            		<strong><?php echo $this->Custom->displayPriceHtml($totalAmount);?></strong>
									</td>
					        </tr>
					    <?php else: ?>
					        <tr>
					            	<td height="30">&nbsp;</td>
					            	<td height="30" align="center" bgcolor="#eee"><strong>Total</strong></td>
					            	<td height="30" align="center" bgcolor="#eee">
					            		<?php $subTotal	=	$this->Custom->getCartSubTotal(); ?>
					            		<strong><?php echo $this->Custom->displayPriceHtml($subTotal);?></strong>
									</td>
					        </tr>
					    <?php endif;?>
	       			</tbody>
      			</table>
      		</td>
    </tr>
   
    <tr>
      <td class="important-msg"><p>IMPORTANT:   Please check the website information to see when your tickets will be   dispatched. Each ticket has a unique security barcode which will only admit one   person, other attempts with the same ticket will be rejected. Our standard terms   and conditions apply. For further information please go to <A href="http://www.leedscastleconcert.co.uk/" target="_blank" moz-do-not-send="true">http://www.leedscastleconcert.co.uk/</A></p></td>
    </tr>
  </tbody>
</table>
