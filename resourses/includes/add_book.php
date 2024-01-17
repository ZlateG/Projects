<?php
include_once '../classes/dbh.php';
session_start();
$dbh = new Dbh();
$conn = $dbh->connect();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $dbh = new Dbh();
    $conn = $dbh->connect();

    $title = htmlspecialchars($_POST["title"], ENT_QUOTES, 'UTF-8');
    $authorId = htmlspecialchars($_POST["author"], ENT_QUOTES, 'UTF-8');
    $publishedAt = htmlspecialchars($_POST["published_at"], ENT_QUOTES, 'UTF-8');
    $noOfPages = htmlspecialchars($_POST["no_of_pages"], ENT_QUOTES, 'UTF-8');
    $categoryId = htmlspecialchars($_POST["category"], ENT_QUOTES, 'UTF-8');
    $imageUrl = htmlspecialchars($_POST["image_url"], ENT_QUOTES, 'UTF-8');


    $query = "INSERT INTO books (title, author_id, published_at, no_of_pages, category_id, image_url)
              VALUES (:title, :author_id, :published_at, :no_of_pages, :category_id, :image_url)";
    
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':author_id', $authorId);
    $stmt->bindParam(':published_at', $publishedAt);
    $stmt->bindParam(':no_of_pages', $noOfPages);
    $stmt->bindParam(':category_id', $categoryId);
    $stmt->bindParam(':image_url', $imageUrl);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Book added successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error adding book.']);
    }

    $conn = null;
}