<?php
include_once '../classes/dbh.php';

if (!isset($_GET['book_id'])) {
    echo json_encode(array('error' => 'Book ID is missing.'));
    exit();
}

$bookId = $_GET['book_id'];

$dbh = new Dbh();
$conn = $dbh->connect();

if ($conn === null) {
    echo json_encode(array('error' => 'Database connection failed.'));
    exit();
}

// Query to retrieve book information based on book_id
$sql = "SELECT * FROM books WHERE book_id = :bookId";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':bookId', $bookId, PDO::PARAM_INT);

if ($stmt->execute()) {
    $book = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($book) {
        // Return book information as JSON
        echo json_encode($book);
    } else {
        echo json_encode(array('error' => 'Book not found.'));
    }
} else {
    echo json_encode(array('error' => 'Error fetching book information.'));
}

$conn = null;
?>
