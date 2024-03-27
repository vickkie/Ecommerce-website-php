<?php
session_start();
error_reporting(0);
include('includes/config.php');


$allowedPositions = array('inventory manager', 'sales manager', 'admin' , 'superadmin');

// Check if the user is logged in and has an allowed position
if (empty($_SESSION['alogin']) || !in_array($_SESSION['position'], $allowedPositions)) {
    // Redirect the user to the access-denied page or any other appropriate page
    header('location:errors/access-denied.php');
    exit(); // Stop further execution of the script
}

if (!isset($_SESSION['alogin'])) {
    header('location:index.php');
} else {
    if (isset($_POST['submit'])) {
        $assignid = $_POST['assignid'];
        $drivername = $_POST['id'];
        $driverid = $_POST['driverid'];
        $userid = $_SESSION['alogin'];
        $orderid = $_POST['orderid'];
        $status = 'Delivering';

        // Check if the data already exists
        $checkSql = "SELECT * FROM assign_driver WHERE user_id = :userid AND id = :driverid AND order_id = :orderid";
        $checkQuery = $dbh->prepare($checkSql);
        $checkQuery->bindParam(':userid', $userid, PDO::PARAM_STR);
        $checkQuery->bindParam(':driverid', $driverid, PDO::PARAM_STR);
        $checkQuery->bindParam(':orderid', $orderid, PDO::PARAM_STR);
        $checkQuery->execute();

        if ($checkQuery->rowCount() > 0) {
            $error = "Data already exists. Cannot insert duplicate records.";
        } else {
            // Insert the data into the assign_driver table
            $sql = "INSERT INTO assign_driver(assign_id,driver_name,assigner_name,id,order_id,status) VALUES(:assignid,:drivername,:userid,:driverid,:orderid,:status)";
            $query = $dbh->prepare($sql);
            $query->bindParam(':assignid', $assignid, PDO::PARAM_STR);
            $query->bindParam(':userid', $userid, PDO::PARAM_STR);
            $query->bindParam(':drivername', $drivername, PDO::PARAM_STR);
            $query->bindParam(':driverid', $driverid, PDO::PARAM_STR);
            $query->bindParam(':orderid', $orderid, PDO::PARAM_STR);
            $query->bindParam(':status', $status, PDO::PARAM_STR);
            $query->execute();
            $lastInsertId = $dbh->lastInsertId();

            // Update the status in the orders_info table
            if ($lastInsertId) {
                $updateSql = "UPDATE orders_info SET status = :status WHERE order_id = :orderid";
                $updateQuery = $dbh->prepare($updateSql);
                $updateQuery->bindParam(':status', $status, PDO::PARAM_STR);
                $updateQuery->bindParam(':orderid', $orderid, PDO::PARAM_STR);
                $updateQuery->execute();

                $msg = "Order assigned successfully";
            } else {
                $error = "Something went wrong. Please try again";
            }
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
    <title>Order assign</title>
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
    <!-- Admin Style -->
    <link rel="stylesheet" href="css/style.css">
    <script type="text/javascript" src="../vendor/countries.js"></script>
    <style>
        .errorWrap {
            padding: 10px;
            margin: 0 0 20px 0;
            background: #dd3d36;
            color: #fff;
            -webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
            box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
        }

        .succWrap {
            padding: 10px;
            margin: 0 0 20px 0;
            background: #5cb85c;
            color: #fff;
            -webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
            box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
        }
    </style>
</head>
<body>
<?php include('includes/header.php'); ?>
<div class="ts-main-content">
    <?php include('includes/leftbar.php'); ?>
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="page-title">ASSIGN ORDER</h2>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">User Info</div>
                                <?php if ($error) { ?>
                                    <div class="errorWrap"><?php echo htmlentities($error); ?></div>
                                <?php } else if ($msg) { ?>
                                    <div class="succWrap"><?php echo htmlentities($msg); ?></div>
                                <?php } ?>

                                <div class="panel-body">
                                    <form method="post" class="form-horizontal" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Driver<span
                                                        style="color:red">*</span></label>
                                            <div class="col-sm-4">
                                                <select name="id" class="form-control" id="driverSelect" required>
                                                    <option value="">Select driver</option>
                                                    <?php
                                                    try {
                                                        $sql = "SELECT * FROM users WHERE position='driver'";
                                                        $query = $dbh->prepare($sql);
                                                        $query->execute();
                                                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                        $cnt = 1;
                                                        if ($query->rowCount() > 0) {
                                                            foreach ($results as $result) {
                                                                ?>
                                                                <option
                                                                    value="<?php echo htmlentities($result->username); ?>"><?php echo htmlentities($result->username); ?></option>
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

                                            <label class="col-sm-2 control-label">Driver ID<span
                                                        style="color:red">*</span></label>
                                            <div class="col-sm-4">
                                                <input type="text" name="driverid" id="driverId" class="form-control"
                                                       required readonly="">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Order Id<span
                                                        style="color:red">*</span></label>
                                            <div class="col-sm-4">
                                                <select name="orderid" class="form-control" id="orderId" required>
                                                    <option value="">Select order</option>
                                                    <?php
                                                    try {
                                                        $sql = "SELECT * FROM orders_info WHERE status='Processing'";
                                                        $query = $dbh->prepare($sql);
                                                        $query->execute();
                                                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                        $cnt = 1;
                                                        if ($query->rowCount() > 0) {
                                                            foreach ($results as $result) {
                                                                ?>
                                                                <option
                                                                    value="<?php echo htmlentities($result->order_id); ?>"><?php echo htmlentities($result->order_id); ?></option>
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

                                            <label class="col-sm-2 control-label">Order ID<span
                                                        style="color:red">*</span></label>
                                            <div class="col-sm-4">
                                                <input type="text" name="orderid" id="orderid" class="form-control"
                                                       required readonly="">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-8 col-sm-offset-2">
                                                <button class="btn btn-default" type="reset">Cancel</button>
                                                <button class="btn btn-primary" name="submit" type="submit">Assign
                                                    Order
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


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
    <script type="text/javascript">
        $(document).ready(function () {
            setTimeout(function () {
                $('.succWrap').slideUp("slow");
            });
        });
        // When the driver select element changes
        $("#driverSelect").change(function () {
            // Get the selected driver ID
            var driverId = $(this).find(':selected').val();
            // Set the driver ID in the input field
            $("#driverId").val(driverId);
        });

        // When the order select element changes
        $("#orderId").change(function () {
            // Get the selected order ID
            var orderId = $(this).find(':selected').val();
            // Set the order ID in the input field
            $("#orderid").val(orderId);
        });
    </script>
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
</body>
</html>
<?php  ?>
