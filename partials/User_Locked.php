<!-- Automatic element centering -->
<div class="lockscreen-wrapper lockscreen" style="display:none; background-color: #ecf0f5;z-index:9999; position:absolute; width:100%;height:100%; border: 1px solid #adadad">
	<div class="lockscreen-logo" style="margin-top: 15%;">
		<img src="./assets/images/cube1.png" width="39px" height="39px" alt="" class="cube" /> <span style="color: #46A800;">L&nbsp;</span><span style="color: #0175A6;">O&nbsp;</span><span style="color: #FB7101;">G&nbsp;</span><span style="color: #038473;">I&nbsp;</span><span style="color: #8B0E8D;">C</span>
	</div>
	<!-- User name -->
	<div class="lockscreen-name">
		<?php echo $_SESSION['FULLNAME']; ?>
	</div>
	<!-- START LOCK SCREEN ITEM -->
	<div class="lockscreen-item">
		<!-- lockscreen image -->
		<div class="lockscreen-image">
			<img src="./assets/images/logo_user/<?php echo $_SESSION['AVATAR']; ?>" alt="User Image">
		</div>
		<!-- /.lockscreen-image -->
		<!-- lockscreen credentials (contains the form) -->
		<form class="lockscreen-credentials" id="locked-form" action="#">
			<div class="input-group">
				<input type="password" name="pwdlocked" id="pwdlocked" class="form-control" placeholder="Mot de passe">
				<div class="input-group-btn">
					<button type="submit" class="btn" style="margin-left: 5px;"><i class="fa fa-arrow-right text-muted"></i></button>
				</div>
			</div>
		</form>
	<!-- /.lockscreen credentials -->
	</div>
	<!-- /.lockscreen-item -->
	<div class="help-block text-center">
	Veuillez saisir votre mot de passe
	</div>
	<div class="lockscreen-footer text-center" style="margin-top:30px">
		<strong>Copyright &copy; 2017-2018&nbsp;&nbsp;<a target="_blank" href="http://www.cci.ci">CCI - C&ocirc;te d'Ivoire</a>.</strong> Tous droits r&eacute;serv&eacute;s.
	</div>
</div>
<!-- /.center -->