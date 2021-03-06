<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo get_config_item('app_title'); ?> | Log in</title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<!-- Bootstrap 3.3.5 -->
	<link rel="stylesheet" href="<?php echo base_url('assets/AdminLTE-2.3.0/bootstrap/css/bootstrap.min.css'); ?>">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
	<!-- Ionicons -->
	<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="<?php echo base_url('assets/AdminLTE-2.3.0/dist/css/AdminLTE.min.css'); ?>">

	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body class="hold-transition login-page">
	<div class="login-box">
		<div class="login-logo">
			<a href="<?php echo site_url(); ?>"><strong><?php echo get_config_item('app_title'); ?></strong></a>
		</div><!-- /.login-logo -->
		<div class="login-box-body">
			<p class="login-box-msg">Sign in to start your session</p>
			<?php alert_message();?>
			<?php echo form_open(); ?>
				<div class="form-group has-feedback">
					<input type="username" name="username" class="form-control" placeholder="Username" value="<?php echo set_value('username'); ?>">
					<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
				</div>
				<div class="form-group has-feedback">
					<input type="password" name="password" class="form-control" placeholder="Password">
					<span class="glyphicon glyphicon-lock form-control-feedback"></span>
				</div>
				<div class="row">
					<div class="col-xs-12">
						<strong>Hint: <br> Username: admin <br> password: 1</strong>
					</div>
					<div class="col-xs-4">
						<button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
					</div><!-- /.col -->
				</div>
			<?php echo form_close(); ?>

		</div><!-- /.login-box-body -->
	</div><!-- /.login-box -->

	<!-- jQuery 2.1.4 -->
	<script src="<?php echo base_url('assets/AdminLTE-2.3.0/plugins/jQuery/jQuery-2.1.4.min.js'); ?>"></script>
	<!-- Bootstrap 3.3.5 -->
	<script src="<?php echo base_url('assets/AdminLTE-2.3.0/bootstrap/js/bootstrap.min.js'); ?>"></script>
</body>

</html>