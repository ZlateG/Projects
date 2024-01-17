<?php
include_once '../classes/dbh.php';




if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(array('error' => 'Invalid request method.'));
    exit();
}

$bookId = htmlspecialchars($_POST["book_id"], ENT_QUOTES, 'UTF-8');
$title = htmlspecialchars($_POST["title"], ENT_QUOTES, 'UTF-8');
$authorId = htmlspecialchars($_POST["author_id"], ENT_QUOTES, 'UTF-8');
$publishedAt = htmlspecialchars($_POST["published_at"], ENT_QUOTES, 'UTF-8');
$categoryId = htmlspecialchars($_POST["category_id"], ENT_QUOTES, 'UTF-8');
$imageUrl = htmlspecialchars($_POST["image_url"], ENT_QUOTES, 'UTF-8');
$noOfPages = htmlspecialchars($_POST["no_of_pages"], ENT_QUOTES, 'UTF-8'); 

$dbh = new Dbh();
$conn = $dbh->connect();

if ($conn === null) {
    echo json_encode(array('error' => 'Database connection failed.'));
    exit();
}

// Update the book in the database
$sql = "UPDATE books SET title = :title, author_id = :author_id, published_at = :published_at, no_of_pages = :no_of_pages, category_id = :category_id, image_url = :image_url WHERE book_id = :book_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':title', $title, PDO::PARAM_STR);
$stmt->bindParam(':author_id', $authorId, PDO::PARAM_INT);
$stmt->bindParam(':published_at', $publishedAt);
$stmt->bindParam(':no_of_pages', $noOfPages, PDO::PARAM_INT);
$stmt->bindParam(':category_id', $categoryId, PDO::PARAM_INT);
$stmt->bindParam(':image_url', $imageUrl, PDO::PARAM_STR);
$stmt->bindParam(':book_id', $bookId, PDO::PARAM_INT);

if ($stmt->execute()) {
    // Successful update, redirect to another page
    header('Location: ../../public/adminDashboard.php');
    exit();
}

$conn = null;

?>
