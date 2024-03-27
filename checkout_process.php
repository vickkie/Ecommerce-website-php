<?php
error_reporting(E_ALL);
session_start();
include "db.php";
include "includes/enter-data.php";


function generateRandomString($length) {
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}

$order_id = 'PRK' . rand(1000, 9999) . generateRandomString(4) . rand(0, 9);

if (isset($_SESSION["uid"])) {
    $f_name = $_POST["firstname"];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $order_date1 = date("Y-m-d");
    $status = 'Ordered';
    $approval = 'disapproved';
    $contact = $_POST['contact'];
    $user_id = $_SESSION["uid"];
    $contactstr = (string)$contact;
    $total_count = $_POST['total_count'];
    $prod_total = $_POST['total_price'];
    $payment = $_POST['paymentMode'];
    


    $sql0 = "SELECT id FROM orders_info";
    $runquery = mysqli_query($con, $sql0);

    if (mysqli_num_rows($runquery) == 0) {
        $id = 1;
    } else if (mysqli_num_rows($runquery) > 0) {
        $sql2 = "SELECT MAX(id) AS max_val FROM orders_info";
        $runquery1 = mysqli_query($con, $sql2);
        $row = mysqli_fetch_array($runquery1);
        $id = $row["max_val"];
        $id = $id + 1;
    }

    $sql = "INSERT INTO orders_info 
            (id,order_id, user_id, f_name, email, address, city, date, status, contact, prod_count, total_amt, approval,payment) 
            VALUES ($id, '$order_id', '$user_id', '$f_name', '$email', '$address', '$city', '$order_date1', '$status', '$contactstr', '$total_count', '$prod_total', '$approval', '$payment')";

    if (mysqli_query($con, $sql)) {
        $i = 1;

        while ($i <= $total_count) {
            $prod_id = $_POST['prod_id_' . $i];
            $prod_qty = $_POST['prod_qty_' . $i];
            $sub_total = (int)$prod_qty;

            $sql1 = "INSERT INTO order_products 
                     (order_pro_id, order_id, product_id, qty, amt) 
                     VALUES (NULL, '$order_id', '$prod_id', '$prod_qty', '$sub_total')";

            if (mysqli_query($con, $sql1)) {
                $update_qty_sql = "UPDATE products SET qty = qty - $prod_qty WHERE product_id = $prod_id";
                if (mysqli_query($con, $update_qty_sql)) {
                    // Quantity updated successfully
                } else {
                    echo(mysqli_error($con));
                }
            } else {
                echo(mysqli_error($con));
            }

            $i++;
        }

        $del_sql = "DELETE FROM cart WHERE user_id = $user_id";
        if (mysqli_query($con, $del_sql)) {

            echo "<script>window.location.href='thanks.php'</script>";
            exit();

        } else {
            echo(mysqli_error($con));
        }
    } else {
        echo(mysqli_error($con));
    }
} else {
    echo "<script>window.location.href='index.php'</script>";
}
?>
