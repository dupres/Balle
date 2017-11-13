// Initialisation des variables
var balle = $("<div/>");
var v_down = 1;
var v_right = 10;
var p_top = 10;
var p_left = 10;
var rebond_ratio = 2/3;
var apesenteur = 7/4;
var interval;
var mouse_begin_x;
var mouse_begin_y;
var mouse_end_x;
var mouse_end_y;
var change = false;


var max_right = 500;
var max_bot = 500;


$(document).ready(function(){
	//Redéfinition de la grandeur de la page
	max_right = $(window).width();
	max_bot = $(window).height();

	//On définni le css de notre balle
	balle.attr("id","balle")
		.css({
			"width" : "50px",
			"height" : "50px",
			"background-color" : "blue",
			"border-radius" : "50%",
			"position" : "absolute",
			"top" : p_top+'px',
			"left" : p_left+'px',
			"transition" : "all 0.001s" // ça fait moins mal aux yeux
		});
	// On ajoute la balle au body (ne pas oublié de set le body et le HTML à width=100%)
	$("body").append(balle);

	//Si on commence à cliquer on prend les positions de la souris et on attend la fin du click et on bloque la balle
	balle.mousedown(function(event){
		mouse_begin_x = event.pageX;
		mouse_begin_y = event.pageY;
		balle.css({
			"background-color" : "red"
		});
		change = true;
	});

	//Si on fini de clicker
	$("body").mouseup(function(event){
		//Si on avait cliquer sur la balle on change les vitesses avec celle de la souris
		if(change){
			mouse_end_x = event.pageX;
			mouse_end_y = event.pageY;
			v_down =  mouse_end_y - mouse_begin_y;
			v_right = mouse_end_x - mouse_begin_x;

			balle.css({
				"background-color" : "blue"
			});
			change = false;
		}
	});



	interval = setInterval(function(){
		//On bouge la balle toutes les 30ms
		move();
	},30);

});



function move(){
	//Si on ne change pas la vitesse de la balle
	if(!change){
	    //On redéfinit la taille de la fenêtre 
		max_right = $(window).width();
		max_bot = $(window).height();

		//La position de la balle est augmentée par celle de la vitesse
		p_top = p_top + v_down;
		p_left = p_left + v_right;

		//On change la vitesse pour que la balle soit attiré vers le bas
		// Si la balle est trop basse et que son rebond est faible, on stoppe les rebonds
		if(v_down <= 1 && v_down >= -1 && p_top >= ($(window).height() - 52) ){
			v_down = 0;
			p_top = $(window).height() - 50;

			// On fraine la balle quand elle est au sol
			v_right = v_right * 42/43; // Parce que c'est joli
		}else{
			v_down = v_down + apesenteur;
		}


		// Ci-dessous les rebond_ratio servent à ralentir la balle au fur et à mesure de ses rebonds

		//Si on est tout en bas on fait rebondir la balle
		if(p_top + v_down + 50 > max_bot){
			v_down = - v_down * rebond_ratio;
			p_top = $(window).height() - 50;
		}

		//Si on est tout à droite on fait rebondir la balle
		if(p_left + v_right + 50 > max_right){
			v_right = - v_right * rebond_ratio;
			p_left = $(window).width() - 50;
		}

		//Si on est tout en haut on fait rebondir encore
		if(p_top + v_down < 0){
			v_down = - v_down * rebond_ratio;
			p_top = 0;
		}

		//Si on est tout à gauche on rebondit aussi
		if(p_left + v_right < 0){
			v_right = - v_right * rebond_ratio;
			p_left = 0;
		}

		//On change la position au niveau du css
		balle.css({
			"top" : p_top+'px',
			"left" : p_left+'px'
		});
	}
}
