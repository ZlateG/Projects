
<?php
class Login extends Dbh
{
    protected function getUser($uid, $pwd) {
        session_start(); // Start the session

        $stmt = $this->connect()->prepare('SELECT user_id, user_uid, user_pwd, is_admin  FROM users WHERE user_uid = ? OR user_email = ?;');
        
        if (!$stmt->execute(array($uid, $uid))) {
            header("location: ../../public/login.php?error=stmtfailed");
            exit();
        }

        if ($stmt->rowCount() == 0) {
            header("location: ../../public/login.php?error=usernotfound");
            exit();
        }

        $userData = $stmt->fetch(PDO::FETCH_ASSOC); // Fetch a single row

        $hashedPwd = $userData["user_pwd"];

        if (password_verify($pwd, $hashedPwd)) {
            $_SESSION["userid"] = $userData["user_id"];
            $_SESSION["useruid"] = $userData["user_uid"];
            $_SESSION["is_admin"] = $userData["is_admin"]; 
        } else {
            header("location: ../../public/login.php?error=wrongpassword");
            exit();
        }
    } 
}

