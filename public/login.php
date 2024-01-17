<?php
    include '../resourses/includes/autoloader.php';
    session_start();
    if (isset($_SESSION['useruid'])) 
    {
        header("Location: profile.php");
        exit();
    }          
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" href="./img/Logo.png" />
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log in</title>

    <!-- MAIN CSS -->
    <link rel="stylesheet" href="./styles.css">
    <link rel="stylesheet" href="./costom.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>
    <!-- HTML CONTENT GOES HERE -->
    <header>
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
        <div class="container mx-auto flex justify-between items-center ">
            <!-- Logo -->
            <a href="#" class="text-gray-600 text-3xl font-semibold">Brainster</a>
            
            <!-- Buttons -->
            <?php
                if(isset($_SESSION["userid"]))
                {
            ?>
                
                <div>
                    <a href="./profile.php" class="bg-blue-400 hover:bg-blue-500 text-white px-4 py-2 rounded-lg mr-4">Hello <?php echo $_SESSION["useruid"];?></a>
                    <a href="../resourses/includes/logout.php" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">LOGOUT</a>
                </div>
            <?php
                }
                else
                {
            ?>
                <div>
                    <a href="./index.php" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">Home</a>
                    <a href="./signup.php" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">Sign Up</a>
                </div>
            <?php
                }
            ?>

        </div>
        </div>
    </header>
    <!-- login form -->
    <div class="bg_signup">
        <div class="flex justify-center">
            <div class="w-1/2 bg-gray-200 p-5 mt-20 rounded-lg">
                <h2 class="text-center mt-5 mb-3 text-xl text-gray-400 font-bold">Login</h2>
                <form action="../resourses/includes/login.php" class="mb-4" method="post">
                    <div class="flex flex-col items-center"> <!-- Use flexbox for centering -->
                        <input type="text" class="bg-gray-50 mb-3 border border-gray-300 text-gray-900 text-sm rounded-lg w-1/2 p-2.5" name="uid" placeholder="Username">
                        <input type="password" class="bg-gray-50 mb-3 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-1/2 p-2.5" name="pwd" placeholder="Password">
                        <button type="submit" class="text-white font-bold bg-blue-500 hover:bg-blue-600 focus:ring-4 rounded-lg text-sm px-5 py-2.5 text-center" name="submit">Log in</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div id="quotable"  class="w-full text-lg bg-blue-400 flex justify-center text-gray-700 p-4">
       
    </div>

    <!-- SCRIPTS NEED TO BE AT THE BOOTM OF THE BODY TAG -->
 
<script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
<script src="index.js"></script>

</body>
</html>