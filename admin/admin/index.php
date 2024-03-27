<?php
if ($_SERVER['SCRIPT_FILENAME'] == __FILE__) {
    exit('Direct access is not allowed.');
}

error_reporting(0);
session_start();
// session timeout duration (in seconds)
$sessionTimeout = 1500;

// Check if session variable exists and if the session has expired
if (isset($_SESSION['lastActivity']) && time() - $_SESSION['lastActivity'] > $sessionTimeout) {
    // Session expired, destroy the session and redirect to login page
    session_unset();
    session_destroy();
    header('Location: index.php');
    exit();
}

// Update the session activity timestamp
$_SESSION['lastActivity'] = time();

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
    <link rel="stylesheet" href="css/adminlte.css">
    
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
    <script src="js/sweetalert.min.js"></script>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function() {
    $('.carousel').carousel({
      interval: 4000 // 10 minutes in milliseconds
    });
  });
</script>

<script type="text/javascript">
    window.onload = function() {
  // Check if cookies are enabled
  if (!navigator.cookieEnabled) {
    showCookieConsent();
  }
};

function showCookieConsent() {
  var cookieConsent = document.getElementById('cookieConsent');
  cookieConsent.style.display = 'block';

  var acceptCookies = document.getElementById('acceptCookies');
  acceptCookies.addEventListener('click', function() {
    setCookieConsent();
  });
}

function setCookieConsent() {
  var cookieConsent = document.getElementById('cookieConsent');
  cookieConsent.style.display = 'none';

  // Set a cookie to track the user's consent
  document.cookie = 'cookieConsent=true; expires=Thu, 31 Dec 2099 23:59:59 UTC; path=/';
}

  </script>

