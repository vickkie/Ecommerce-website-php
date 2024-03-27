<?php
if ($_SERVER['SCRIPT_FILENAME'] == __FILE__) {
    exit('Direct access is not allowed.');
}

error_reporting(0);

include('includes/config.php');
?>


<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="js/sweetalert.min.js"></script>
  <script>
function success() {
  swal("Success💃", "Request Under review!", "success");

}
</script>
<script>
function exists() {
  swal("Wait🍹", "Under review!", "warning");

}
</script>
<script>
function failed() {
  swal("Failed💃", "Request Failed!", "error");

}
</script>

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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/5.5.3/css/ionicons.min.css">

  <link rel="stylesheet" href="css/font-awesome.min.css">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" href="css/bootstrap-social.css">
  <link rel="stylesheet" href="css/bootstrap-select.css">
  <link rel="stylesheet" href="css/fileinput.min.css">
  <link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/adminlte.css">


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
  <script>
    function removeSpaces(input) {
        input.value = input.value.replace(/\s/g, '');
    }
</script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function() {
    $('.carousel').carousel({
      interval: 4000 // 4sec in milliseconds// code by uzi
    });
  });
</script>
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
</head>
<body style="margin-top:0px;">
    <div class="login-page">
        <div class="containerss"style="margin-right: 0px;margin-left: 0px;">
            <div class="row">

                <div class="col-md-7 bk-light">
                    <h1 class="text-center text-bold" style="color:green;">REGISTER</h1>
                    <div class="col-md-8 col-md-offset-2">
                        <div class="col-md-12">
                            <form method="post">
                                <div class="text-center">
                                    <span style="margin: auto;"><?php echo COMPANY_LOGO; ?>"</span>
                                </div>
                                <div id="error-messages"></div>
                                <br>
                                 <div class="text-center">
                                  <span class="d-block">Welcome</span>
                                  <span>It only takes a few seconds to request an account.</span>
                                   <h6 class="mt-3">Have an account? <a href="index.php" class="text-primary">&nbsp Login</a></h6>
                                 </div>
                                 <br>
                                <div class="text-center">
                                    <!-- Add "text-center" class to center the column content -->
                                    <div class="divider "></div>
                                </div><br>
                                <div class="row justify-content-center">
                                    <div class="col-md-6">
                                        <label for="" class="text-uppercase text-sm">Full name</label>
                                        <input type="text" placeholder="Full name" name="fullname" class="form-control mb" maxlength="20" style="height: 30px; padding: 4px;">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="id-no" class="text-uppercase text-sm">ID NO</label>
                                        <input type="text" id="idno" placeholder="National ID no" name="idno" class="form-control mb" style="height: 30px; padding: 4px;">
                                    </div>
                                </div>
                                <div class="row justify-content-center">
                                    <div class="col-md-6">
                                        <label for="" class="text-uppercase text-sm">Employee No.</label>
                                        <input type="text" placeholder="No. assigned" name="employee" class="form-control mb" style="height: 30px; padding: 4px;">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="" class="text-uppercase text-sm">Temporary Username</label>
                                        <div>
                                            <span id="username-error" style="color:red;display:none;">Username already taken</span>
                                        </div>
                                        <input type="text" placeholder="Username" name="username" class="form-control mb" maxlength="10" id="username" style="height: 30px; padding: 4px;">
                                    </div>
                                </div>
                                <div class="row justify-content-center">
                                    <div class="col-md-6">
                                        <label for="" class="text-uppercase text-sm">Temporary Password</label>
                                        <input type="Password" placeholder="Password" name="password" id="password" class="form-control mb" onblur="removeSpaces(this)" oninput="checkPasswordMatch()" maxlength="14" style="height: 30px; padding: 4px;">
                                         </div>


                                    <div class="col-md-6">
                                        <label for="" class="text-uppercase text-sm">Confirm Password</label>
                                                                            <div>
                                            <span id="donotmatch" style="color:red;display:none;">Passwords do not match</span>
                                     </div>
                                        <input type="Password" placeholder="Confirm" id="confirmpassword" class="form-control mb" oninput="checkPasswordMatch()" onblur="removeSpaces(this)" maxlength="14" style="height: 30px; padding: 4px;">
                                    </div>
                                </div>
                                     <div class="row justify-content-center">
                                    <div class="col-md-6">
                                      
                                        <div class="checkbox icheck">
                                            <input type="checkbox" name="accept" id="terms-checkbox" required>
                                            <label for="terms-checkbox">I agree to <a href="terms.php">terms</a></label>
                                        </div>
                                    </div>
                                </div>
                                </div>
                                <div class="row justify-content-center">
                                    <div class="col-md-6">
                                        <button class="btn bk-uzi3 btn-block" name="submit" type="submit" id="submit-button">REQUEST</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

            <!-- another point-->

                  <div class="col-md-5">
                    <div id="myCarousel" class="carousel slide" data-ride="carousel">
                        <!-- Indicators -->
                        <ol class="carousel-indicators">
                            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                            <li data-target="#myCarousel" data-slide-to="1"></li>
                            <li data-target="#myCarousel" data-slide-to="2"></li>
                            <li data-target="#myCarousel" data-slide-to="3"></li>
                        </ol>
                        <!-- Slides -->
                        <div class="carousel-inner">
                            <div class="item active">
                                <img src="img/indexs/index10.jpg" style="height: 100vh; width: 100%; object-fit: cover;">
                                <div class="text-overlay">
                                
                                        <center><h4>Delivering Excellence</h4><br>
                                        <p>Where Dreams Come to Life, With a Touch of Regal Splendor</p>
                                    </center>
                                </div>
                            </div>
                            <div class="item">
                                <img src="img/indexs/index9.jpg" alt="promokings" style="height: 100vh; width: 100%; object-fit: cover;">
                                <div class="text-overlay">
                                    <center style="color: black;">
                                        <h3>Potential</h3><br>
                                        <p>Unlocking Potential, Unleashing Success</p>
                                    </center>
                                </div>
                            </div>
                            <div class="item">
                                <img src="img/indexs/index6.jpg" alt="promokings" style="height: 100vh; width: 100%; object-fit: cover;">
                                <div class="text-overlay">
                                    <center style="color: black;">
                                        <h3>Integrity</h3><br>
                                        <p>Foundation of our business, guiding us to always do what is right.</p>
                                    </center>
                                </div>
                            </div>
                            <div class="item">
                                <img src="img/indexs/index8.jpg" alt="promokings" style="height: 100vh; width: 100%; object-fit: cover;">
                                <div class="text-overlay">
                                    <center>
                                        <h3>Transparency</h3><br>
                                        <p>Fostering trust and building strong relationships with our clients and partners.</p>
                                    </center>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- this point😄😄-->
                </div>

            </div>
        </div>
    </div>
