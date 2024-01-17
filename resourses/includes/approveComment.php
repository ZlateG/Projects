<?php
include_once '../classes/dbh.php';
$dbh = new Dbh();
$conn = $dbh->connect();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment_id'])) {

    $commentId = htmlspecialchars($_POST["comment_id"], ENT_QUOTES, 'UTF-8');

    $sql = "UPDATE comments SET is_approved = 1 WHERE comments_id = :comment_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':comment_id', $commentId, PDO::PARAM_INT);

    $success = $stmt->execute();

    $response = array('success' => $success);

    header('Content-Type: application/json');
    echo json_encode($response);
}

$conn = null;
?>
