<?php
if ($_SERVER['SCRIPT_FILENAME'] == __FILE__) {
    exit('Direct access is not allowed.');
}

session_start();
// Set session timeout duration (in seconds)
$sessionTimeout = 120; // 30 minutes

// Check if session variable exists and if the session has expired
if (isset($_SESSION['lastActivity']) && time() - $_SESSION['lastActivity'] > $sessionTimeout) {
    // Session expired, destroy the session and redirect to login page
    session_unset();
    session_destroy();
    header('Location: login.php'); // Replace "login.php" with your actual login page URL
    exit();
}

// Update the session activity timestamp
$_SESSION['lastActivity'] = time();

error_reporting(0);

include('includes/config.php');
?>

<!doctype html>

<html lang="en" class="no-js">



<head>
	<title>Promokings</title>
	   <link rel="shortcut icon" href="itemimg/promoking.jpg">

	<meta charset="UTF-8">

	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">

	<meta name="description" content="">

	<meta name="author" content="">



	

	<link rel="stylesheet" href="css/font-awesome.min.css">

	<link rel="stylesheet" href="css/bootstrap.min.css">

	<link rel="stylesheet" href="css/dataTables.bootstrap.min.css">

	<link rel="stylesheet" href="css/bootstrap-social.css">

	<link rel="stylesheet" href="css/bootstrap-select.css">

	<link rel="stylesheet" href="css/fileinput.min.css">

	<link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">

	<link rel="stylesheet" href="css/style.css">

	  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/5.5.3/css/ionicons.min.css">	

     <!-- Loading Scripts -->
	<script src="js/jquery.min.js"></script>

	<script src="js/bootstrap-select.min.js"></script>

	<script src="js/bootstrap.min.js"></script>

	<script src="js/jquery.dataTables.min.js"></script>

	<script src="js/dataTables.bootstrap.min.js"></script>

	<script src="js/Chart.min.js"></script>

	<script src="js/fileinput.js"></script>

	<script src="js/chartData.js"></script>

	<script src="js/main.js"></script>

	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


	    <style>
    .password-toggle {
      position: relative;
    }
    .password-toggle .toggle-icon {
      position: absolute;
      top: 50%;
      right: 10px;
      transform: translateY(-50%);
      cursor: pointer;
    }
  </style>
  <script>
    function togglePasswordVisibility() {
  var passwordInput = document.getElementById('password-input');
  var passwordToggleIcon = document.getElementById('password-toggle-icon');

  if (passwordInput.type === 'password') {
    passwordInput.type = 'text';
    passwordToggleIcon.classList.remove('fa-eye');
    passwordToggleIcon.classList.add('fa-eye-slash');
  } else {
    passwordInput.type = 'password';
    passwordToggleIcon.classList.remove('fa-eye-slash');
    passwordToggleIcon.classList.add('fa-eye');
  }
}

  </script>


<script>

function error() {
      swal("Wrong Details!😪", {
        buttons: { //creates a button. You can separate them with a comma.
          cancel: "Try Again!", 
          catch: {
            text: "Report",
            value: "catch",
          },
          register: true,
          //try: true,
          
        },
      customClass: {
      container: 'my-sweetalert-container',
      content: 'my-sweetalert-content',
      actions: 'my-sweetalert-actions',
      button: 'my-sweetalert-button',
    },
      })
      .then((value) => {
        switch (value) { //creates a switch inbetween the buttons we created above.
       
          case "register":
              window.location.href = "register.php";
             break;

       
          case "catch":
            swal("Okay!😒", "Reported successfully!", "success");
            break; 

          case "try": // this is a confirm function in sweetalert
          swal("Are you sure?", {
            dangerMode: true, //this option setup a confirm modal in sweetalert.
            buttons: true,
          });    
          break;     
        }
      });
    }

    </script>
    
<script>
function login() {
  swal("Success💃", "Login successfully!", "success");

}
</script>

 <!--reserve  
<script src="https://cdn.jsdelivr.net/npm/notiflix@2.7.0/dist/notiflix-aio-2.7.0.min.js"></script>
<script>
function login() {
  Notiflix.Notify.Success('Login successfully! 💃');
}
</script>

--> 
    


</head>



