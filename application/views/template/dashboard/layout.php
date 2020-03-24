<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo get_config_item('app_title'); ?></title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<!-- Bootstrap 3.3.5 -->
	<link rel="stylesheet" href="<?php echo base_url('assets/AdminLTE-2.3.0/bootstrap/css/bootstrap.min.css'); ?>">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
	<!-- Ionicons -->
	<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
	<!-- DataTables -->
	<link rel="stylesheet"
		href="<?php echo base_url('assets/AdminLTE-2.3.0/plugins/datatables/dataTables.bootstrap.css'); ?>">
	<!-- Theme style -->
	<link rel="stylesheet" href="<?php echo base_url('assets/AdminLTE-2.3.0/dist/css/AdminLTE.min.css'); ?>">
	<!-- AdminLTE Skins. We have chosen the skin-blue for this starter
          page. However, you can choose any other skin. Make sure you
          apply the skin class to the body tag so the changes take effect.
	-->
	<link rel="stylesheet" href="<?php echo base_url('assets/AdminLTE-2.3.0/plugins/sweetalert2/dist/sweetalert2.min.css'); ?>">
	<link rel="stylesheet" href="<?php echo base_url('assets/AdminLTE-2.3.0/dist/css/skins/skin-awantengah.min.css'); ?>">

	<style>
		.swal2-popup {
			font-size: 1.5rem;
		}
		.swal2-confirm.btn.btn-success {
			margin-right: 0.5em;
		}
		.swal2-cancel.btn.btn-danger {
			margin-left: 0.5em;
		}
	</style>

	<!-- jQuery 2.1.4 -->
	<script src="<?php echo base_url('assets/AdminLTE-2.3.0/plugins/jQuery/jQuery-2.1.4.min.js'); ?>"></script>
	<!-- DataTables -->
	<script src="<?php echo base_url('assets/AdminLTE-2.3.0/plugins/datatables/jquery.dataTables.min.js'); ?>"></script>
	<script src="<?php echo base_url('assets/AdminLTE-2.3.0/plugins/datatables/dataTables.bootstrap.min.js'); ?>"></script>

	<link rel="stylesheet" type="text/css" href="https://code.jquery.com/ui/1.12.0/themes/smoothness/jquery-ui.css">
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<script src="<?php echo base_url('assets/js/jquery.datetimepicker.full.js'); ?>"></script>

	<script>
		let base_url = "<?php echo base_url(); ?>";
	</script>

	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<!--
  BODY TAG OPTIONS:
  =================
  Apply one or more of the following classes to get the
  desired effect
  |---------------------------------------------------------|
  | SKINS         | skin-blue                               |
  |               | skin-black                              |
  |               | skin-purple                             |
  |               | skin-yellow                             |
  |               | skin-red                                |
  |               | skin-green                              |
  |---------------------------------------------------------|
  |LAYOUT OPTIONS | fixed                                   |
  |               | layout-boxed                            |
  |               | layout-top-nav                          |
  |               | sidebar-collapse                        |
  |               | sidebar-mini                            |
  |---------------------------------------------------------|
  -->

