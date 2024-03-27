<?php
session_start();
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(0);

include('includes/config.php');

$allowedPositions = array('inventory manager', 'admin' ,'superadmin');

// Check if the user is logged in and has an allowed position
if (empty($_SESSION['alogin']) || !in_array($_SESSION['position'], $allowedPositions)) {
    // Redirect the user to the access-denied page or any other appropriate page
    header('location:errors/access-denied.php');
    exit(); // Stop further execution of the script
}
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1500)) {
    // Last activity was more than 30 minutes ago
    session_unset();     // Unset all session variables
    session_destroy();   // Destroy the session
    header('location: index.php'); // Redirect the user to the login page
    exit(); // Stop further execution of the script
}

// Update last activity time stamp
$_SESSION['LAST_ACTIVITY'] = time();

if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
    if (isset($_POST['submit'])) {
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $address = $_POST['address'];
        $mobile = $_POST['mobile'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];
         $status = 'Unapproved';

        // Check if the username already exists
        $checkUsernameQuery = $dbh->prepare("SELECT * FROM driver WHERE username = :username");
        $checkUsernameQuery->bindParam(':username', $username, PDO::PARAM_STR);
        $checkUsernameQuery->execute();

        if ($checkUsernameQuery->rowCount() > 0) {
            $error = "Username already exists. Please choose a different username.";
             $errorClass = "errorGreen"; // Assign a class for red color
        } else {
            $sql = "INSERT INTO driver (firstname, lastname, address, mobile, username, password, email ,status) 
                    VALUES (:firstname, :lastname, :address, :mobile, :username, :password, :email ,:status)";

            $query = $dbh->prepare($sql);
            $query->bindParam(':firstname', $firstname, PDO::PARAM_STR);
            $query->bindParam(':lastname', $lastname, PDO::PARAM_STR);
            $query->bindParam(':address', $address, PDO::PARAM_STR);
            $query->bindParam(':mobile', $mobile, PDO::PARAM_STR);
            $query->bindParam(':username', $username, PDO::PARAM_STR);
            $query->bindParam(':password', $password, PDO::PARAM_STR);
            $query->bindParam(':email', $email, PDO::PARAM_STR);
             $query->bindParam(':status', $status, PDO::PARAM_STR);

            if ($query->execute()) {
                $msg = "User added successfully";
            } else {
                $error = "Something went wrong. Please try again";
            }
        }
    }

?>


<!doctype html>
<html lang="en" class="no-js">
  <head>
    
     <link rel="shortcut icon" href="itemimg/promoking.jpg">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="theme-color" content="#3e454c">
    <title>Add Driver
    </title>
    <!-- Font awesome -->
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <!-- Sandstone Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Bootstrap Datatables -->
    <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
    <!-- Bootstrap social button library -->
    <link rel="stylesheet" href="css/bootstrap-social.css">
    <!-- Bootstrap select -->
    <link rel="stylesheet" href="css/bootstrap-select.css">
    <!-- Bootstrap file input -->
    <link rel="stylesheet" href="css/fileinput.min.css">
    <!-- Awesome Bootstrap checkbox -->
    <link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
    <!-- Admin Stye -->
    <link rel="stylesheet" href="css/style.css">
    <script type= "text/javascript" src="../vendor/countries.js">
    </script>
    <style>
      .errorWrap {
        padding: 10px;
        margin: 0 0 20px 0;
        background: #dd3d36;
        color:#fff;
        -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
        box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
      }
      .succWrap{
        padding: 10px;
        margin: 0 0 20px 0;
        background: #5cb85c;
        color:#fff;
        -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
        box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
      }
    </style>
  </head>
  <body>
   
                   , 3000);
      }
                       );
    </script>
  </body>
