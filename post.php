<?php  
session_start();
$postBy=$_SESSION['userName'];
include("db_connect.php");

if(!isset($postBy)){
    header("location:index.php");

}

if(isset($_POST['pub']))
    {
        $title=$_POST['title'];
        $text=$_POST['text'];
        $text=htmlspecialchars($text);

        $query=$connected->prepare("INSERT INTO article(postBY,title,text,Date_create)
        VALUES('$postBy','$title','$text',current_timestamp() )");
        $query->execute();
    }


    
if(isset($_POST['suprimer']))
{
    $getID=$_POST['suprimer'];
    $query=$connected->prepare("DELETE FROM article WHERE IDA= :id");
    $query->bindParam("id",$getID);
    $query->execute();
}

// Retrieve data from AJAX request
if(isset($_POST['action'])){
$itemID = $_POST['item_id'];
$action = $_POST['action'];
// Update the like or dislike count based on the action
if ($action === 'like') {
    $sql =$connected->prepare("UPDATE article SET nbr_likes = nbr_likes + 1 WHERE IDA =:ida");
    $sql->bindParam(":ida",$itemID);
    $sql->execute();
  } elseif ($action === 'dislike') {
    $sql =$connected->prepare("UPDATE article SET nbr_dislike = nbr_dislike + 1 WHERE IDA =:ida");
    $sql->bindParam(":ida",$itemID);
    $sql->execute();  }
}
?>

<!-- -------------------------------------------------------------------------------------------------------------------------  -->
<html>
<head>
    <title>Articles</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />  
    <link rel="stylesheet" href="./style.css">
    <link rel="shortcut icon" href="./img/logo_black_and_white.png" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;500;600;700;800;900;1000&display=swap" rel="stylesheet">
</head>
<body>
    <!-- --------------------------------------Post_header-------------------------------------------------------- -->
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

    <!-- -------------------------------------------Post_main--------------------------------------------------------------------- -->
    <div class="post_main">

        <div class="post_left_main"> 
                
                <button class="article" onclick="location.href='publish.php'"><b>CREATE A NEW ARTICLE</b> </button>
        </div>

        <div class="post_right_main">
        <?php 
        $query=$connected->prepare("SELECT * FROM article WHERE postBY= :By");
        $query->bindParam("By",$postBy) ;
        $query->execute();
        $query->errorInfo();
        foreach($query as $var)
        {
            $user=$var['postBY'];
            $user_char=strtoupper($user[0]);
            $user_likes=$var['nbr_likes'];
            $user_dislikes=$var['nbr_dislike'];
            $articleId=$var["IDA"];
            $post = '<div class="div_post">
            <div class="reaction">
                <div class="like">
                    <p id="jaime'.$articleId.'">'.$user_likes.'</p>
                    <button id="click'.$articleId.'" onclick="Like(this)" class="click1">
                        <span class="material-symbols-outlined arrow_modifie">
                            arrow_drop_up
                        </span>
                    </button>
                </div>
                <div class="dislike">
                    <p id="Grr'.$articleId.'">'.$user_dislikes.'</p>
                    <button id="click'.$articleId.'" onclick="Dislike(this)" class="click2">
                        <span class="material-symbols-outlined arrow_modifie">
                            arrow_drop_down
                        </span>
                    </button>
                </div>
            </div>
            <div class="post">
                <div class="post_left">
                    <h1 class="maj">'.$user_char.'</h1>
                </div>
                <div class="post_right">
                    <div class="title_post">
                        <h3>'.$var['title'].'</h3>
                    </div>
                    <div class="text_post">'.$var['text'].'</div>
                    <div class="date_post">
                        <b class="date_style">Published •'.$var['Date_update'].'</b>
                        <a href="modify.php?edit='.$var['IDA'].'" class="post_modf" type="submit" name="edit">
                            <img src="./img/353430-checkbox-edit-pen-pencil_107516.png" alt="" class="image_modf image_modf2">
                        </a>
                        <form action="post.php" method="POST" class="post_sup">
                            <button name="suprimer" type="submit" class="post_sup" value="'.$var['IDA'].'">
                                <img src="./img/OIP.png" class="image_modf">
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>';
echo $post;
            }
        ?>
        </div>
    </div>  
</body>
<!-- include jQuery library -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
var clicked =false
    
function Like(ev) {
    // extraction article id from btn.id
    var id = ev.id;
    var number = parseInt(id.match(/\d+/)[0]);
    // get counter element
    var likeCounter = document.getElementById(`jaime${number}`);
    var currentValue = parseInt(likeCounter.textContent);
    
    if (clicked) {
        likeCounter.textContent = (currentValue - 1).toString();
        clicked=false
    } else {
        likeCounter.textContent = (currentValue+1).toString();
        clicked=true
    }
// send AJAX request to server for updating database record
    $.ajax({
        url: 'post.php',
        method: 'POST',
        data: { item_id: number, action: 'like' }, // Replace 'like' with the appropriate action value
        success: function(response) {
            console.log('Data saved successfully!');
        },
        error: function(error) {
            console.error('An error occurred:', error);
        }
    });


}


var clicked2=false

function Dislike(ev){
    var id = ev.id;
    var number = parseInt(id.match(/\d+/)[0]);

    var dislikeCounter = document.getElementById(`Grr${number}`);
    var currentValue = parseInt(dislikeCounter.textContent);

    if (clicked2) {
        dislikeCounter.textContent = (currentValue - 1).toString();
        clicked2=false
    } else {
        dislikeCounter.textContent = (currentValue+1).toString();
        clicked2=true
    }

    // send AJAX request to server for updating database record
    $.ajax({
        url: 'post.php',
        method: 'POST',
        data: { item_id: number, action: 'dislike' }, // Replace 'like' with the appropriate action value
        success: function(response) {
            console.log('Data saved successfully!');
        },
        error: function(error) {
            console.error('An error occurred:', error);
        }
    });
}
    
</script>

</html>