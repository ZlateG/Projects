<?php
include_once '../classes/dbh.php';

// Create a new Dbh instance and establish a database connection
$dbh = new Dbh();
$pdo = $dbh->connect();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $authorId = $_POST['author_id'];

    // Get the updated author information from the form
    $newFirstName = htmlspecialchars($_POST["new_first_name"], ENT_QUOTES, 'UTF-8');
    $newLastName = htmlspecialchars($_POST["new_last_name"], ENT_QUOTES, 'UTF-8');
    $newShortBio = htmlspecialchars($_POST["new_short_bio"], ENT_QUOTES, 'UTF-8');

    // Check if any of the values are empty or if new_short_bio is too short
    if (empty($newFirstName) || empty($newLastName) || strlen($newShortBio) < 20) {
        // Handle validation errors
        echo json_encode(array('success' => false, 'error' => 'Invalid input values.'));
        exit; 
    } else {
        // Perform the SQL update query
        $sql = "UPDATE authors SET first_name = :first_name, last_name = :last_name, short_bio = :short_bio WHERE author_id = :author_id";
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':first_name', $newFirstName, PDO::PARAM_STR);
        $stmt->bindParam(':last_name', $newLastName, PDO::PARAM_STR);
        $stmt->bindParam(':short_bio', $newShortBio, PDO::PARAM_STR);
        $stmt->bindParam(':author_id', $authorId, PDO::PARAM_INT);

        // Execute the update query
        if ($stmt->execute()) {
            // Update successful
            echo json_encode(array('success' => true));
        } else {
            // Update failed
            echo json_encode(array('success' => false, 'error' => 'Short Bio needs to be at least 20 char long and all feilds are mandatory'));
        }
    }
} else {
    // Handle the case where the request method is not POST
    echo json_encode(array('success' => false, 'error' => 'Invalid request method.'));
}
?>
