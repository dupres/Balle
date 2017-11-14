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
        <option value="7">Pokemon</option>
        <option value="8">Pokemon 2</option>
        <option value="9">TMNT</option>
        <option value="10">DBZ</option>
        <option value="11">Spaaaace</option>
        <option value="12">Spaghetti</option>
        <option value="13">Greed</option>
        <option value="14">IUT</option>
        <option value="15">Cycle</option>
        <option value="16">Billard </option>
        <option value="17">Box</option>
        <option value="18">Tail star</option>
        <option value="19">Pen</option>
        <option value="20">Balloon</option>
    </select>

    <canvas id="canvas"/>
</body>

<style>
    body{
        background-size: cover;
    }
    #canvas{
        position:fixed;
        top:0;
        left:0;
        width:100%;
        height:100%;
        z-index:-1;
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

var context;
var canvas;

var canDraw = false;
var mode = 1;
$(document).ready(function(){
        //Redéfinition de la grandeur de la page
        max_right = $(window).width();
        max_bot = $(window).height();
        //On récupère le canvas
        canvas = $("#canvas");
        context = canvas.get(0).getContext("2d");
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
            event.preventDefault();
            mouse_begin_x = event.pageX;
            mouse_begin_y = event.pageY;
            balle.css({
                    "background-color" : balle.css("background-color")
            });
            change = true;
        });

        //Si on fini de clicker
        $("body").mouseup(function(event){
            event.preventDefault();
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

        context.canvas.width  = max_right;
        context.canvas.height = max_bot;
});

