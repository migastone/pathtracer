<body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white">
	<!-- BEGIN HEADER -->
	<div class="page-header navbar navbar-fixed-top">
		<!-- BEGIN HEADER INNER -->
		<div class="page-header-inner ">
			<!-- BEGIN LOGO -->
			<div class="page-logo"> <a href="<?php echo base_url(); ?>"> <img src="<?php echo base_url(); ?>assets/img/logo_top.png" alt="logo" class="logo-default" /> </a>
				<div class="menu-toggler sidebar-toggler"> </div>
			</div>
			<!-- END LOGO -->
			<!-- BEGIN RESPONSIVE MENU TOGGLER -->
			<a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse"> </a>
			<!-- END RESPONSIVE MENU TOGGLER -->
			<!-- BEGIN TOP NAVIGATION MENU -->
			<div class="top-menu">
				<ul class="nav navbar-nav pull-right">
					<!-- BEGIN USER LOGIN DROPDOWN -->
					<!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
					<li class="dropdown dropdown-user"> <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true"> <img alt="<?php echo $this->session->userdata('strName'); ?>" class="img-circle" src="<?php echo base_url(); ?>assets/layouts/layout/img/avatar.png" /> <span class="username username-hide-on-mobile"> <?php echo $this->session->userdata('strName'); ?> </span> <i class="fa fa-angle-down"></i> </a>
						<ul class="dropdown-menu dropdown-menu-default">
							<li> <a href="<?php echo base_url(); ?>profile"> <i class="icon-user"></i> My Profile </a> </li>
							<li class="divider"> </li>
							<li> <a href="<?php echo base_url(); ?>logout"> <i class="icon-key"></i> Logout </a> </li>
						</ul>
					</li>
					<!-- END USER LOGIN DROPDOWN -->
				</ul>
			</div>
			<!-- END TOP NAVIGATION MENU -->
		</div>
		<!-- END HEADER INNER -->
	</div>
	<!-- END HEADER -->
	<!-- BEGIN HEADER & CONTENT DIVIDER -->
	<div class="clearfix"> </div>
	<!-- END HEADER & CONTENT DIVIDER -->
	<!-- BEGIN CONTAINER -->
	<div class="page-container">
		<!-- BEGIN SIDEBAR -->
		<div class="page-sidebar-wrapper">
			<!-- BEGIN SIDEBAR -->
			<!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
			<!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
			<div class="page-sidebar navbar-collapse collapse">
				<!-- BEGIN SIDEBAR MENU -->
				<!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
				<!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
				<!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
				<!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
				<!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
				<!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
				<ul class="page-sidebar-menu  page-header-fixed " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">
					<!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
					<li class="sidebar-toggler-wrapper hide">
						<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
						<div class="sidebar-toggler"> </div>
						<!-- END SIDEBAR TOGGLER BUTTON -->
					</li>
					<?php if ($this->session->userdata('nGroupId') == 1) { ?>
						<li class="nav-item <?php if (in_array($this->uri->segment(1), array('dashboard'))) { ?> active open<?php } ?>"> <a href="javascript:;" class="nav-link nav-toggle"> <i class="icon-home"></i> <span class="title">Dashboard</span> <span class="arrow"></span> </a>
							<ul class="sub-menu">
								<li class="nav-item <?php if (in_array($this->uri->segment(1), array('dashboard'))) { ?> active open<?php } ?>"> <a href="<?php echo base_url(); ?>dashboard" class="nav-link"> <i class="icon-bar-chart"></i> <span class="title">Dashboard &amp; Statistics</span> </a> </li>
							</ul>
						</li>
						<li class="nav-item <?php if (in_array($this->uri->segment(1), array('users', 'create-new-user', 'edit-user'))) { ?> active open<?php } ?>"> <a href="javascript:;" class="nav-link nav-toggle"> <i class="icon-user"></i> <span class="title">Users</span> <span class="arrow"></span> </a>
							<ul class="sub-menu">
								<li class="nav-item <?php if (in_array($this->uri->segment(1), array('users', 'edit-user'))) { ?> active open<?php } ?>"> <a href="<?php echo base_url(); ?>users" class="nav-link"> <span class="title">Users Listening</span> </a> </li>
								<li class="nav-item <?php if ($this->uri->segment(1) == 'create-new-user') { ?> active open<?php } ?>"> <a href="<?php echo base_url(); ?>create-new-user" class="nav-link"> <span class="title">Create New User</span> </a> </li>
							</ul>
						</li>
						<li class="nav-item <?php if (in_array($this->uri->segment(1), array('clients', 'create-new-client', 'edit-client', 'devices', 'ledgers'))) { ?> active open<?php } ?>"> <a href="javascript:;" class="nav-link nav-toggle"> <i class="icon-screen-smartphone"></i> <span class="title">Clients</span> <span class="arrow"></span> </a>
							<ul class="sub-menu">
								<li class="nav-item <?php if (in_array($this->uri->segment(1), array('clients', 'edit-client'))) { ?> active open<?php } ?>"> <a href="<?php echo base_url(); ?>clients" class="nav-link"> <span class="title">Clients Listening</span> </a> </li>
								<li class="nav-item <?php if ($this->uri->segment(1) == 'create-new-client') { ?> active open<?php } ?>"> <a href="<?php echo base_url(); ?>create-new-client" class="nav-link"> <span class="title">Create New Client</span> </a> </li>
								<li class="nav-item <?php if ($this->uri->segment(1) == 'devices') { ?> active open<?php } ?>"> <a href="<?php echo base_url(); ?>devices" class="nav-link"> <span class="title">Devices Listening</span> </a> </li>
								<li class="nav-item <?php if ($this->uri->segment(1) == 'ledgers') { ?> active open<?php } ?>"> <a href="<?php echo base_url(); ?>ledgers" class="nav-link"> <span class="title">Ledgers Listening</span> </a> </li>
							</ul>
						</li>
						<li class="nav-item <?php if (in_array($this->uri->segment(1), array('smtp-settings', 'registration-settings'))) { ?> active open<?php } ?>"> <a href="javascript:;" class="nav-link nav-toggle"> <i class="icon-settings"></i> <span class="title">Settings</span> <span class="arrow"></span> </a>
							<ul class="sub-menu">
								<li class="nav-item <?php if (in_array($this->uri->segment(1), array('registration-settings'))) { ?> active open<?php } ?>"> <a href="<?php echo base_url(); ?>registration-settings" class="nav-link"> <span class="title">Registration Settings</span> </a> </li>
								<li class="nav-item <?php if (in_array($this->uri->segment(1), array('smtp-settings'))) { ?> active open<?php } ?>"> <a href="<?php echo base_url(); ?>smtp-settings" class="nav-link"> <span class="title">SMTP Settings</span> </a> </li>
							</ul>
						</li>
					<?php } ?>
					<li class="nav-item" style="margin-left:10px;margin-top:20px;">
						<div id="google_translate_element"></div>
						<script type="text/javascript">
							function googleTranslateElementInit() {
								new google.translate.TranslateElement({
									pageLanguage: 'en',
									layout: google.translate.TranslateElement.InlineLayout.SIMPLE
								}, 'google_translate_element');
							}
						</script>
						<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
					</li>
				</ul>
				<!-- END SIDEBAR MENU -->
				<!-- END SIDEBAR MENU -->
			</div>
			<!-- END SIDEBAR -->
		</div>
		<!-- END SIDEBAR -->
		<!-- BEGIN CONTENT -->
		<div class="page-content-wrapper">
			<!-- BEGIN CONTENT BODY -->
			<div class="page-content">
				<!-- BEGIN PAGE HEADER-->