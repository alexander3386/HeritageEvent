<!doctype html>
<html>
 <head>
 <meta charset="utf-8">
 <style>
  body{font-family: 'Arial', sans-serif;margin:50px 0; color: #484846}
 table.main{border: 1px solid #cccccc; margin-top: 30px; background: #fff} 
 table.main td{padding:4px 15px;}
 table.main th{padding:15px 15px}
 table.main td.logo{padding: 0 0 15px 0}
 .bill-table{margin-top: 50px; margin-bottom: 50px;}
 .important-msg{line-height: 150%; font-size: 11px;}
	
	
	.single-ticket{max-width: 148px; line-height: 140%; text-transform: uppercase; font-weight: 600}
	.single-ticket h3{font-weight: 600; font-size: 16px; margin: 0; padding: 0; text-transform: none}
 
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
                  <td width="50%" valign="top" style="font-size:30px; font-family:arial;padding-left: 15px;">
                  <?php echo $eventname;?>
                  </td>
                  </tr>
                      </table>
                  </td>
                  <td valign="top" style="text-align: right"><div class="barcode"><img src="<?php echo $barcode;?>" width="141" height="57" alt=""/></div></td>
                </tr>
            </tbody>
            </table></td>
        </tr>
        
       
        
        <tr>
      <td class="date" style="padding:40px 0 0 0; display:inline-block; font-size: 28px; font-weight:400; color: #484846"><?php echo DATE('l dS F',strtotime($eventdate));?>
      
      <div style="text-transform: uppercase; display: block; font-weight: normal; font-size: 16px; margin-top: 15px; float:left; width:100%">Please Print This ticket and bring it with you</div>
      </td>
    </tr>

        <tr>
        
      <td valign="top" style="padding:0">
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-top:1px solid #363334; border-bottom: 1px solid #363334; margin:30px 0; padding: 30px 0; float: left">
  <tbody>
    <tr>
      <td width="33%" style="line-height: 140%; text-transform: uppercase; font-weight: 600; color: #525250"><?php echo $customername;?><br>
      			<?php echo ($customeradd);?>
      </td>
      <td width="33%">&nbsp;</td>
      <td width="33%">&nbsp;</td>
    </tr>
    <tr>
      <td width="33%">&nbsp;</td>
      <td width="33%">&nbsp;</td>
      <td width="33%">&nbsp;</td>
    </tr>
    <tr>
     <?php
      $i = 1; 
      foreach($tickets as $ticket){
      echo $ticket['item_quantity'];
        for($j = 1; $j <= $ticket['item_quantity'];$j++){
        ?>
          <td width="33%" style="padding-bottom: 20px;"><div style="max-width: 148px; line-height: 140%; text-transform: uppercase; font-weight: 600"><h3 style="font-weight: 600; font-size: 16px; margin: 0; padding:0 0 5px 0; text-transform: none"><?php echo $ticket['item_name'];?></h3> <div style="display: block; width: 100%"></div> <?php echo $customername;?></div> </td>
         
        <?php
        if($i%3 == 0){
        echo "</tr><tr>";
        }
        $i++;
        }
      }
      ?>
    </tr>    
    <tr>
      <td width="33%">&nbsp;</td>
      <td width="33%">&nbsp;</td>
      <td width="33%">&nbsp;</td>
    </tr>
    
    
  </tbody>
</table>

      
      
      </td>
    </tr>
        </tr>
        <tr>
          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tbody>
              <tr>
                  <td valign="top"><div class="footer" style="font-family: arial; font-size: 18px;"> <div style="display: block; width: 300px;"><?php echo nl2br($company_add);?></div> 
                      <br>
                      <div style="margin-top:30px; font-size: 14px; display: block">Telephone: <?php echo $company_cont;?></div> <div style="margin-top: 30px; font-size:14px; display: block">Company Number : <?php echo $company_num;?><br>
                    VAT Registration Number: <?php echo $company_vat;?></div> </div></td>
                  <td valign="top" style="text-align: right"><div class="footer-logo"><img src="<?php echo SITE_URL;?>/img/footer-logo.jpg" alt=""/></div></td>
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