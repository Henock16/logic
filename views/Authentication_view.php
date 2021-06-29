<body style="display:none; height:100%; max-height:100%">
	<div class="loader" style="display:none"></div>
	<div uk-sticky="media: 960" class="uk-navbar-container tm-navbar-container uk-sticky uk-active" style="position: fixed; top: 0px; width: 1903px;border-bottom: 1px solid rgb(229, 229, 229);background: #fff !important;" ">
		<div class="uk-container uk-container-expand">
			<nav uk-navbar>
				<div class="uk-navbar-left" style="width:60%">
					<a href="#" class="uk-navbar-item uk-logo">
						<img src="assets/images/cci.jpg" style="width: 250px;border-radius: 2px;box-shadow: -1px 1px 2px 1px rgba(85, 85, 85, 0.5), -1px 2px 20px rgba(255, 255, 255, 0.3) inset;" />
					</a>
				</div>
				<div class="uk-navbar-right" style="width:40%; text-align: center;">
					C&ocirc;te d'Ivoire, le <?php echo utf8_encode($date);?>&nbsp;&nbsp;&nbsp;
					<div id="h" style="font-size: 14px;color: black; width: 6%;height: 30%; background-color:white; border-radius: 2px; box-shadow: -1px 1px 2px 1px rgba(85, 85, 85, 0.3) inset;">
						<?php echo($hour);?>
					</div>
					<span style="font-size: 18px; font-weight:500; color:rgb(98, 98, 98);">&nbsp;:&nbsp;</span>
					<div id="m" style="font-size: 14px;color: black; width: 6%;height: 30%; background-color:white; border-radius: 2px; box-shadow: -1px 1px 2px 1px rgba(85, 85, 85, 0.3) inset;">
						<?php echo($min);?>
					</div>
					<span style="font-size: 18px; font-weight:500; color:rgb(98, 98, 98);">&nbsp;:&nbsp;</span>
					<div id="s" style="font-size: 14px;color: white; width: 6%;height: 30%; background-color:#C2C2C2; border-radius: 2px; box-shadow: -1px 1px 2px 1px rgba(85, 85, 85, 0.3) inset">
						<?php echo($sec);?>
					</div>
				</div>
			</nav>
		</div>
	</div>
	<div class="content-background" style="background-color: white;background-image: url(assets/images/8.jpg);background-size: cover;background-repeat: no-repeat;background-attachment:fixed;">
		<div class="uk-section-large" style="padding-top: 25px;">
			<div class="uk-container uk-container-large">
				<div uk-grid class="uk-child-width-1-1@s uk-child-width-2-3@l">
					<div class="uk-width-1-1@s uk-width-1-5@l uk-width-1-3@xl"></div>
					<div class="uk-width-1-1@s uk-width-3-5@l uk-width-1-3@xl">
						<div id="notification" class="alert alert-danger alert-dismissible" style="display:none;color:white;max-width: 475px;margin: auto;">
							<!--<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>-->
							<h4><span uk-icon="icon: warning"></span>&nbsp;Alerte !</h4>
							<span id ="message1"></span><br/>
							<span id ="message2"></span>
						</div>
						<div class="uk-card uk-card-default" style="border: solid 1px #E5E5E5;max-width:475px;margin:auto">
							<div class="uk-card-header">
								<span style="float: left">Connexion</span><span style="float: right;font-size: 10px;"">D&eacute;pt Pesage et Certification des Poids</span>
							</div>
							<div class="uk-card-body">
								<center>
									<h2 style="font-family: Source Sans pro; margin-bottom: 20px; margin-top: 0px; font-weight:300"><img src="./assets/images/cube1.png" width="39px" height="30px" alt="" class="cube" /> <span style="color: #46A800;">L&nbsp;</span><span style="color: #0175A6;">O&nbsp;</span><span style="color: #FB7101;">G&nbsp;</span><span style="color: #038473;">I&nbsp;</span><span style="color: #8B0E8D;">C</span></h2>
									<h5 style="margin-top: 0px;">Logiciel de Gestion Intégrée des Certificats de Pesage</h5>
								</center>
								<form id="login-form" action="#">
									<fieldset class="uk-fieldset">

										<div class="uk-margin">
											<div class="uk-position-relative">
												<span class="uk-form-icon ion-android-person"></span>
												<input name="username" id="username" class="uk-input" type="text" placeholder="Utilisateur" required>
											</div>
										</div>

										<div class="uk-margin">
											<div class="uk-position-relative">
												<span class="uk-form-icon ion-locked"></span>
												<input name="password" id="password" class="uk-input" type="password" placeholder="Mot de passe" required>
											</div>
										</div>

										<div class="uk-margin">
											<button type="submit" class="uk-button uk-button-primary">
												<span class="ion-forward"></span>&nbsp; Se connecter
											</button>
										</div>

										<hr />

										<center>
										</center>
									</fieldset>
								</form>
							</div>
						</div>
					</div>
					<div class="uk-width-1-1@s uk-width-1-5@l uk-width-1-3@xl">
						
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<?php include_once('partials/Authentication_firstconnection.php'); ?>