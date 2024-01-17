<?php
include_once '../classes/dbh.php';
session_start();
$dbh = new Dbh();
$conn = $dbh->connect();


if (isset($_SESSION['userid']) && isset($_POST['bookId'])) {
    $dbh = new Dbh();
    $conn = $dbh->connect();

    $userId = $_SESSION['userid'];
   $bookId = htmlspecialchars($_POST["bookId"], ENT_QUOTES, 'UTF-8');


    // Check if the book is already in the cart
    $checkCartQuery = "SELECT * FROM shopping_cart WHERE user_id = :userId AND book_id = :bookId  AND removed = 0";
    $stmt = $conn->prepare($checkCartQuery);
    $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    $stmt->bindParam(':bookId', $bookId, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() === 0) {
        // Book is not in the cart, insert it
        $insertCartQuery = "INSERT INTO shopping_cart (user_id, book_id) VALUES (:userId, :bookId)";
        $stmt = $conn->prepare($insertCartQuery);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':bookId', $bookId, PDO::PARAM_INT);
        $stmt->execute();

        echo "Book added to cart successfully!";
    } else {
        echo "Book is already in your cart.";
    }
} else {
    echo "Please log in to add to cart.";
}
?>
