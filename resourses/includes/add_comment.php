<?php
include_once '../classes/dbh.php';
session_start();
$dbh = new Dbh();
$conn = $dbh->connect();

if (isset($_SESSION['userid']) && isset($_POST['book_id']) && isset($_POST['comment']) && !empty($_POST['book_id']) && !empty($_POST['comment'])) {
    $userId = $_SESSION['userid'];
    
    $bookId = htmlspecialchars($_POST["book_id"], ENT_QUOTES, 'UTF-8');
    $commentText = htmlspecialchars($_POST["comment"], ENT_QUOTES, 'UTF-8');


    $sqlCheck = "SELECT COUNT(*) FROM comments WHERE user_id = :user_id AND book_id = :book_id";
    $stmtCheck = $conn->prepare($sqlCheck);
    $stmtCheck->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $stmtCheck->bindParam(':book_id', $bookId, PDO::PARAM_INT);
    $stmtCheck->execute();
    $existingCommentCount = $stmtCheck->fetchColumn();

    if ($existingCommentCount === 0) {

        $sqlInsert = "INSERT INTO comments (user_id, book_id, comment) VALUES (:user_id, :book_id, :comment)";
        $stmtInsert = $conn->prepare($sqlInsert);
        $stmtInsert->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmtInsert->bindParam(':book_id', $bookId, PDO::PARAM_INT);
        $stmtInsert->bindParam(':comment', $commentText, PDO::PARAM_STR);

        $success = $stmtInsert->execute();

        header('Content-Type: application/json');
        echo json_encode(['success' => $success]);
    } else {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'User has already left a comment for this book']);
    }
}

$conn = null;
