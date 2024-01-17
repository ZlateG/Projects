<?php
include_once '../classes/dbh.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $categoryId = htmlspecialchars($_POST["category_id"], ENT_QUOTES, 'UTF-8');
    $newCategoryName = htmlspecialchars($_POST["new_category_name"], ENT_QUOTES, 'UTF-8');

    $dbh = new Dbh();
    $conn = $dbh->connect();

    if ($conn === null) {
        die("Connection failed");
    }

    try {
        $updateCategoryQuery = "UPDATE category SET category_name = :new_category_name WHERE category_id = :category_id";
        $stmt = $conn->prepare($updateCategoryQuery);
        $stmt->bindParam(':new_category_name', $newCategoryName, PDO::PARAM_STR);
        $stmt->bindParam(':category_id', $categoryId, PDO::PARAM_INT);
        $stmt->execute();

        $response = ["success" => true];
    } catch (PDOException $e) {
        $response = ["success" => false, "message" => "Error: " . $e->getMessage()];
    }

    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
