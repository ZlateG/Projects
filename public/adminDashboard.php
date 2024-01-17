<?php
    include '../resourses/includes/autoloader.php';
    session_start(); 
    
    if (!isset($_SESSION["userid"]) || $_SESSION["is_admin"] !== 1) {
        header('Location: index.php?notAdmin');
        exit();
    }

    $dbh = new Dbh();
    $conn = $dbh->connect();

// Check connection
if ($conn === null) {
    die("Connection failed");
}

// Query to retrieve book information
$sql = "SELECT * FROM books";
$result = $conn->query($sql);
$books = [];

if ($result !== false) {
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $books[] = $row;
    }

    // Get the number of rows using rowCount
    $numRows = $result->rowCount();
} else {
    // Handle query error
    echo "Error: " . $conn->errorInfo()[2];
}
$bookManager = new BookManager();
$allUsers = $bookManager->getAllUsers();
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
    <link rel="stylesheet" href="./costom.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!--  -->
</head>
<body class="bg-gray-100">
    <!-- navbar -->
        <?php
            if (isset($_SESSION["is_admin"]) && $_SESSION["is_admin"] == 1) {
        
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

                    <a href="./index.php" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">Home</a>
                    <a href="../resourses/includes/logout.php" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">LOGOUT</a>
                </div>
                    <?php
                        }
                    ?>


            </div>
            
        </div>
        
        
  

 
 


    <!-- show and delete books -->
    <div class="container mx-auto px-4 py-8">
        <div class="overflow-x-auto">
            <h2 class="text-2xl font-semibold mb-4">Books</h2>
            <table class="min-w-full table-auto border bg-white"  style="overflow-x: hidden;">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="py-2 px-4 border border-gray-300">Title</th>
                        <th class="py-2 px-4 border border-gray-300">Author</th>
                        <th class="py-2 px-4 border border-gray-300">Published At</th>
                        <th class="py-2 px-4 border border-gray-300">No of Pages</th>
                        <th class="py-2 px-4 border border-gray-300">Category</th>
                        <!-- <th class="py-2 px-4 border border-gray-300">Image URL</th> -->
                        <th class="py-2 px-4 border border-gray-300">Actions</th>
                        <th class="py-2 px-4 border border-gray-300">Edit</th>
                        <th class="py-2 px-4 border border-gray-300">Delete</th>
                    </tr>
                </thead>
                <tbody id="booksTable">
                </tbody>
            </table>
            <div>
                <p id="bookMessage" class="text-red-400 text-center hidden"></p>    
            </div>
        </div>
    </div>
    <!-- Edit Book -->
    <div class="container mx-auto px-4 py-8" id="editBookContainer">
        <div class="overflow-x-auto">
            <h2 class="text-2xl font-semibold mb-4">Edit Book</h2>
            <form action="../resourses/includes/update_book.php" method="post">
            <table class="min-w-full table-auto border bg-white">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="py-2 px-4 border border-gray-300">Title</th>
                        <th class="py-2 px-4 border border-gray-300">Author</th>
                        <th class="py-2 px-4 border border-gray-300">Published At</th>
                        <th class="py-2 px-4 border border-gray-300">No of Pages</th>
                        <th class="py-2 px-4 border border-gray-300">Category</th>
                        <th class="py-2 px-4 border border-gray-300">Image URL</th>
                        <th class="py-2 px-4 border border-gray-300">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="py-2 px-4 border border-gray-300">
                            <input type="hidden" id="bookId" name="book_id"> 

                            <input type="text" id="newTitle1" name="title" class="border p-1 w-full">
                        </td>
                        <td class="py-2 px-4 border border-gray-300">
                            <select id="newAuthor1" name="author_id" class="border p-1 w-full">
                                <!-- Populate this dropdown with authors from the database -->
                            </select>
                        </td>
                        <td class="py-2 px-4 border border-gray-300">
                            <input type="date" id="newPublishedAt1" name="published_at"  class="border p-1 w-full">
                        </td>
                        <td class="py-2 px-4 border border-gray-300">
                            <input type="number" id="newNoOfPages1" name="no_of_pages" class="border p-1 w-full">
                        </td>
                        <td class="py-2 px-4 border border-gray-300">
                            <select id="newCategory1" name="category_id" class="border p-1 w-full">
                                <!-- Populate this dropdown with categories from the database -->
                            </select>
                        </td>
                        <td class="py-2 px-4 border border-gray-300">
                            <input type="text" id="newImageUrl1" name="image_url" class="border p-1 w-full">
                        </td>
                        <td class="py-2 px-4 border border-gray-300">
                            <button id="editBookBtn1" type="submit" class="bg-blue-400 hover:bg-blue-500 text-white px-4 py-1 rounded-lg">
                                Edit Book
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
            <div>
                <p id="editBookMessage" class="text-red-400 text-center hidden"></p>
            </div>
        </div>
    </div>                    
       <!-- add new book -->
    <div class="container mx-auto px-4 py-8">
        <div class="overflow-x-auto">
            <h2 class="text-2xl font-semibold mb-4">Add New Book</h2>
            <table class="min-w-full table-auto border bg-white">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="py-2 px-4 border border-gray-300">Title</th>
                        <th class="py-2 px-4 border border-gray-300">Author</th>
                        <th class="py-2 px-4 border border-gray-300">Published At</th>
                        <th class="py-2 px-4 border border-gray-300">No of Pages</th>
                        <th class="py-2 px-4 border border-gray-300">Category</th>
                        <th class="py-2 px-4 border border-gray-300">Image URL</th>
                        <th class="py-2 px-4 border border-gray-300">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="py-2 px-4 border border-gray-300">
                            <input type="text" id="newTitle" class="border p-1 w-full">
                        </td>
                        <td class="py-2 px-4 border border-gray-300">
                            <select id="newAuthor" class="border p-1 w-full">
                            </select>
                        </td>
                        <td class="py-2 px-4 border border-gray-300">
                            <input type="date" id="newPublishedAt" class="border p-1 w-full">
                        </td>
                        <td class="py-2 px-4 border border-gray-300">
                            <input type="number" id="newNoOfPages" class="border p-1 w-full">
                        </td>
                        <td class="py-2 px-4 border border-gray-300">
                            <select id="newCategory" class="border p-1 w-full">
                            </select>
                        </td>
                        <td class="py-2 px-4 border border-gray-300">
                            <input type="text" id="newImageUrl" class="border p-1 w-full">
                        </td>
                        <td class="py-2 px-4 border border-gray-300">
                            <button id="addBookBtn" class="bg-blue-400 hover:bg-blue-500 text-white px-4 py-1 rounded-lg">
                                Add Book
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div>
            <p id="addBookMessage" class="text-red-400 text-center hidden"></p>    
        </div>    
        </div>
    </div>


    <!-- manage authors -->
    <div class="container mx-auto px-4 py-8 ">

        <div class="overflow-x-auto">
            <h2 class="text-2xl font-semibold mb-4">Manage Authors</h2>
            <table id="authors-table" class="min-w-full table-auto border bg-white">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="py-2 px-4 border border-gray-300">First Name</th>
                        <th class="py-2 px-4 border border-gray-300">Last Name</th>
                        <th class="py-2 px-4 border border-gray-300">Short bio</th>
                        <th class="py-2 px-4 border border-gray-300">Action:</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                    <tr id="editTray" class="hidden">
                        <td class="py-2 px-4 border border-gray-300">
                            <input type="text" id="new_first_name" class="border p-1 w-full">
                        </td>
                        <td class="py-2 px-4 border border-gray-300">
                            <input type="text" id="new_last_name" class="border p-1 w-full">
                        </td>
                        <td class="py-2 px-4 border border-gray-300">
                            <textarea id="new_short_bio" rows="2" cols="50" class="border p-1 w-full"></textarea>
                        </td>
                        <td class="py-2 px-4 border border-gray-300">
                            <button id="editAuthor" class="bg-blue-400 hover:bg-blue-500 text-white px-4 py-1 rounded-lg">
                               Edit Author
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td class="py-2 px-4 border border-gray-300">
                            <input type="text" id="first_name" class="border p-1 w-full">
                        </td>
                        <td class="py-2 px-4 border border-gray-300">
                            <input type="text" id="last_name" class="border p-1 w-full">
                        </td>
                        <td class="py-2 px-4 border border-gray-300">
                            <textarea id="short_bio" rows="2" cols="50" class="border p-1 w-full"></textarea>
                        </td>
                        <td class="py-2 px-4 border border-gray-300">
                            <button id="addAuthor" class="bg-blue-400 hover:bg-blue-500 text-white px-4 py-1 rounded-lg">
                                Add Author
                            </button>
                        </td>
                    </tr>
                </tfoot>
            </table>
            <div>
                <p id="authorBioError" class="text-red-400 text-center hidden"></p>    
            </div>
        </div>
    </div>


    <!-- display categories  -->
    <div class="container mx-auto p-4">
        <h2 class="text-2xl font-semibold mb-4">Manage Category</h2>
        <table id="categories-table" class="min-w-full table-auto border bg-white">
            <thead>
                <tr class="bg-gray-200">
                    <th class="py-2 px-4 border border-gray-300">Category ID</th>
                    <th class="py-2 px-4 border border-gray-300">Category Name</th>
                    <th class="py-2 px-4 border border-gray-300">Edit</th>
                    <th class="py-2 px-4 border border-gray-300">Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
            <tfoot>
                <tr>
                    <td class="py-2 px-4 border border-gray-300"></td>
                    <td class="py-2 px-4 border border-gray-300">
                        <input type="text" id="newCategoryName" class="border p-1 w-full">
                    </td>
                    <td class="py-2 px-4 border border-gray-300">
                        <button id="addCategoryBtn" class="bg-blue-400 hover:bg-blue-500 text-white px-4 py-1 rounded-lg">
                            Add Category
                        </button>
                    </td>
                </tr>
            </tfoot>
        </table>
        <div>
            <p id="categoryMessage" class="text-red-400 text-center hidden"></p>    
        </div>                
    </div>

      <!-- Comments to be aprooved -->
    <div class="container mx-auto px-4 py-8 " >

        <div class="overflow-x-auto">
            <h2 class="text-2xl font-semibold mb-4">Unapproved Comments</h2>
            <table id="commentsTable" class="min-w-full table-auto border bg-white">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="py-2 px-4 border border-gray-300">Book_Title</th>
                        <th class="py-2 px-4 border border-gray-300">Author</th>
                        <th class="py-2 px-4 border border-gray-300">User_name</th>
                        <th class="py-2 px-4 border border-gray-300">Comment to be reviewed</th>
                        <th class="py-2 px-4 border border-gray-300">Action:</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            <div>
                <p id="commentMessage" class="text-red-400 text-center hidden"></p>    
            </div>
        </div>
    </div>
    <!-- Display users -->
    <div class="container mx-auto px-4 py-8">
        <h2 class="text-2xl font-semibold mb-4">Manage Users</h2>
        <table id="usersTable" class="min-w-full table-auto border bg-white">
            <thead class="bg-gray-100">
                <tr>
                    <th class="py-2 px-4 border border-gray-300">User ID</th>
                    <th class="py-2 px-4 border border-gray-300">Username</th>
                    <th class="py-2 px-4 border border-gray-300">Email</th>
                    <th class="py-2 px-4 border border-gray-300">Is Admin</th>
                    <th class="py-2 px-4 border border-gray-300">Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($allUsers as $user): ?>
                <tr>
                    <td class="py-2 px-4 border border-gray-300"><?= $user['user_id']; ?></td>
                    <td class="py-2 px-4 border border-gray-300"><?= $user['user_uid']; ?></td>
                    <td class="py-2 px-4 border border-gray-300"><?= $user['user_email']; ?></td>
                    <td class="py-2 px-4 border border-gray-300"><?= $user['is_admin'] ? 'Yes' : 'No'; ?></td>
                    <td class="py-2 px-4 border border-gray-300">
                    <form action="../resourses/includes/delete_user.php" method="post">
                        <input type="hidden" name="user_id" value="<?= $user['user_id']; ?>">
                        <button type="submit" name="deleteUserBtn">Delete User</button>
                    </form>


                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <div>
            <!-- You can add any messages or additional content here if needed -->
        </div>
    </div>


    <div id="quotable" class="w-full text-lg bg-blue-400 flex justify-center text-gray-700 p-4"></div>



<script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
<script src="adminDashboard.js"></script>

</body>
</html>