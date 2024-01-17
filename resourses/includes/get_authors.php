<?php
include_once '../classes/dbh.php';
session_start();
$dbh = new Dbh();
$conn = $dbh->connect();

$query = "SELECT * FROM authors"; 
$stmt = $conn->prepare($query);
$stmt->execute();
$authors = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($authors);