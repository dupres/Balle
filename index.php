<html style="width:100%">
<head>

<script
  src="https://code.jquery.com/jquery-3.2.1.js"
  integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="
  crossorigin="anonymous"></script>

</head>

<body style="width:100%"> 
    <select id="select">
        <option value="1">Normal</option>
        <option value="2">Bambi</option>
        <option value="3">Sonic</option>
        <option value="4">Basket</option>
        <option value="5">Metroid</option>
        <option value="6">IE</option>
    </select>
</body>

<style>
    body{
        background-size: cover;
    }
</style>

<script>
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
                        "background-size" : "cover",
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
                        "background-color" : balle.css("background-color")
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
                                "background-color" : balle.css("background-color")
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
                if(v_down <= 1 && v_down >= -1 && p_top >= ($(window).height() - 53) ){
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

$('#select').on('change', function() {
    switch (this.value){
        case '1':
            $("body").css("background-image","src('')");
            $("#balle").css("background-image","src('')")
                .css("background-color","black");
            break;
        case '2':
            $("body").css("background-image","url('bg_2.jpeg')");
            $("#balle").css("background-image","url('balle_2.jpg')")
                .css("background-color","rgba(0,0,0,0)");
            break;
        case '3':
            $("body").css("background-image","url('bg_3.png')");
            $("#balle").css("background-image","url('balle_3.gif')")
                .css("background-color","rgba(0,0,0,0)");
            break;
        case '4':
            $("body").css("background-image","url('bg_4.jpg')");
            $("#balle").css("background-image","url('balle_4.gif')")
                .css("background-color","rgba(0,0,0,0)");
            break;
        case '5':
            $("body").css("background-image","url('bg_2.jpeg')");
            $("#balle").css("background-image","url('balle_2.jpg')");
            break;
        case '6':
            $("body").css("background-image","url('bg_2.jpeg')");
            $("#balle").css("background-image","url('balle_2.jpg')");
            break;
    }
    
})

</script>