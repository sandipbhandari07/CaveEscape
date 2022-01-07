<html>
<head>
 <title>Cave Escape</title>
   <meta charset="utf-8">
   <link rel="stylesheet" type="text/css" href="css/caveescape.css">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <style>
    body{
        margin: 0;
        padding: 0;
        font-family: sans-serif;
        background:#2E2D2D;
        
    }
    header{
        width: auto;
        height: auto;
        background: #3E3E3E;
    }
    
    /* nav bar */
    .navbar ul{
        display: inline-flex;
        margin: 10px;
       
    }
    .navbar ul a{
        text-decoration: none;
        letter-spacing: 1px;
        font-size: 23px;
    }
    .navbar ul li{
       list-style: none;
       cursor: pointer;
       margin: 0px 20px;
       color: white;
       margin: 0px 20px;
       padding-top: 9px;
    
      
       
    }
    #logo{
        letter-spacing: 5px;
        font-size: 30px;
        
    }
    #level{
        display: flex;
        position: absolute;
        top: 2%;
        right: 10%;
        color: white;
    }
    
    .active{
        
        color: lightskyblue !important;
    }
    #home:hover{
        color: lightskyblue;
    }
    #scoreboard:hover{
        color: lightskyblue;
    }
    /* nav bar */
    /*innerpart */
    
    
    .tet{
        position: absolute;
        right: 5%;
        top: 62%;
        color: white;
    }
    .tet fieldset{
        width: 350px;
        background:#474646 ;
        border: transparent;
        border-radius: 10px;
    }
    #cev{
        text-align: center;
        letter-spacing: 2px;
    }
    .tet p{
        text-align: center;
        letter-spacing: 1px;
    }
    .info fieldset {
        color: white;
        background: #474646;
        position: absolute;
        top: 45%;
        right: 6.5%;
        border: transparent;
        border-radius: 10px;
    }

    #eas:hover{
        background: white;
        color: black;
    }
    #ced:hover{
        background: white;
        color: black;
    }
    

    /*innerpart */

    </style>

 </head>
 
 <body>

     <!--nav bar-->
     <header>
        <div class="navbar">
                    <ul>
                        <a href="/caveescapemain.html"><li class="active" id="logo">CAVE ESCAPE</li></a>
                        <a href="/singleplayer/single.html"><li class="home" id="home">Home</li></a>
                        <a href="/about.html"><li class="scoreboard" id="scoreboard">About</li></a>     
                </ul>                           
         </div>
         </header>
         <!--nav bar-->
    
         <!-- inner part-->
         <div class="info" >
            <fieldset id="eas">
                <h2 style="font-size: 23px; padding-left: 15px; letter-spacing: 4PX; " >DIFFICULTY = Easy</h2>
               
                
            </fieldset>
           </div>
         
         <div class="tet">
         <fieldset style="padding-left: 10px; padding-right: 10px;" id="ced">
             <h1 id="cev">Cave Escape</h1>
             <p>
                Play cave escape here online for free. 
                Click on the screen, or use your spacebar to get started. 
                Fly the bird as far as you can without hitting a pipe.
        
             </p>
             
         </fieldset>
        </div>
        <!-- ingame-->




  <div class="container">
     <h1><b><div id="div1" class="fa">
     </div></b></h1>
<canvas id="myCanvas" width=600 height=600 
 style="background:url('images/flappyback.jpg'); border: 2px solid black; position: absolute; top: 55%; left: 35%; transform: translate(-50%,-50%);">
</canvas>
  </div>
  <canvas id="canvas1"></canvas>

 
 
<script> 
function myFunction(x) {
    x.classList.toggle("fa-thumbs-down");
}
// ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
//
 var ctx = myCanvas.getContext("2d"); 
 var FPS = 40;                  
 var jump_amount = -10;              
 var max_fall_speed= +10;             
 var acceleration = 1;          
 var pipe_speed = -2;                
 var game_mode = 'prestart';          
 var time_game_last_running;        
 var bottom_bar_offset = 0;         
 var pipes = [];   
 const APPLAUSE = new Audio();
 APPLAUSE.src = "audio/applause2.wav"
 const FLAP = new Audio();
 FLAP.src = "audio/sfx_flap.wav";
 const DIE = new Audio();
 DIE.src = "audio/sfx_die.wav";
 const HIT = new Audio();
 HIT.src = "audio/sfx_hit.wav";
 const SCORE_S = new Audio();
