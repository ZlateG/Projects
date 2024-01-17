<?php
include_once '../classes/dbh.php';
include_once '../classes/BookManager.php'; 

$dbh = new Dbh();
$conn = $dbh->connect();

$bookManager = new BookManager();

if (isset($_POST['title'])) {
    
    $title = htmlspecialchars($_POST["title"], ENT_QUOTES, 'UTF-8');
    $existingBooks = $bookManager->getAllBooks($conn);
    $bookExists = false;

    foreach ($existingBooks as $book) {
        if ($book['title'] === $title) {
            $bookExists = true;
            break;
        }
    }

    echo json_encode(['bookExists' => $bookExists]);
} else {
    echo json_encode(['error' => 'Title not provided.']);
}

$conn = null;
?>
