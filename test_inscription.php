<?php
//include file to connect DB
// include("db_connect.php");

// if (mysqli_connect_error()) 
//     die("cannot conect : " . mysqli_connect_error());
// else
//     echo "db connected </br>";

// if(isset($_POST['send']))
// {   
//     $userEmail=$_POST['email'] ;
//     $userName=$_POST['userName'];
//     // protect user passwords
//     $userpass=$_POST['userPassword'];
//     $hashed_password = password_hash($userpass, PASSWORD_BCRYPT, array('cost' => 12));

//     // echo $userEmail.$userName.$userpass."<br>";
//     $query=$connected->prepare("INSERT INTO `user`(username,email,password,sign_upDate) VALUES('$userName','$userEmail','$hashed_password',current_timestamp())");
//     $query->execute();
//     var_dump($query->errorInfo());
// }
?>
<?php
//include file to connect DB
include("db_connect.php");

if(isset($_POST['send']))
{
    $userEmail=$_POST['email'] ;
    $userName=$_POST['userName'];
   // protect user passwords
   $userpass=$_POST['userPassword'];
   $hashed_password = password_hash($userpass, PASSWORD_BCRYPT, array('cost' => 12));

   //testing..if email and username do not exist together in DB
    $query=$connected->prepare("SELECT email FROM user WHERE email='$userEmail'");
    $query->execute();
    var_dump($query->errorInfo());
    echo"<br>";
    $num1=$query->rowCount();
    $query=$connected->prepare("SELECT username FROM user WHERE username='$userName'");
    $query->execute();
    var_dump($query->errorInfo());
    echo"<br>";
    $num2=$query->rowCount();
    echo $num1."<br>".$num2."<br>";

    //if they're not exist..insert into
    if(($num1==0)&&($num2==0))
    {   $_url="post.php";
        $query=$connected->prepare("INSERT INTO `user`(username,email,password,sign_upDate) VALUES('$userName','$userEmail','$hashed_password',current_timestamp())");
        $query->execute();
        var_dump($query->errorInfo());
        echo"succes!";
        header ("location:post.php") ;//post.php الانتقال الى الصفحة 
    }
    else{
        echo"<h1>username or email have existe!</h1>";
        header ("location:SignUp.php") ;//SignUp.php الانتقال الى الصفحة 
    } 


}
?>