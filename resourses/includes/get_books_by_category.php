<?php
include_once '../classes/dbh.php';
include_once '../classes/BookManager.php'; 

$dbh = new Dbh();
$conn = $dbh->connect();

$bookManager = new BookManager();
$categories = $bookManager->getCategoriesWithBooks();

if (!empty($categories)) {
    echo json_encode(['success' => true, 'categories' => $categories]);
} else {
    echo json_encode(['success' => false, 'message' => 'No categories found.']);
}

$conn = null;
