<?php


if($_SERVER["REQUEST_METHOD"] == "POST")
{
    // grabing the data
    $uid =  htmlspecialchars($_POST["uid"], ENT_QUOTES, 'UTF-8');
    $pwd = htmlspecialchars($_POST["pwd"], ENT_QUOTES, 'UTF-8');
   

    // Instantiate signupContr class

    include "../classes/dbh.php";
    include "../classes/login.php";
    include "../classes/loginContr.php";
    $login = new LoginContr($uid, $pwd);
    
    $login->loginUser();

    header("location: ../../public/index.php?error=none");

}