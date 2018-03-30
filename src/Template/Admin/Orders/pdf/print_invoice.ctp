<!doctype html>
<html>
 <head>
 <meta charset="utf-8">
 <style>
   @import url('https://fonts.googleapis.com/css?family=Lato:400,700');
 body{font-family: 'Arial', sans-serif;background: #c8c8c8; margin:50px 0; color: #484846}
 .logo{float: left; line-height: 220%; width:50%; display:flex}
 .logo .img{display: inline-block; vertical-align: top; margin-right:10px;float:left; width:66px} 
 .logo .title{display: inline-block; vertical-align: top; font-size:40px; max-width:250px;float:left; width:calc(100% - 66px); border:1px solid #000}
 .main-table{background: #ffffff; padding: 20px;}
 .barcode{float: right; margin: 0; padding:0}
 .date{ margin:40px 0 0 0; display:inline-block; font-size: 28px; font-weight:400; color: #484846}
 .date span{text-transform: uppercase; display: block; font-weight: normal; font-size: 16px; margin-top: 10px;}
 .ticket-details{border-top:1px solid #363334; border-bottom: 1px solid #363334; margin:30px 0; padding: 30px 0; float: left}
 .ticket-address{max-width: 300px; line-height: 140%; text-transform: uppercase; font-weight: 600; color: #525250}
 .tickets ul{margin:35px 0 80px 0; padding: 0; color: #525250; display: inline-block}
 .tickets ul li{display: inline-block; width: 33.33%; float: left; margin:0 0 25px 0}
 .single-ticket{max-width: 148px; line-height: 140%; text-transform: uppercase; font-weight: 600}
 .single-ticket h3{font-weight: 600; font-size: 16px; margin: 0; padding: 0; text-transform: none}
 .footer-logo{float: right; margin: 0; padding: 0}
 .footer{float:left; margin: 0; padding: 0; width:300px; font-size: 16px; font-weight: 600; color: #535351}
 .footer span{display: block}
 .footer .number{font-size:11px; margin-top:15px;}
 
 table.main{border: 1px solid #cccccc; margin-top: 30px; } 
 table.main td{padding:4px 15px;}
 table.main th{padding:15px 15px}
 table.main td.logo{padding: 0 0 15px 0}
 .bill-table{margin-top: 50px; margin-bottom: 50px;}
 .important-msg{line-height: 150%; font-size: 11px;}

 
  </style>
 </head>
 
 <body>
    <table width="800" border="0" align="center" cellpadding="0" cellspacing="0" class="main-table">
      <tbody>
        <tr>
          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tbody>
              <tr>
                  <td valign="top" width="70%" >
                      <table width="60%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                  <td width="12%" valign="top" >
                  <?php 
		          	$filePath = 'uploads'.DS.strtolower($settings->source()).DS.'image'.DS.$settings->get('upload_dir').DS.$settings->get('image');
					
					$sizeArr = @getimagesize(WWW_ROOT.$filePath);
					$mimeArr = ['image/gif', 'image/png', 'image/jpg', 'image/jpeg'];
				 	
				 	
				
		          ?>
					<img src="<?php echo SITE_URL.'/uploads/'.strtolower($settings->source()).'/image/' .$settings->get('upload_dir'). '/square_' . $settings->get('image');?>" width="66" height="98" alt=""/>
                  </td>
                  <td width="50%" valign="top" style="font-size:30px; font-family:arial; width: 250px; padding-left: 15px;">
                    <?php echo $eventname;?>
                  </td>
                  </tr>
                      </table>
                  </td>
                  <td valign="top"><div class="barcode"><!--img src="<?php echo $barcode;?>" width="141" height="57" alt=""/--></div></td>
                </tr>
            </tbody>
            </table></td>
        </tr>
        <tr>
          <td><table width="100%" cellspacing="0" cellpadding="20" class="bill-table" style="border-top:1px solid #363334; border-bottom: 1px solid #363334; margin:30px 0; padding: 30px 0; float: left">
              <tbody>
              <tr>
                  <th height="0" align="left" bgcolor="#eeeeee"><strong>Description </strong></th>
                  <th height="0" align="center" bgcolor="#eeeeee"><strong>Number Of Quantity </strong></th>
                  <th height="0" align="center" bgcolor="#eeeeee"><strong>Amount </strong></th>
                </tr>
              <tr>
	          		<?php 
					//pr($programs);//die;
					foreach ($tickets as $ticket){
					?>
					<tr>
						<td height="30"><?php echo $ticket['item_name'];?></td>
						<td height="30" align="center"><?php echo $ticket['item_quantity'];?></td>
						<td height="30" align="center">
							<?php 
							echo $this->Custom->displayPriceHtml($ticket['item_total']);
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
					<?php 
					} 
					foreach ($programs as $program){
					?>
					
					<tr>
						<td height="30"><?php echo $program['item_name'];?></td>
						<td height="30" align="center"><?php echo $program['item_quantity'];?></td>
						<td height="30" align="center"><?php echo $this->Custom->displayPriceHtml($program['item_total']);?></td>
					</tr>
					<?php } ?>

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
				            		<strong><?php echo $this->Custom->displayPriceHtml($totalAmount);?></strong>
								</td>
				        </tr>
				    <?php endif;?>
       			</tbody>
  			</table></td>
        </tr>
        <tr>
          
          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tbody>
              <tr>
                  <td valign="top"><div class="footer" style="font-family: arial; font-size: 18px;"> <div style="display: block; width: 300px;"><?php echo nl2br($company_add);?></div> 
                      <br>
                      <span class="number">Telephone: <?php echo $company_cont;?></span> <br><span class="number">Company Number : <?php echo $company_num;?><br>
                    VAT Registration Number: <?php echo $company_vat;?></span> </div></td>
                  <td valign="top"><div class="footer-logo"><img src="<?php echo SITE_URL;?>/img/footer-logo.jpg" alt=""/></div></td>
                </tr>
            </tbody>
            </table></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
      </tbody>
    </table>
</body>
</html>