<!--Liasse en attente de traitement-->
<div id="waitingBundle" class="sidenav" style="overflow: hidden;z-index: 99;">
	<a href="javascript:void(0)" class="closebtn" onclick="closeNav('1')" style="color: white; padding-top: 8px; font-size: 30px;margin-right:15px">&times;</a>
	<button class="btn btn-block btn-success" style="text-align:left;width:360px;font-size: 12px;margin: 0px 8px 8px 8px;"><i class="fas fa-inbox" ></i>&nbsp;&nbsp;BAC DE TRAITEMENT</button>
	
	<table class="table table-hover" id="wbundle">
		<tbody style="display:block; max-height:137px; overflow:auto">	
		</tbody>
	</table>
</div>

<!--Bordereau en attente-->
<div id="waitingSlip" class="sidenav" style="overflow: hidden;z-index: 99;">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav('2')" style="color: white; padding-top: 8px; font-size: 30px;margin-right:15px">&times;</a>
  <button class="btn btn-block btn-warning" style="text-align:left;width:360px;font-size: 12px;margin: 0px 8px 8px 8px;" id ="numbord"><i class="far fa-folder-open" ></i>&nbsp;&nbsp;BORDEREAU FERME</button>
  <button class="btn btn-block btn-primary send-slip" style="display: none; text-align:center;width:38%;font-size: 12px;margin: auto; margin-bottom: 8px"><i class="far fa-paper-plane" ></i>&nbsp;&nbsp;Envoyer le bordereau</button>
  
	<table class="table table-hover" id="wslip">
		<tbody style="display:block; max-height:137px; overflow:auto">			
		</tbody>
	</table>
</div>

<!--Liasse en attente-->
<div id="blockedBundle" class="sidenav" style="overflow: hidden;z-index: 99;">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav('3')" style="color: white; padding-top: 8px; font-size: 30px;margin-right:15px">&times;</a>
  <button class="btn btn-block btn-danger" style="text-align:left;width:360px;font-size: 12px;margin: 0px 8px 8px 8px;"><i class="fas fa-exclamation-triangle" ></i>&nbsp;&nbsp;BAC D'ATTENTE</button>
  
	<table class="table table-hover" id="bbundle">
		<tbody style="display:block; max-height:137px; overflow:auto">		
		</tbody>
	</table>
</div>