<body class="hold-transition skin-awantengah sidebar-mini">
	<div class="wrapper">

		<!-- Main Header -->
		<header class="main-header">

			<!-- Logo -->
			<a href="<?php echo site_url(); ?>" class="logo">
				<!-- mini logo for sidebar mini 50x50 pixels -->
				<span class="logo-mini"><?php echo get_config_item('app_title'); ?></span>
				<!-- logo for regular state and mobile devices -->
				<span class="logo-lg"><?php echo get_config_item('app_title'); ?></span>
			</a>

			<!-- Header Navbar -->
			<nav class="navbar navbar-static-top" role="navigation">
				<!-- Sidebar toggle button-->
				<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
					<span class="sr-only">Toggle navigation</span>
				</a>
				<!-- Navbar Right Menu -->
				<div class="navbar-custom-menu">
					<ul class="nav navbar-nav">
						<!-- User Account Menu -->
						<li class="dropdown user user-menu">
							<!-- Menu Toggle Button -->
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<!-- The user image in the navbar-->
								<img src="<?php echo !is_null($_user_login->photo) ? base_url(get_config_item('user_path') . $_user_login->photo) : base_url('assets/img/user.png'); ?>"
									class="user-image" alt="User Image">
								<!-- hidden-xs hides the username on small devices so only the image appears. -->
								<span class="hidden-xs"><?php echo $_user_login->username; ?></span>
							</a>
							<ul class="dropdown-menu">
								<!-- The user image in the menu -->
								<li class="user-header">
									<img src="<?php echo !is_null($_user_login->photo) ? base_url(get_config_item('user_path') . $_user_login->photo) : base_url('assets/img/user.png'); ?>"
										class="img-circle" alt="User Image">
									<p>
										<?php echo $_user_login->username; ?>
									</p>
								</li>
								<!-- Menu Footer-->
								<li class="user-footer">
									<div class="pull-left">
										<!-- <a href="#" class="btn btn-default btn-flat">Profile</a> -->
									</div>
									<div class="pull-right">
										<a href="<?php echo site_url('logout'); ?>"
											class="btn btn-default btn-flat">Sign out</a>
									</div>
								</li>
							</ul>
						</li>
					</ul>
				</div>
			</nav>
		</header>
		<!-- Left side column. contains the logo and sidebar -->
		<aside class="main-sidebar">

			<!-- sidebar: style can be found in sidebar.less -->
			<section class="sidebar">

				<!-- Sidebar user panel (optional) -->
				<div class="user-panel">
					<div class="pull-left image">
						<img src="<?php echo !is_null($_user_login->photo) ? base_url(get_config_item('user_path') . $_user_login->photo) : base_url('assets/img/user.png'); ?>"
							class="img-circle" alt="User Image">
					</div>
					<div class="pull-left info">
						<p><?php echo $_user_login->username; ?></p>
						<!-- Status -->
						<a href="#"><i class="fa fa-circle text-success"></i> Online</a>
					</div>
				</div>

				<!-- Sidebar Menu -->
				<ul class="sidebar-menu">
					<li class="header">NAVIGATION</li>
					<!-- Optionally, you can add icons to the links -->
					<li class="<?php echo isset($_sidebar_active) ? ($_sidebar_active == 'home' ? 'active' : '') : ''; ?>">
						<a href="<?php echo site_url('dashboard'); ?>">
							<i class="fa fa-link"></i> <span>Dashboard</span>
						</a>
					</li>
					<li class="<?php echo isset($_sidebar_active) ? ($_sidebar_active == 'car_data' ? 'active' : '') : ''; ?>">
						<a href="<?php echo site_url('dashboard/car-data'); ?>">
							<i class="fa fa-link"></i> <span>Car Data</span>
						</a>
					</li>
					<li class="<?php echo isset($_sidebar_active) ? ($_sidebar_active == 'car_rental' ? 'active' : '') : ''; ?>">
						<a href="<?php echo site_url('dashboard/car-rental'); ?>">
							<i class="fa fa-link"></i> <span>Car Rental</span>
						</a>
					</li>
				</ul><!-- /.sidebar-menu -->
			</section>
			<!-- /.sidebar -->
		</aside>

		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">

			<!-- Content Header (Page header) -->
			<section class="content-header">
				<h1>
					<?php echo $page_title; ?>
				</h1>

				<?php if (isset($breadcrumb)): ?>
				<ol class="breadcrumb">
					<li>
						<a href="<?php echo site_url('dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a>
					</li>
					<?php foreach ($breadcrumb as $row): ?>
					<?php if ($row['active'] == '1'): ?>
					<li><?php echo ucwords($row['title']); ?></li>
					<?php else: ?>
					<li>
						<a href="<?php echo $row['link']; ?>">
							<i class="<?php echo $row['icon']; ?>"></i> <?php echo ucwords(($row['title'])); ?>
						</a>
					</li>
					<?php endif;?>
					<?php endforeach;?>
				</ol>
				<?php endif;?>
			</section>

			<!-- Main content -->
			<section class="content">

				<?php echo $_main_content; ?>

			</section><!-- /.content -->


		</div><!-- /.content-wrapper -->

		<!-- Main Footer -->
		<footer class="main-footer">
			<!-- To the right -->
			<div class="pull-right hidden-xs">

			</div>
			<!-- Default to the left -->
			<strong>Copyright &copy; <?php echo date('Y'); ?> <a href="https://awantengah.com/" target="_blank">Rahmat
					Basuki</a>.</strong> All rights reserved.
		</footer>

	</div><!-- ./wrapper -->

	<!-- REQUIRED JS SCRIPTS -->

	<!-- Bootstrap 3.3.5 -->
	<script src="<?php echo base_url('assets/AdminLTE-2.3.0/bootstrap/js/bootstrap.min.js'); ?>"></script>
	<script src="<?php echo base_url('assets/AdminLTE-2.3.0/plugins/currency.js/dist/currency.min.js'); ?>"></script>
	<script src="<?php echo base_url('assets/AdminLTE-2.3.0/plugins/cleave.js/dist/cleave.min.js'); ?>"></script>
	<script src="<?php echo base_url('assets/AdminLTE-2.3.0/plugins/sweetalert2/dist/sweetalert2.min.js'); ?>"></script>
	<!-- AdminLTE App -->
	<script src="<?php echo base_url('assets/AdminLTE-2.3.0/dist/js/app.min.js'); ?>"></script>

	<!-- Optionally, you can add Slimscroll and FastClick plugins.
         Both of these plugins are recommended to enhance the
         user experience. Slimscroll is required when using the
         fixed layout. -->
</body>

</html>