</html>
<?php } ?>
 <?php include('includes/header.php');?>
    <div class="ts-main-content">
      <?php include('includes/leftbar.php');?>
      <div class="content-wrapper">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <h2 class="page-title">Add Driver
              </h2>
     <div class="x_content">
  <ul class="nav nav-tabs bar_tabs " id="myTab" role="tablist">
    <li class="nav-item">
      <a class="nav-link " id="profile-tab" href="manage-driver.php">Approved</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" id="contact-tab" href="new-driver.php">Unapproved</a>
    </li>
    <li class="nav-item">
      <a class="nav-link active" id="contact-tab" href="add-driver.php">Register</a>
    </li>
  </ul>
</div>
              <div class="row">
                <div class="col-md-12">
                  <div class="panel panel-default">
                    <div class="panel-heading">Driver Info
                    </div>
                    <?php if($error){?>
                    <div class="errorWrap">
                      <?php echo htmlentities($error); ?> 
                    </div>
                    <?php } 
                    else if($msg){?>
                    <div class="succWrap">
                      <?php echo htmlentities($msg); ?> 
                    </div>
                    <?php }?> 
                    
               <div class="panel-body">
  <form method="post" class="form-horizontal" enctype="multipart/form-data" >
    <div class="form-group">
      <label class="col-sm-2 control-label">First Name <span style="color:red">*</span></label>
      <div class="col-sm-4">
        <input type="text" name="firstname" class="form-control" placeholder="Enter First name" required>

      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label">Last Name <span style="color:red">*</span></label>
      <div class="col-sm-4">
        <input type="text" name="lastname" class="form-control" 
         placeholder="Enter Lastname"  required>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label">Address location <span style="color:red">*</span></label>
      <div class="col-sm-4">
        <input type="text" name="address" class="form-control" 
        placeholder="Enter Address" required>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label">Email <span style="color:red">*</span></label>
      <div class="col-sm-4">
        <input type="email" name="email" class="form-control" required placeholder="Enter your email">

      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label">Mobile <span style="color:red">*</span></label>
      <div class="col-sm-4">
        <input type="number" name="mobile" placeholder="Enter Mobile" class="form-control" required>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label">User Name <span style="color:red">*</span></label>
      <div class="col-sm-4">
        <input type="text" name="username" placeholder="Enter Username" class="form-control" required>
      </div>
    </div>
    <div class="form-group">
  <label class="col-sm-2 control-label">Enter password <span style="color:red">*</span></label>
  <div class="col-sm-4">
    <input type="text" name="password" id="password" class="form-control" placeholder="Enter password" required>
  </div>
</div>
<div class="form-group">
  <label class="col-sm-2 control-label">Confirm password <span style="color:red">*</span></label>
  <div class="col-sm-4">
    <input type="text" name="password2" id="password2" class="form-control" placeholder="Confirm password" required>
    <span id="password-error" style="color:red; display:none;">Passwords do not match.</span>
  </div>
</div>

    
    <div class="form-group">
      <div class="col-sm-8 col-sm-offset-2">
        <button class="btn btn-default" type="reset">Cancel</button>
        <button class="btn btn-primary" name="submit" type="submit">Save Changes</button>
      </div>
    </div>
  </form>
</div>


    <!-- Loading Scripts -->
    <script src="js/jquery.min.js">
    </script>
    <script src="js/bootstrap-select.min.js">
    </script>
    <script src="js/bootstrap.min.js">
    </script>
    <script src="js/jquery.dataTables.min.js">
    </script>
    <script src="js/dataTables.bootstrap.min.js">
    </script>
    <script src="js/Chart.min.js">
    </script>
    <script src="js/fileinput.js">
    </script>
    <script src="js/chartData.js">
    </script>
    <script src="js/main.js">
    </script>
    <script type="text/javascript">
      $(document).ready(function () {
        setTimeout(function() {
          $('.succWrap').slideUp("slow");
        }</script>
  <script>
  var password = document.getElementById("password");
  var password2 = document.getElementById("password2");
  var passwordError = document.getElementById("password-error");

  function checkPasswordMatch() {
    if (password.value !== password2.value) {
      passwordError.style.display = "block";
    } else {
      passwordError.style.display = "none";
    }
  }

  password.addEventListener("input", checkPasswordMatch);
  password2.addEventListener("input", checkPasswordMatch);
</script>
