<?php
include_once '../classes/dbh.php';

$dbh = new Dbh();
$conn = $dbh->connect();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $bookId = htmlspecialchars($_POST["book_id"], ENT_QUOTES, 'UTF-8');

    // Check if the book exists and is not already soft-deleted
    $checkQuery = "SELECT * FROM books WHERE book_id = :book_id AND is_deleted = 0";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bindParam(':book_id', $bookId, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        // Soft delete the book
        $deleteQuery = "UPDATE books SET is_deleted = 1 WHERE book_id = :book_id";
        $stmt = $conn->prepare($deleteQuery);
        $stmt->bindParam(':book_id', $bookId, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $response = ["success" => true];
        } else {
            $response = ["success" => false, "message" => "Failed to delete the book."];
        }
    } else {
        $response = ["success" => false, "message" => "Book not found or already deleted."];
    }

    // Set the response header to indicate JSON content
    header('Content-Type: application/json');
    
    error_log(json_encode($response));
    echo json_encode($response);
}
?>
