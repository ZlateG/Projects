<?php
include_once '../classes/dbh.php';
session_start();
$dbh = new Dbh();
$conn = $dbh->connect();

if (isset($_POST['comments_id'])) {
    
    $commentId = htmlspecialchars($_POST["comments_id"], ENT_QUOTES, 'UTF-8');

    $sql = "DELETE FROM comments WHERE comments_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$commentId]);

    if ($stmt->rowCount() > 0) {
        $response = array('success' => true, 'message' => 'Comment deleted successfully.');
    } else {
        $response = array('success' => false, 'message' => 'Failed to delete comment.');
    }

    echo json_encode($response);
} else {
    echo json_encode(array('success' => false, 'message' => 'Comment ID not provided.'));
}
?>
