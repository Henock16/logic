//Vérification si nombre est entier
function isInt(n){
   return n % 1 === 0;
}

//Vérification de la validité de l'adresse email
function isValidEmailAddress(emailAddress){
	
    var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
    return pattern.test(emailAddress);
}

//Détermination du type de produit
function checkProd(numpklist){
	
	var bool = true;
    var i = "";
	var j = 0;
    var pos = numpklist.length - 1;
    
    while(bool){
        
        i = numpklist.charAt(pos).concat(i) ;        
        if(isInt(i)){			
            pos = pos - 1 ;
        }
        else{			
            j = numpklist.charAt(pos);
            bool = false ;
        }
    }
	return j ;
}

//Apparition du loader
function showLoader(){
	
	var loadstat = $('.loader').css('display') ;	
	if(loadstat == 'none'){		
		$('.loader').fadeIn(0);
	}
}
//Disparition du loader
function hideLoader(){
	
	var loadstat = $('.loader').css('display') ;	
	if(loadstat == 'block'){		
		$('.loader').fadeOut(500);
	}
}

//notification
function notification(text1,text2,classtoadd){
	
	$('#message1').text(text1);
	$('#message2').text(text2);	
	
	var tab = ['alert-warning','alert-success','alert-danger'];	
	for(var i = 0; i < 3; i++){
		
		if(tab[i] == classtoadd){			
			$('#notification').addClass(classtoadd);
		}
		else{			
			$('#notification').removeClass(tab[i]);
		}	
	}
	$('#notification').delay(800).slideDown(300,'linear').delay(3500).slideUp(300,'linear');
}

//Chargement de la liste déroulante des produits
function getSelectProduit(select){
	
	$.ajax({
		
		url : './models/Admin_selectProd.php',
		type : 'POST',
		data : '',
		dataType : 'json',
		success : function(data){

			var option = '<option selected disabled>------------ Produit ------------</option>',
				j = 1
			;			
			for(var i = 0; i < data[0]; i++){
				
				option +='<option value="'+data[(i+j)]+'">'+data[(i+(j+1))]+'</option>';
				j+=1;
			}
			$(select).html(option);			
		}
	});
}

//Chargement de la liste déroulante des campagnes
function updateCamp(){

	$('#camp_Addexpor').html('');
	var idprod = $('#prod_Addexpor').val() ;
	
	$.ajax({
		
		url : './models/Admin_selectCamp.php',
		type : 'POST',
		data : 'idprod='+idprod,
		dataType : 'json',
		success : function(data){

			var option = '<option selected disabled>--------- Campagne ---------</option>',
				j = 1
			;			
			for(var i = 0; i < data[0]; i++){				
				option += '<option value="'+data[(i+j)]+'">'+data[(i+(j+1))]+'</option>';
				j += 1;
			}
			$('#camp_Addexpor').html(option);
		}
	});
}

//Chargement de la liste déroulante des campagnes pour l'exportateur
function updateExpCamp(){
	
	$('#camp_Updexpor').val() = '';
	var idprod = $('#prod_Updexpor').val() ;
	
	$.ajax({
		
		url : './models/Admin_selectCamp.php',
		type : 'POST',
		data : 'idprod='+idprod,
		dataType : 'json',
		success : function(data){

			var option = '<option selected disabled>Campagne</option>',
				j = 1
			;			
			for(var i = 0; i < data[0]; i++){				
				option += '<option value="'+data[(i+j)]+'">'+data[(i+(j+1))]+'</option>';
				j += 1;
			}
			$('#camp_Updexpor').html(option);
		}
	});
}

//Chargement de la liste des villes
function getTown(){
	
	$.ajax({
		
		url : './models/Admin_selectVille.php',
		type : 'POST',
		data : '',
		dataType : 'json',
		success : function(data){

			var option = '<option selected disabled>------------------ Ville ------------------</option>',
				j = 1
			;			
			for(var i = 0; i < data[0]; i++){
				
				option += '<option value="'+data[(i+j)]+'">'+data[(i+(j+1))]+'</option>';
				j += 1;
			}
			$('#user-town').html(option);
		}
	});
}

//Chargement de la liste des cellules
function getWorkplace(){
	
	$.ajax({
		
		url : './models/Admin_selectPoste.php',
		type : 'POST',
		data : '',
		dataType : 'json',
		success : function(data){

			var option = '<option selected disabled>---------------- Cellule ----------------</option>',
				j = 1
			;			
			for(var i = 0; i < data[0]; i++){
				
				option += '<option value="'+data[(i+j)]+'">'+data[(i+(j+1))]+'</option>';
				j += 1;
			}
			$('#user-cel').html(option);
		}
	});
}

//Changement d'onglet pour navigation menu
function showMenu(button, menu){
	
	$('.nav-button').parent('li').removeClass('active');
	$(button).parent('li').addClass('active');
	
	$('.nav-menu').fadeOut(0);
	$(menu).fadeIn(400,'swing');
}

//Début gestion des onglets
$('#interface-button').on('click', function(){	
	showMenu('#interface-button', '#INTERFACE');
});
$('#matching-button').on('click', function(){
	showMenu('#matching-button', '#MATCHING');
});
$('#control-button').on('click', function(){
	showMenu('#control-button', '#CONTROLE');
});
$('#incident-button').on('click', function(){
	showMenu('#incident-button', '#INCIDENT');
});
$('#user-button').on('click', function(){
	showMenu('#user-button', '#USER');
});
$('#archive-button').on('click', function(){
	showMenu('#archive-button', '#ARCHIVE');
});
$('#profil-button').on('click', function(){
	showMenu('#profil-button', '#PROFIL');
});
//Fin gestion des onglets

//Verrouillage de l'écran
$('#locked').on('click', function(){	
	$('.lockscreen').slideDown(1000,'swing');
});

//Déverrouillage de l'espace de travail
$('#locked-form').on('submit', function(event){
	
	event.preventDefault();
	var pass = $('input[name=pwdlocked]').val();
	
	$.ajax({
		
		url : './models/User_lockSession.php',
		type : 'POST',
		data : 'pass='+pass,
		dataType : 'json',
		success : function(data){
			
			if(data[0] == 0){
				$('input[name=pwdlocked]').css('border', '1px solid red');
			}
			else{
				$('input[name=pwdlocked]').css('border', '0px solid red');
				$('.lockscreen').slideUp(1000,'swing');
			}
			$('#pwdlocked').val('');
		}
	});
});

//Rotation du logo
var AnimatedLogo = setInterval(function(){
	
	var elem = $(".cube");
    $({deg: 0}).animate({deg: 1800}, {
		
        duration: 2000,
        step: function(now){			
            elem.css({				
                transform: "rotate(" + now + "deg)"
            });
        }
    });
}, 10000);