<?php
// Create connection
$conn = new mysqli("localhost", "root", "", "users");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data from form_data table
$sql = "SELECT * FROM form_data";
$result = mysqli_query($conn, $sql);

// Close connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <link rel="icon" href="./img/Logo.png"/>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Brainster</title>
    <!-- font awsome -->
    <script
      src="https://kit.fontawesome.com/40372871aa.js"
      crossorigin="anonymous"
    ></script>

    <!-- BOOSTRAP CSS -->
    <link rel="stylesheet" href="./assets/css/bootstrap.min.css" />
    <!-- MAIN CSS -->
    <link rel="stylesheet" href="./assets/css/main.css" />
  </head>

</head>
<body>
    <div class="container-fluid">
     <div class="row justify-content-center mb-4">
        <div class="col-10 text-center">
             <h1>Employer Details</h1>
	         <table>
                <tr>
                    <th>Full Name</th>
                    <th>Company Name</th>
                    <th>Email</th>
                    <th>Contact Number</th>
                    <th>Student Type</th>
		        </tr>
		        <?php
                // forma za prevzemanej detali od tabela
                    if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . $row["fullName"] . "</td>";
                            echo "<td>" . $row["companyName"] . "</td>";
                            echo "<td>" . $row["email"] . "</td>";
                            echo "<td>" . $row["contactNumber"] . "</td>";
                            echo "<td>" . $row["studentType"] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No data found.</td></tr>";
                    }
		      ?>
	         </table>
            </div>
        </div>
    </div>
    <footer class="bg-dark text-light text-center font-weight-bold py-3">
        <p>Изработено со <span class="text-danger h4">&hearts;</span> од студентите на Brainster</p>
    </footer>

   <!-- JQUERY -->
   <script src="./assets/js/jquery-3.6.3.min.js"></script>
    <!-- POPPER JS -->
    <script src="./assets/js/popper.min.js"></script>
    <!-- BOOTSTRAP JS -->
    <script src="./assets/js/bootstrap.min.js"></script>

  </body>
</html>