<body>

	<div class="login-page bk-img" style="background-image: url(img/background.jpg);">

		<div class="form-content">

			<div class="container" >

				<div class="row">

					<div class="col-md-6 col-md-offset-3">

						<h1 class="text-center text-bold  mt-4x"> Staff Login</h1>
						  

			     <div class="well row pt-2x pb-3x bk-light">

							<div class="col-md-8 col-md-offset-2">

								<form method="post">


                                  <?php echo 	COMPANY_LOGO ;?><br><br>
                                 <div id="error-messages">

                                 

                  </div>
                  <div>
									<label for="" class="text-uppercase text-sm">Your Username </label>

									<input type="text" placeholder="Username" name="username" class="form-control mb">

                                    <label for="password-input" class="text-uppercase text-sm">Password</label>
                                    <div class="password-toggle">
                                    <input type="password" id="password-input" placeholder="Password" name="password" class="form-control mb">
                                     <i id="password-toggle-icon" class="toggle-icon fa fa-eye" onclick="togglePasswordVisibility()"></i>

                 </div>
                 <div class="checkbox">
			    	    	<label>
			    	    		<input name="remember" type="checkbox" value="Remember Me"> Remember Me
			    	    	</label>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
			    	    	<a href="register-request.php" class="float-right">Register</a>
			     </div>

							
					        <button class="btn btn-primary btn-block" name="login" type="submit">LOGIN</button>



								</form>

							</div>

						</div>

					</div>

				

			</div>

		</div>

	</div>

	



	<script>
    ion.iconsLoaded.then(function () {
      var passwordToggleIcon = document.getElementById("password-toggle-icon");
      ion.add(passwordToggleIcon);
    });
  </script>


</body>



</html>

<?php
if ($_SERVER['SCRIPT_FILENAME'] == __FILE__) {
    exit('Direct access is not allowed.');
}

error_reporting(E_ALL);

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

   // Request query
    $requestsql = "SELECT username, password, status FROM register_requests WHERE username = :username AND password = :password";
    $requestquery = $dbh->prepare($requestsql);
    $requestquery->bindParam(':username', $username, PDO::PARAM_STR);
    $requestquery->bindParam(':password', $password, PDO::PARAM_STR);
    $requestquery->execute();
    $requestresults = $requestquery->fetchAll(PDO::FETCH_OBJ);


    // User login query
    $usersql = "SELECT username, password FROM users WHERE username = :username AND password = :password AND status = 'Approved'";
    $userquery = $dbh->prepare($usersql);
    $userquery->bindParam(':username', $username, PDO::PARAM_STR);
    $userquery->bindParam(':password', $password, PDO::PARAM_STR);
    $userquery->execute();
    $userresults = $userquery->fetchAll(PDO::FETCH_OBJ);

    // Admin login query
    $adminSql = "SELECT username, password, position FROM admin WHERE username = :username AND password = :password AND status = 'Approved'";
    $adminQuery = $dbh->prepare($adminSql);
    $adminQuery->bindParam(':username', $username, PDO::PARAM_STR);
    $adminQuery->bindParam(':password', $password, PDO::PARAM_STR);
    $adminQuery->execute();
    $adminresults = $adminQuery->fetchAll(PDO::FETCH_OBJ);

    if (!empty($userresults)) {
        // Prepare and execute the SQL query to retrieve the user's profile picture
        $sql = "SELECT profpic, position FROM users WHERE username = :username";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $uresult = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($uresult) {
            $_SESSION['alogin'] = $username;
            $_SESSION['position'] = $uresult['position'];
            $_SESSION['profilepicture'] = $uresult['profpic'];
            $_SESSION['id'] = $uresult['id'];

            if (strlen($_SESSION['alogin']) == 0) {
                header('location:index.php');
            } else {
                $position = $_SESSION['position'];
                if ($position == 'admin') {
                    echo "<script>login();</script>";
                    echo "<script>
                        setTimeout(function() {
                            window.location.href = 'dashboard-new.php';
                        }, 2000);
                    </script>";
                    exit();
                } elseif ($position == 'driver') {
                    echo "<script type='text/javascript'> document.location = 'dashboard-driver.php'; </script>";
                    exit();
                } elseif ($position == 'inventory manager') {
                    echo "<script type='text/javascript'> document.location = 'dashboard-inventory.php'; </script>";
                    exit();
                } elseif ($position == 'finance manager') {
                    echo "<script type='text/javascript'> document.location = 'dashboard-finance.php'; </script>";
                    exit();
                }
            }
        }
    } elseif (!empty($adminresults)) {
        $_SESSION['alogin'] = $username;
        $_SESSION['position'] = $adminresults[0]->position;
        $_SESSION['profilepicture'] = $adminresults[0]->profpic;
        $_SESSION['id'] = $adminresults[0]->id;

        $position = $_SESSION['position'];

        if ($position == 'superadmin') {
            echo "<script>login();</script>";
            echo "<script>
                setTimeout(function() {
                    window.location.href = 'dashboard-new.php';
                }, 2000);
            </script>";
            exit();
        }
    } 

   elseif (!empty($requestresults)) {
        $status = $requestresults[0]->status;

        if ($status == 'Approve') {
            $_SESSION['alogin'] = $username;
            $_SESSION['id'] = $requestresults[0]->id;
             $_SESSION['position'] = $status;
            
            echo "<script>login();</script>";
            echo "<script>
                setTimeout(function() {
                    window.location.href = 'dashboard-newbie.php';
                }, 2000);
            </script>";
            exit();
        }
    } 

    else {
        // No matching record in users or admin table
           echo "<script>error();</script>";
}

}

?>






