<?php
include_once '../classes/dbh.php';
session_start();
$dbh = new Dbh();
$conn = $dbh->connect();


if (isset($_GET['book_id']) && !empty($_GET['book_id'])) {
    $bookId = $_GET['book_id'];

    $sql = "SELECT c.comment, u.user_uid, c.is_approved, c.user_id, c.comments_id
            FROM comments AS c
            JOIN users AS u ON c.user_id = u.user_id
            WHERE c.book_id = :book_id ";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':book_id', $bookId, PDO::PARAM_INT);
    $stmt->execute();
    $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

    header('Content-Type: application/json');
    echo json_encode($comments);
}

$conn = null;
