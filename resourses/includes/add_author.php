<?php
include_once '../classes/dbh.php';
session_start();
$dbh = new Dbh();
$conn = $dbh->connect();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['first_name']) && isset($_POST['last_name']) && !empty($_POST['first_name']) && !empty($_POST['last_name'])) {
        
        $first_name = htmlspecialchars($_POST["first_name"], ENT_QUOTES, 'UTF-8');
        $last_name = htmlspecialchars($_POST["last_name"], ENT_QUOTES, 'UTF-8');
        $short_bio = htmlspecialchars($_POST["short_bio"], ENT_QUOTES, 'UTF-8');

        $dbh = new Dbh();
        $conn = $dbh->connect();

        $checkQuery = "SELECT * FROM authors WHERE first_name = :first_name AND last_name = :last_name";
        $checkStmt = $conn->prepare($checkQuery);
        $checkStmt->bindParam(':first_name', $first_name, PDO::PARAM_STR);
        $checkStmt->bindParam(':last_name', $last_name, PDO::PARAM_STR);
        $checkStmt->execute();

        if ($checkStmt->rowCount() > 0) {
            echo json_encode(array('success' => false, 'message' => 'Author already exists.'));
        } else {
            $insertQuery = "INSERT INTO authors (first_name, last_name, short_bio) VALUES (:first_name, :last_name, :short_bio)";
            $insertStmt = $conn->prepare($insertQuery);
            $insertStmt->bindParam(':first_name', $first_name, PDO::PARAM_STR);
            $insertStmt->bindParam(':last_name', $last_name, PDO::PARAM_STR);
            $insertStmt->bindParam(':short_bio', $short_bio, PDO::PARAM_STR);

            if ($insertStmt->execute()) {
                echo json_encode(array('success' => true, 'message' => 'Author added successfully.'));
            } else {
                echo json_encode(array('success' => false, 'message' => 'Failed to add author.'));
            }
        }
    } else {
        echo json_encode(array('success' => false, 'message' => 'First name and last name are required.'));
    }
} else {
    echo json_encode(array('success' => false, 'message' => 'Invalid request method.'));
}
?>
