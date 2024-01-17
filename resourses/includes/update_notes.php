<?php
include_once '../classes/dbh.php';

$dbh = new Dbh();
$pdo = $dbh->connect();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $noteId = $_POST['note_id'];


    $newNote = htmlspecialchars($_POST["new_note"], ENT_QUOTES, 'UTF-8');


    if (empty($newNote)) {

        echo json_encode(array('success' => false, 'error' => 'Invalid input value.'));
    } else {

        $sql = "UPDATE notes SET note = :new_note WHERE note_id = :note_id";
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':new_note', $newNote, PDO::PARAM_STR);
        $stmt->bindParam(':note_id', $noteId, PDO::PARAM_INT);


        if ($stmt->execute()) {
            
            echo json_encode(array('success' => true));
        } else {
            
            echo json_encode(array('success' => false, 'error' => 'Failed to update note.'));
        }
    }
} else {
 
    echo json_encode(array('success' => false, 'error' => 'Invalid request method.'));
}
?>
