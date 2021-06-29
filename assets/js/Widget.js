//Ouverture d'une fenetre
function openNav(type){
	
    if(type == 1){
		
		document.getElementById("waitingBundle").style.width = "400px";
	}
	else if(type == 2){
		
		document.getElementById("waitingSlip").style.width = "400px";
	}
	else if(type == 3){
		
		document.getElementById("blockedBundle").style.width = "400px";
	}
}

//fermeture d'une fenetre
function closeNav(type){
	
    if(type == 1){
		
		document.getElementById("waitingBundle").style.width = "0px";
	}
	else if(type == 2){
		
		document.getElementById("waitingSlip").style.width = "0px";
	}
	else if(type == 3){
		
		document.getElementById("blockedBundle").style.width = "0px";
	}
}