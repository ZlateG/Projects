<?php
include_once '../classes/dbh.php';
session_start();
$dbh = new Dbh();
$conn = $dbh->connect();

// Check if the user is logged in
if (isset($_SESSION['userid'])) {
    $userId = $_SESSION['userid'];

    // Check if the user is not trying to delete themselves
    if (isset($_POST['user_id']) && $_POST['user_id'] != $userId) {
        // Sanitize and retrieve user_id from POST data
        $deleteUserId = htmlspecialchars($_POST['user_id'], ENT_QUOTES, 'UTF-8');

        try {
            // Start a transaction
            $conn->beginTransaction();

            // Delete associated comments
            $deleteCommentsQuery = "DELETE FROM comments WHERE user_id = :user_id";
            $stmtComments = $conn->prepare($deleteCommentsQuery);
            $stmtComments->bindParam(':user_id', $deleteUserId, PDO::PARAM_INT);
            $stmtComments->execute();

            // Delete associated notes
            $deleteNotesQuery = "DELETE FROM notes WHERE user_id = :user_id";
            $stmtNotes = $conn->prepare($deleteNotesQuery);
            $stmtNotes->bindParam(':user_id', $deleteUserId, PDO::PARAM_INT);
            $stmtNotes->execute();

            // Delete the user
            $deleteUserQuery = "DELETE FROM users WHERE user_id = :user_id";
            $stmtUser = $conn->prepare($deleteUserQuery);
            $stmtUser->bindParam(':user_id', $deleteUserId, PDO::PARAM_INT);
            $stmtUser->execute();

            // Commit the transaction
            $conn->commit();

            // Redirect to the original page or a designated page after deletion
            header('Location: ../../public/adminDashboard.php');
            exit();
        } catch (PDOException $e) {
            // An error occurred, rollback the transaction
            $conn->rollBack();
            echo "Error: " . $e->getMessage();
        }
    }
}

$conn = null;
?>
