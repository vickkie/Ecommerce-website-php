


<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

   <script>
        function success() {
            swal("Success💃", "Payment successful!", "success");
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
    $status= "Sent";
    $email= $_SESSION["email"];

    // Store the original URL
    $redirect_url = isset($_GET['original_url']) ? urldecode($_GET['original_url']) : 'checkout.php';
    $_SESSION['redirect_url'] = $redirect_url;

    if (isset($_POST["submit"])) {
        $name = mysqli_real_escape_string($con, $_POST["name"]);
        $cardname = mysqli_real_escape_string($con, $_POST['cardname']);
        $cardnumber = mysqli_real_escape_string($con, $_POST['cardnumber']);
        $expdate = mysqli_real_escape_string($con, $_POST['expdate']);
        $cvv = mysqli_real_escape_string($con, $_POST['cvv']);

        // Perform additional input validation if required

        $sql0 = "SELECT * FROM banking_payment WHERE username = '$name' AND cardnumber = '$cardnumber' AND order_date = '$date'";
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
            $sql = "INSERT INTO banking_payment(user_id, username, cardname, cardnumber, cvv, expiry_date, order_date,status) 
                    VALUES ('$user_id', '$name', '$cardname', '$cardnumber', '$cvv', '$expdate', '$date', '$status')";

            if (mysqli_query($con, $sql)) {

            echo "<script>success();</script>";

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
                echo "Error: " . mysqli_error($con);
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
                        <form id="payment_form" method="POST" action="banking_payment.php" class="was-validated">
                            <div class="row-checkout">
                                <div class="col-50">
                                    <h3>Payment</h3>
                                    <label for="fname">Accepted Cards</label>
                                    <div class="icon-container">
                                        <i class="fa fa-cc-visa" style="color:navy;"></i>
                                        <i class="fa fa-cc-amex" style="color:blue;"></i>
                                        <i class="fa fa-cc-mastercard" style="color:red;"></i>
                                        <i class="fa fa-cc-discover" style="color:orange;"></i>
                                        <i class="fa fa-cc-amazon-pay" style="color:green;"></i>
                                        <i class="fa fa-cc-apple-pay" style="color:green;"></i>
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
                                <input type="hidden" name="url" value="<?php echo $_SESSION['redirect_url']; ?>" class="form-control" required readonly>
                               <?php endif; ?>

                                    <input type="text" id="username" name="name" value="<?php echo $fullName; ?>" class="form-control" required readonly>
                                    <label for="cname">Name on Card</label>
                                    <input type="text" id="cname" name="cardname" class="form-control" pattern="^[a-zA-Z ]+$"  maxlength="19" required>
                                    <div class="form-group" id="card-number-field">
                                        <label for="cardNumber">Card Number</label>
                                        <input type="text" class="form-control" id="cardnumber" name="cardnumber" maxlength="20" required>
                                    </div>
                                    <label for="expdate">Exp Date</label>
                                    <input type="text" id="expdate" name="expdate" class="form-control" pattern="^((0[1-9])|(1[0-2]))\/(\d{2})$" placeholder="Example:12/22" required>
                                    <div class="row">
                                        <div class="col-50">
                                            <div class="form-group" id="cvv-field">
                                                <label for="cvv">CVV</label>
                                                <input type="text" class="form-control" id="cvv" name="cvv" maxlength="4" required>
                                            </div>
                                        </div>
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

 <script>
    const cardNumberInput = document.getElementById('cardnumber');

    cardNumberInput.addEventListener('input', function (event) {
        const input = event.target;
        const trimmedValue = input.value.replace(/\s+/g, '');
        const formattedValue = formatCardNumber(trimmedValue);
        input.value = formattedValue;
    });

    function formatCardNumber(value) {
        const groups = value.match(/\d{1,4}/g);
        if (groups) {
            return groups.join(' ');
        }
        return value;
    }
</script>

<script>
    const cvvInput = document.getElementById('cvv');

    cvvInput.addEventListener('input', function (event) {
        const input = event.target;
        const trimmedValue = input.value.trim();
        const formattedValue = formatCVV(trimmedValue);
        input.value = formattedValue;
    });

    function formatCVV(value) {
        return value.replace(/\D/g, '');
    }
</script>

<script type="text/javascript">
    const expDateInput = document.getElementById('expdate');

    expDateInput.addEventListener('input', function (event) {
        const input = event.target;
        const formattedValue = input.value.replace(/\D/g, '').substring(0, 4);
        const parts = [];

        for (let i = 0; i < formattedValue.length; i += 2) {
            parts.push(formattedValue.substring(i, i + 2));
        }

        input.value = parts.join('/');
    });
</script>

<?php
include "footer.php";
?>
