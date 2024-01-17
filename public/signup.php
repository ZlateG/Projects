<?php
    include '../resourses/includes/autoloader.php';
    session_start();
    if (isset($_SESSION['form_data'])) 
    {
        $formData = $_SESSION['form_data'];
        // Clear the stored form data from the session
        unset($_SESSION['form_data']);
    } else 
    { 
        // If there is no stored form data, initialize an empty array
        $formData = array(
            'uid' => '',
            'email' => ''
        );
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" href="./img/Logo.png" />
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>

    <!-- MAIN CSS -->
    <link rel="stylesheet" href="./styles.css">
    <link rel="stylesheet" href="./costom.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <!-- HTML CONTENT GOES HERE -->

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
                    <a href="./index.php" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">Home</a>
                </div>
            <?php
                }
            ?>

        </div>
        </div>

        <div class="bg_signup">
            <div class="container">
                <div class="flex justify-center items-center h-screen"> 
                    <div class="w-1/2 shadow bg-gray-200 p-5">
                        <h2 class="text-center">Sign up</h2>
                        <form action="../resourses/includes/signup.php" method="post">
                            <div class="mb-4">
                                <input class="bg-gray-50 mb-3 border border-gray-300 text-gray-900 text-sm rounded-lg w-full p-2.5" type="text" name="uid" placeholder="Username" value="<?= htmlspecialchars($formData['uid']) ?>">
                                <input class="bg-gray-50 mb-3 border border-gray-300 text-gray-900 text-sm rounded-lg w-full p-2.5" type="password" name="pwd" placeholder="Password">
                                <input class="bg-gray-50 mb-3 border border-gray-300 text-gray-900 text-sm rounded-lg w-full p-2.5" type="password" name="pwdRepeat" placeholder="Repeat Password">
                                <input class="bg-gray-50 mb-3 border border-gray-300 text-gray-900 text-sm rounded-lg w-full p-2.5" type="text" name="email" placeholder="E-mail" value="<?= htmlspecialchars($formData['email']) ?>">
                                <div>
                                    <p id="signUpError" class="text-red-400 text-center hidden"></p>    
                                </div>
                                <button class="text-white font-bold bg-blue-500 hover:bg-blue-600 focus:ring-4 rounded-lg text-sm px-5 py-2.5 text-center mt-3" type="submit" name="submit">SIGN UP</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    <!-- Footer -->
    <div id="quotable" class="w-full text-lg bg-blue-400 flex justify-center text-gray-700 p-4">
        
    </div>



<script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
<script src="index.js"></script>


</body>
</html>