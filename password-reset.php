
<?php
error_reporting(0);
ob_start();
include "headermain.php";
include "db.php";


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer autoload.php file

require 'admin/admin/includes/PHPMailer/vendor/autoload.php';

require 'admin/admin/includes/PHPMailer/src/Exception.php';
require 'admin/admin/includes/PHPMailer/src/PHPMailer.php';
require 'admin/admin/includes/PHPMailer/src/SMTP.php';

// Function to check if the email exists in the customers table
function checkEmailExists($email) {
  global $con;

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userInput = $_POST['email']; // Assuming the input field name is 'email'

    $email = mysqli_real_escape_string($con, $userInput);
    $sql = "SELECT * FROM customers WHERE email = '$email'";
    $result = mysqli_query($con, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
      return true;
    }
    return false;
  }
}

// Function to generate a unique token for password reset
function generateResetToken() {
  $length = 32; // Length of the generated token
  $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'; // Characters to include in the token
  $token = '';

  // Generate random characters for the token
  for ($i = 0; $i < $length; $i++) {
    $token .= $characters[rand(0, strlen($characters) - 1)];
  }


  return $token;
}


// Function to store the reset token and its association with the user's email in the database
function storeResetToken($email, $token) {
  global $con;

  $email = mysqli_real_escape_string($con, $email);
  $token = mysqli_real_escape_string($con, $token);

  $sql = "INSERT INTO reset_tokens (email, token) VALUES ('$email', '$token')";
  $result = mysqli_query($con, $sql);

  if ($result) {
    // Token stored successfully
    return true;
  } else {
    // Failed to store token
    return false;
  }
}


// Function to send the password reset email to the user
function sendResetEmail($email, $resetLink) {
  global $con;

  $email = mysqli_real_escape_string($con, $email);

  // Create a new PHPMailer instance
  $mail = new PHPMailer(true);

  try {
    // Configure PHPMailer

    $mail->SMTPDebug = 0;
    $mail->isSMTP();
    $mail->Host = 'smtp.mailgun.org';
    $mail->Port = 587;
    $mail->SMTPAuth = true;
    $mail->Username = 'uzitrake@sandboxf3782479a2ca42fd8c12aa40b4a89184.mailgun.org';
    $mail->Password = '552e961bcdc1e1e153fddaa985bea909-e5475b88-792a80ad';
    $mail->SMTPSecure = 'tls';
    //$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;



    //$mail->setFrom('uzitrake@sandboxf3782479a2ca42fd8c12aa40b4a89184.mailgun.org', 'Promokings Ltd');
    $mail->setFrom('promokings@gmail.com', 'Promokings Ltd');
    $mail->addAddress($email);
    $mail->addReplyTo('vickkietrake2@gmail.com');
    //$mail->addAttachment('img/promokings.jpg');
$mail->addEmbeddedImage('img/promokings.jpg', 'logo', 'img/promokings.jpg');
$mail->isHTML(true);
$mail->Subject = 'Password Reset Instructions';
$mail->Body = '
    <html>


        <body style="font-family: Arial, sans-serif; background-color: #f4f4f4; color: #333; padding: 20px;">
            <div style="background-color: #fff; padding: 20px; border-radius: 5px;">

            <img src="cid:logo" alt="Logo" style="width: 157px; height: 51px; position: absolute; top: 10px; left: 10px;">
            
                <h2 style="color: #555;">Password Reset Instructions</h2>
                <p>Please click on the following button to reset your password:</p>
                <a href="' . $resetLink . '" style="display: inline-block; background-color: #007bff; color: #fff; padding: 10px 20px; text-decoration: none; border-radius: 5px;margin: auto;">Reset Password</a>
            </div>

          
        </body>
          <div id="newsletter" class="section">
    <div class="contact-container">
      <h2>Contact Us</h2>
       <h3>Lets Get in Touch</h3>
      <p><i class="fa fa-envelope"></i>Email: promokings@gmail.com</p>
      <p><i class="fa fa-phone"></i>Phone: +254 7580151580</p>
      <p><i class="fa fa-map-marker"></i>Address: Atlantis business park, Nairobi</p>
    </div>
  </div>
        
    </html>
';



if ($mail->send()) {
    ob_end_clean(); 
      header("Location:reset-sent.php");
      exit;
} else {
    echo 'An error occurred while sending the email:' . $mail->ErrorInfo;
}

}catch (Exception $e) {
    // Handle any errors that occurred during sending
    echo 'An error occurred while sending the email: ' . $mail->ErrorInfo;
  }
}




// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $userInput = $_POST['email']; // Assuming the input field name is 'email'

  // Check if the email exists in the customers table
  $emailExists = checkEmailExists($userInput);

  if ($emailExists) {
    // Generate a unique token for password reset
    $token = generateResetToken();

    // Store the token and its association with the user's email in the database
    storeResetToken($userInput, $token);

    // Compose the password reset link with the generated token
    $resetLink = 'https://localhost/bruh/promokings/reset-password.php?token=' . urlencode($token);

    // Send the password reset email to the user
    sendResetEmail($userInput, $resetLink);

    // Display a success message or redirect the user to a confirmation page
    //echo 'Password reset instructions have been sent to your email address.';
    exit;
  } else {
    // Display an error message if the email does not exist in the customers table
    echo '<div id="invalid" style="background-color: red;padding:6px;width:80%;margin:auto;"><center><strong>Email not registered.</strong></center></div>';
echo '<script>
    setTimeout(function() {
      var notification = document.getElementById("invalid");
      if (notification) {
        notification.style.display = "none";
      }
    }, 8000);
  </script>';

   }
}


mysqli_close($con);
?>




<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>About Us</title>
  <style>
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

    input[type=email] {
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

  <script>
    // JavaScript code goes here
    // You can add your custom JavaScript code if needed
  </script>
</head>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>USER DETAILS</title>
  <style>
    /* CSS styles */
.profile-picture-box
{
}

    /* ... */
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
          <center><h3>Reset password</h3></center>
            <label for="email"><center><h4>Enter email:</h4></center></label>
            <input type="email" id="email" name="email" placeholder="email"  required><br>
              <button type="submit" id="submit">Reset Password</button>
           </form>
        </div>
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
