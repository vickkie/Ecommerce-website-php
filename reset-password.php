<?php
// password-reset.php
error_reporting(0);
ob_start(); // Start output buffering
include "headermain.php";
include "db.php";

//$email = ""; // Declare and initialize the $email variable

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['token'])) {
  $token = $_GET['token'];
  
  // Check if the token exists in the reset_tokens table and retrieve the associated email
  $token = mysqli_real_escape_string($con, $token);
  $sql = "SELECT email FROM reset_tokens WHERE token = '$token'";
  $result = mysqli_query($con, $sql);

  if ($result && mysqli_num_rows($result) === 1) {
    $row = mysqli_fetch_assoc($result);
    $email = $row['email'];

  } else {
    // Invalid token
    echo '<div id="invalid" style="background-color: red;padding:6px;width:80%;margin:auto;"><center><strong>Invalid Request.</strong></center></div>';
    echo '<script>
      setTimeout(function() {
        var notification = document.getElementById("invalid");
        if (notification) {
          notification.style.display = "none";
        }
      }, 8000);
    </script>';
    exit;
  }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset(
  $_POST['email'],
  $_POST['token'], 
  $_POST['new-password'], 
  $_POST['confirm-password'])) {
  // Form submitted, process the new password
  $email = $_POST['email'];
  $token = $_POST['token'];
  
  $newPassword = $_POST['new-password'];
  $confirmPassword = $_POST['confirm-password'];

  // Check if the new password and confirm password match
  if ($newPassword !== $confirmPassword) {
    echo '<div id="invalid" style="background-color: red;padding:6px;width:80%;margin:auto;"><center><strong>Passwords do not match.</strong></center></div>';
    echo '<script>
      setTimeout(function() {
        var notification = document.getElementById("invalid");
        if (notification) {
          notification.style.display = "none";
        }
      }, 8000);
    </script>';
    exit;
  }

  $email = mysqli_real_escape_string($con, $email);
  $newPassword = mysqli_real_escape_string($con, $newPassword);
  $sql = "UPDATE customers SET password = '$newPassword' WHERE email = '$email'";
  $result = mysqli_query($con, $sql);

  if ($result && mysqli_affected_rows($con) > 0) {
    // Password updated successfully
    // Remove the used token from the reset_tokens table
    $token = mysqli_real_escape_string($con, $token);
    $sql = "DELETE FROM reset_tokens WHERE token = '$token'";
    $result = mysqli_query($con, $sql);

    if ($result && mysqli_affected_rows($con) > 0) {
      // Token removed successfully
      // Redirect the user to a success page
       ob_end_clean(); 
      header("Location:successful-reset.php");
      exit;
    } else {
      // Failed to remove the token
      echo 'An error occurred while removing the token.';
    }
  } else {
    // Failed to update password or no rows were affected
    echo 'Error updating the password.';
  }
}

mysqli_close($con);

?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Reset Password</title>
  <style>
    /* CSS styles */
    /* ... */
    /* Center the text */
    #about-text {
      margin: 0 auto;
      width: 50%;
      max-width: 990px;
      font-weight: bold;
      padding: 10px;
    }
    
    #about-background {
      position: absolute;
      top: 0;
      bottom: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-image: url('img/promokings11.jpg');
      background-repeat: no-repeat;
      background-size: cover;
      opacity: 0.1;
      z-index: -1;
    }
    
    /* Move the image to the right */
    #about-image {
      float: right;
      margin-left: 20px;
    }

    .row-checkout {
      display: -ms-flexbox;
      display: flex;
      -ms-flex-wrap: wrap;
      flex-wrap: wrap;
      margin: 0 -16px;
    }

    .col-50 {
      -ms-flex: 50%;
      flex: 50%;
    }

    .container-checkout {
      background-color: #f2f2f2;
      padding: 5px 20px 15px 20px;
      width: 80%;
      margin: auto;
      border: 1px solid lightgrey;
      border-radius: 3px;
    }

    input[type=password] {
      width: 75%;
     margin-left:40px;
      margin-bottom: 20px;
      padding: 12px;
      border: 1px solid #ccc;
      border-radius: 3px;
    }

    label {
      margin-bottom: 10px;
      display: block;
    }

    .icon-container {
      margin-bottom: 20px;
      padding: 7px 0;
      font-size: 24px;
    }

    .checkout-btn {
      background-color: #e2221d;
      color: white;
      padding: 12px;
      margin: 10px 0;
      border: none;
      width: 50%;
      border-radius: 3px;
      cursor: pointer;
      font-size: 17px;
    }

    .checkout-btn:hover {
      background-color: #45a049;
    }

    hr {
      border: 1px solid lightgrey;
    }
    #submit {
     background-color:skyblue;
     margin-left:40px;
      border: none;
       width: 75%;
       padding: 12px;
      

    }
    #submit:hover {
      background-color:limegreen;
    }

    span.price {
      float: right;
      color: grey;
    }

    /* Responsive layout - when the screen is less than 800px wide, make the two columns stack on top of each other instead of next to each other (also change the direction - make the "cart" column go on top) */
    @media (max-width: 800px) {
      .row-checkout {
        flex-direction: column-reverse;
      }
      .col-50 {
        margin-bottom: 20px;
      }
    }
  </style>
</head>
<body>
  <div id="about-container">
    <div id="about-background"></div>
  
    <div class="col-40">
      <div class="container-checkout">
        <form id="update_form" method="POST" action="" class="was-validated" enctype="multipart/form-data">
          <div class="row-checkout">
            <div class="col-50">
              <center><h3>RESET PASSWORD</h3></center>
              <label for="new-password"><center><h4>Enter New Password:</h4></center></label>
              <input type="hidden" name="email" value="<?php echo $email; ?>">
               <input type="hidden" name="token" value="<?php echo $token; ?>">
              <input type="password" id="new-password" name="new-password" placeholder="New Password" required><br>
              <input type="password" id="confirm-password" name="confirm-password" placeholder="Confirm Password" required>

              <button type="submit" id="submit">Reset Password</button>
           </form>
        </div>
      </div>
    </div>
  </div>
</body>
</html>

<?php
include "newsletter.php";
include "footer.php";
?>
