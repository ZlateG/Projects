<?php
include_once '../classes/dbh.php';
session_start();
$dbh = new Dbh();
$conn = $dbh->connect();

if (isset($_SESSION['userid']) && isset($_POST['note_id']) && !empty($_POST['note_id'])) {
    $userId = $_SESSION['userid'];
    $noteId = htmlspecialchars($_POST["note_id"], ENT_QUOTES, 'UTF-8');
    
    $sql = "DELETE FROM notes WHERE user_id = :user_id AND note_id = :note_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $stmt->bindParam(':note_id', $noteId, PDO::PARAM_INT);

    $success = $stmt->execute();

    header('Content-Type: application/json');
    echo json_encode(['success' => $success]);
}

$conn = null;
?>
