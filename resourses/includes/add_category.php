<?php
include_once '../classes/dbh.php';
session_start();
$dbh = new Dbh();
$conn = $dbh->connect();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['category_name']) && !empty($_POST['category_name'])) {
        
        $categoryName = htmlspecialchars($_POST["category_name"], ENT_QUOTES, 'UTF-8');

        $dbh = new Dbh();
        $conn = $dbh->connect();

        $checkQuery = "SELECT * FROM category WHERE category_name = :category_name";
        $checkStmt = $conn->prepare($checkQuery);
        $checkStmt->bindParam(':category_name', $categoryName, PDO::PARAM_STR);
        $checkStmt->execute();

        if ($checkStmt->rowCount() > 0) {
            echo json_encode(array('success' => false, 'message' => 'Category already exists.'));
        } else {
            $insertQuery = "INSERT INTO category (category_name) VALUES (:category_name)";
            $insertStmt = $conn->prepare($insertQuery);
            $insertStmt->bindParam(':category_name', $categoryName, PDO::PARAM_STR);

            if ($insertStmt->execute()) {
                echo json_encode(array('success' => true, 'message' => 'Category added successfully.'));
            } else {
                echo json_encode(array('success' => false, 'message' => 'Failed to add category.'));
            }
        }
    } else {
        echo json_encode(array('success' => false, 'message' => 'Category name is required.'));
    }
} else {
    echo json_encode(array('success' => false, 'message' => 'Invalid request method.'));
}
?>