</script>

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
                buttons: {
                    cancel: "Try Again!",
                    catch: {
                        text: "Report",
                        value: "catch",
                    },
                    register: true,
                },
                customClass: {
                    container: 'my-sweetalert-container',
                    content: 'my-sweetalert-content',
                    actions: 'my-sweetalert-actions',
                    button: 'my-sweetalert-button',
                },
            }).then((value) => {
                switch (value) {
                    case "register":
                        window.location.href = "register.php";
                        break;
                    case "catch":
                        swal("Okay!😒", "Reported successfully!", "success");
                        break;
                    case "try":
                        swal("Are you sure?", {
                            dangerMode: true,
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
</head>
<body>
    <div class="login-page bk-img">
    <div class="containers" style="margin-right: 0px;margin-left: 0px;">
      <div class="row">
        <div class="col-md-4">
          
<div id="myCarousel" class="carousel slide" data-ride="carousel">
  <!-- Indicators -->
  <ol class="carousel-indicators">
    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
    <li data-target="#myCarousel" data-slide-to="1"></li>
    <li data-target="#myCarousel" data-slide-to="2"></li>
    <li data-target="#myCarousel" data-slide-to="3"></li>
    <li data-target="#myCarousel" data-slide-to="4"></li>
  </ol>
  <!-- Slides -->
  <div class="carousel-inner">
    
    <div class="item active">
      <img src="img/indexs/index4.jpg" style="height: 100vh; width: 100%; object-fit: cover;">
      <div class="text-overlay">
        <center><h4>Excellence</h4><br>
        <p>Where Dreams Come to Life, With a Touch of Regal Splendor</p></center>
      </div>
    </div>
    <div class="item">
      <img src="img/indexs/index8.jpg" alt="promokings" style="height: 100vh; width: 100%; object-fit: cover;">
      <div class="text-overlay">
         <center><h3>Potential</h3><br>
        <p>Unlocking Potential, Unleashing Success</p></center>
      </div>
    </div>
    <div class="item">
      <img src="img/indexs/index3.jpg" alt="promokings" style="height: 100vh; width: 100%; object-fit: cover;">
      <div class="text-overlay">
        <center><h3>Integrity</h3><br>
        <p>Foundation of our business, guiding us to always do what is right.</p></center>
      </div>
    </div>
    <div class="item">
      <img src="img/indexs/index7.jpg" alt="promokings" style="height: 100vh; width: 100%; object-fit: cover;">
      <div class="text-overlay">
        <center><h3>Transparency</h3><br>
        <p>Fostering trust and building strong relationships with our clients and partners.</p></center>
      </div>
    </div>
    <div class="item">
      <img src="img/indexs/index6.jpg" style="height: 100vh; width: 100%; object-fit: cover;filter: blur(5px);">
      <div class="text-overlay">
        <center style="color: black;"><h4>Delivery</h4><br>
        <p>Connecting anticipation with satisfaction, transforming expectations into tangible delight</p></center>
      </div>
    </div>
  </div>
</div>
</div>

<div class="col-md-8 bk-light">
<h1 class="text-center text-bold mt-4x">STAFF LOGIN</h1>
          
<div class="col-md-12">
  <form method="post">
    <div class="text-center">
      <span style="margin: auto;"><?php echo COMPANY_LOGO; ?></span>
    </div>
    <div id="error-messages"></div>
    <br><br>
    <div class="text-center">
      <span class="d-block">Welcome back,</span>
      <span>Please sign in to your account.</span>
      <h6 class="mt-3">No account? <a href="register-request.php" class="text-primary">&nbsp Sign up now</a></h6>
    </div>
    <br>
    
             <div class="text-center"> <!-- Add "text-center" class to center the column content -->
                <div class="divider "></div>
             </div><br>

    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="row">
          <div class="col">
            <label for="username" class="text-uppercase text-sm">Username</label>
            <input type="text" placeholder="Username" name="username" class="form-control mb" style="height: 30px; padding: 4px;">
          </div>
          <div class="col">
            <label for="password-input" class="text-uppercase text-sm">Password</label>
            <div class="password-toggle">
              <input type="password" id="password-input" placeholder="Password" name="password" class="form-control mb" style="height: 30px; padding: 6px;">
              <i id="password-toggle-icon" class="toggle-icon fa fa-eye" onclick="togglePasswordVisibility()"></i>
            </div>
          </div>
        </div>

        <button class="btn btn-primary btn-block" name="login" type="submit">LOGIN</button>
      </div>
    </div>
  </form>
  <br><br><br><br>
</div><span class="copyright">
                        
    <center>Copyright &copy;<script>document.write(new Date().getFullYear());</script> <?php echo DESIGNER; ?>. All rights reserved</center>
                            
</span>
<div id="cookieConsent" class="cookie-consent" style="background-color:!important;">
    <div class="cookie-message"  style="color:black;">
      This website uses cookies to ensure you get the best experience on our website. 
       <?php
    for ($i = 1; $i <= 3; $i++) {
    echo "&nbsp;";
       }
       ?>  Please Allow Cookies
      <?php
    for ($i = 1; $i <= 6; $i++) {
    echo "&nbsp;";
       }
       ?>
      <a href="errors/error-cookies.php" id="how" class="accept-cookies">How to set?</a>
      
      <?php
    for ($i = 1; $i <= 2; $i++) {
    echo "&nbsp;";
       }
       ?>
     <a hrefs="javascript:void(0)" id="acceptCookies" class="accept-cookies">🍪🍪</a>
    </div>
  </div>




          </div>

        <!-- </div>-->
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

error_reporting(0);

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $pass = $_POST['password'];
    $password = md5($pass);


     //new  user  Request query
    $requestsql = "SELECT username, password, status FROM register_requests WHERE username = :username AND password = :password 
    AND status= 'Approve' ";
    $requestquery = $dbh->prepare($requestsql);
    $requestquery->bindParam(':username', $username, PDO::PARAM_STR);
    $requestquery->bindParam(':password', $password, PDO::PARAM_STR);
    $requestquery->execute();
    $requestresults = $requestquery->fetchAll(PDO::FETCH_OBJ);



    // User login query
    $usersql = "SELECT username, password, position, profpic, id FROM users WHERE username = :username AND password = :password AND status = 'Approved'";
    $userquery = $dbh->prepare($usersql);
    $userquery->bindParam(':username', $username, PDO::PARAM_STR);
    $userquery->bindParam(':password', $password, PDO::PARAM_STR);
    $userquery->execute();
    $userresults = $userquery->fetchAll(PDO::FETCH_OBJ);

    // Admin login query
    $adminSql = "SELECT username, password, position, profpic, id FROM admin WHERE username = :username AND password = :password AND status = 'Approved'";
    $adminQuery = $dbh->prepare($adminSql);
    $adminQuery->bindParam(':username', $username, PDO::PARAM_STR);
    $adminQuery->bindParam(':password', $password, PDO::PARAM_STR);
    $adminQuery->execute();
    $adminresults = $adminQuery->fetchAll(PDO::FETCH_OBJ);

    if (!empty($userresults)) {
        $_SESSION['alogin'] = $username;
        $_SESSION['position'] = $userresults[0]->position;
        $_SESSION['profilepicture'] = $userresults[0]->profpic;
        $_SESSION['id'] = $userresults[0]->id;

        $loginSuccessful = true;

        $userData = $userresults[0];

        // Insert login data into the database
        $insertQuery = "INSERT INTO staff_login_tracking (staff_id, login_time, username) VALUES (:staff_id, NOW(), :username)";
        $stmt = $dbh->prepare($insertQuery);
        $stmt->bindParam(':staff_id', $userData->id, PDO::PARAM_INT);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();

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
            echo "<script>login();</script>";
            echo "<script>
                setTimeout(function() {
                    window.location.href = 'dashboard-driver.php';
                }, 2000);
            </script>";
            exit();
        } elseif ($position == 'inventory manager') {
            echo "<script>login();</script>";
            echo "<script>
                setTimeout(function() {
                    window.location.href = 'dashboard-inventory.php';
                }, 2000);
            </script>";
            exit();
        } elseif ($position == 'finance manager') {
            echo "<script>login();</script>";
            echo "<script>
                setTimeout(function() {
                    window.location.href = 'dashboard-finance.php';
                }, 2000);
            </script>";
            exit();
        }
    } elseif (!empty($adminresults)) {
        $_SESSION['alogin'] = $username;
        $_SESSION['position'] = $adminresults[0]->position;
        $_SESSION['profilepicture'] = $adminresults[0]->profpic;
        $_SESSION['id'] = $adminresults[0]->id;

        $loginSuccessful = true;

        $adminData = $adminresults[0];

        // Insert login data into the database
        $insertQuery = "INSERT INTO staff_login_tracking (staff_id, login_time, username) VALUES (:staff_id, NOW(), :username)";
        $stmt = $dbh->prepare($insertQuery);
        $stmt->bindParam(':staff_id', $adminData->id, PDO::PARAM_INT);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();

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
if (!empty($requestresults)) {
    $status = $requestresults[0]->status;

    if ($status == 'Approve') {
        $_SESSION['alogin'] = $username;
        $_SESSION['id'] = $requestresults[0]->id;
        $_SESSION['position'] = $status;

        $loginSuccessful = true;

        $requestData = $requestresults[0];

        // Insert login data into the database
        $insertQuery = "INSERT INTO staff_login_tracking(staff_id, login_time, username) VALUES (:staff_id, NOW(), :username)";
        $stmt = $dbh->prepare($insertQuery);
        $stmt->bindParam(':staff_id', $requestData->id, PDO::PARAM_INT);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        
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