SCORE_S.src = "audio/sfx_point.wav";
 const SWOOSHING = new Audio();
SWOOSHING.src = "audio/sfx_swooshing.wav";



 function MySprite (img_url) {
    this.x = 0;
    this.y = 0; 
    this.visible= true;
    this.velocity_x = 0;
    this.velocity_y = 0;
    this.MyImg = new Image();
    this.MyImg.src = img_url || '';
    this.angle = 0;                                 
    this.flipV = false;             
    this.flipH = false;                              
    }
 MySprite.prototype.Do_Frame_Things = function() {
    ctx.save();
    ctx.translate(this.x + this.MyImg.width/2, this.y + this.MyImg.height/2);
    ctx.rotate(this.angle * Math.PI / 180);                       
    if (this.flipV) ctx.scale(1,-1);                              
    if (this.flipH) ctx.scale(-1,1);
   if (this.visible) ctx.drawImage(this.MyImg, -this.MyImg.width/2, -this.MyImg.height/2);
    this.x = this.x + this.velocity_x;
    this.y = this.y + this.velocity_y;                            
    ctx.restore();                                               
    }
 function ImagesTouching(thing1, thing2) {
     if (!thing1.visible  || !thing2.visible) return false;         
     if (thing1.x >= thing2.x + thing2.MyImg.width || thing1.x + thing1.MyImg.width <= thing2.x) return false;  
     if (thing1.y >= thing2.y + thing2.MyImg.height || thing1.y + thing1.MyImg.height <= thing2.y) return false;
     return true;                                                                                            
     }
function Got_Player_Input(MyEvent) {
   switch (game_mode) {
      case 'prestart': {
                        game_mode = 'running';
                        break;
                        } 
      case 'running': {
                        bird.velocity_y = jump_amount;
                        break;
                        } 
      case 'over': if (new Date() - time_game_last_running > 1000) {
                    reset_game();
                    game_mode = 'running';
                    break;
                    } 
       } 
   MyEvent.preventDefault();
   }
 addEventListener("touchstart", Got_Player_Input);     
 addEventListener("keyup", Got_Player_Input);     
 addEventListener("keydown", Got_Player_Input);     
function make_bird_slow_and_fall() {
    if (bird.velocity_y < max_fall_speed) {
         bird.velocity_y = bird.velocity_y + acceleration; 
         }  
    if (bird.y > myCanvas.height - bird.MyImg.height)  {      
         bird.velocity_y = 0; 
         game_mode = 'over';
         }
    }
function add_pipe(x_pos, top_of_gap, gap_width) {             
    var top_pipe = new MySprite();
    top_pipe.MyImg = pipe_piece;                              
    top_pipe.x = x_pos;                                       
    top_pipe.y = top_of_gap - pipe_piece.height;              
    top_pipe.velocity_x = pipe_speed;            
    pipes.push(top_pipe);         
    var bottom_pipe = new MySprite();
    bottom_pipe.MyImg = pipe_piece;
    bottom_pipe.flipV = true;                                
    bottom_pipe.x = x_pos;
    bottom_pipe.y = top_of_gap + gap_width;
    bottom_pipe.velocity_x = pipe_speed;
    pipes.push(bottom_pipe );
    }
function make_bird_tilt_appropriately() {
    if (bird.velocity_y < 0)  {
                 bird.angle= -15; 
                 FLAP.play();                  
                 }
       else if (bird.angle < 70) {                   
                 bird.angle = bird.angle + 4;       
                 }
    }
function show_the_pipes() {                          
    for (var i=0; i < pipes.length; i++) {
             pipes[i].Do_Frame_Things(); 
             }
    }
function check_for_end_game() {
   for (var i=0; i < pipes.length; i++) 
     if (ImagesTouching(bird, pipes[i])) game_mode = "over";  
   }
function display_intro_instructions () {
   ctx.font= "40px 'Reggae One', cursive";
   ctx.fillStyle= "white";
   ctx.textAlign="center";
   ctx.fillText("WELCOME TO CAVE ESCAPE", myCanvas.width / 2, myCanvas.height / 4);
   ctx.font = "20px 'Reggae One', cursive";
   ctx.fillText("Press up or down arrow to start",myCanvas.width / 2.95, 390); 
   var score = 0;                                                       
   ctx.font= "30px 'Reggae One', cursive";
   ctx.fillStyle= "white";
   ctx.textAlign="center";
     
   ctx.font= "20px 'Reggae One', cursive";
   }
   function showscorewhileplaying(){
        
               ctx.font= "30px 'Reggae One', cursive";
               ctx.fillStyle= "white";
               ctx.textAlign="center";
               ctx.fillText("Level 1 " , myCanvas.width / 4.50, 520);
                }
