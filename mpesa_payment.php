<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script>
    function success() {
        if (typeof swal === 'function') {
            swal("Success💃", "Payment sent!", "success");
        } else {
            alert("Payment successful!");
        }
    }
</script>

<script>
    function error() {
        if (typeof swal === 'function') {
            swal("Continue checkout🍹", "Payment sent!", "warning");
        } else {
            alert("Already sent!");
        }
    }
</script>

<?php

if ($_SERVER['SCRIPT_FILENAME'] == __FILE__) {
    exit('Direct access is not allowed.');
}

include "db.php";
include "headermain.php";

if (isset($_SESSION["uid"])) {
   
    $user_id = $_SESSION["uid"];
    $date = date("Y-m-d");
    $status='Sent';
  
    // Store the original URL
    $redirect_url = isset($_GET['original_url']) ? urldecode($_GET['original_url']) : 'checkout.php';
    $_SESSION['redirect_url'] = $redirect_url;

    if (isset($_POST["submit"])) {
        $name = mysqli_real_escape_string($con, $_POST["name"]);
        $cname = mysqli_real_escape_string($con, $_POST["cname"]);
        $code = mysqli_real_escape_string($con, $_POST['code']);


        // Perform additional input validation if required

        $sql0 = "SELECT * FROM mpesa_payment WHERE username = '$name' AND mpesa_code = '$code' ";
        $runquery = mysqli_query($con, $sql0);

        if (mysqli_num_rows($runquery) !== 0) {


          echo "<script>error();</script>";
echo "<script>
    setTimeout(function() {
        window.location.href = 'cart.php';
    }, 2000);
</script>";

echo "<script>
    setTimeout(function() {
        setTimeout(function() {
            window.location.href = 'checkout.php';
        }, 2000);
    }, 2000);
</script>";

exit();


        } else {
            $sql = "INSERT INTO mpesa_payment(user_id, username,code_name ,mpesa_code, order_date,status) 
                VALUES ('$user_id', '$name','$cname','$code', '$date', '$status')";

            if (mysqli_query($con, $sql)) {

                echo "<script>success();</script>";

                echo "<script>
                  setTimeout(function() {
                    window.location.href = 'cart.php';
                   }, 2000);
                  </script>";

                
                  echo "<script>
                  setTimeout(function() {
                    window.location.href = 'checkout.php';
                   }, 2000);
                  </script>";
            
            exit();
                
            } else {
        
        echo "<script>
            window.location.href = '404-error.php';
        </script>";
        exit();
            }
        }
    }
}

?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Payment</title>
    <link rel="stylesheet" type="text/css" href="css/themebyuzi.css">
    

   
</head>
<body>
    <section class="section">
        <div class="container-fluid">
            <div class="row-checkout">
                <div class="col-50">
                    <div class="container-checkout">
                        <form id="payment_form" method="POST" class="was-validated">
                            <div class="row-checkout">
                                <div class="col-50">
                                    <h3>Payment</h3>
                                    <label for="fname">Mpesa </label>
                                    <div class="icon-container">
                                        <i class="fa-brands fa-cc-card" style="color:navy;"></i>
                                       
                                    </div>
                                    <?php
                                    if (isset($_SESSION["uid"])) {
                                    	  $redirect_url = isset($_GET['original_url']) ? urldecode($_GET['original_url']) : 'checkout.php';
                                        $_SESSION['redirect_url'] = $redirect_url;
                                         
                                        $sql = "SELECT * FROM customers WHERE user_id='$_SESSION[uid]'";
                                        $query = mysqli_query($con, $sql);
                                        $row = mysqli_fetch_array($query);
                                        $fullName = $row['first_name'] . '' . $row['last_name'];
                                    }
                                    ?>
                                    <label for="username">Customer Name</label>
                                <?php if (!empty($_SESSION['redirect_url'])): ?>
                                <input type="hidden" name="url" value="<?php echo $_SESSION['redirect_url']; ?>"class="form-control" required readonly>
                               <?php endif; ?>

                                    <input type="text" id="username" name="name" value="<?php echo $fullName; ?>" class="form-control" required readonly>
                                    <label for="cname">Name on code</label>
                                    <input type="text" id="cname" name="cname" class="form-control" pattern="^[a-zA-Z ]+$"  maxlength="19" required>
                                    <div class="form-group" id="code-field">
                                    <label for="code">Mpesa Code</label>
                                    <input type="text" class="form-control" id="code" name="code" maxlength="20" required>
                                    </div>
                                </div>
                            </div>
                            <button class="checkout-btn" name="submit" type="submit">Save Changes</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div id="newsletter" class="section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="newsletter">
                        <p>Sign Up for the <strong>NEWSLETTER</strong></p>
                        <form>
                            <input class="input" type="email" placeholder="Enter Your Email">
                            <button class="newsletter-btn"><i class="fa fa-envelope"></i> Subscribe</button>
                        </form>
                        <ul class="newsletter-follow">
                            <li>
                                <a href="#"><i class="fa fa-facebook"></i></a>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-twitter"></i></a>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-instagram"></i></a>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-pinterest"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

<?php
include "footer.php";
?>
