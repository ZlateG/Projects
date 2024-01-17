<?php
include '../resourses/includes/autoloader.php';
session_start();
// var_dump($_SESSION);
$dbh = new Dbh();
$conn = $dbh->connect();

if (isset($_GET['book_id']) && !empty($_GET['book_id'])) {
    $bookId = $_GET['book_id'];

    $sql = "SELECT b.*, a.first_name, a.last_name, c.comment,cat.category_name ,u.user_uid, n.note, n.user_id, n.note_id AS note_user_id
    FROM books AS b
    JOIN authors AS a ON b.author_id = a.author_id
    LEFT JOIN comments AS c ON b.book_id = c.book_id AND c.is_approved = 1
    LEFT JOIN users AS u ON c.user_id = u.user_id
    LEFT JOIN category AS cat ON cat.category_id = b.category_id
    LEFT JOIN notes AS n ON b.book_id = n.book_id AND n.user_id = :user_id
    WHERE b.book_id = :book_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':book_id', $bookId, PDO::PARAM_INT);
    $stmt->bindParam(':user_id', $_SESSION['userid'], PDO::PARAM_INT);
    $stmt->execute();
    $bookData = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //public comments
    if (!empty($bookData)) {
        $book = $bookData[0];
        $comments = [];

        // Process comments and store in the $comments array
        foreach ($bookData as $row) {
            if ($row['comment']) {
                $comments[] = [
                    'comment' => $row['comment'],
                    'user_uid' => $row['user_uid'],
                ];
            }
        }
    }
}
$year = date("Y", strtotime($book['published_at']));

// echo $year;
// var_dump($book);

$conn = null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" href="./img/Logo.png" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brainster Library</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <!-- Navbar -->
    <div class="bg-gray-200">
    <div class="container mx-auto flex py-5 justify-between items-center">
        <!-- Logo -->
        <a href="#" class="text-gray-600 text-3xl font-semibold">Brainster</a>

        <!-- Buttons -->
        <div>
            <?php if (isset($_SESSION["userid"])) { ?>
                <a href="./profile.php" class="bg-blue-400 hover:bg-blue-500 text-white px-4 py-2 rounded-lg mr-4">
                    Hello <?php echo $_SESSION["useruid"]; ?>
                </a>
                <a href="../resourses/includes/logout.php" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg mr-4">
                    LOGOUT
                </a>
            <?php } else { ?>
                <a href="./login.php" class="bg-blue-400 hover:bg-blue-500 text-white px-4 py-2 rounded-lg mr-4">
                    Login
                </a>
                <a href="./signup.php" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg mr-4">
                    Sign Up
                </a>
            <?php } ?>
                <a href="./index.php" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">Home</a>
        </div>
    </div>
    </div>

    <!-- Display the book details -->
    <div class="w-full py-8">
        <div class="flex justify-center bg-blue-100 px-10">
            <div class="carousel-container p-5">
                <?php if (isset($book)) { ?>
                    <h2 class="font-semibold uppercase">Category: <?= $book["category_name"]?></span></h2>
                    <button id="add-to-cart" data-book-id="<?= $bookId; ?>" class="bg-blue-400 hover:bg-blue-500 text-white px-4 py-2 rounded-lg">
                        Add to Cart
                    </button>
                    <div>
                        <p id="cartMessage" class="text-red-400 text-center hidden"></p>    
                    </div>
                    <div class="bg-white shadow-xl rounded-lg overflow-hidden max-w-xs mt-2">
                        <div class="p-10 bg-gray-100">
                            <img src="<?= $book['image_url']; ?>" alt="Book Cover" class="w-full h-auto">
                        </div>
                        <div class="p-4">
                            <h3 class="text-xl font-semibold mb-2"><?= $book['title']; ?></h3>
                            <p>Author: <?= $book['first_name'] . ' ' . $book['last_name']; ?></p>
                            <p>Published: <?= $year; ?> year.</p>
                            <p>Pages: <?= $book['no_of_pages']; ?></p>
                        </div>
                        
                    </div>

                    <!-- Display Comments -->
                    <div id="comments"></div>
                        <!-- Add Comments Form (conditionally displayed) -->
                        <?php if (isset($_SESSION['userid'])) { ?>
                            <div class="bg-white shadow-xl rounded-lg overflow-hidden max-w-xs mt-4 note-container">
                                <div class="p-4">
                                    <h3 class="text-xl font-semibold mb-2">Add Comment</h3>
                                    <form id="add-comment-form">
                                        <textarea id="comment-text" class="w-full p-2 border border-gray-300 rounded-lg mb-2" placeholder="Enter your Comment..."></textarea>
                                        <button class="bg-blue-400 hover:bg-blue-500 text-white px-4 py-2 rounded-lg">
                                            Add Comment
                                        </button>
                                    </form>
                                    <div>
                                        <p id="commentMessage" class="text-red-400 text-center hidden"></p>    
                                    </div>
                                </div>
                            </div>
                        <?php } ?>



                    <!-- Display Notes -->
                    <div id="notes"> 
                 
                    </div>
                           <!-- Add Note Form (conditionally displayed) -->
                           <?php if (isset($_SESSION['userid'])) { ?>
                                <div class="bg-white shadow-xl rounded-lg overflow-hidden max-w-xs mt-4 note-container">
                                    <div class="p-4">
                                        <h3 class="text-xl font-semibold mb-2">Add Note</h3>
                                        <form id="add-note-form">
                                            <textarea id="note-text" class="w-full p-2 border border-gray-300 rounded-lg mb-2" placeholder="Enter your note..."></textarea>
                                            <button class="bg-blue-400 hover:bg-blue-500 text-white px-4 py-2 rounded-lg">
                                                Add Note
                                            </button>
                                        </form>
                                        <div>
                                            <p id="noteMessage" class="text-red-400 text-center hidden"></p>    
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>




                <?php } else { ?>
                    <p>Book not found.</p>
                <?php } ?>
            </div>
        </div>
    </div>

    <!-- Quotable Section -->
    <div id="quotable" class="w-full text-lg bg-blue-400 flex justify-center text-gray-700 p-4">Quotes by famoust people</div>
    <script>
        var bookId = <?= $bookId; ?>; 
        var userId = <?php echo isset($_SESSION['userid']) ? $_SESSION['userid'] : 'null'; ?>;

    </script>
    <script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
    <script src="index.js"></script>
</body>
</html>
