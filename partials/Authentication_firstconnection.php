<div class="modal fade" id="modal-FirstConnection" >
	<div class="modal-dialog">
		<!-- Modal content-->
		<form id="firstconnection-form" action="#" >
			<div class="modal-content" style="width:580px;">
			
				<div class="modal-header">
					<h4 class="modal-title" align="center">Bienvenue M./Mme  <span id="user-fullname"></span>
					</h4>
					<p align="center" style="color: red"><i>*** Veuillez s'il vous pla&icirc;t renseigner les informations suivantes</i></p>  
				</div>
				
				<div class="modal-body">
					
					<div class="uk-margin">
						<label class="uk-form-label" for="form-stacked-text">Date de naissance</label>
						<div class="uk-position-relative">
							<span class="uk-form-icon" uk-icon=" icon: calendar"></span>
							<input class="uk-input" name="birth" id="birth" type="date" placeholder="Date de naissance" required>
						</div>
					</div>
					
					<div class="uk-margin">
						<div class="uk-position-relative">
							<span class="uk-form-icon" uk-icon=" icon: pencil"></span>
							<input class="uk-input" name="contact" id="contact" type="text" placeholder="Contact" required>
						</div>
					</div>
					
					<div class="uk-margin">
						<div class="uk-position-relative">
							<span class="uk-form-icon" uk-icon=" icon: mail"></span>
							<input class="uk-input" name="email" id="email" type="email" placeholder="Email" required>
						</div>
					</div>
					<hr />
					<div class="uk-margin">
						<div class="uk-position-relative">
							<span class="uk-form-icon ion-locked"></span>
							<input name="new-password2" id="new-password2" value="" class="uk-input" type="password" placeholder="Nouveau mot de passe" required>
						</div>
					</div>
					<div class="uk-margin">
						<div class="uk-position-relative">
							<span class="uk-form-icon ion-locked"></span>
							<input name="new-password3" id="new-password3" class="uk-input" type="password" placeholder="Confirmer mot de passe" required>
						</div>
					</div>
				</div>
				
				<div class="modal-footer">
					<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Fermer</button>
					<button type="submit" class="btn btn-primary" >Valider</button>
				</div>
			</div>
		</form>
	</div>
</div>