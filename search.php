<?php 
session_start();
include("db_connect.php");

$postBy=$_SESSION['userName'];
if(!isset($postBy)){
    header("location:index.php");
}
?>

<!-- -------------------------------------------------------------------------------------------------------- -->
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Style.CSS">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />  
    <title>Searcht</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;500;600;700;800;900;1000&display=swap" rel="stylesheet">
</head>
<body>
<div class="post_header">
           
           <div class="post_left_header">
               <img src="./img/logo_black_and_white.png" alt="" class="photo_logo" onclick="location.href='post.php'">
           </div>
         
           <form action="search.php" method="POST" class="post_center_header">
               <button  name="search_icon" class="material-symbols-outlined">
                   <svg  style="color: white" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search " viewBox="0 0 16 16" >
                       <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" fill="white"></path>
                   </svg>
               </button>  
               <input type="text" name="search" placeholder="Search for articles" class="search">
           </form>

           <form action="index.php" method="POST" class="post_right_header">
               <button class="logoout" name="logOut" > <b>Log out </b></button> 
           </form>

   </div>


<div class="main_search">
   <?php 
   if (isset($_POST['search']) ||(isset($_POST['search_icon']))){
        $title=$_POST['search'];
        $t=$title[0];
        $query=$connected->prepare("SELECT postBY,title,text,Date_update,nbr_likes,nbr_dislike FROM article WHERE title like '$t%'");
        $query->execute();
        $num=$query->rowCount();
        if($num>=1)
    {        foreach($query as $var)
        {
            $user=$var['postBY'];
            $user_char=strtoupper($user[0]);
            $user_likes=$var['nbr_likes'];
            $user_dislikes=$var['nbr_dislike'];
            echo '<div class="div_post">
            <div class="reaction">
                <div class="like">
            '.$user_likes.'
                <span class="material-symbols-outlined arrow_modifie">
                arrow_drop_up
                </span> </div>
                <div class="dislike">
                '.$user_dislikes.'
                <span class="material-symbols-outlined arrow_modifie">
                arrow_drop_down
                </span></div>
            </div>
                <div class ="post">
                    <div class ="post_left"> 
                    <h1 class="maj">'. $user_char.'</h1>
                    </div>
                <div class ="post_right">
                    <div class="title_post"> <h3>'.$var['title'].'</h1></div> 
                    <div class="text_post">'.$var['text'].'</div>
                    <div class="date_post"> <b class="date_style">Published •'.$var['Date_update'].'</b> </div>
                </div>
            </div>
        </div>';
        }}
        else
        echo'<h1> No articles </h1>';
}
   ?> 
</div>
</body>
</html>