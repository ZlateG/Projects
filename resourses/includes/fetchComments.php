<?php
include_once '../classes/dbh.php';
session_start();
$dbh = new Dbh();
$conn = $dbh->connect();

$sql = "SELECT c.comments_id, c.comment, u.user_uid, c.is_approved, c.user_id, b.title AS book_title, CONCAT(a.first_name, ' ', a.last_name) AS author_name
        FROM comments AS c
        JOIN users AS u ON c.user_id = u.user_id
        JOIN books AS b ON c.book_id = b.book_id
        JOIN authors AS a ON b.author_id = a.author_id
        WHERE c.is_approved = 0";
$stmt = $conn->prepare($sql);
$stmt->execute();
$comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($comments);

$conn = null;

