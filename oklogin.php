<?php
	session_start();
	error_reporting(0);
	include "timeout.php";
	include "config/library.php";
	//include "functionrp.php";
	include "function_terbilang.php";

	if($_SESSION['login']==1){
		if(!cek_login()){
			$_SESSION['login'] = 0;
		}
	}
	if($_SESSION['login']==0){

		header('location:logout.php');
	}
	else{
		if (empty($_SESSION['username']) AND empty($_SESSION['passuser']) AND $_SESSION['login']==0){
			?>
				<link href='style.css' rel='stylesheet' type='text/css' />
				<center>
					Untuk mengakses modul, Anda harus login <br>
					<a href=index.php><b>LOGIN</b></a>
				</center>
			<?php
		}
		else {
			?>
				<!DOCTYPE html>
				<html>
					<head>
						<meta charset="utf-8">
						<meta http-equiv="X-UA-Compatible" content="IE=edge">
						<title>Administrator</title>
						<!-- Tell the browser to be responsive to screen width -->
						<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
						<!-- Bootstrap 3.3.6 -->
						<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
						<!-- Font Awesome -->
						<link rel="stylesheet" href="bootstrap/font-awesome/css/font-awesome.min.css">
						<!-- Ionicons -->
						<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
						<!-- Theme style -->
						<!-- Select2 -->
						<link rel="stylesheet" href="plugins/select2/select2.min.css">
						<!-- Theme style -->
						<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
						<!-- AdminLTE Skins. Choose a skin from the css/skins
						   folder instead of downloading all of them to reduce the load. -->
						<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
						<!-- iCheck -->
						<link rel="stylesheet" href="plugins/iCheck/flat/blue.css">
						<!-- jvectormap -->
						<link rel="stylesheet" href="plugins/jvectormap/jquery-jvectormap-1.2.2.css">
						<!-- Date Picker -->
						<link rel="stylesheet" href="plugins/datepicker/datepicker3.css">
						<!-- Daterange picker -->
						<link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
						<!-- bootstrap wysihtml5 - text editor -->
						<link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
						<!-- DataTables -->
						<link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
						
						<link rel="stylesheet" href="bootstrap/css/bootstrap-theme.min.css">
						<link rel="stylesheet" href="plugins/text_blink.css">
						<!-- Custom CSS -->
						<link rel="stylesheet" href="style.css">
						<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
						<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
						<!--[if lt IE 9]>
						<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
						<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
						<![endif]-->
						<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
						<!-- jQuery UI 1.11.4 -->
						<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
						<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
						<script>
						  $.widget.bridge('uibutton', $.ui.button);
						</script>
						<!-- Bootstrap 3.3.6 -->
						<script src="bootstrap/js/bootstrap.min.js"></script>
						<!-- Untuk maskmoney  -->
						<!--<script type="text/javascript" src="bootstrap/js/jquery.min.js"></script>-->
						<!-- Penambahan koma di inputan  -->
						<script type="text/javascript" src="plugins/jquerymoney/jquery.maskMoney.min.js"></script>
						<!-- Select2 -->
						<script src="plugins/select2/select2.full.min.js"></script>
						<!-- DataTables -->
						<script src="plugins/datatables/jquery.dataTables.min.js"></script>
						<script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
						<!-- Sparkline -->
						<script src="plugins/sparkline/jquery.sparkline.min.js"></script>
						<!-- jvectormap -->
						<script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
						<script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
						<!-- jQuery Knob Chart -->
						<script src="plugins/knob/jquery.knob.js"></script>
						<!-- daterangepicker -->
						<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
						<script src="plugins/daterangepicker/daterangepicker.js"></script>
						<!-- datepicker -->
						<script src="plugins/datepicker/bootstrap-datepicker.js"></script>
						<!-- Bootstrap WYSIHTML5 -->
						<script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
						<!-- Slimscroll -->
						<script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
						<!-- FastClick -->
						<script src="plugins/fastclick/fastclick.js"></script>
						<!-- AdminLTE App -->
						<script src="dist/js/app.min.js"></script>
						<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
						<script src="dist/js/pages/dashboard.js"></script>
						<!-- AdminLTE for demo purposes -->
						<script src="dist/js/demo.js"></script>
						<!-- </head> -->
					</head>
					
					<body class="hold-transition skin-blue sidebar-mini">
						<div class="wrapper">
							<header class="main-header">
								<!-- Logo -->
								<a href="oklogin.php?module=home" class="logo">
								  <!-- mini logo for sidebar mini 50x50 pixels -->
								  <span class="logo-mini">NML</span>
								  <!-- logo for regular state and mobile devices -->
								  <span class="logo-lg"><b>Admin</b></span>
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
												<img src="dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
												<span class="hidden-xs"><?php echo $_SESSION['namalengkap']; ?></span>
											</a>
											<ul class="dropdown-menu">
												<!-- User image -->
												<li class="user-header">
													<img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">

													<p>
													  <?php echo $_SESSION['namalengkap']; ?> - <?php echo $_SESSION['levelusername']; ?>
													  <small>Member since Nov. 2012</small>
													</p>
												</li>
												<!-- Menu Body -->
												<li class="user-body">
													<div class="row">
													  <div class="col-xs-4 text-center">
														<a href="#">Followers</a>
													  </div>
													  <div class="col-xs-4 text-center">
														<a href="#">Sales</a>
													  </div>
													  <div class="col-xs-4 text-center">
														<a href="#">Friends</a>
													  </div>
													</div>
												<!-- /.row -->
												</li>
												<!-- Menu Footer-->
												<li class="user-footer">
													<div class="pull-left">
													  <a href="#" class="btn btn-default btn-flat">Profile</a>
													</div>
													<div class="pull-right">
													  <a href="logout.php" class="btn btn-default btn-flat">Keluar</a>
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
									<!-- Sidebar user panel -->
									<div class="user-panel">
										<div class="pull-left image">
											<img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
										</div>
										<div class="pull-left info">
											<p><?php echo $_SESSION['namalengkap']; ?></p>
											<a href="#"><i class="fa fa-circle text-success"></i> Online</a>
										</div>
									</div>

									<?php include "menu.php"; ?>
									
								</section>
								<!-- /.sidebar -->
							</aside>

							<!-- Content Wrapper. Contains page content -->
							<div class="content-wrapper">
								<?php include "content.php"; ?>
							</div>
							<!-- /.content-wrapper -->
							<footer class="main-footer">
								<div class="pull-right hidden-xs">
								  <b>Version</b> 2.3.8
								</div>
								<strong>Copyright &copy; 2014-2018 <a href="http://komputertech.com">komputertech.com</a>.</strong> All rights
								reserved.
							</footer>
						</div>
						<!-- </body></html> -->
					</body>
				</html>
			<?php
		}
	}
?>