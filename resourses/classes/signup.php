<?php
class Signup extends Dbh
{
    protected function setUser($uid, $pwd, $email) 
    {
        $stmt = $this->connect()->prepare('INSERT INTO users (user_uid, user_pwd, user_email) VALUES (?, ?, ?)');

        $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

        if (!$stmt->execute(array($uid, $hashedPwd, $email))) { 
            $stmt = null;
            header("location: ../index.php?error=stmtfailed");
            exit();
        }
        
        $stmt = null;
    } 

    public function checkUser($uid, $email) 
    {
        $stmt = $this->connect()->prepare('SELECT user_uid FROM users WHERE user_uid = ? OR user_email = ?;');
        if (!$stmt->execute(array($uid, $email))) { 
            $stmt = null;
            header("location: ../../public/index.php?error=stmtfailed");
            exit();
        }
        $resultCheck;
        if ($stmt->rowCount() > 0) {
            $resultCheck = false;
        } else {
            $resultCheck = true;
        }
        return $resultCheck;
    } 

    protected function getUserId($uid)
    {
        $stmt = $this->connect()->prepare('SELECT user_id FROM users WHERE user_uid = ?;'); 

        if (!$stmt->execute(array($uid))) {
            $stmt = null;
            header("location: profile.php?error=stmtfailed");
            exit();
        }

        if ($stmt->rowCount() == 0) {
            $stmt = null;
            header("location: profile.php?error=profileNotfound");
            exit();
        }

        $profileData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $profileData;
    }
}
