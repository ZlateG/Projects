<?php
include_once '../classes/dbh.php';
include_once '../classes/BookManager.php';

session_start();
$dbh = new Dbh();
$conn = $dbh->connect();

if (isset($_POST['search'])) {
    
    $searchValue = htmlspecialchars($_POST["search"], ENT_QUOTES, 'UTF-8');
    $bookManager = new BookManager();

    // Fetch books based on the search query
    $searchResults = $bookManager->searchBooksAndAuthors($searchValue);

    // Display the search results as cards
    if (count($searchResults) > 0) {
        echo '<p class="text-center p-5 text-xl text-gray-500">Your search results:</p>';
        echo '<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 p-5">';
        foreach ($searchResults as $result) {
            // var_dump($result);
            ?>
            <div class="max-w-md mx-auto bg-white shadow-xl rounded-lg overflow-hidden">
                <img src="<?= $result['image_url'] ?>" alt="Book Cover" class="h-auto p-5">
                <div class="p-4">
                    <h3 class="text-xl font-semibold my-2"><?= $result['title'] ?></h3>
                    <p class="text-sm font-semibold text-red-500">By: <?= $result['author_name'] ?></p>
                    <a href="./currentbook.php?book_id=<?= $result['book_id'] ?>" class="mt-2 px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg block text-center">Read More</a>
                </div>
            </div>
            <?php
        }
        echo '</div>';
    } else {
        echo '<p class="text-center p-5 text-xl text-gray-500">No results found</p>';
    }
}
