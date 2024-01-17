<?php
include '../resourses/includes/autoloader.php';
session_start();
// var_dump($_SESSION);
$dbh = new Dbh();
$conn = $dbh->connect();


if (isset($_SESSION["userid"])) {
    $userId = $_SESSION["userid"];

    // Query to get items in the user's cart
    $sql = "SELECT b.title, b.image_url, b.book_id
            FROM shopping_cart AS sc
            INNER JOIN books AS b ON sc.book_id = b.book_id
            WHERE sc.user_id = :userId AND sc.removed = 0";
    
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    $stmt->execute();
    $cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" href="./img/Logo.png" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brainster Library</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="./costom.css">
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

    <!-- Display Cart Items -->
    <div class="w-full py-8 bg_empty">
        <div class="flex items-center justify-center bg-blue-100 px-10">
            <div class="cart-container p-5">
                <h2 class="font-semibold uppercase">Shopping Cart</h2>
                <p id="cartMessage" class="text-red-400 text-center font-semibold hidden">Item removed from cart</p>
                <div class="bg-white shadow-xl rounded-lg overflow-hidden mt-2">
                    <div class="p-4">
                        <?php if (!empty($cartItems)) { ?>
                            <div class="flex flex-wrap justify-center">
                                <?php foreach ($cartItems as $item) { ?>
                                    <div class="w-full md:w-1/3 lg:w-1/5 mb-4 p-2">
                                        <div class="bg-white shadow-xl rounded-lg overflow-hidden">
                                            <div class="p-4">
                                                <img src="<?= $item['image_url']; ?>" alt="<?= $item['title']; ?>" class="w-full h-auto">
                                                <p class="mt-2 mb-4 text-center"><?= $item['title']; ?></p>
                                                
                                                <button class="remove-from-cart bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg w-full" data-book-id="<?= $item['book_id']; ?>">Remove from cart</button>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        <?php } else { ?>
                            <p class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">Your cart is empty.</p>
                          
                        <?php } ?>
                    </div>
                </div>
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
