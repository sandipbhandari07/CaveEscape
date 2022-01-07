<!DOCTYPE html>
<html>
<head>
	<title>cave escape</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="css/medium.css">
    
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Reggae+One&display=swap" rel="stylesheet">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
  <link href='https://fonts.googleapis.com/css?family=Permanent Marker' rel='stylesheet'>

    <style>
        #div1 {
  font-size:48px; }
     @keyframes mymove {
    50% {box-shadow: 10px 20px 30px blue;} }
     h3{ font-family:'Permanent Marker'; }
    body{
      background-color: black;
    }
    </style>
    <style>
    .info{
        width: 290px;
        background:#474646 ;
        position: absolute;
        right: 5%;
        top: 37%;
        border-radius: 10px;
        
    }
    .info fieldset{
        color: white;
        border: transparent;
        font-size: 23px;
        
    } 
    </style>




</head>
<body>
    <!--nav bar-->
    <header>
    <div class="navbar">
                <ul>
                    <a href="main.html"><li class="active" id="logo">CAVE ESCAPE</li></a>
                    <a href="main.html"><li class="home" id="home">Game</li></a>
                    <a href="scoreboard.html"><li class="scoreboard" id="scoreboard">Leaderboard</li></a>     
            </ul>                           
     </div>
     </header>
     <!--nav bar-->

     <!-- inner part-->
     <div class="info">
        <fieldset>
            <h2 style="font-size: 23px; padding-left: 10px;">Difficulty: Medium</h2>
           
            
        </fieldset>
       </div>
     
     <div class="tet">
     <fieldset style="padding-left: 10px; padding-right: 10px;">
         <h1 id="cev">Cave Escape</h1>
         <p>
            Play cave escape here online for free. 
            Click on the screen, or use your spacebar to get started. 
            Fly the bird as far as you can without hitting a pipe.
    
         </p>
         
     </fieldset>
    </div>
    <!-- inner part-->
    <!-- ingame-->
    <canvas id="mycanvas" width="320" height="480"></canvas>
    <script src="js/cavegame.js"></script>



    <div class="container">
        <h1><b><div id="div1" class="fa">
        </div></b></h1>
   <canvas id="myCanvas" width=600 height=480 
    style="background:url('images/flappyback.jpg');  background-size: 100%; height: 90%; position: absolute; top: 10%;">
   </canvas>
     </div>
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
           ctx.font= "30px 'Reggae One', cursive";
           ctx.fillStyle= "white";
           ctx.textAlign="center";
           ctx.fillText("WELCOME TO CAVE ESCAPE", myCanvas.width / 2, myCanvas.height / 4);
           ctx.font = "18px 'Reggae One', cursive";
           ctx.fillText("Press up or down arrow to start",myCanvas.width / 1.35, 250); 
           var score = 0;                                                       
           ctx.font= "30px 'Reggae One', cursive";
           ctx.fillStyle= "white";
           ctx.textAlign="center";
           ctx.fillText("HighScore: " + score, myCanvas.width / 4.50, 390);  
           ctx.font= "20px 'Reggae One', cursive";
           }
           function showscorewhileplaying(){
                 var score = 0;
                       for (var i=0; i < pipes.length; i++)
                           if (pipes[i].x < bird.x) 
                           score = score + 0.5 
                       ctx.font= "30px 'Reggae One', cursive";
                       ctx.fillStyle= "white";
                       ctx.textAlign="center";
                       ctx.fillText("Score: " + score, myCanvas.width / 4.50, 390);
                        }
        function display_game_over () {
           var score = 0;                                             
           for (var i=0; i < pipes.length; i++) 
                if (pipes[i].x < bird.x) score = score + 0.5         
           ctx.font= "30px 'Reggae One', cursive";
           ctx.fillStyle= "white";
           ctx.textAlign="center";
           ctx.fillText("Wanna Try again ?", myCanvas.width / 2, 100);  
           ctx.fillText("Score: " + score, myCanvas.width / 2, 150);  
           ctx.font= "20px 'Reggae One', cursive";
           ctx.fillText("Press up or down arrow to try again", myCanvas.width / 2, 300);
           ctx.fillText("click here add to leaderboard", myCanvas.width / 2, 350); 

           //use of ajax
           // Create our XMLHttpRequest object
           var hr = new XMLHttpRequest();
           // Create some variables we need to send to our PHP file
           var url = "save.php";
           var myscore = +score;
           var vars = "firstname="+fn+"&lastname="+ln;
           hr.open("POST", url, true);
           hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
           // Access the onreadystatechange event for the XMLHttpRequest object
           hr.onreadystatechange = function() {
            if(hr.readyState == 4 && hr.status == 200) {
                var return_data = hr.responseText;
                document.getElementById("status").innerHTML = return_data;
            }
            }
            // Send the data to PHP now... and wait for response to update the status div
            hr.send(myscore); // Actually execute the request
            document.getElementById("status").innerHTML = "processing..."; 
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
            add_pipe(500,  120, 170);
            add_pipe(800,  200, 180);
            add_pipe(1100, 250, 140);
            add_pipe(1400, 150, 170);
            add_pipe(1700, 100, 150);
            add_pipe(2000, 150, 140);
            add_pipe(2300, 200, 120);
            add_pipe(2500, 250, 120);
            add_pipe(2800,  30, 100);
            add_pipe(3000, 300, 100);
            add_pipe(3300, 100,  80);
            add_pipe(3600, 250,  80);
            add_pipe(3900,  50,  60);
            add_pipe(4200,  50,  140);
            add_pipe(4500, 200, 120);
            add_pipe(4800, 150, 120);
            add_pipe(5000, 100, 150);
            var finish_line = new MySprite("http://s2js.com/img/etc/flappyend.png");
            finish_line.x = 5300;
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
        
         var bird = new MySprite("images/flappybird1.png");
        
         bird.x = myCanvas.width / 3;
         bird.y = myCanvas.height / 2;
        
         setInterval(Do_a_Frame, 1000/FPS);                            
         </script>  
  

</body>
</html>