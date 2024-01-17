<?php
try {
    include '../resourses/includes/autoloader.php';
    // include_once '../resourses/includes/search_options.php';
    session_start(); 
    
    $dbh = new Dbh();
    $conn = $dbh->connect();
    $bookManager = new BookManager();
    
    $categories = $bookManager->getCategoriesWithBooks();
    if ($conn === null) {
        die("Connection failed");
    }

    // Fetch categories and books here

    $conn = null;
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Debugging
// echo '<pre>';
// print_r($categories);
// echo '</pre>';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" href="./img/Logo.png" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brainster Library</title>
    <link href="../node_modules/tailwindcss/tailwind.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="./costom.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
</head>
<body>
    <!-- navbar -->
    <?php
        if (isset($_SESSION["is_admin"]) && $_SESSION["is_admin"] == 1) {
        // User is an admin
        ?>
                <div class="bg-red-100 p-4">
        <?php
        } 
            else 
        {
            // User is not an admin
        ?>
                <div class="bg-blue-100 p-4">
        <?php
        }
    ?>
    <div class="container mx-auto flex justify-between items-center">
            <!-- Logo -->
            <a href="#" class="text-gray-600 text-3xl font-semibold">Brainster</a>
            
            <!-- Buttons -->
            <?php
                if(isset($_SESSION["userid"]))
                {
            ?>
                
                <div>
                    <a href="./profile.php" class="bg-blue-400 hover:bg-blue-500 text-white px-4 py-2 rounded-lg mr-4">Hello <?= $_SESSION["useruid"];?></a>
                    <?php if (isset($_SESSION["is_admin"]) && $_SESSION["is_admin"] == 1){ ?>
                        
                    <a href="./adminDashboard.php" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">Admin Dashboard</a>
                    <?php } ?>
                    <a href="../resourses/includes/logout.php" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">LOGOUT</a>
                </div>
            <?php
                }
                else
                {
            ?>
                <div>
                    <a href="./login.php" class="bg-blue-400 hover:bg-blue-500 text-white px-4 py-2 rounded-lg mr-4">Login</a>
                    <a href="./signup.php" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">Sign Up</a>
                </div>
            <?php
                }
            ?>

        </div>
        </div>
            <!-- card container -->
        <div id="search" class="flex justify-between items-center flex-col md:flex-row p-5 bg-emerald-100">
            <div id="categorySearch" >
                <h2>Search by Category</h2>
                <?php foreach ($categories as $category) { ?>
                    <label>
                        <input type="checkbox" class="category-checkbox" value="<?= $category['category_id']; ?>">
                        <?= $category['category_name']; ?>
                    </label>
                <?php } ?>
            </div>
            <div id="searchBooks">
                <input id="searchInput" type="text" class="bg-gray-50 mb-3 border border-gray-300 text-gray-900 md:mt-5 text-sm rounded-lg p-2.5" placeholder="Enter book or author name">
            </div>
        </div>
        <div id="searchResults">
        </div>
        <div id="categoryResults">
        </div>
        <div class="bg_index"></div>           
        <div class="w-full">
            <div class="flex justify-center space-x-4 bg-blue-100 px-10">
                <div class="carousel-container">
                    <?php foreach ($categories as $category) {
                        // Check if the category has books
                        if (count($category['books']) > 0) { ?>
                            <div class="w-full py-8 px-5 ">
                                <div class="space-x-4 bg-blue-100 px-10">
                                    <p class="text-xl text-red-500 my-5 capitalize ml-5 font-bold underline"><?= $category['category_name']; ?> :</p>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-4 ">
                                    <?php foreach ($category['books'] as $book) { ?>
                                        <div class="bg-white shadow-xl rounded-lg overflow-hidden max-w-xs">
                                            <div class="p-10 bg-gray-100">
                                                <img src="<?= $book['image_url']; ?>" alt="Book Cover" class="w-full h-auto">
                                            </div>
                                            <div class="p-4">
                                                <h3 class="text-xl font-semibold mb-2"><?= $book['title']; ?></h3>
                                                <h3 class="text-xl font-semibold mb-5">By: <?= $book['author_name']; ?></h3>
                                                <a href="./currentbook.php?book_id=<?= $book['book_id']; ?>" class="mt-4 px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg">Read More</a>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        <?php }
                    } ?>
                </div>
            </div>
        </div>

    

    </div>
    <div id="quotable" class="w-full text-lg bg-blue-400 flex justify-center text-gray-700 p-4">
        
    </div>



<script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
<script src="index.js"></script>


</body>
</html>