function move(){
        //Si on ne change pas la vitesse de la balle
        if(!change){
            //On redéfinit la taille de la fenêtre 
                max_right = $(window).width();
                max_bot = $(window).height();

                //------- Canvas draw -------------
                if (canDraw){
                    if (mode == 18){
                        context.canvas.width  = max_right;
                        context.canvas.height = max_bot;
                        context.moveTo(p_left+25,p_top+25);
                        context.lineTo(p_left+v_right*(-4)+25,p_top+v_down*(-4)+25);
                        context.stroke();
                    }
                    if (mode == 19){
                        

                        context.lineTo(p_left+v_right+25,p_top+v_down+25);
                        context.stroke();
                    }
                    
                }
                //---------------------------------

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
    mode = this.value;
    switch (this.value){
        case '1': //Normal
            $("body").css("background-image","none");
            $("#balle").css("background-image","none")
                .css("background-color","black");
                rebond_ratio = 2/3;
                apesenteur = 7/4;
                canDraw = false;
            break;
        case '2': //Bambi
            $("body").css("background-image","url('bg_2.jpeg')");
            $("#balle").css("background-image","url('balle_2.jpg')")
                .css("background-color","rgba(0,0,0,0)");
                rebond_ratio = 0.75;
                apesenteur = 7/4;
                canDraw = false;
            break;
        case '3': //Sonic
            $("body").css("background-image","url('bg_3.png')");
            $("#balle").css("background-image","url('balle_3.gif')")
                .css("background-color","rgba(0,0,0,0)");
                rebond_ratio = 2/3;
                apesenteur = 7/4;
                canDraw = false;
            break;
        case '4': //Basket
            $("body").css("background-image","url('bg_4.jpg')");
            $("#balle").css("background-image","url('balle_4.gif')")
                .css("background-color","rgba(0,0,0,0)");
                rebond_ratio = 0.955;
                apesenteur = 15;
                canDraw = false;
            break;
        case '5': //Metroid
            $("body").css("background-image","url('bg_5.png')");
            $("#balle").css("background-image","url('balle_5.gif-c200')");
                rebond_ratio = 2/3;
                apesenteur = 2.5;
                canDraw = false;
            break;
        case '6': //IE
            $("body").css("background-image","url('bg_6.jpg')");
            $("#balle").css("background-image","url('balle_6.png')");
                rebond_ratio = 2/3;
                apesenteur = -0.75;
                canDraw = false;
            break;
        case '7': //Pokemon
            $("body").css("background-image","url('bg_7.jpg')");
            $("#balle").css("background-image","url('balle_7.png')");
                rebond_ratio = 2/3;
                apesenteur = 7/4;
                canDraw = false;
            break;
        case '8': //Pokemon 2
            $("body").css("background-image","url('bg_8.jpg')");
            $("#balle").css("background-image","url('balle_8.png')")
                .css("background-color","rgba(0,0,0,0)");
                rebond_ratio = 2/3;
                apesenteur = 7/4;
                canDraw = false;
            break;
        case '9': //TMNT
            $("body").css("background-image","url('bg_9.jpg')");
            $("#balle").css("background-image","url('balle_9.jpg')")
                .css("background-color","rgba(0,0,0,0)");
                rebond_ratio = 2/3;
                apesenteur = 7/4;
                canDraw = false;
            break;
        case '10': //DBZ
            $("body").css("background-image","url('bg_10.jpg')");
            $("#balle").css("background-image","url('balle_10.png')")
                .css("background-color","rgba(0,0,0,0)");
                rebond_ratio = 2/3;
                apesenteur = 7/4;
                canDraw = false;
            break;
        case '11': //Spaaaace
            $("body").css("background-image","url('bg_11.jpg')");
            $("#balle").css("background-image","url('balle_11.jpg')")
                .css("background-color","rgba(0,0,0,0)");
                rebond_ratio = 1/3;
                apesenteur = 0;
                canDraw = false;
            break;
        case '12': //Spaghetti
            $("body").css("background-image","url('bg_12.jpg')");
            $("#balle").css("background-image","url('balle_12.png')")
                .css("background-color","rgba(0,0,0,0)");
                rebond_ratio = 2/3;
                apesenteur = 7/4;
                canDraw = false;
            break;
        case '13': //Greed
            $("body").css("background-image","url('bg_13.jpg')");
            $("#balle").css("background-image","url('balle_13.png')")
                .css("background-color","rgba(0,0,0,0)");
                rebond_ratio = 2/3;
                apesenteur = 7/4;
                canDraw = false;
            break;
        case '14': //IUT
            $("body").css("background-image","url('bg_14.jpg')");
            $("#balle").css("background-image","url('balle_14.png')")
                .css("background-color","rgba(0,0,0,0)");
                rebond_ratio = 2/3;
                apesenteur = 7/4;
                canDraw = false;
            break;
        case '15': //Wheel
            $("body").css("background-image","url('bg_15.jpg')");
            $("#balle").css("background-image","url('balle_15.gif')")
                .css("background-color","rgba(0,0,0,0)");
                rebond_ratio = 0;
                apesenteur = 0;
                canDraw = false;
            break;
        case '16': //Billard
            $("body").css("background-image","url('bg_16.png')");
            $("#balle").css("background-image","url('balle_16.png')")
                .css("background-color","rgba(0,0,0,0)");
                rebond_ratio = 1/3;
                apesenteur = 0;
                canDraw = false;
            break;
        case '17': //Bug
            $("body").css("background-image","url('bg_17.jpg')");
            $("#balle").css("background-image","url('balle_17.png')")
                .css("background-color","rgba(0,0,0,0)");
                rebond_ratio = 0;
                apesenteur = 0;
                canDraw = false;
            break;
        case '18': //Construct
            $("body").css("background-image","none");
            $("#balle").css("background-image","url('balle_18.png')")
                .css("background-color","rgba(0,0,0,0)");
                rebond_ratio = 1/3;
                apesenteur = 0;
                canDraw = true;
            break;
        case '19': //Pen
            $("body").css("background-image","none");
            $("#balle").css("background-image","none")
                .css("background-color","rgba(0,0,0,1)");
                rebond_ratio = 2/3;
                apesenteur = 7/4;
                canDraw = true;
            break;
        case '20': //Balloon
            $("body").css("background-image","url('bg_20.jpg')");
            $("#balle").css("background-image","url('balle_20.png')")
                .css("background-color","rgba(0,0,0,0)");
                rebond_ratio = 2/3;
                apesenteur = -0.75 ;
                canDraw = true;
            break;
    }
    

})

</script>