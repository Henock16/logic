<!DOCTYPE html>
<html>
	<head>
		<title>Logiciel de Gestion Int&eacute;gr&eacute;e des Certificats de Poids</title>
		<meta charset="UTF-8">
		<meta name="description" content="">
        <meta name="keywords" content="">
        <meta name="author" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">

		<link rel="icon" type="image/png" href="./assets/images/cube1.png" />

		<link rel="stylesheet" href="./assets/css/bootstrap.min.css">
		<link rel="stylesheet" href="./assets/css/fontawesome-5.3.1/css/all.css">
		<link rel="stylesheet" href="./assets/css/ionicons.min.css">
		<link rel="stylesheet" href="./assets/css/jquery-jvectormap.css">
		<link rel="stylesheet" href="./assets/css/AdminLTE.min.css">
		<link rel="stylesheet" href="./assets/css/_all-skins.min.css">
		<link rel="stylesheet" href="./assets/css/style-font.css">
		<link rel="stylesheet" href="./assets/css/widget.css">
		<link rel="stylesheet" href="./assets/DataTables/datatables.min.css">
		<link rel="stylesheet" href="./assets/css/jquery-ui.custom.min.css" />
		<link rel="stylesheet" href="./assets/css/jquery.gritter.min.css" />
		<link rel="stylesheet" href="./assets/css/bootstrap-editable.min.css" />

	</head>

	<body class="hold-transition skin-black-light sidebar-mini" style="font-size: 16px">

		<?php include_once('./partials/User_locked.php'); ?>

		<div class="loader2" style="display:block">
			<img src="./assets/images/logo_user/<?php echo $_SESSION['AVATAR'] ?>" class="img-circle" alt="User Image" width="60px" style ="position: absolute;top: 20%;left: 48.5%;"/>
			<img src="./assets/images/cube1.png" alt="Logic" title="Logic" class="cube" style=";position: absolute;top: 33%;left: 46%;font-size: 60px;" width="39px" height="39px">
			<span style ="position: absolute;top: 33%;left: 49%">
				<span style="color: #46A800;font-size: 25px;">&nbsp;L&nbsp;</span><span style="color: #0175A6;font-size: 25px;">O&nbsp;</span><span style="color: #FB7101;font-size: 25px;">G&nbsp;</span><span style="color: #038473;font-size: 25px;">I&nbsp;</span><span style="color: #8B0E8D;font-size: 25px;">C</span>
			</span>
			<br/>
			<i style="position: absolute;top: 45%;left: 49%;font-size: 50px;color: black;" class="fas fa-circle-notch fa-spin"></i><br/>
			<p class="text-center" style="position: absolute;top: 39%;left: 36%;font-size: 18px;color: black;opacity: 1;">Veuillez patienter pendant le chargement de vos données...
			</p>
		</div>

		<div class="loader" style="display:none">
			<i style="position: absolute;top: 35%;left: 50%;font-size: 50px;color: black;" class="fas fa-circle-notch fa-spin"></i>
		</div>

		<div class="wrapper" style="z-index:1">

			<header class="main-header">
				<!-- Logo -->
				<a href="#" class="logo">
					<!-- mini logo for sidebar mini 50x50 pixels -->
					<span class="logo-mini"><img src="./assets/images/cci.jpg" class="user-image" alt="CCI-CI" style="width: 40px;height: 16px;border-radius: 2px;box-shadow: -1px 1px 2px 1px rgba(85, 85, 85, 0.5), -1px 2px 20px rgba(255, 255, 255, 0.3) inset;"></span>
					<!-- logo for regular state and mobile devices -->
					<span class="logo-lg"><img src="./assets/images/cci.jpg" class="user-image" alt="CCI-CI" style="width: 195px;height: 35px;border-radius: 2px;box-shadow: -1px 1px 2px 1px rgba(85, 85, 85, 0.5), -1px 2px 20px rgba(255, 255, 255, 0.3) inset;"></span>
				</a>
				<!-- Header Navbar: style can be found in header.less -->
				<nav class="navbar navbar-static-top">
					<!-- Sidebar toggle button-->
					<a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
						<span class="sr-only">Toggle navigation</span>
					</a>

					<!-- Navbar Right Menu -->
					<div class="navbar-custom-menu">
						<ul class="nav navbar-nav">
							<li class="dropdown messages-menu" style="font-size: 16px;">
								<a href="#" class="dropdown-toggle" >
									<i class="fas fa-map-marker-alt fa-lg" ></i>
									<?php echo $_SESSION['LIB_VILLE'].', le '.utf8_encode($date);?>&nbsp;&nbsp;&nbsp;
									<span id="h" style="text-align:center; display:inline-block; font-size: 16px;color: black; width: 25px;height: 30%; background-color:white; border-radius: 2px; box-shadow: -1px 1px 2px 1px rgba(85, 85, 85, 0.3) inset;">
										<?php echo($hour);?>
									</span>

									<span style="font-size: 16px; font-weight:500; color:rgb(98, 98, 98);">&nbsp;:&nbsp;</span>
									<span id="m" style="text-align:center; display:inline-block;font-size: 16px;color: black; width: 25px;height: 30%; background-color:white; border-radius: 2px; box-shadow: -1px 1px 2px 1px rgba(85, 85, 85, 0.3) inset;">
										<?php echo($min);?>
									</span>

									<span style="font-size: 16px; font-weight:500; color:rgb(98, 98, 98);">&nbsp;:&nbsp;</span>
									<span id="s" style="text-align:center; display:inline-block;font-size: 16px;color: white; width: 25px;height: 30%; background-color:#C2C2C2; border-radius: 2px; box-shadow: -1px 1px 2px 1px rgba(85, 85, 85, 0.3) inset">
										<?php echo($sec);?>
									</span>
								</a>
							</li>
							<!-- Messages: style can be found in dropdown.less-->
							<li class="dropdown messages-menu">
								<a href="#" class="dropdown-toggle" onclick="openNav('1')">
									<i class="fas fa-inbox fa-lg" ></i>
									<span class="label label-success" id="numwb">0</span>
								</a>
							</li>
							<!-- Notifications: style can be found in dropdown.less -->
							<li class="dropdown notifications-menu">
								<a href="#" class="dropdown-toggle" onclick="openNav('2')">
									<i class="fas fa-folder-open fa-lg" ></i>
									<span class="label label-warning" id="numws">0</span>
								</a>
							</li>
							<!-- Tasks: style can be found in dropdown.less -->
							<li class="dropdown tasks-menu">
								<a href="#" class="dropdown-toggle" onclick="openNav('3')">
									<i class="fas fa-exclamation-triangle fa-lg" ></i>
									<span class="label label-danger" id="numbb">0</span>
								</a>
							</li>
							<!-- User Account: style can be found in dropdown.less -->
							<li class="dropdown user user-menu">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" style="font-size: 15px;">
									<img src="./assets/images/logo_user/<?php echo $_SESSION['AVATAR'] ?>" class="user-image" alt="photo">
									<span class="hidden-xs"><?php echo $_SESSION['FULLNAME'] ?></span>
								</a>
								<ul class="dropdown-menu">
									<!-- User image -->
									<li class="user-header">
										<img src="./assets/images/logo_user/<?php echo $_SESSION['AVATAR'] ?>" class="img-circle" alt="User Image">
										<p style="font-size: 15px;"><?php echo $_SESSION['FULLNAME'] ?> - <?php echo $_SESSION['FUNCTION'] ?>
											<small>Membre depuis <?php echo $_SESSION['DATE'] ?></small>
										</p>
									</li>
									<!-- Menu Footer-->
									<li class="user-footer" style="border: 1px solid #222222;">
										<div class="pull-left">
											<a href="#" id="locked" class="btn btn-warning" style="font-size: 14px;"><i  class="fas fa-user-lock"></i>&nbsp;&nbsp;Verrouiller</a>
										</div>
										<div class="pull-right">
											<a href="#" class="btn btn-danger logout" style="font-size: 14px;"><i  class="fas fa-power-off"></i>&nbsp;&nbsp;D&eacute;connexion</a>
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
					<div class="user-panel" style="min-height: 95px;">
						<div class="pull-left image">
							<img src="./assets/images/logo_user/<?php echo $_SESSION['AVATAR'] ?>" class="img-circle" alt="User Image">
						</div>
						<div class="pull-left info">
							<p><?php echo $_SESSION['FULLNAME'] ?></p>
							<a href="#"><i class="fa fa-circle text-success" style="color:#00A65A"></i> Connect&eacute;</a><br/>
							<a href="#" class="btn btn-danger logout" style="color: white;font-size: 14px;"><i  class="fas fa-power-off"></i>&nbsp;D&eacute;connexion</a>
						</div>
					</div>
