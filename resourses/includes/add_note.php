<?php
include_once '../classes/dbh.php';
session_start();
$dbh = new Dbh();
$conn = $dbh->connect();

if (isset($_SESSION['userid']) && isset($_POST['book_id']) && isset($_POST['note']) && !empty($_POST['book_id']) && !empty($_POST['note'])) {
    $userId = $_SESSION['userid'];

    $bookId = htmlspecialchars($_POST["book_id"], ENT_QUOTES, 'UTF-8');
    $noteText = htmlspecialchars($_POST["note"], ENT_QUOTES, 'UTF-8');

    $sql = "INSERT INTO notes (user_id, book_id, note) VALUES (:user_id, :book_id, :note)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $stmt->bindParam(':book_id', $bookId, PDO::PARAM_INT);
    $stmt->bindParam(':note', $noteText, PDO::PARAM_STR);

    $success = $stmt->execute();

    header('Content-Type: application/json');
    echo json_encode(['success' => $success]);
}

$conn = null;
?>