function display_game_over () {
         
   ctx.font= "55px 'Reggae One', cursive";
   ctx.fillStyle= "white";
   ctx.textAlign="center";
   ctx.fillText("You didn't escape ", myCanvas.width / 2, 240);  
   ctx.font= "20px 'Reggae One', cursive";
   ctx.fillText("Press up or down arrow to restart level", myCanvas.width / 2, 330);

   
    }

    let gamespeed = 1;
    const particlesArray = [];

class Particle{
    constructor(){
        this.x = bird.x;
        this.y = bird.y;
        this.size = Math.random() * 7 + 3;
        this.speedY = (Math.random() * 1) - 0.5;
        this.color = 'hsla(' + hue + ',100%, 50%, 0.8)';
    }
    update(){
        this.x -= gamespeed;
        this.y += this.speedY;
    }
    draw(){
        ctx.fillStyle = this.color;
        ctx.beginPath();
        ctx.arc(this.x,this.y,this.size, 0, Math.PI * 2);
        ctx.fill();
    }
}

function handleParticles(){
    particlesArray.unshift(new Particle);
    for(i=0; i<particlesArray.length; i++){
        particlesArray[i].update();
        particlesArray[i].draw();
    }
    //if more than 200, remove 20
    if (particlesArray.length > 200){
        for(let i=0; i<20; i++){
            particlesArray.pop(particlesArray[i]);
        }
    }
}





function display_bar_running_along_bottom() {
     if (bottom_bar_offset < -23) bottom_bar_offset = 0;
     ctx.drawImage(bottom_bar, bottom_bar_offset, myCanvas.height - bottom_bar.height);
     }

     
function reset_game() {
      bird.y = myCanvas.height / 2;
      bird.angle= 0;
      pipes=[];                         // erase all the pipes from the array
      add_all_my_pipes();                 // and load them back in their starting positions 
      SCORE_S.play();   
      }
function add_all_my_pipes() {
             add_pipe(500,  90, 290);
            add_pipe(500,  90, 250);
            add_pipe(800,  50, 270);
            add_pipe(1100, 130, 230);
            add_pipe(1400, 90, 250);
            add_pipe(1700, 50, 270);
            add_pipe(2000, 20, 280);
            add_pipe(2300, 90, 250);
            add_pipe(2500, 50, 270);
            add_pipe(2850,  20, 280);
            add_pipe(3000, 90, 250);
            add_pipe(3300, 50,  270);
            add_pipe(3600, 90,  250);
            add_pipe(3900,  20,  280);
            add_pipe(4200,  50,  270);
            add_pipe(4500, 90, 250);
            add_pipe(4800, 130, 230);
            add_pipe(5000, 50, 270);
    var finish_line = new MySprite("http://s2js.com/img/etc/flappyend.png");
    finish_line.x = 5200;
    finish_line.velocity_x = pipe_speed;
    pipes.push(finish_line);
    }
 var pipe_piece = new Image();
 pipe_piece.onload = add_all_my_pipes;                       
 pipe_piece.src = "images/flappypipe.png" ;
function Do_a_Frame () {
    ctx.clearRect(0, 0, myCanvas.width, myCanvas.height);   
    bird.Do_Frame_Things(); 
    display_bar_running_along_bottom();
    switch (game_mode) {
        case 'prestart': {
                          display_intro_instructions();                 
                          break;
                          } 
        case 'running': {
                         time_game_last_running = new Date(); 
                         bottom_bar_offset = bottom_bar_offset + pipe_speed; 
                         showscorewhileplaying();
                         show_the_pipes();
                         make_bird_tilt_appropriately();
                         make_bird_slow_and_fall();
                         check_for_end_game();                 
                         break;
                         }
        case 'over': {
                      make_bird_slow_and_fall();
                      display_game_over();
                      break;
                      } 
        } 
    }
 var bottom_bar = new Image();
 bottom_bar.src = "images/flappybottom.png" ;

 var bird = new MySprite("images/gg.png");

 bird.x = myCanvas.width / 5;
 bird.y = myCanvas.height / 2.2;


 

 setInterval(Do_a_Frame, 1000/FPS);                            
 </script>  
</body>
</html>