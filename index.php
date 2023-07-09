<?php 
// include file to connect DB
include("db_connect.php");
 
// session_abort();

//log in and transition to post.php
if(isset($_POST['send']))
{
    $userName=$_POST['username'];
    $userpass=$_POST['password'] ;
    //    $hashed_password = password_hash($userpass, PASSWORD_BCRYPT, array('cost' => 12));
    $query=$connected->prepare("SELECT * FROM user WHERE username= :name" );
    $query->bindParam("name",$userName);
    $query->execute();
    if($query->rowCount()==1)
    {
        foreach($query AS $var)
        { if ($var['ACTIVATED']==true){
            if (password_verify($userpass, $var['password'])) 
            {
                // Password is correct
                //save data in cookies
                $exp=time()+(60*60*24*30);
                setcookie($userName,$var['password'],$exp,'/');
                session_start();
                $_SESSION['userName']=$userName;
                $_SESSION['userPassword']=$var['password'];
                header("location:post.php");
            } 
            else echo "<br> <h1>error 501<br> </h1>"; // Password is incorrect 
            }
        }           
    }          
}

if(isset($_POST['logOut'])) 
{       
    session_start();
    session_unset();
    session_destroy(); 
    // $exp=time()-3600;
    // $variable1=$_SESSION['userName'];
    // $variable2=$_SESSION['userPassword'];
    // setcookie($variabel,$variable2,$exp,'/');
    // session_set_cookie_params(0, '/', '', false, true);
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
        // header("Loaction:".$_SERVER["REQUEST_URI"]);
        
    // iterate through all cookies and delete them
    // foreach ($_COOKIE as $name => $value) {
    //     setcookie($name, '', time() - 3600, '/');
    //     setcookie($name, '', time() - 3600, '/', $_SERVER['HTTP_HOST']);
    // }


    // $_COOKIE
    // $exp=time()-1;
    // setcookie($exp,'/');
        // session_set_cookie_params('');
}

if(count($_COOKIE)>1) 
{
    header("location:post.php");
}else { echo "cookies=00"; }

print_r($_COOKIE);
echo count($_COOKIE);
?>

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title> BlogX </title>
        <link rel="stylesheet" href="./style.css">
        <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
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
                            echo '<h4 style="color: rgb(224, 39, 39); margin: 0;">Failed to login! Try again..</h4>
                            ';
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
                                <button class="LOGINN" name="send">LOGIN</button>
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
               <h5>BlogX © 2023</h5>
            <div class="div_social_medea">
               <a href="https://www.instagram.com/s_t_a_n_i_s_k/"> <img src="./img/instagram-clipart-and-white-15.png" alt="" class="social_medea "></a> 
               <a href="mailto:kadiksalah03@gmail.com"><img src="./img/gmail_logo.png" alt="" class="social_medea logo_gmail"></a>
             </div>
               
            </div>
        </div>
        
    </body>
</html>















