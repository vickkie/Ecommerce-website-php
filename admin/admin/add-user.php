<?php
session_start();
error_reporting(E_ALL);
include('includes/config.php');

$allowedPositions = array('superadmin', 'admin', 'manager');

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
$name = $_POST['name'];
$lastname = $_POST['lastname'];
$address = $_POST['address'];
$email = $_POST['email'];
$mobile = $_POST['mobile'];
$position = $_POST['position'];
$username = $_POST['username'];
$pass = $_POST['password'];
$password =md5($pass);
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
    $pic_name = $name . "_" . date('YmdHis') . "_" . $picture_name;
    $upload_path = "img/members/" . $pic_name;

    // Upload the original image
    move_uploaded_file($picture_tmp_name, $upload_path);

    // Resize the image
    list($width, $height) = getimagesize($upload_path);
    $new_width = 600;
    $new_height = 600;
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
    imagejpeg($resized_image, $upload_path, 100);

    // Free up memory
    imagedestroy($source_image);
    imagedestroy($resized_image);
  }
}

$m = $pic_name;

$sql1= "SELECT username,mobile,last_name FROM users WHERE username=:username AND last_name = :lastname";
$query1= $dbh->prepare($sql1);
$query1->bindParam(':username',$username,PDO::PARAM_STR);
$query1->bindParam(':lastname',$lastname,PDO::PARAM_STR);
$query1->execute();
$results = $query1->fetch();

if ($results) {
  $error="User data already exists";
}
else{

  //welcome user

$sql2="INSERT INTO message(cmsg,sender_name,receiver_name,dates) VALUES(:message,:sender,:receiver,:dates)";
$query2 = $dbh->prepare($sql2);
$query2->bindParam(':message',$message,PDO::PARAM_STR);
$query2->bindParam(':sender',$sender,PDO::PARAM_STR);
$query2->bindParam(':receiver',$receiver,PDO::PARAM_STR);
$query2->bindParam(':dates',$dates,PDO::PARAM_STR);
$query2->execute();


//save details
$sql="INSERT INTO users(first_name,last_name,address,email,mobile,position,username,password,status,profpic) VALUES(:name,:lastname,:address,:email,:mobile,:position,:username,:password,:status,:m )";
$query = $dbh->prepare($sql);
$query->bindParam(':name',$name,PDO::PARAM_STR);
$query->bindParam(':lastname',$lastname,PDO::PARAM_STR);
$query->bindParam(':address',$address,PDO::PARAM_STR);
$query->bindParam(':email',$email,PDO::PARAM_STR);
$query->bindParam(':mobile',$mobile,PDO::PARAM_STR);
$query->bindParam(':position',$position,PDO::PARAM_STR);
$query->bindParam(':username',$username,PDO::PARAM_STR);
$query->bindParam(':password',$password,PDO::PARAM_STR);
$query->bindParam(':status',$status,PDO::PARAM_STR);
$query->bindParam(':m',$m,PDO::PARAM_STR);

$query->execute();
$rowCount = $query->rowCount();
if($rowCount>0)
{
$msg="User added successfully";
}
else 
{
$error="Something went wrong. Please try again";
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
    <div class="ts-main-content" >
      <?php include('includes/leftbar.php');?>
      <div class="content-wrapper">
        <div class="container-fluid">
          <div class="row">

            <div class="col-md-12">
              <h2 class="page-title">Add User
              </h2>
                <div class="x_content">
  <ul class="nav nav-tabs bar_tabs " id="myTab" role="tablist">
    <li class="nav-item">
      <a class="nav-link" id="profile-tab" href="manage-user.php">Approved</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" id="contact-tab" href="new-user.php">Unapproved</a>
    </li>
    <li class="nav-item">
      <a class="nav-link active" id="contact-tab" href="add-user.php">Register</a>
    </li>
  </ul>
</div>
              <div class="row">
                <div class="col-md-12">

                  <div class="panel panel-default">
                    <div class="panel-heading">User Info
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
                    <div class="errorWrap">
                      <?php echo "Username taken:"; ?> 
                    </div>
                    <?php }?>
               <div class="panel-body">
  <form method="post" class="form-horizontal" enctype="multipart/form-data" >
    <div class="form-group">
      <label class="col-sm-2 control-label">First Name <span style="color:red">*</span></label>
      <div class="col-sm-4">
        <input type="text" name="name" class="form-control" maxlength="30" required>
      </div>

       <div class="form-group " style="">
      <label class="col-sm-2 control-label">Last Name <span style="color:red">*</span></label>
      <div class="col-sm-4">
        <input type="text" name="lastname" class="form-control" maxlength="30" required>
      </div>
       </div>
    
    <div class="form-group">
      <label class="col-sm-2 control-label">Address <span style="color:red">*</span></label>
      <div class="col-sm-4">
        <input type="text" name="address" class="form-control" required>
      </div>
   
    <div class="form-group">
      <label class="col-sm-2 control-label">Mobile <span style="color:red">*</span></label>
      <div class="col-sm-4">
        <input type="text" name="mobile" class="form-control" required>
      </div>
       </div>

       <div class="form-group">
      <label class="col-sm-2 control-label">Email<span style="color:red">*</span></label>
      <div class="col-sm-4">
        <input type="text" name="email" class="form-control" required>
      </div>
  
    <label class="col-sm-2 control-label">Position
                            <span style="color:red">*
                            </span>
                          </label>
                          <div class="col-sm-4">
                            <select name="position" class="form-control" >
                              <option value="">Select position
                              </option>
                             <?php
    try {
       
        $sql = "SELECT * FROM position";
        $query = $dbh->prepare($sql);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);
        $cnt = 1;
        if ($query->rowCount() > 0) {
            foreach ($results as $result) {
?>
                <option value="<?php echo htmlentities($result->position_name); ?>">
                    <?php echo htmlentities($result->position_name); ?>
                </option>
<?php
            }
        }
    } catch (PDOException $e) {
        // Handle database errors here
        echo "Database Error: " . $e->getMessage();
    }
