<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>You are currently being transferred to World Pay</title>
<style type="text/css">
<!--
#container {
	height: auto;
	width: 280px;
	margin-right: auto;
	margin-left: auto;
	margin-top: 100px;
}
body,td,th {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	color: #333333;
}
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
p {
	line-height: 140%;
	margin: 5px 0px;
	padding: 0px;
}
input {
	width: 235px;
	margin-top: 10px;
	margin-bottom: 10px;
}
#box {
	height: 280px;
	width: 280px;
	text-align: center;
	background-image: url(checkout_bg_wp.gif);
}
#spin {
	float: left;
	height: 43px;
	width: 280px;
	text-align: center;
	top: 27px;
	position: relative;
}
h2 {
	font-size: 18px;
	color: #003872;
	margin-bottom: 3px;
	clear: left;
	padding-top: 35px;
}
form {
	margin: 0px;
	padding: 0px;
}
fieldset {	border: 0;}
legend {	display:none;}
-->
</style>

</head>
<body onload='document.stform.submit();'>
	<div id="container">
		<div id="box">
			<div id="spin"><img src="<?php echo $this->Url->image('checkout_spin.gif'); ?>" alt="please wait" width="43" height="43" /></div>
			<h2>Please Wait </h2>
			<p><strong>You will now be automatically forwarded to <br /> World Pay to complete your purchase.  </strong></p>
			<p>If this has not happened within 10 seconds<br /> please click the button to continue.
				<?php echo $this->Worldpay->form($data); ?>	
				<?php echo $this->Html->script(['jquery.min.js']); ?>
				<script>
				jQuery(document).ready(function(){
					var t = setTimeout(function(){
						jQuery('#worldpay-order').submit();
					}, 5000);
				});
				</script>	
		</div>	
	</div>	
</body>
</html>