<?php
if(isset($_GET['code']))
{   echo $_GET['code'];
    include("db_connect.php"); 
    $checkCode=$connected->prepare("SELECT SECURITY_CODE FROM user WHERE SECURITY_CODE=:SECURITY_CODE");
    $checkCode->bindParam("SECURITY_CODE",$_GET['code']);
    $checkCode->execute();

    // ________________________________________

//     $update = $database->prepare("UPDATE users SET SECURITY_CODE = :NEWSECURITY_CODE ,
//     ACTIVATED=true WHERE SECURITY_CODE = :SECURITY_CODE");
//      $securityCode = md5(date("h:i:s"));
//    $update->bindParam("NEWSECURITY_CODE",$securityCode);
//    $update->bindParam("SECURITY_CODE",$_GET['code']);
   
   
    // // ________________________________________


   if($checkCode->execute()){
  
    if($checkCode->rowCount()>0){
  
        $upDate=$connected->prepare("UPDATE  `user` SET `ACTIVATED`=true ,SECURITY_CODE=:newSecurity_code WHERE SECURITY_CODE = :SECURITY_CODE");
        $newCode=md5(date("h:i:s"));
        $upDate->bindParam("newSecurity_code",$newCode);
        $upDate->bindParam("SECURITY_CODE",$_GET['code']);
        if($upDate->execute()){
        echo "<h1 style='color: green; margin-left:5px;' > Your account has been successfully verified</h1>";
        echo '<a  href="index.php" classe="logoout">Log in </a>';
        }
        else{
        echo "<h1 style='color: red; margin-left:5px;' >Sorry! This is code that is no longer usable</h1>";
        echo'Try to sign up again';
        $delete=$connected->prepare("DELETE FROM user WHERE  SECURITY_CDOE=:SECURITY_CODE");
        $delete->bindParam("SECURITY_CODE",$_GET['code']);
        $delete->execute();
        }
    }
  } 

}
else echo"error";
?>