?>

                            </select>
                         
                        </div>
                      </div>


<div class="form-group">
  <label class="col-sm-2 control-label">Username <span style="color:red">*</span></label>
  <div class="col-sm-4">
    <span id="username-error" style="color:red;display:none;">Username already taken</span>
    <input type="text" name="username" id="username" class="form-control" required>
    
  </div>
</div>


    <div class="form-group">
  <label class="col-sm-2 control-label">Enter password <span style="color:red">*</span></label>
  <div class="col-sm-4">
    <input type="password" name="password" id="password" class="form-control" required>
  </div>

<div class="form-group">
  <label class="col-sm-2 control-label">Confirm password <span style="color:red">*</span></label>
  <div class="col-sm-4">
    <input type="password" name="password2" id="password2" class="form-control" required>
    <span id="password-error" style="color:red; display:none;">Passwords do not match.</span>
  </div>
</div>

    
    <div class="form-group">
      <div class="col-sm-8 col-sm-offset-2">
        <button class="btn btn-default" type="reset">Cancel</button>
        <button class="btn btn-primary" name="submit" type="submit" id="submit-button">Save Changes</button>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script type="text/javascript">
      $(document).ready(function () {
        setTimeout(function() {
          $('.succWrap').slideUp("slow");
        }
         , 3000);
      }
      );
    </script>
        <script type="text/javascript">
      $(document).ready(function () {
        setTimeout(function() {
          $('.errorWrap').slideUp("slow");
        }
                   , 3000);
      }
                       );
    </script>
       <!-- <script>
$(document).ready(function() {
  $('#username').on('input', function() {
    var username = $(this).val();
    $.ajax({
      url: 'check-username.php',
      method: 'POST',
      data: { username: username },
      success: function(response) {
        if (response == 'exists') {
          $('#username-error').show();
        } else {
          $('#username-error').hide();
        }
      }
    });
  });
});
</script>
-->
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








