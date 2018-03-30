<?php use Cake\Routing\Router; ?>
<header class="main-header">
	<a href="<?php echo $this->Url->build(['controller' => 'users', 'action' => 'dashboard']); ?>" class="logo">
	<!-- mini logo for sidebar mini 50x50 pixels -->
	<span class="logo-mini"><b>H</b>E</span>
	<!-- logo for regular state and mobile devices -->
	<span class="logo-lg"><b>Heritage</b>Events</span>
	</a>
	<!-- Header Navbar: style can be found in header.less -->
	<nav class="navbar navbar-static-top">
		<!-- Sidebar toggle button-->
		<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
			<span class="sr-only">Toggle navigation</span>
		</a>
		<div class="navbar-custom-menu">
			<ul class="nav navbar-nav">
			       <li class="dropdown user user-menu">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<img src="<?php echo $this->request->webroot; ?>img/logo.png" class="user-image" alt="User Image">
						<span class="hidden-xs"><?php echo $this->request->session()->read('name'); ?></span>
					</a>
					<ul class="dropdown-menu" style="width:170px">
					      <!-- User image -->
					    <!--   <li class="user-header">
						<img src="<?php echo $this->request->webroot; ?>img/logo.png" class="img-circle" alt="User Image">
						<p><?php echo $this->request->session()->read('name'); ?></p>
					      </li>
					     -->
						<li class="user-footer">
							<div class="pull-left">
								<a href="<?php echo $this->Url->build(['controller' => 'users', 'action' => 'edit_profile']) ?>" class="btn btn-primary btn-flat">Profile</a>
							</div>
							<div class="pull-right">
								<a href="<?php echo $this->Url->build(['controller' => 'users', 'action' => 'logout']); ?>" class="btn btn-danger btn-flat">Sign out</a>
							</div>
						</li>
					</ul>
				</li>
			</ul>
		</div>
	</nav>
  </header>