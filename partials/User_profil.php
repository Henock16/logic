<div class="col-xs-12">
	<div id="home" class="tab-pane in active">
		<div class="row" style="background-color: white;margin: 15px;padding: 10px 0 10px 0px;border-radius: 5px;box-shadow: 1px 1px 3px #a5a5a5;max-width:550px">
			<div class="col-xs-3 center">
				<span class="profile-picture">
					<img class="editable img-responsive" alt="Avatar" src="./assets/images/logo_user/<?php echo $_SESSION['AVATAR'] ?>" />
				</span>
			</div><!-- /.col -->

			<div class="col-xs-9">
				<h4 class="blue">
					<span class="middle"><?php echo $_SESSION['FULLNAME']?></span>&nbsp;
					<span class="btn btn-flat" style="font-size: 12px; background: #00a65a; color: white">
						<i class="fa fa-circle"></i>
						connect&eacute;
					</span>
				</h4>

				<div class="profile-user-info">
				
					<div class="profile-info-row">
						<div class="profile-info-name"> Matricule </div>
						<div class="profile-info-value">
							<span><?php echo $_SESSION['MATRICULE']?></span>
						</div>
					</div>
					
					<div class="profile-info-row">
						<div class="profile-info-name"> Utilisateur </div>
						<div class="profile-info-value">
							<span><?php echo $_SESSION['LOGIN']?></span>
						</div>
					</div>
					
					<div class="profile-info-row">
						<div class="profile-info-name"> Cellule </div>
						<div class="profile-info-value">
							<span><?php echo $_SESSION['FUNCTION']?></span>
						</div>
					</div>
					
					<div class="profile-info-row">
						<div class="profile-info-name"> Ville </div>
						<div class="profile-info-value">
							<i class="fas fa-map-marker-alt fa-lg"></i>
							<span><?php echo $_SESSION['LIB_VILLE']?></span>
						</div>
					</div>

					<div class="profile-info-row">
						<div class="profile-info-name"> Contact </div>
						<div class="profile-info-value">
							<span><?php echo $_SESSION['CONTACT']?></span>
						</div>
					</div>
				</div>

				<div class="hr hr-8 dotted"></div>

				<div class="profile-user-info">
					<div class="profile-info-row">
						<div class="profile-info-name"> Email </div>
						<div class="profile-info-value">
							<span><?php echo $_SESSION['EMAIL']?></span>
						</div>
					</div>
				</div>
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /#home -->
</div>