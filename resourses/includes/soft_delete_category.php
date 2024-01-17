<?php
include_once '../classes/dbh.php';
session_start();
$dbh = new Dbh();
$conn = $dbh->connect();

if (isset($_POST['category_id'])) {
    
    $category_id = htmlspecialchars($_POST["category_id"], ENT_QUOTES, 'UTF-8');

    try {
        $query = "UPDATE category SET is_deleted = 1 WHERE category_id = :category_id";
        $stmt = $conn->prepare($query);

        $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $response = array("success" => true);
        } else {
            throw new Exception("Query execution failed");
        }
    } catch (Exception $e) {
        $response = array("success" => false, "error" => $e->getMessage());
    }

    header("Content-Type: application/json");
    echo json_encode($response);
} else {
    header("Content-Type: application/json");
    echo json_encode(array("success" => false, "message" => "Invalid request."));
}
?>