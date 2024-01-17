<?php
// Include the necessary files for database connection and BookManager
include_once '../classes/dbh.php';
include_once '../classes/BookManager.php';

// Start the session and initialize the database connection
session_start();
$dbh = new Dbh();
$conn = $dbh->connect();

// Check if selectedCategories are set in the POST request
if (isset($_POST['selectedCategories'])) {
    
    $selectedCategories = $_POST['selectedCategories'];
    $bookManager = new BookManager();

    // Fetch books 
    $filteredBooks = $bookManager->getBooksForSelectedCategories($selectedCategories);

    // Display the books 
    echo ' <h3 class="text-center p-5 text-2xl text-gray-500">Your search results:</h3><div class="grid  grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-4 bg-gray-100">';
    if (empty($filteredBooks)) {
        echo '<p class="text-center p-5 text-xl text-gray-500"> No books in this category yet.</p>';
    } else {
    foreach ($filteredBooks as $book) {
        ?>
        <div class="max-w-xs m-5 mx-auto bg-white shadow-xl rounded-lg overflow-hidden">
            <h3 class="ml-4 mt-4 text-2xl capitalize text-gray-500"><?= $book['category_name'] ?></h3>

            <div class="p-4">
                <img src="<?= $book['image_url'] ?>" alt="Book Cover" class="w-full h-auto">
                <h3 class="text-xl font-semibold my-2"><?= $book['title'] ?></h3>
                <p class="text-sm font-semibold text-red-500">By: <?= $book['author_name'] ?></p>
                <a href="./currentbook.php?book_id=<?= $book['book_id'] ?>" class="mt-2 px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg block text-center">Read More</a>
            </div>
        </div>
        <?php
    }
    }

    echo '</div>';
}
?>
