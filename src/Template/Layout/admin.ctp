<!DOCTYPE html>
<html>
<head>
  <?php echo $this->Html->charset() ?>
  <?= $this->Html->meta('favicon.ico','/favicon.ico',    ['type' => 'icon']);?>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Heritage Events</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="<?php echo $this->request->webroot; ?>bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="<?php echo $this->request->webroot; ?>plugins/select2/select2.min.css">
  <link rel="stylesheet" href="<?php echo $this->request->webroot; ?>css/admin/AdminLTE.css">
  <link rel="stylesheet" href="<?php echo $this->request->webroot; ?>css/admin/_all-skins.min.css">
  <link rel="stylesheet" href="<?php echo $this->request->webroot; ?>plugins/datetimepicker/css/bootstrap-datetimepicker.min.css">
  <!--<link rel="stylesheet" href="<?php echo $this->request->webroot; ?>plugins/datepicker/datepicker3.css">
  <link rel="stylesheet" href="<?php echo $this->request->webroot; ?>plugins/daterangepicker/daterangepicker.css">
  <link rel="stylesheet" href="<?php echo $this->request->webroot; ?>plugins/timepicker/bootstrap-timepicker.min.css">
    <link rel="stylesheet" href="<?php echo $this->request->webroot; ?>plugins/colorbox/colorbox.css">
  -->
  <link rel="stylesheet" href="<?php echo $this->request->webroot; ?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
    <link rel="stylesheet" href="<?php echo $this->request->webroot; ?>plugins/validation/validationEngine.jquery.css">
  <link rel="stylesheet" href="<?php echo $this->request->webroot; ?>css/admin/custom_style.css">

<script src="<?php echo $this->request->webroot; ?>plugins/jQuery/jquery-2.2.3.min.js"></script>
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
	<?php echo $this->element('admin_header'); ?>
	<?php echo $this->element('admin_sidebar'); ?>
	<div class="content-wrapper">
		<!--  <section class="content-header">
			<h1>Dashboard<small>Control panel</small></h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
				<li class="active">Dashboard</li>
			</ol>
		</section> -->
		<section class="content">
			<?php echo $this->Flash->render(); ?>
			<?php echo $this->fetch('content'); ?>
		</section>
	</div>
	<div class="clear"></div>
	<footer class="main-footer">
		<div class="pull-right hidden-xs">
			<b>Version</b> 1.0
		</div>
		<strong>Copyright &copy; <?php echo date('Y'); ?>
		<?php echo $this->Html->link('Heritage Events','/'); ?></strong> All rights reserved.
	</footer>
	<!-- Add the sidebar's background. This div must be placed
	immediately after the control sidebar -->
	<div class="control-sidebar-bg"></div>
</div>
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
<script src="<?php echo $this->request->webroot; ?>plugins/select2/select2.full.min.js"></script>
<script src="<?php echo $this->request->webroot; ?>plugins/datetimepicker/js/moment.js"></script>
<script src="<?php echo $this->request->webroot; ?>bootstrap/js/bootstrap.min.js"></script>
<script src="<?php echo $this->request->webroot; ?>plugins/datetimepicker/js/bootstrap-datetimepicker.min.js"></script>

<!--<script src="<?php echo $this->request->webroot; ?>plugins/daterangepicker/daterangepicker.js"></script>
<script src="<?php echo $this->request->webroot; ?>plugins/datepicker/bootstrap-datepicker.js"></script>
<script src="<?php echo $this->request->webroot; ?>plugins/timepicker/bootstrap-timepicker.min.js"></script>
<script src="<?php echo $this->request->webroot; ?>plugins/colorbox/jquery.colorbox-min.js"></script>
-->
<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
<script src="<?php echo $this->request->webroot; ?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<script src="<?php echo $this->request->webroot; ?>plugins/validation/jquery.validationEngine.js"></script>
<script src="<?php echo $this->request->webroot; ?>plugins/validation/languages/jquery.validationEngine-en.js"></script>
<script src="<?php echo $this->request->webroot; ?>js/admin_common.js"></script>
<script src="<?php echo $this->request->webroot; ?>js/app.min.js"></script>
<!---graph js -->
 <script type="text/javascript" src="<?php echo $this->request->webroot; ?>plugins/graph/js/mdb.min.js"></script>
</body>
</html>
