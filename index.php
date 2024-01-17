<?php
	// Create connection
	$conn = new mysqli("localhost", "root", "", "users");

	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}

	// Insert data into table when form is submitted
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$name = $_POST["fullName"];
    $companyName = $_POST["companyName"];
		$email = $_POST["email"];
		$phone = $_POST["contactNumber"];
    $studentType = $_POST["studentType"];

	// 
	if (isset($data['studentType'])) {
  		$studentType = $data['studentType'];
	} else {
  	// handle the case where the key does not exist
 
	}
	// 
     if (!empty($_POST ['fullName'])) {
      $name = $_POST['fullName'];
     } 
     else {
      echo center('Please enter Full Name');
     }


	$sql = "INSERT INTO form_data (fullName, companyName, email, contactNumber, studentType)
		VALUES ('$name', ' $companyName', '$email', '$phone', '$studentType')";

		if ($conn->query($sql) === TRUE) {
			echo center('<h1 class="p-3 rounded text-center bg-light text-success" >Success!<br> <span class="text-danger">Thank You!</span></h1>');
		} else {
				echo "Error: " . $sql . "<br>" . $conn->error;
		}
	}

		
    //  center screen message
    function center($content) {
      return '<div style="position:absolute; top:50%; left:50%; transform:translate(-50%, -10%);">' . $content . '</div>';
  	}

	//prevzemanje data
	$sql2 = "SELECT option_value FROM options_table";

	$result = mysqli_query($conn, $sql2);

	$options = array();

	while ($row = mysqli_fetch_assoc($result)) {
    $options[] = $row['option_value'];
	}

	mysqli_free_result($result);
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
  <body class="bg-warning">
    <!-- navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-warning fixed-top shadow">
      <div class="text-start">
      
        <a class="navbar-brand" href="#">
        <img src="./img/Logo.png" alt="Logo" class="logo mr-auto" />
        <figcaption>Brainster</figcaption> </a>
      </div>
   
     
      <button
        class="navbar-toggler"
        type="button"
        data-toggle="collapse"
        data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>
      <div
        class="collapse navbar-collapse font-weight-bold"
        id="navbarSupportedContent"
        >
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a
              class="nav-link"
              href="https://brainster.co/marketing/"
              target="_blank"
              >Академија за маркетинг<span class="sr-only">(current)</span></a
            >
          </li>
          <li class="nav-item">
            <a
              class="nav-link"
              href="https://brainster.co/full-stack/"
              target="_blank"
              >Академија за програмирање</a
            >
          </li>
          <li class="nav-item">
            <a
              class="nav-link"
              href="https://brainster.co/data-science/"
              target="_blank"
              >Академија за data science</a
            >
          </li>
          <li class="nav-item">
            <a
              class="nav-link"
              href="https://brainster.co/graphic-design/"
              target="_blank"
              >Академија за дизајн</a
            >
          </li>
        </ul>
        <div class="dropdownForm">
          <button
            class="btn btn-danger btn-sm font-weight-bold p-2"
            type="button"
            id="dropdownMenuButton"
            data-toggle="dropdownForm"
            aria-haspopup="true"
            aria-expanded="false"
            data-auto-close="false"
          >
            Вработи наш студент 
          </button>
          <div class="dropdown-menu submit-form">
            <div class="row justify-content-center">
              <div class="col-11 col-md-8 text-center">
                <h2 class="h1 my-5 font-weight-bold">Вработи студенти</h2>
                <form id="myForm" action="" method="POST">
                  <div class="row font-weight-bold">
                    <div class="col-md-6 form-group text-left">
                      <label for="fullName">Име и презиме</label>
                      <input
                        type="text"
                        class="form-control font-italic"
                        name="fullName"
                        id="fullName"
                        placeholder="Вашето име и презиме"
                        required
                      />
                    </div>
                    <div class="col-md-6 form-group text-left">
                      <label for="companyName">Име на компанијата</label>
                      <input
                        type="text"
                        class="form-control font-italic"
                        name="companyName"
                        id="companyName"
                        placeholder="Името на вашата компанија"
                        required
                      />
                    </div>
                    <div class="col-md-6 form-group text-left">
                      <label for="email">Контакт имејл</label>
                      <input
                        type="email"
                        class="form-control font-italic"
                        name="email"
                        id="email"
                        placeholder="Контакт имејл на вашата компанија"
                        required
                      />
                    </div>
                    <div class="col-md-6 form-group text-left ">
                      <label for="contactNumber">Контакт телефон</label>
                      <input
                        type="tel"
                        class="form-control font-italic mb-1"
                        name="contactNumber"
                        id="contactNumber"
                        placeholder="Контакт телефон на вашата компанија"
                        required
                      />
                    </div>
                    <div class="col-md-6 form-group text-left">
                      <label for="studentType">Тип на студенти:</label>
                      <select
                        class="form-control"
                        
                        name="studentType"
                        id="studentType"
                        required
                       
                      >
							<?php foreach ($options as $option): ?>
								<option value="<?php echo $option; ?>"><?php echo $option; ?></option>
							<?php endforeach; ?>
                      </select>
                    </div>
  
                      
                    <div class="col-md-6 sendform mt-2">
                      
                      <button type="submit" class="sin btn btn-danger btn-block my-4">
                        Испрати
                      </button>
                     
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Dropdown Form -->
    </nav>
    <!-- navbar -->
    <!-- Brainster Labs -->
      <div class=" bg-seting  d-flex justify-content-center align-items-center bg-img">
        <div class="typewriter mb-5">
          <h1 class="text-light mb-5 display-3 font-weight-bold"> Brainster Labs</h1>
        </div>
      </div>
    <!-- Brainster Labs -->
    <!-- Proekti -->
    <!-- Card filters -->
    <div class="container-fluid">
      <div class="row filters font-weight-bold">
        <input class="d-none" type="checkbox" id="filter-marketing" />
        <label
            class="col-md-4 bg-dark text-light text-center p-4 mb-0"
            id="marketing"
            for="filter-marketing"
        >
            <div class="row">
            <div class="col-10">
                Проекти на студенти по академијата за маркетинг
            </div>
            <div class="col-2">
                <i class="fa-solid fa-circle-check text-dark h3"></i>
            </div>
            </div>
        </label>

        <label
            class="col-md-4 bg-dark text-light text-center p-4 mb-0"
            id="coding"
            for="filter-coding"
        >
            <div class="row">
            <div class="col-10">
                Проекти на студенти по академијата за програмирање
            </div>
            <div class="col-2">
                <i class="fa-solid fa-circle-check text-dark h3"></i>
            </div>
            </div>
        </label>
        <input type="checkbox" id="filter-coding" class="d-none" />

        <label
            class="col-md-4 bg-dark text-light text-center p-4 dizajn mb-0"
            id="design"
            for="filter-design"
        >
            <div class="row">
            <div class="col-10">Проекти на студенти по академијата за дизајн</div>
            <div class="col-2">
                <i class="fa-solid fa-circle-check text-dark h3"></i>
            </div>
            </div>
        </label>
        <input type="checkbox" id="filter-design" class="d-none" />
      </div>
    </div>
    <!-- cards -->
    <div class="container-fluid">
      <div class="proekti text-center my-4">
        <h2 class="h1">Проекти</h2>
      </div>
      <div class="row justify-content-center">
        <!-- buttons -->
        
        <div class="col-11 col-md-10">
         
          <div class="row">
        
            <!-- Programiranje -->

            <div class="jcard jcoding col-md-6 col-lg-4 mb-4">
              <div class="card shadow coding border-warning">
                <img
                  src="./img/coding_1.jpg"
                  class="card-img-top"
                  alt="codding 1"
                />

                <div class="card-body">
                  <p class="card-text bg-warning d-inline px-2">
                    Академија за Програмирање
                  </p>
                  <h5 class="card-title">
                    Име на проектот стои овде во две линии
                  </h5>
                  <p class="card-text">
                    Краток опис во кој студентите ќе можат да опишат за што се
                    работи во проектот.
                  </p>
                  <p class="font-weight-bold small">Април - Октомври 2019</p>
                  <div class="text-right">
                    <a href="#" class="btn btn-danger">Дознај повеќе</a>
                  </div>
                </div>
              </div>
            </div>
            <div class="jcard jcoding col-md-6 col-lg-4 mb-4">
              <div class="card shadow coding border-warning">
                <img
                  src="./img/coding_2.jpg"
                  class="card-img-top"
                  alt="codding 2"
                />

                <div class="card-body">
                  <p class="card-text bg-warning d-inline px-2">
                    Академија за Програмирање
                  </p>
                  <h5 class="card-title">
                    Име на проектот стои овде во две линии
                  </h5>
                  <p class="card-text">
                    Краток опис во кој студентите ќе можат да опишат за што се
                    работи во проектот.
                  </p>
                  <p class="font-weight-bold small">Април - Октомври 2019</p>
                  <div class="text-right">
                    <a href="#" class="btn btn-danger">Дознај повеќе</a>
                  </div>
                </div>
              </div>
            </div>
            <div class="jcard jcoding col-md-6 col-lg-4 mb-4">
              <div class="card shadow coding border-warning mb-2">
                <img
                  src="./img/coding_3.jpg"
                  class="card-img-top"
                  alt="codding 3"
                />

                <div class="card-body">
                  <p class="card-text bg-warning d-inline px-2">
                    Академија за Програмирање
                  </p>
                  <h5 class="card-title">
                    Име на проектот стои овде во две линии
                  </h5>
                  <p class="card-text">
                    Краток опис во кој студентите ќе можат да опишат за што се
                    работи во проектот.
                  </p>
                  <p class="font-weight-bold small">Април - Октомври 2019</p>
                  <div class="text-right">
                    <a href="#" class="btn btn-danger">Дознај повеќе</a>
                  </div>
                </div>
              </div>
            </div>
            <div class="jcard jcoding col-md-6 col-lg-4 mb-4">
              <div class="card shadow coding border-warning">
                <img
                  src="./img/coding_4.jpg"
                  class="card-img-top"
                  alt="codding 4"
                />

                <div class="card-body">
                  <p class="card-text bg-warning d-inline px-2">
                    Академија за Програмирање
                  </p>
                  <h5 class="card-title">
                    Име на проектот стои овде во две линии
                  </h5>
                  <p class="card-text">
                    Краток опис во кој студентите ќе можат да опишат за што се
                    работи во проектот.
                  </p>
                  <p class="font-weight-bold small">Април - Октомври 2019</p>
                  <div class="text-right">
                    <a href="#" class="btn btn-danger">Дознај повеќе</a>
                  </div>
                </div>
              </div>
            </div>
            <div class="jcard jcoding col-md-6 col-lg-4 mb-4">
              <div class="card shadow coding border-warning">
                <img
                  src="./img/coding_5.jpg"
                  class="card-img-top"
                  alt="codding 5"
                />

                <div class="card-body">
                  <p class="card-text bg-warning d-inline px-2">
                    Академија за Програмирање
                  </p>
                  <h5 class="card-title">
                    Име на проектот стои овде во две линии
                  </h5>
                  <p class="card-text">
                    Краток опис во кој студентите ќе можат да опишат за што се
                    работи во проектот.
                  </p>
                  <p class="font-weight-bold small">Април - Октомври 2019</p>
                  <div class="text-right">
                    <a href="#" class="btn btn-danger">Дознај повеќе</a>
                  </div>
                </div>
              </div>
            </div>
            <div class="jcard jcoding col-md-6 col-lg-4 mb-4">
              <div class="card shadow coding border-warning">
                <img
                  src="./img/coding_6.jpg"
                  class="card-img-top"
                  alt="codding 6"
                />

                <div class="card-body">
                  <p class="card-text bg-warning d-inline px-2">
                    Академија за Програмирање
                  </p>
                  <h5 class="card-title">
                    Име на проектот стои овде во две линии
                  </h5>
                  <p class="card-text">
                    Краток опис во кој студентите ќе можат да опишат за што се
                    работи во проектот.
                  </p>
                  <p class="font-weight-bold small">Април - Октомври 2019</p>
                  <div class="text-right">
                    <a href="#" class="btn btn-danger">Дознај повеќе</a>
                  </div>
                </div>
              </div>
            </div>
            <div class="jcard jcoding col-md-6 col-lg-4 mb-4">
              <div class="card shadow coding border-warning">
                <img
                  src="./img/coding_7.jpg"
                  class="card-img-top"
                  alt="codding 7"
                />

                <div class="card-body">
                  <p class="card-text bg-warning d-inline px-2">
                    Академија за Програмирање
                  </p>
                  <h5 class="card-title">
                    Име на проектот стои овде во две линии
                  </h5>
                  <p class="card-text">
                    Краток опис во кој студентите ќе можат да опишат за што се
                    работи во проектот.
                  </p>
                  <p class="font-weight-bold small">Април - Октомври 2019</p>
                  <div class="text-right">
                    <a href="#" class="btn btn-danger">Дознај повеќе</a>
                  </div>
                </div>
              </div>
            </div>
            <div class="jcard jcoding col-md-6 col-lg-4 mb-4">
              <div class="card shadow coding border-warning">
                <img
                  src="./img/coding_8.jpg"
                  class="card-img-top"
                  alt="codding 8"
                />

                <div class="card-body">
                  <p class="card-text bg-warning d-inline px-2">
                    Академија за Програмирање
                  </p>
                  <h5 class="card-title">
                    Име на проектот стои овде во две линии
                  </h5>
                  <p class="card-text">
                    Краток опис во кој студентите ќе можат да опишат за што се
                    работи во проектот.
                  </p>
                  <p class="font-weight-bold small">Април - Октомври 2019</p>
                  <div class="text-right">
                    <a href="#" class="btn btn-danger">Дознај повеќе</a>
                  </div>
                </div>
              </div>
            </div>
            <div class="jcard jcoding col-md-6 col-lg-4 mb-4">
              <div class="card shadow coding border-warning">
                <img
                  src="./img/coding_9.jpg"
                  class="card-img-top"
                  alt="codding 9"
                />

                <div class="card-body">
                  <p class="card-text bg-warning d-inline px-2">
                    Академија за Програмирање
                  </p>
                  <h5 class="card-title">
                    Име на проектот стои овде во две линии
                  </h5>
                  <p class="card-text">
                    Краток опис во кој студентите ќе можат да опишат за што се
                    работи во проектот.
                  </p>
                  <p class="font-weight-bold small">Април - Октомври 2019</p>
                  <div class="text-right">
                    <a href="#" class="btn btn-danger">Дознај повеќе</a>
                  </div>
                </div>
              </div>
            </div>
            <div class="jcard jcoding col-md-6 col-lg-4 mb-4">
              <div class="card shadow coding border-warning">
                <img
                  src="./img/coding_10.jpg"
                  class="card-img-top"
                  alt="codding 10"
                />

                <div class="card-body">
                  <p class="card-text bg-warning d-inline px-2">
                    Академија за Програмирање
                  </p>
                  <h5 class="card-title">
                    Име на проектот стои овде во две линии
                  </h5>
                  <p class="card-text">
                    Краток опис во кој студентите ќе можат да опишат за што се
                    работи во проектот.
                  </p>
                  <p class="font-weight-bold small">Април - Октомври 2019</p>
                  <div class="text-right">
                    <a href="#" class="btn btn-danger">Дознај повеќе</a>
                  </div>
                </div>
              </div>
            </div>

            <!-- Marketing -->

            <div class="jcard jmarketing col-md-6 col-lg-4 mb-4">
              <div class="card shadow marketing border-warning">
                <img
                  src="./img/marketing_1.jpg"
                  class="card-img-top"
                  alt="Marketing 1"
                />

                <div class="card-body">
                  <p class="card-text bg-warning d-inline px-2">
                    Академија за Маркетинг
                  </p>
                  <h5 class="card-title">
                    Име на проектот стои овде во две линии
                  </h5>
                  <p class="card-text">
                    Краток опис во кој студентите ќе можат да опишат за што се
                    работи во проектот.
                  </p>
                  <p class="font-weight-bold small">Април - Октомври 2019</p>
                  <div class="text-right">
                    <a href="#" class="btn btn-danger">Дознај повеќе</a>
                  </div>
                </div>
              </div>
            </div>
            <div class="jcard jmarketing col-md-6 col-lg-4 mb-4">
              <div class="card shadow marketing border-warning">
                <img
                  src="./img/marketing_2.jpg"
                  class="card-img-top"
                  alt="marketing 2"
                />

                <div class="card-body">
                  <p class="card-text bg-warning d-inline px-2">
                    Академија за Маркетинг
                  </p>
                  <h5 class="card-title">
                    Име на проектот стои овде во две линии
                  </h5>
                  <p class="card-text">
                    Краток опис во кој студентите ќе можат да опишат за што се
                    работи во проектот.
                  </p>
                  <p class="font-weight-bold small">Април - Октомври 2019</p>
                  <div class="text-right">
                    <a href="#" class="btn btn-danger">Дознај повеќе</a>
                  </div>
                </div>
              </div>
            </div>
            <div class="jcard jmarketing col-md-6 col-lg-4 mb-4">
              <div class="card shadow marketing border-warning">
                <img
                  src="./img/marketing_3.jpg"
                  class="card-img-top"
                  alt="marketing 3"
                />

                <div class="card-body">
                  <p class="card-text bg-warning d-inline px-2">
                    Академија за Маркетинг
                  </p>
                  <h5 class="card-title">
                    Име на проектот стои овде во две линии
                  </h5>
                  <p class="card-text">
                    Краток опис во кој студентите ќе можат да опишат за што се
                    работи во проектот.
                  </p>
                  <p class="font-weight-bold small">Април - Октомври 2019</p>
                  <div class="text-right">
                    <a href="#" class="btn btn-danger">Дознај повеќе</a>
                  </div>
                </div>
              </div>
            </div>
            <div class="jcard jmarketing col-md-6 col-lg-4 mb-4">
              <div class="card shadow marketing border-warning">
                <img
                  src="./img/marketing_4.jpg"
                  class="card-img-top"
                  alt="marketing 4"
                />

                <div class="card-body">
                  <p class="card-text bg-warning d-inline px-2">
                    Академија за Маркетинг
                  </p>
                  <h5 class="card-title">
                    Име на проектот стои овде во две линии
                  </h5>
                  <p class="card-text">
                    Краток опис во кој студентите ќе можат да опишат за што се
                    работи во проектот.
                  </p>
                  <p class="font-weight-bold small">Април - Октомври 2019</p>
                  <div class="text-right">
                    <a href="#" class="btn btn-danger">Дознај повеќе</a>
                  </div>
                </div>
              </div>
            </div>

            <div class="jcard jmarketing col-md-6 col-lg-4 mb-4">
              <div class="card shadow marketing border-warning">
                <img
                  src="./img/marketing_6.jpg"
                  class="card-img-top"
                  alt="marketing 6"
                />

                <div class="card-body">
                  <p class="card-text bg-warning d-inline px-2">
                    Академија за Маркетинг
                  </p>
                  <h5 class="card-title">
                    Име на проектот стои овде во две линии
                  </h5>
                  <p class="card-text">
                    Краток опис во кој студентите ќе можат да опишат за што се
                    работи во проектот.
                  </p>
                  <p class="font-weight-bold small">Април - Октомври 2019</p>
                  <div class="text-right">
                    <a href="#" class="btn btn-danger">Дознај повеќе</a>
                  </div>
                </div>
              </div>
            </div>
            <div class="jcard jmarketing col-md-6 col-lg-4">
              <div class="card shadow marketing border-warning">
                <img
                  src="./img/marketing_5.jpg"
                  class="card-img-top"
                  alt="marketing 5"
                />

                <div class="card-body">
                  <p class="card-text bg-warning d-inline px-2">
                    Академија за Маркетинг
                  </p>
                  <h5 class="card-title">
                    Име на проектот стои овде во две линии
                  </h5>
                  <p class="card-text">
                    Краток опис во кој студентите ќе можат да опишат за што се
                    работи во проектот.
                  </p>
                  <p class="font-weight-bold small">Април - Октомври 2019</p>
                  <div class="text-right">
                    <a href="#" class="btn btn-danger">Дознај повеќе</a>
                  </div>
                </div>
              </div>
            </div>

            <!-- Design  -->

            <div class="jcard jdesign col-md-6 col-lg-4 mb-4">
              <div class="card shadow design border-warning">
                <img
                  src="./img/design_1.jpg"
                  class="card-img-top"
                  alt="design 1"
                />

                <div class="card-body">
                  <p class="card-text bg-warning d-inline px-2">
                    Академија за Дизајн
                  </p>
                  <h5 class="card-title">
                    Име на проектот стои овде во две линии
                  </h5>
                  <p class="card-text">
                    Краток опис во кој студентите ќе можат да опишат за што се
                    работи во проектот.
                  </p>
                  <p class="font-weight-bold small">Април - Октомври 2019</p>
                  <div class="text-right">
                    <a href="#" class="btn btn-danger">Дознај повеќе</a>
                  </div>
                </div>
              </div>
            </div>
            <div class="jcard jdesign col-md-6 col-lg-4 mb-4">
              <div class="card shadow design border-warning">
                <img
                  src="./img/design_2.jpg"
                  class="card-img-top"
                  alt="desing 2"
                />

                <div class="card-body">
                  <p class="card-text bg-warning d-inline px-2">
                    Академија за Дизајн
                  </p>
                  <h5 class="card-title">
                    Име на проектот стои овде во две линии
                  </h5>
                  <p class="card-text">
                    Краток опис во кој студентите ќе можат да опишат за што се
                    работи во проектот.
                  </p>
                  <p class="font-weight-bold small">Април - Октомври 2019</p>
                  <div class="text-right">
                    <a href="#" class="btn btn-danger">Дознај повеќе</a>
                  </div>
                </div>
              </div>
            </div>
            <div class="jcard jdesign col-md-6 col-lg-4 mb-4">
              <div class="card shadow design border-warning">
                <img
                  src="./img/design_3.jpg"
                  class="card-img-top"
                  alt="design 3"
                />

                <div class="card-body">
                  <p class="card-text bg-warning d-inline px-2">
                    Академија за Дизајн
                  </p>
                  <h5 class="card-title">
                    Име на проектот стои овде во две линии
                  </h5>
                  <p class="card-text">
                    Краток опис во кој студентите ќе можат да опишат за што се
                    работи во проектот.
                  </p>
                  <p class="font-weight-bold small">Април - Октомври 2019</p>
                  <div class="text-right">
                    <a href="#" class="btn btn-danger">Дознај повеќе</a>
                  </div>
                </div>
              </div>
            </div>
            <div class="jcard jdesign col-md-6 col-lg-4 mb-4">
              <div class="card shadow design border-warning">
                <img
                  src="./img/design_4.jpg"
                  class="card-img-top"
                  alt="design 4"
                />

                <div class="card-body">
                  <p class="card-text bg-warning d-inline px-2">
                    Академија за Дизајн
                  </p>
                  <h5 class="card-title">
                    Име на проектот стои овде во две линии
                  </h5>
                  <p class="card-text">
                    Краток опис во кој студентите ќе можат да опишат за што се
                    работи во проектот.
                  </p>
                  <p class="font-weight-bold small">Април - Октомври 2019</p>
                  <div class="text-right">
                    <a href="#" class="btn btn-danger">Дознај повеќе</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <footer class="bg-dark text-light text-center font-weight-bold py-3">
        <p>Изработено со <span class="text-danger h4">&hearts;</span> од студентите на Brainster</p>
    </footer>

    <!--JS -->
    <script>
      // not null form
      const form = document.getElementById('myForm');

      form.addEventListener('submit', function(event) {
       const fullName = document.getElementById('fullName');
       const email = document.getElementById('email');
       const companyName = document.getElementById('companyName');
       const contactNumber = document.getElementById('contactNumber');
       const studentType = document.getElementById('studentType');

       if (fullName.value === '' || email.value === '' || contactNumber.value === '' || companyName.value === '' ) {
       event.preventDefault();
       alert('Please fill in all the required fields');
        }
      });
      // not null form

      // test for dropdown
      //
      var dropdown = document.querySelector(".dropdownForm");

      // Get the dropdown menu element

      var menu = dropdown.querySelector(".dropdown-menu");

      // Add an event listener 

      dropdown.addEventListener("click", function (event) {
        // If the user clicked inside the dropdown menu, do nothing
        if (event.target.closest(".dropdown-menu")) {
          return;
        }

        // Prevent the default behavior of the click event
        event.preventDefault();
        event.stopPropagation();

        // Toggle the "show" class on the dropdown menu element
        menu.classList.toggle("show");
      });
      // test ends //
      const jcards = document.querySelectorAll(".jcard");
        jcards.forEach((jcard) => {
        jcard.addEventListener("mouseover", () => {
          jcard.style.transform = "scale(1.05)";
        });
        jcard.addEventListener("mouseout", () => {
          jcard.style.transform = "scale(1)";
        });
      });
      // test on Filter for cards
      document
        .querySelector("#filter-coding")
        .addEventListener("change", filterCoding);
      document
        .querySelector("#filter-design")
        .addEventListener("change", filterDesign);
      document
        .querySelector("#filter-marketing")
        .addEventListener("change", filterMarketing);

      // Function Coding
      function filterCoding() {
        hideAllCards();
        resetMarketing();
        resetDesign();

        if (document.querySelector("#filter-coding").checked) {
          var codingCards = document.querySelectorAll(".jcoding");
          codingCards.forEach((codingCard) => {
            codingCard.style.display = "inline-block";
          });
          var codingCards = document.querySelectorAll("#coding");
          codingCards.forEach((codingCard) => {
            codingCard.classList.add("mystyle");
          });

          document.querySelector("#filter-design").checked = false;
          document.querySelector("#filter-marketing").checked = false;
        } else {
          showAllCards();
          resetCoding();
        }
      }
      // reset Coding
      function resetCoding() {
        var codingCard = document.getElementById("coding");
        codingCard.classList.remove("mystyle");
      }
      // Design function
      function filterDesign() {
        hideAllCards();
        resetMarketing();
        resetCoding();

        if (document.querySelector("#filter-design").checked) {
          var jdesignCards = document.querySelectorAll(".jdesign");
          jdesignCards.forEach((jdesignCard) => {
            jdesignCard.style.display = "inline-block";
          });
          var dizajnCards = document.querySelectorAll(".dizajn");
          dizajnCards.forEach((dizajnCard) => {
            dizajnCard.classList.add("mystyle");
          });

          document.querySelector("#filter-coding").checked = false;
          document.querySelector("#filter-marketing").checked = false;
        } else {
          showAllCards();
          resetDesign();
        }
      }
      // reset Design
      function resetDesign() {
        var dizajnCard = document.getElementById("design");
        dizajnCard.classList.remove("mystyle");
      }
      // Function Marketing
      function filterMarketing() {
        hideAllCards();
        resetDesign();
        resetCoding();

        if (document.querySelector("#filter-marketing").checked) {
          var jmarketingCards = document.querySelectorAll(".jmarketing");
          jmarketingCards.forEach((jmarketingCard) => {
            jmarketingCard.style.display = "inline-block";
          });
          var marketingCards = document.querySelectorAll("#marketing");
          marketingCards.forEach((marketingCard) => {
            marketingCard.classList.add("mystyle");
          });

          document.querySelector("#filter-design").checked = false;
          document.querySelector("#filter-coding").checked = false;
        } else {
          showAllCards();
          resetMarketing();
        }
      }
      // reset Marketing
      function resetMarketing() {
        var dizajnCard = document.getElementById("marketing");
        dizajnCard.classList.remove("mystyle");
      }

      // hide cards Function
      function hideAllCards() {
        var alljCards = document.querySelectorAll(".jcard");

        alljCards.forEach((jcard) => {
          jcard.style.display = "none";
        });
      }

      function showAllCards() {
        var alljCards = document.querySelectorAll(".jcard");
        alljCards.forEach((jcard) => {
          jcard.style.display = "inline-block";
        });
      }
    </script>
    <!-- JS -->
       <!-- GOES AT THE BOOTOM OF THE BODY TAG -->
    <!-- JQUERY -->
    <script src="./assets/js/jquery-3.6.3.min.js"></script>
    <!-- POPPER JS -->
    <script src="./assets/js/popper.min.js"></script>
    <!-- BOOTSTRAP JS -->
    <script src="./assets/js/bootstrap.min.js"></script>

  </body>
</html>
