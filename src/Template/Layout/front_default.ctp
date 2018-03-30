<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
		<?php echo $this->Html->meta('favicon.ico', '/favicon.ico', ['icon' => 'icon']);?>
		<?php $this->assign('title', $title); ?>
		<title><?php echo $this->fetch('title'); ?></title>
		<?php echo $this->Html->css(['bootstrap.min.css','font-awesome.css','owl.carousel.min.css','owl.theme.default.min.css','bootstrap-spinner.css','cs-select.css', 'style.css']); ?>
		<link rel="stylesheet" href="<?php echo $this->request->webroot; ?>plugins/validation/validationEngine.jquery.css">
		<?php echo $this->Html->script(['jquery.min.js','jquery.spinner.js','bootstrap.min.js','owl.carousel.min.js','classie.js','selectFx.js', 'front_custom.js']); ?>
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
	<body>
		<?php echo $this->element('front_header'); ?>
		
		<?php echo $this->fetch('content') ?>
		<?php  echo $this->element('front_footer'); ?>
		<script src="<?php echo $this->request->webroot; ?>plugins/validation/jquery.validationEngine.js"></script>
		<script src="<?php echo $this->request->webroot; ?>plugins/validation/languages/jquery.validationEngine-en.js"></script>
	</body>
</html>
