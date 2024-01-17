<?php
include_once '../classes/dbh.php';
session_start();
$dbh = new Dbh();
$conn = $dbh->connect();

if (isset($_SESSION['userid']) && isset($_GET['book_id']) && !empty($_GET['book_id'])) {
    $userId = $_SESSION['userid'];
    $bookId = $_GET['book_id'];

   
    $sql = "SELECT * FROM notes WHERE user_id = :user_id AND book_id = :book_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $stmt->bindParam(':book_id', $bookId, PDO::PARAM_INT);
    $stmt->execute();
    $notes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    header('Content-Type: application/json; charset=utf-8');

    
    echo json_encode($notes, JSON_UNESCAPED_UNICODE);

}

$conn = null;
?>
