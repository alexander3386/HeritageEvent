<?php
	//pr($this->request->params); die;
	$controller = strtolower($this->request->params['controller']);
	$action = $this->request->params['action'];
?>
 <!-- Left side column. contains the logo and sidebar -->
	<aside class="main-sidebar">
	<!-- sidebar: style can be found in sidebar.less -->
	<section class="sidebar">
		<!-- Sidebar user panel -->
		<!--<div class="user-panel">
			<div class="pull-left image">
				<img src="<?php echo $this->request->webroot; ?>img/logo.png" class="img-circle" alt="User Image">
			</div>
			<div class="pull-left info">
				<p><?php echo $this->request->session()->read('name'); ?> </p>
			</div>
		</div>-->
		<!-- sidebar menu: : style can be found in sidebar.less -->
		<ul class="sidebar-menu">
			<li class="<?php echo ($action == 'dashboard')?'active':''; ?>">
				<a href="<?php echo $this->Url->build(['controller' => 'users', 'action' => 'dashboard']); ?>">
				<i class="fa fa-dashboard"></i> 
				<span>Dashboard</span></a>
			</li>
			<li class="<?php echo ($controller == 'events')?'active':''; ?>">
				<a href="<?php echo $this->Url->build(['controller' => 'events', 'action' => 'index']); ?>">
				<i class="fa fa-bookmark"></i>
				<span>Manage Events</span></a>
			</li>
			<li class="<?php echo ($controller == 'tickets')?'active':''; ?>">
				<a href="<?php echo $this->Url->build(['controller' => 'tickets', 'action' => 'index']); ?>">
				<i class="fa fa-ticket"></i>
				 <span>Manage Tickets</span></a>
			</li>
			<li class="<?php echo ($controller == 'reserve-tickets')?'active':''; ?>">
				<a href="<?php echo $this->Url->build(['controller' => 'reserve-tickets', 'action' => 'index']); ?>">
				<i class="fa fa-ticket"></i>
				<span>Manage Reserve Tickets</span></a>
			</li>
			<li class="<?php echo ($controller == 'coupons')?'active':''; ?>"><a href="<?php echo $this->Url->build(['controller' => 'coupons', 'action' => 'index']); ?>"><i class="fa fa-tags"></i> <span>Manage Coupons</span></a></li>
			<li class="<?php echo ($controller == 'products')?'active':''; ?>"><a href="<?php echo $this->Url->build(['controller' => 'products', 'action' => 'index']); ?>"><i class="fa fa-product-hunt"></i> <span>Manage Products</span></a></li>
			<li class="<?php echo ($controller == 'programs')?'active':''; ?>"><a href="<?php echo $this->Url->build(['controller' => 'programs', 'action' => 'index']); ?>"><i class="fa fa-product-hunt"></i> <span>Manage Programs</span></a></li>

			<li class="<?php echo ($controller == 'customers' && $action == 'index'  )?'active':''; ?>">  <a href="<?php echo $this->Url->build(['controller' => 'customers', 'action' => 'index']); ?>"><i class="fa fa-users"></i> <span>Manage Customers</span></a>
			</li>
			<li class="<?php echo ($controller == 'orders' && ($action == 'index' || $action == 'orderdetails'))?'active':''; ?>">
				<a href="<?php echo $this->Url->build(['controller' => 'orders', 'action' => 'index']); ?>">
				<i class="fa fa-list"></i>
				<span>Manage Orders</span></a>
			</li>
			<li class="<?php echo ($controller == 'orders' && ($action == 'add' || $action == 'cart' ))?'active':''; ?>">
				<a href="<?php echo $this->Url->build(['controller' => 'orders', 'action' => 'add']); ?>">
				<i class="fa fa-archive"></i>
				<span>Create Order</span></a>
			</li>
            <li class="<?php echo ($controller == 'users')?'active':''; ?>">
				<a href="<?php echo $this->Url->build(['controller' => 'users', 'action' => 'index']); ?>">
				<i class="fa fa-user"></i>
				<span>Manage Users</span></a>
			</li>
			<!--li  aria-expanded="<?php echo ($controller == 'reports')?'true':'false'; ?>" >
				<a href="#" data-toggle="collapse" data-target="#report"> <i class="fa fa-bar-chart"></i> <span>Manage  Reports</span></a>	
				
				<ul id="report" class="collapse sidebar-menu list-unstyled <?php echo ($controller == 'reports')?'in':''; ?>" aria-expanded="<?php echo ($controller == 'reports' && $action == 'index')?'true':'false'; ?>">
					<li class="<?php echo ($controller == 'reports' && $action == 'index')?'active':''; ?>">
						<a href="<?php echo $this->Url->build(['controller' => 'reports', 'action' => 'index']); ?>">
						 <i class="fa fa-object-group"></i><span>Orders Report</span></a>
					</li>
		            <li class="<?php echo ($controller == 'reports' && $action == 'customerReport')?'active':''; ?>">
						<a href="<?php echo $this->Url->build(['controller' => 'reports', 'action' => 'customer-report']); ?>">
						 <i class="fa fa-database"></i><span>Customers Report</span></a>
					</li>
            	</ul>
            </li-->
            <li class="<?php echo ($action == 'defaultsettings')?'active':''; ?>">
            	<a href="<?php echo $this->Url->build(['controller' => 'settings', 'action' => 'defaultsettings']); ?>"><i class="fa fa-cogs"></i> <span>Settings</span></a>
            </li>
			<li class="<?php echo ($action == 'changepassword')?'active':''; ?>">
				<a href="<?php echo $this->Url->build(['controller' => 'users', 'action' => 'changepassword']); ?>">
				<i class="fa fa-unlock-alt"></i>
				<span>Change password</span></a>
			</li>
		</ul>
	</section>
    <!-- /.sidebar -->
  </aside>
