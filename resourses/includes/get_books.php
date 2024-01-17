<?php
include_once '../classes/dbh.php';

$dbh = new Dbh();
$conn = $dbh->connect();

$query = "SELECT b.book_id, b.title, CONCAT(a.first_name, ' ' , a.last_name ) AS author_name , b.published_at, b.no_of_pages, c.category_name, b.image_url, b.is_deleted
          FROM books as b 
          JOIN authors AS a ON b.author_id = a.author_id
          JOIN category AS c ON b.category_id = c.category_id";



$result = $conn->query($query);

$books = array();
if ($result->rowCount() > 0) { 
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $books[] = $row;
    }
}

echo json_encode($books);
?>

