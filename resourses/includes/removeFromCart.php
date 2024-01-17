<?php
include_once '../classes/dbh.php';
session_start();
$dbh = new Dbh();
$conn = $dbh->connect();



if (isset($_SESSION["userid"]) && isset($_POST['book_id'])) {
    $userId = $_SESSION["userid"];
    $bookId = htmlspecialchars($_POST["book_id"], ENT_QUOTES, 'UTF-8');

    // Update the item's "removed" status 
    $sql = "UPDATE shopping_cart
            SET removed = 1
            WHERE user_id = :userId AND book_id = :bookId";
    
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    $stmt->bindParam(':bookId', $bookId, PDO::PARAM_INT);
    
    if ($stmt->execute()) {
        echo 'success';
    } else {
        echo 'error';
    }
} else {
    echo 'error';
}

