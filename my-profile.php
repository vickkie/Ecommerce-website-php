<?php
error_reporting(0);
include "headermain.php";
include "db.php";

if (isset($_SESSION["uid"]) == 0) {
  header('location:login-prompt.php');
} else {
  if (isset($_POST["submit"])) {
    // Retrieve form data
    $f_name = $_POST["firstname"];
    $l_name = $_POST["lastname"];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $contact = $_POST['contact'];
    $user_id = $_SESSION["uid"];
    $contactstr = (string)$contact;

    // Picture coding
    $picture_name = $_FILES['image']['name'];
    $picture_type = $_FILES['image']['type'];
    $picture_tmp_name = $_FILES['image']['tmp_name'];
    $picture_size = $_FILES['image']['size'];

    if (!empty($picture_name)) {
      if (is_uploaded_file($picture_tmp_name)) {
        $target_directory = "img/customers/";
        $unique_filename = $f_name . $l_name . uniqid() . "_" . $picture_name;
        $target_path = $target_directory . $unique_filename;

        // Move the uploaded image to the desired directory
        if (move_uploaded_file($picture_tmp_name, $target_path)) {
          if ($picture_size <= 50000000) {
            // Image uploaded successfully, update the database with the new filename
            $sql = "UPDATE customers SET first_name='$f_name', last_name='$l_name', email='$email', address1='$address', address2='$city', mobile='$contactstr', profile_picture='$unique_filename' WHERE user_id=$user_id";

            $query = mysqli_query($con, $sql);

            if ($query) {
              $msg = "Update successful";
              echo "<p id='success-msg' style='background-color: #27ff00; margin: 0 auto;'>$msg</p>";
              echo "<script>
                setTimeout(function() {
                  document.getElementById('success-msg').style.display = 'none';
                }, 8000);
              </script>";
            } else {
              $msg = "Update failed: " . mysqli_error($con);
              echo "<p style='background-color: #ff0000; margin: 0 auto;'>$msg</p>";
            }
          } else {
            $msg = "The file size exceeds the limit (50MB)";
            echo "<p style='background-color: #ff0000; margin: 0 auto;'>$msg</p>";
          }
        } else {
          $msg = "Error moving the uploaded file";
          echo "<p style='background-color: #ff0000; margin: 0 auto;'>$msg</p>";
        }
      } else {
        $msg = "File upload error";
        echo "<p style='background-color: #ff0000; margin: 0 auto;'>$msg</p>";
      }
    } else {
      // If no new image was uploaded, update the database without changing the profile picture
      $sql = "UPDATE customers SET first_name='$f_name', last_name='$l_name', email='$email', address1='$address', address2='$city', mobile='$contactstr' WHERE user_id=$user_id";

      $query = mysqli_query($con, $sql);

      if ($query) {
        $msg = "Update successful";
        echo "<p id='success-msg' style='background-color: #27ff00; margin: 0 auto;'>$msg</p>";
        echo "<script>
          setTimeout(function() {
            document.getElementById('success-msg').style.display = 'none';
          }, 8000);
        </script>";
      } else {
        $msg = "Update failed: " . mysqli_error($con);
        echo "<p style='background-color: #ff0000; margin: 0 auto;'>$msg</p>";
      }
    }
  }
}
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
      width: 80%;
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
      margin-left: 10px;
      margin-right: 10px;
      border: 1px solid lightgrey;
      border-radius: 3px;
    }

    input[type=text] {
      width: 80%;
      margin-left: 10px;
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

  input[type=text] {
    border-radius: 15px;
    margin:0,auto;
  }

 label {
  margin-right: 10px;
}
.centered {
  text-align: center;
}
.center-value {
  text-align: center;
}



  </style>
</head>
<body>
  <div id="about-container">
    <div id="about-background"></div>
    <?php
    include "db.php";

    if (isset($_SESSION["uid"])) {
      $sql = "SELECT * FROM customers WHERE user_id = '{$_SESSION['uid']}'";
      $query = mysqli_query($con, $sql);

      if ($query) {
        $row = mysqli_fetch_array($query);
        $profilePicture = $row["profile_picture"];

        // Display customer details

  echo '
<div class="col-70">
  <div class="container-checkout">
    <form id="update_form" method="POST" class="was-validated" enctype="multipart/form-data">
      <div class="row-checkout">
        <div class="col-50" >
          <h3>Your Address/Details</h3>
          <label for="fname" ><i class="fa fa-user"></i> First Name *</label>
          <input type="text" id="fname" class="form-control" name="firstname" pattern="^[a-zA-Z ]+$" value="' . $row["first_name"] . '" readonly>
          <label for="fname"><i class="fa fa-user"></i> Last Name *</label>
          <input type="text" id="lname" class="form-control" name="lastname" pattern="^[a-zA-Z ]+$" value=" ' . $row["last_name"] . '" readonly>
          <label for="email"><i class="fa fa-envelope"></i> Email</label>
          <input type="text" id="email" name="email" class="form-control" pattern="^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9]+(\.[a-z]{2,4})$" value="' . $row["email"] . '" readonly>
          <label for="adr"><i class="fa fa-address-card-o"></i> Address</label>
          <input type="text" id="adr" name="address" class="form-control" value="' . $row["address1"] . '" readonly>
          <label for="city"><i class="fa fa-institution"></i> City</label>
          <input type="text" id="city" name="city" class="form-control" value="' . $row["address2"] . '" pattern="^[a-zA-Z ]+$" readonly>

          <div class="form-group" id="phone-number-field">
            <label for="cardNumber">Phone number</label>
            <input type="text" class="form-control" id="Number" name="contact" value="' . $row["mobile"] . '" readonly>
          </div>

          

          <input type="button" id="edit-btn" value="Edit" onclick="enableFields()" class="checkout-btn">
          <input type="submit" name="submit" value="Update" class="checkout-btn" style="display: none;">
        </div>
        <div class="col-50">
          <h3 class="centered" >Profile Picture</h3>
          <br>
          <div class="pull-right profile-picture-box" style="width: 500px; height: 500px; overflow: hidden; ">
            <img src="img/customers/' . $profilePicture . '" alt="Profile Picture" onerror="this.onerror=null; this.src=\'img/default.png\';" style="max-width: 50%; height: auto;border-radius:15px;"><br><br>
            <label class="col-sm-8 control-label" id="change" style="display: none;">Change Picture
            <span style="color:red">*</span>
          </label>
          <div class="col-sm-8">
            <input type="file" id="image" name="image" class="form-control" value="Select Image File" readonly style="display: none;">
          </div>
          </div>
     

        </div>
      </div>
      
    </form>
  </div>
</div>';

        // JavaScript code
        echo '
      <script>
          function enableFields() {
            document.getElementById("fname").readOnly = false;
            document.getElementById("lname").readOnly = false;
            document.getElementById("email").readOnly = false;
            document.getElementById("adr").readOnly = false;
            document.getElementById("city").readOnly = false;
            document.getElementById("Number").readOnly = false;
            document.getElementById("image").readOnly = false;
            document.getElementById("edit-btn").style.display = "none";
            document.getElementById("image").style.display = "block";
            document.getElementById("change").style.display = "block";
            document.getElementsByName("submit")[0].style.display = "block";
          }
        </script>';
      } else {
        echo "Error: " . mysqli_error($con);
      }
    } else {
      echo '
      <!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Promokings</title>

  <style>
    body {
      background-color: #f5f5f5;
    }
    .container {
      margin-top: 50px;
      text-align: center;
      margin-bottom:30px;
    }
    h1 {
      font-size: 3em;
      color: #333;
      margin-bottom: 30px;
    }
    p {
      font-size: 1.2em;
      color: #777;
      margin-bottom: 30px;
    }
    .button {
      display: inline-block;
      margin-top: 30px;
      padding: 10px 20px;
      background-color: #00bfff;
      color: #fff;
      border: none;
      border-radius: 3px;
      font-size: 1.2em;
      text-decoration: none;
      text-align: center;
      cursor: pointer;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Continue Shopping With Us</h1>
    <p><b>Please login to access this page.</b></p>
   
    <a href=""class="button" data-toggle="modal" data-target="#Modal_login"><i aria-hidden="true" ></i>Login</a><br>
  </div>
</body>
</html>';
    }
    ?>
  </div>
</body>
</html>

<?php
include "newsletter.php";
include "footer.php";
?>


