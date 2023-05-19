<?php
// include Data Base
include("db_connect.php");

// if you click ignore
  if(isset($_POST['ignore']))
  header("location:post.php");

?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Article:Modification</title>
    <link rel="stylesheet" href="./Style.CSS">
</head>

<body>
<div class="header_publish post_header">
         <div class="publish_top_header">
            <img src="./img/logo_black_and_white.png" alt="" class="publish_photo_logo" onclick="location.href='post.php'">
         </div> 
</div>

    <?php 
    //if ID of article is exist in parameter select info 
     if(isset( $_GET['edit'])){
        $getArticle = $connected->prepare("SELECT * FROM article WHERE IDA = :id");
        $getArticle->bindParam("id",$_GET['edit']);
        $getArticle->execute();
        
        foreach($getArticle AS $data)
        {
               echo' 
            <form  method="POST" class="main_Modify">

                <div  class="div_Modify">
                    <button name="upD" class="button_Modify" value="'.$data['IDA'].'" > Update</button>   
                    <button name="ignore" class="button_Modify" > Ignore</button>   
                </div>

                <div  class="titles" > 
                <input type="text" name="title" placeholder="Title" class="title_input" value="'.$data['title'].'">
                </div>
         

                <div  class="text" >
                <textarea name="text" class="text_input" cols="30" rows="40" >'.$data['text'].'</textarea>
                </div>

            </form>
         '; }} 

         if(isset($_POST['upD']))
         { 
             $text = $_POST['text'];
             $text=htmlspecialchars($text);
             $title = $_POST['title'];
             $id = $_POST['upD'];
         $query=$connected->prepare("UPDATE `article` SET text= :texxt, title= :titlee, Date_update=current_timestamp() 
         WHERE IDA= :id ");

         $query->bindParam("texxt",$text);
         $query->bindParam("titlee",$title);    
         $query->bindParam("id",$id); 
         if($query->execute())
         {   
         header("location:post.php");
         }}
       
         ?>
        
</body>
</html>