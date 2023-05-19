<?php
//include file to connect DB
include("db_connect.php"); 




if(isset($_POST['send']))
{
    $userEmail=$_POST['email'] ;
    // $userEmail=filter_var($userEmail,FILTER_VALIDATE_EMAIL);
    $userEmail=filter_input(INPUT_POST,"email",FILTER_VALIDATE_EMAIL);

    $userName=$_POST['userName'];
   // protect user passwords
   // $userpass=sha1($_POST['userPassword']); 
   $userpass = password_hash($_POST['userPassword'],PASSWORD_DEFAULT);

   //testing..if email and username do not exist together in DB
   if($userEmail){
    $query=$connected->prepare("SELECT email FROM user WHERE email= :emmail");
    $query->bindParam("emmail",$userEmail);
    $query->execute();
    // var_dump($query->errorInfo());
    // echo"<br>";

    $num1=$query->rowCount();
    $query=$connected->prepare("SELECT username FROM user WHERE username=paass");
    $query->bindParam("paass",$userpass);
    $query->execute();
    // var_dump($query->errorInfo());
    // echo"<br>";
    $num2=$query->rowCount();
    // echo $num1."<br>".$num2."<br>";



    //if they're not exist..insert into
    if(($num1==0)&&($num2==0))
    {  
        //  $_url="post.php";
        $query=$connected->prepare("INSERT INTO `user`(username,email,password,sign_upDate,SECURITY_CODE)
         VALUES(:naame,:eemail,:ppass,current_timestamp(),:SECURITY_CODE)");
         $security=md5(date("h:i:s"));
        $query->bindParam("SECURITY_CODE",$security);
        $query->bindParam("naame",$userName);
        $query->bindParam("eemail",$userEmail);
        $query->bindParam("ppass",$userpass);
        $query->execute();
        var_dump($query->errorInfo());
        echo"succes!";

        //send message to email to confirm you 
        require_once 'mail.php';
        $mail->setFrom('kadiksalah03@gmail.com','kadik salah');
        $mail->addAddress($userEmail);
        $mail->Subject = 'Welcome to blogX!';
        $mail->Body    = '<h1>We`re so glad you`re here </h1> '."<br><a href= 'http://localhost/blogX/activate.php?code=
        ".$security ."'><button type='submit'>Confirm</button></a>";
        $mail->send(); 

        //save data in cookies
        // $email='username';
        // setcookie($email,$userName,$exp);
        // session_start();
        // $_SESSION['userName']=$userName;
        // $_SESSION['userPassword']=$userpass;
        // header("location:post.php") ;                //post.php الانتقال الى الصفحة 
    }
    // else{
    //     echo"<h1>username or email have existe!</h1>";
    //     header ("location:SignUpFAILED.php") ;       //SignUp.php الانتقال الى الصفحة 
    // } 


}
}
if(count($_COOKIE)>1) 
    {
        header("location:post.php");
    }

?>

<html>
    <head>
        <title> Sign Up</title>
        <link rel="stylesheet" href="Style.css">
    </head>
    <body>
            <div class="Sign_header">
                    <img src="./img/logo_black_and_white.png" alt="" class="Sign_logo" onclick="location.href='index.php'">
             </div>

            <div class="Sign_main">
                <?php 
                if(isset($_POST['send']))
                { 
                    if($userEmail){
                        if(($num1!=0)||($num2!=0)) 
                        echo '<h4 class="failed">Failed to register! Try again..</h4>
                        <br>';
                    else echo'<h3 style="color:green;">Check your email to confirm your registration!</h3>';
                    }
                
                    }
                ?>
                    <div class="RE">
                        <div class="black"></div>
                        <p class="register">
                              Register on this site
                        </p> 
                    </div>
                    <br><br><br>
                    
                    <div class="form2 login">
                        <form action="SignUp.php" method="POST">
                                <input type="text" name="userName" placeholder="username"  class="username" required>
                                <br> <br>
                                <input type="email" name="email" placeholder="e-mail"  class="username" required>
                                <br> <br>
                                <input type="password" name="userPassword" placeholder="password"  class="password" required>
                                <br><br>
                                <button  name="send">Sign up</button>
                        </form>
                   </div> 
            </div> 
    </body>
</html>