</body>
</html>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
  var submitButton = $('#submit-button'); // Assuming your submit button has the id "submit-button"

  $('#username').on('input', function() {
    var username = $(this).val();
    $.ajax({
      url: 'check-request-username.php',
      method: 'POST',
      data: { username: username },
      success: function(response) {
        if (response === 'exists') {
          $('#username-error').show();
          submitButton.attr('disabled', true); // Disable the submit button
        } else {
          $('#username-error').hide();
          submitButton.attr('disabled', false); // Enable the submit button
        }
      }
    });
  });
});

</script>
<script>
  function checkPasswordMatch() {
    var password = document.getElementById("password").value;
    var confirmPassword = document.getElementById("confirmpassword").value;
    var doNotMatchMessage = document.getElementById("donotmatch");

    if (password === confirmPassword) {
      doNotMatchMessage.style.display = "none";
    } else {
      doNotMatchMessage.style.display = "block";
    }
  }
</script>
<?php
ob_start();
session_start();

include('includes/config.php');

error_reporting(0);

if(isset($_POST['submit'])) {
    $fullname = $_POST['fullname'];
    $id_no = $_POST['idno'];
    $employee = $_POST['employee'];
    $username = $_POST['username'];

    $pass = $_POST['password'];
    $password = md5($pass);
     $status = 'Requested';

    // Check if the record already exists
    $checkSql = "SELECT COUNT(*) FROM register_requests WHERE username = :username AND employee_no = :employee AND id_no=:id_no ";
    $checkQuery = $dbh->prepare($checkSql);
    $checkQuery->bindParam(':username', $username, PDO::PARAM_STR);
    $checkQuery->bindParam(':employee', $employee, PDO::PARAM_STR);
    $checkQuery->bindParam(':id_no', $id_no, PDO::PARAM_STR);
    
    $checkQuery->execute();
    $recordCount = $checkQuery->fetchColumn();

    if ($recordCount > 0) {
        echo '<script>exists();</script>';
    } else {
        // Insert the new record
        $insertSql = "INSERT INTO register_requests (fullname, username, id_no, employee_no,password, status) 
                      VALUES (:fullname, :username, :id_no, :employee, :password, :status)";
        $insertQuery = $dbh->prepare($insertSql);
        $insertQuery->bindParam(':fullname', $fullname, PDO::PARAM_STR);
        $insertQuery->bindParam(':username', $username, PDO::PARAM_STR);
        $insertQuery->bindParam(':id_no', $id_no, PDO::PARAM_STR);
        $insertQuery->bindParam(':employee', $employee, PDO::PARAM_STR);
        $insertQuery->bindParam(':password', $password, PDO::PARAM_STR);
        $insertQuery->bindParam(':status', $status, PDO::PARAM_STR);

        if ($insertQuery->execute()) {
            echo '<script>success();</script>';
        } else {
            echo '<script>failed();</script>';
        }
    }
}
ob_end_flush();
?>