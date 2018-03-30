<?php	$return_url	 	=	$this->Url->build(['controller' => 'carts', 'action' => 'thankyou']).'/'.base64_encode($order_id.'-'.$customer_id)?>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Payment successful</title>
		<meta http-equiv="refresh" content="2;URL='<?php echo $return_url; ?>'">
	</head>
	<body>
		<p>Payment has been successfully. You will be redirected to the website in 2 sec, or click <a href="<?php echo $return_url;?>">here</a> to continue</p>
	</body>
</html>
