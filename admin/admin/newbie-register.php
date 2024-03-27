<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


<script>
function success() {
  swal("Registration successfully!💃", "Login With Your New Details.⛱️ Wait Approval", "success");

}
</script>
<script>
function error() {
  swal("Error💃", "Registration unsuccessfully!", "warning");

}
</script>
<script>
function exists() {
  swal("Patience⚖️", "Wait for Approval!", "warning");

}
</script>

<?php
session_start();
error_reporting(0);
include('includes/config.php');

$allowedPositions = array('superadmin', 'admin', 'Approve');

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

if(strlen($_SESSION['alogin'])==0)
{ 
header('location:index.php');
}
else{ 
if(isset($_POST['submit']))
{

$position = $_SESSION['position'];
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$address = $_POST['address'];
$mobile = $_POST['mobile'];
$email = $_POST['email'];
$location = $_POST['location'];
$username = $_POST['username'];
$pass = $_POST['password'];
$password= md5($pass);
$status ='Unapproved';
$message='Welcome to our company';
$sender='admin';
$receiver=$username;
$dates = date('Y:m:d H:i:s');

// Picture coding
$picture_name = $_FILES['image']['name'];
$picture_type = $_FILES['image']['type'];
$picture_tmp_name = $_FILES['image']['tmp_name'];
$picture_size = $_FILES['image']['size'];

if ($picture_type == "image/jpeg" || $picture_type == "image/jpg" || $picture_type == "image/png" || $picture_type == "image/gif") {
  if ($picture_size <= 50000000) {
    $pic_name = $firstname . "_" . date('YmdHis') . "_" . $picture_name;
    $upload_path = "img/members/" . $pic_name;

    // Upload the original image
    move_uploaded_file($picture_tmp_name, $upload_path);

    // Resize the image
    list($width, $height) = getimagesize($upload_path);
    $new_width = 300;
    $new_height = 300;
    $resized_image = imagecreatetruecolor($new_width, $new_height);

    if ($picture_type == "image/jpeg" || $picture_type == "image/jpg") {
      $source_image = imagecreatefromjpeg($upload_path);
    } elseif ($picture_type == "image/png") {
      $source_image = imagecreatefrompng($upload_path);
    } elseif ($picture_type == "image/gif") {
      $source_image = imagecreatefromgif($upload_path);
    }

    imagecopyresampled($resized_image, $source_image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

    // Save the resized image
    imagejpeg($resized_image, $upload_path, 90);

    // Free up memory
    imagedestroy($source_image);
    imagedestroy($resized_image);
  }
}

$m = $pic_name;



  // Check if the record already exists
    $checkSql = "SELECT COUNT(*) FROM users WHERE  first_name=:firstname  AND last_name = :lastname AND username=:username";
    $checkQuery = $dbh->prepare($checkSql);
    $checkQuery->bindParam(':firstname', $firstname, PDO::PARAM_STR);
    $checkQuery->bindParam(':lastname', $lastname, PDO::PARAM_STR);
    $checkQuery->bindParam(':username', $username, PDO::PARAM_STR);
    
    $checkQuery->execute();
    $recordCount = $checkQuery->fetchColumn();

    if ($recordCount > 0) {
        echo '<script>exists();</script>';
    } else {


//welcome 
$sql2="INSERT INTO message(cmsg,sender_name,receiver_name,dates) VALUES(:message,:sender,:receiver,:dates)";
$query2 = $dbh->prepare($sql2);
$query2->bindParam(':message',$message,PDO::PARAM_STR);
$query2->bindParam(':sender',$sender,PDO::PARAM_STR);
$query2->bindParam(':receiver',$receiver,PDO::PARAM_STR);
$query2->bindParam(':dates',$dates,PDO::PARAM_STR);
$query2->execute();


//save details
$sql="INSERT INTO users(first_name,last_name,address,mobile,username,password,status,profpic,email) VALUES(:firstname,:lastname,:address,:mobile,:username,:password,:status,:m ,:email)";
$query = $dbh->prepare($sql);
$query->bindParam(':firstname',$firstname,PDO::PARAM_STR);
$query->bindParam(':lastname',$lastname,PDO::PARAM_STR);
$query->bindParam(':address',$address,PDO::PARAM_STR);
$query->bindParam(':mobile',$mobile,PDO::PARAM_STR);
$query->bindParam(':username',$username,PDO::PARAM_STR);
$query->bindParam(':password',$password,PDO::PARAM_STR);
$query->bindParam(':status',$status,PDO::PARAM_STR);
$query->bindParam(':m',$m,PDO::PARAM_STR);
$query->bindParam(':email',$email,PDO::PARAM_STR);

$query->execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{
echo "<script>success();</script>";
}
else 
{
echo "<script>error();</script>";
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
    <title>Add User
    </title>
    <!-- Font awesome -->
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <!-- Sandstone Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.css">
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

     <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Admin Stye -->
    <link rel="stylesheet" href="css/adminlte.css">
    <link rel="stylesheet" href="css/style.css">

  </head>
  <body>


<?php } ?>
 <?php include('request/header.php');?>
    <div class="ts-main-content">
      <?php include('request/leftbar.php');?>
      <div class="content-wrapper" style="margin-left:10px">
        <div class="container-fluid">



          <div class="row">
            <div class="col-md-12">
              <h2 class="page-title">
                <a href="dashboard-newbie.php">
                <i class="fa fa-arrow-circle-left">Back</i>
                </a> &nbsp&nbsp&nbsp 

               Registration Form
              </h2>
              <div class="row" style="margin-left: 20px;">
                <div class="col-md-12">
                  <div class="panel panel-default">
                    <div class="panel-heading">User Info
                    </div>
                   
                    <div class="container-fluid" style="margin:auto;"> 
               <div class="panel-body">
  <form method="post" class="form-horizontal" enctype="multipart/form-data" >
      <div class="form-group">
      <label class="col-sm-6 control-label">First Name <span style="color:red">*</span></label>
      <div class="col-sm-6">
        <input type="text" name="firstname" class="form-control" maxlength="30" required>
      </div>

       <div class="form-group">
      <label class="col-sm-6 control-label">Last Name <span style="color:red">*</span></label>
      <div class="col-sm-6">
        <input type="text" name="lastname" class="form-control" maxlength="30" required>
      </div>
      </div>
    
     <div class="form-group">
      <label class="col-sm-6 control-label">Address&nbsp<span style="color:red">*</span></label>
      <div class="col-sm-6">
        <input type="text" name="address" class="form-control" required>
      </div>
       <div class="form-group">
      <label class="col-sm-6 control-label">Mobile <span style="color:red">*</span></label>
      <div class="col-sm-6">
        <input type="text" name="mobile" class="form-control" required>
      </div>
      </div>
      <div class="form-group">
      <label class="col-sm-2 control-label">Email <span style="color:red">*</span></label>
      <div class="col-sm-6">
        <input type="email" name="email" class="form-control" required>
      </div>
      </div>
                        
      
    

     <div class="form-group">
  <label class="col-sm-6 control-label">Username <span style="color:red">*</span></label>
  <div class="col-sm-6">
    <span id="username-error" style="color:red;display:none;">Username already taken</span>
    <input type="text" name="username" id="username" class="form-control" required>
    
  </div>

  <div class="form-group">
   <label class="col-sm-6 control-label">Enter password <span style="color:red">*</span></label>
  <div class="col-sm-6">
    <input type="password" name="password" id="password" class="form-control" required>
  </div>

<div class="form-group">
  <label class="col-sm-6 control-label">Confirm password <span style="color:red">*</span></label>
  <div class="col-sm-6">
    <input type="password" name="password2" id="password2" class="form-control" required>
    <span id="password-error" style="color:red; display:none;">Passwords do not match.</span>
  </div>
 </div>
   <label class="col-sm-6 control-label">Picture
                            <span style="color:red">*
                            </span>
                          </label>
         <div class="col-sm-6">
           <input type="file" name="image" class="form-control" value="Select Image File" required>
           </div>
        </div>

    
    <div class="form-group">
      <div class="col-sm-8 col-sm-offset-2">
        <button class="btn btn-default" type="reset">Cancel</button>
        <button class="btn btn-primary" name="submit" type="submit" id="submit-button">Register</button>
      </div>
    </div>
  </form>
</div>

  </body>
</html>


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
 <script>
$(document).ready(function() {
  var submitButton = $('#submit-button'); // Assuming your submit button has the id "submit-button"

  $('#username').on('input', function() {
    var username = $(this).val();
    $.ajax({
      url: 'check-username.php',
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