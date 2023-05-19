<?php  
                session_start();
                // echo print_r($_SESSION);
 ?>
<html>
    <head>
<title>publishing  </title>
<link rel="stylesheet" href="style.CSS">
</head>
    <body>
        <div class="header_publish post_header">
         <div class="publish_top_header">
            <img src="./img/logo_black_and_white.png" alt="" class="publish_photo_logo" onclick="location.href='post.php'">
         </div> 
        
         </div>
         <form action="post.php" method="POST" class="main_publish">

          <div  class="div_Publish">
            <button name="pub" class="button_publish" > Publish</button>   
        </div>
       
            
             
            <div  class="titles" > 
               <input type="text" name="title" placeholder="Title" class="title_input" required>
            </div>
         
            <div  class="text" >
               <textarea name="text"class="text_input" cols="30" rows="40" required></textarea>
            </div>
         </form>
            
    </body>
</html> 