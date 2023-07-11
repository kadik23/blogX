<?php 
// include file to connect DB
include("db_connect.php");
   
// session_abort();

//log in and transition to post.php
if(isset($_POST['send']))
{
    $userName=$_POST['username'];
    $userpass=$_POST['password'] ;
    // check in username and pass on DB
    $query=$connected->prepare("SELECT * FROM user WHERE username= :name" );
    $query->bindParam("name",$userName);
    $query->execute();
    if($query->rowCount()==1)
    {       //if username are exist in db check if this compte is activated 
        foreach($query AS $var)
        { if ($var['ACTIVATED'] == true) {
            // comparaison between password hashed and password
            if (password_verify($userpass, $var['password'])) {
         //------------ Password is correct-------------------
                $randomByte = mt_rand();    // make random byte of new token
                // add new token in db
                $query = $connected->prepare("UPDATE user SET token = :token WHERE username = :username");
                $query->bindValue(':token', $randomByte);
                $query->bindParam(':username', $userName);
                $query->execute();
        
                // put username in session
                session_start();
                $_SESSION['userName']=$userName;

                 //save Token in cookies
                $exp=time()+(60*60*24*30);
                setcookie("token",$randomByte,$exp,'/');
                header("location:post.php");               
            }  
            else echo "<br> <h1>Password is incorrect<br> </h1>";  
            }
        }           
    }          
}

if(isset($_POST['logOut'])) 
{       
    session_start();
    session_unset();
    session_destroy(); 
    if(count($_COOKIE)>1) 
    {
        $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
        foreach($cookies as $cookie) 
        {
            $parts = explode('=', $cookie);
            $name = trim($parts[0]);
            setcookie($name, '', time() - 3600, '/');
            setcookie($name, '', time() - 3600, '/', $_SERVER['HTTP_HOST']);
            setcookie("PHPSESSID", "", time() - 3600, "/");
        } 
        header("location:index.php");
        die("");
    }
}

if(count($_COOKIE)>1) 
{  
    session_start();
    $username= $_SESSION["userName"];
    $token=$_COOKIE['token'];
// comparaison between DATABASE token and COOKIE token 
    $tokenn=$connected->prepare("SELECT * FROM user WHERE username=:name");
    $tokenn->bindParam("name",$username);
    $tokenn->execute();
    foreach($tokenn AS $T){
        echo $T['token'];
        if($token==$T['token'])
        header("location:post.php");
        exit;
    }
    
}
// else {
//     echo "cookies=00"; 
// }

// print_r($_COOKIE);
// echo count($_COOKIE);
?>

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title> BlogX </title>
        <link rel="stylesheet" href="./style.CSS">
        <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;500;600;700;800;900;1000&display=swap" rel="stylesheet">
    </head>
    <body>

        <div class="header">
            <div class="logo">
               <img src="./img/logo_black_and_white.png" alt="" class="photo_logo" onclick="location.href='index.php'">
            </div>
        </div>

        <div class="main">
            <div class="main_top">
                <div class="login">
                    <div class="logo_div">
                        <img src="./img/utilisateur.png" alt="" class="utilisateur" >
                        <?php
                        if(isset($_POST['send']))
                        { if($query->rowCount()==0)
                            echo '<h4 style="color: rgb(224, 39, 39); margin: 0;">Failed to login! Try again..</h4>';
                        }
                        ?>
                    </div>
                    <div class="form">
                        <div class="form_right">
                            <img src="./img/user.png" alt="" class="user">
                            <img src="./img/pass.png" alt="" class="pass">
                        </div>
                        <div class="form_left">
                            <form action="index.php" method="POST">
                                <input type="text" name="username" placeholder="username" class="username " required>
                                <br>
                                <br>
                                <input type="password" name="password" placeholder="password"  class="password " required>
                                <br> <br> <br>
                                <button class='LOGINN' name='send'>LOGIN</button>
                            </form>
                            <br>
                        </div>
                    </div>
                    <vr style="height: 1px; background-color: white;">
                     <br><br>
                    <form action="SignUp.php" method="POST">
                        <button  class="create">Create new account</button>
                    </form> 
                </div>
            </div>
            <div class="footer">
               <h5>BlogX &copy; 2023</h5>
            <div class="div_social_medea">
               <a href="https://www.instagram.com/s_t_a_n_i_s_k/"> <img src="./img/instagram-clipart-and-white-15.png" alt="" class="social_medea "></a> 
               <a href="mailto:kadiksalah03@gmail.com"><img src="./img/gmail_logo.png" alt="" class="social_medea logo_gmail"></a>
             </div>
               
            </div>
        </div>
        
    </body>
</html>















