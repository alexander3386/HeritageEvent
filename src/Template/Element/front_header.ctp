<header>
	<div class="container">
		<div class="row">
			<div class="col-md-2 col-sm-3 col-xs-12 logo"><a href="/"><img src="/img/logo.png" alt=""/></a></div>
			<div class="col-md-10 col-sm-9 col-xs-12 header-right">
				<div class="social">
					<ul>
						<li><a href="#"><i class="fa fa-facebook-f"></i></a></li>
						<li><a href="#"><i class="fa fa-twitter"></i></a></li>
						<li><a href="#"><i class="fa fa-instagram"></i></a></li>
					</ul>
				</div>
				<div class="navigation-main">
					<div class="header-search">
						<input type="text" placeholder="Search">
						<input type="submit">
					</div>
					<div class="navigation">
						<div class="navbar-header">
							<div class="mobile_search-icon"><a href="#"><img src="/img/search-icon.png"></a></div>
							<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false"><span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span></button>
						</div>
						<div id="bs-example-navbar-collapse-1" class="navbar-collapse collapse" aria-expanded="false">
							<ul class="nav navbar-nav">
								<li><a href="#">Home</a></li>
								<li><a href="/">Buy Tickets</a>
									<!--<ul class="dropdown-menu">
										<li><a href="#">Submenu 1</a></li>
										<li><a href="#">Submenu 2</a></li>
										<li><a href="#">Submenu 3</a></li>
									</ul>-->
								</li>
								<li><a href="#">Gallery</a></li>
								<li><a href="#">Location </a></li>
								<li><a href="#">About</a></li>
								<li><a href="#">Hospitality &AMP; Packages </a></li>
								<li><a href="#">Contact </a></li>
								<?php /* if($this->request->session()->read('Auth.Customer')): ?>
									<li><a href="<?php echo $this->Url->build(['controller' => 'customers', 'action' => 'index'])?>">My Account </a></li>
								<?php else: ?>
									<li><a href="<?php echo $this->Url->build(['controller' => 'customers', 'action' => 'login','prefix'=>'user'])?>">Login </a></li>
								<?php endif; */ ?>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="mobile_searchbar">
		<div class="header-search">
			<input type="text" placeholder="Search">
			<input type="submit">
		</div>
	</div>
</header>