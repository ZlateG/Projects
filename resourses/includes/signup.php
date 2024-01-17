<?php


if($_SERVER["REQUEST_METHOD"] == "POST")
{
    $_SESSION['form_data'] = $_POST;
    var_dump($_POST); 
    // grabing the data
    $uid = htmlspecialchars($_POST["uid"], ENT_QUOTES, 'UTF-8');
    $pwd = htmlspecialchars($_POST["pwd"], ENT_QUOTES, 'UTF-8');
    $pwdRepeat = htmlspecialchars($_POST["pwdRepeat"], ENT_QUOTES, 'UTF-8');
    $email = htmlspecialchars($_POST["email"], ENT_QUOTES, 'UTF-8');
  


    include_once "../classes/dbh.php";
    include_once "../classes/signup.php";
    include_once "../classes/signupContr.php";
    $signup = new SignupContr($uid, $pwd, $pwdRepeat, $email);
    $signup->signupUser();

    $userId = $signup->fetchUserId($uid);


    include_once "../classes/profileinfoc.php";

    

    // Going back to front page
    header("location: ../../public/login.php?error=none");

}else {
    var_dump($_SESSION); // Add this line for debugging
    // Initialize form data
    $formData = array(
        'uid' => '',
        'email' => ''
    );
}