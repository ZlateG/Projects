<?php
include_once '../classes/dbh.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $bookId = filter_input(INPUT_POST, "book_id", FILTER_VALIDATE_INT);

    if ($bookId === null || $bookId === false) {
        // Invalid input, handle accordingly
        $response = ["success" => false, "message" => "Invalid book ID"];
        header('Content-Type: application/json');
        echo json_encode($response);
        exit; // Exit the script
    }

    $dbh = new Dbh();
    $conn = $dbh->connect();

    if ($conn === null) {
        die("Connection failed");
    }

    try {
        // Start a transaction
        $conn->beginTransaction();

        $deleteShoppingCartQuery = "DELETE FROM shopping_cart WHERE book_id = :book_id";
        $stmt = $conn->prepare($deleteShoppingCartQuery);
        $stmt->bindParam(':book_id', $bookId, PDO::PARAM_INT);
        $stmt->execute();

        // Delete comments with the book
        $deleteCommentsQuery = "DELETE FROM comments WHERE book_id = :book_id";
        $stmt = $conn->prepare($deleteCommentsQuery);
        $stmt->bindParam(':book_id', $bookId, PDO::PARAM_INT);
        $stmt->execute();

        // Delete notes with the book
        $deleteNotesQuery = "DELETE FROM notes WHERE book_id = :book_id";
        $stmt = $conn->prepare($deleteNotesQuery);
        $stmt->bindParam(':book_id', $bookId, PDO::PARAM_INT);
        $stmt->execute();

        // Delete the book
        $deleteBookQuery = "DELETE FROM books WHERE book_id = :book_id";
        $stmt = $conn->prepare($deleteBookQuery);
        $stmt->bindParam(':book_id', $bookId, PDO::PARAM_INT);
        $stmt->execute();

        $conn->commit();

        $response = ["success" => true];
    } catch (PDOException $e) {
        $conn->rollBack();
        $response = ["success" => false, "message" => "Error: " . $e->getMessage()];
    }

    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
