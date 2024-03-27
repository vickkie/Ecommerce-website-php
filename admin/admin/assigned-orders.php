<?php
session_start();
error_reporting(0);
include('includes/config.php');
include('includes//enter-data.php');

$allowedPositions = array('driver', 'superadmin' ,'admin');

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
if(isset($_GET['del']))
{
$id=$_GET['del'];
$sql = "delete from orders_info WHERE order_id=:id";
$query = $dbh->prepare($sql);
$query -> bindParam(':id',$id, PDO::PARAM_STR);
$query -> execute();

trackStatusChange($id, 'current_status', 'Order Deleted');

$msg="Order Deleted successfully";
}

//dude this part was hard lol..by uzi

function trackStatusChange($order_id, $previous_status, $new_status) {
    global $dbh;
    // Check if the same status change already exists for the order
    $checkSql = "SELECT COUNT(*) FROM status_history WHERE order_id = :order_id AND previous_status = :previous_status AND new_status = :new_status";
    $checkQuery = $dbh->prepare($checkSql);
    $checkQuery->bindParam(':order_id', $order_id, PDO::PARAM_STR);
    $checkQuery->bindParam(':previous_status', $previous_status, PDO::PARAM_STR);
    $checkQuery->bindParam(':new_status', $new_status, PDO::PARAM_STR);
    $checkQuery->execute();
    $count = $checkQuery->fetchColumn();

    if ($count == 0) {
        // Insert the status change if it doesn't exist
        $insertSql = "INSERT INTO status_history (order_id, previous_status, new_status)
                      SELECT order_id, :previous_status, :new_status
                      FROM orders_info
                      WHERE order_id = :order_id";
        $insertQuery = $dbh->prepare($insertSql);
        $insertQuery->bindParam(':order_id', $order_id, PDO::PARAM_STR);
        $insertQuery->bindParam(':previous_status', $previous_status, PDO::PARAM_STR);
        $insertQuery->bindParam(':new_status', $new_status, PDO::PARAM_STR);
        $insertQuery->execute();
    }
}


if(isset($_REQUEST['deliveredid']))
{
$eid=($_GET['deliveredid']);
$status='Delivered';
$sql = "UPDATE orders_info SET status=:status WHERE order_id=:eid";
$query = $dbh->prepare($sql);
$query -> bindParam(':status',$status, PDO::PARAM_STR);
$query-> bindParam(':eid',$eid, PDO::PARAM_STR);
$query -> execute();
$msg="Status Updated Sucessfully";

trackStatusChange($eid, 'current_status', $status);



}
else
{
  $err="Not updated, sorry an error occured";
}
if(isset($_REQUEST['cancelid']))
{
$eid=($_GET['cancelid']);
$status='Cancelled';
$sql = "UPDATE orders_info SET status=:status WHERE order_id=:eid";
$query = $dbh->prepare($sql);
$query -> bindParam(':status',$status, PDO::PARAM_STR);
$query-> bindParam(':eid',$eid, PDO::PARAM_STR);
$query -> execute();
$msg="Status Updated Sucessfully";
}
if (isset($_GET['error'])) {
    $error = $_GET['error'];

    // Display the appropriate error message based on the error parameter
    if ($error == 'file_not_found') {
        $errorMessage = "File not found.";
    } else {
        $errorMessage = "An unknown error occurred.";
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
    <title>Promokings | Invoices
    </title>
    <!-- Font awesome -->
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/5.5.3/css/ionicons.min.css">
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
    <?php include('includes/header.php');?>
    <div class="ts-main-content">
      <?php include('includes/leftbar.php');?>
      <div class="content-wrapper">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <h2 class="page-title">
                <a href="assigned-orders.php">Orders Assigned
                </a>
              </h2>
              <!-- Zero Configuration Table -->
              <div class="panel panel-default">
                <div class="panel-heading">Invoices
                </div>
                <div class="panel-body">
                  <?php if($error){?>
                  <div class="errorWrap">
                    <strong>ERROR
                    </strong>:
                    <?php echo htmlentities($error); ?> 
                  </div>
                  <?php } 
          else if($msg){?>
                  <div class="succWrap">
                    <strong>SUCCESS
                    </strong>:
                    <?php echo htmlentities($msg); ?> 
                  </div>
                  <?php }?>
                  <table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th>OrderID
                        </th>
                        <th>Order Date
                        </th>
                        <th>Name
                        </th>
                        <th>Mobile Number
                        </th>
                         <th>Payment
                        </th>
                        <th>Area
                        </th>
                        <th>Address
                        </th>
                        <th>Status
                        </th>
                        <th>Download Invoice
                        </th>
                        <th>Action
                        </th>
                      
                      </tr>
                    </thead>
                    <tbody>
                      <?php 

if (isset($_SESSION['alogin'])) {
   $drivername = $_SESSION['alogin'];
//i was testing 😂🤣

 //$drivername = 'follow me on ig u.z.i.__';

    echo "<span style='color: blue;'>Orders Assigned To: " . htmlentities(strtoupper($drivername)) . "</span>";
}
    $sql = "SELECT oi.*
            FROM orders_info oi
            JOIN assign_driver ad ON oi.order_id = ad.order_id
            WHERE ad.status = 'Delivering' AND ad.driver_name = :drivername
            ORDER BY oi.order_id DESC";

    $query = $dbh->prepare($sql);
    $query->bindParam(':drivername', $drivername, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);

                      $cnt=1;
                      if($query->rowCount() > 0)
                      {
                      foreach($results as $result)
                      {				?>	
                      <tr>
                        <td>
                          <?php echo htmlentities($result->order_id);?>
                        </td>
                        <td>
                          <?php echo htmlentities($result->date);?>
                        </td>
                        <td>
                          <?php echo htmlentities(strtoupper($result->f_name));?> 
                          <?php // echo htmlentities($result->lname);?>
                        </td>
                        <td>
                          <?php echo htmlentities($result->contact);?>

                        </td>
                                          <td>
  <?php
  $payment = htmlentities($result->payment);
  $paymentClass = '';


if ($payment == 'Paid') {
    $paymentClass = 'text-success';
  } elseif ($payment == 'Unpaid') {
    $paymentClass = 'text-danger';
  }
 

  echo '<b class="' . $paymentClass . '">' . $payment . '</b>';
  ?>
</td>
                        <td>
                          <?php echo htmlentities($result->city);?>
                        </td>
                        <td>
                          <?php echo htmlentities($result->address);?>
                        </td>
                        <td>
  <?php
  $status = htmlentities($result->status);
  $statusClass = '';


if ($status == 'Delivered') {
    $statusClass = 'text-success';
  } elseif ($status == 'Cancelled') {
    $statusClass = 'text-danger';
  }
  elseif ($status == 'Delivering') {
    $statusClass = 'text-warning';
  }

  echo '<b class="' . $statusClass . '">' . $status . '</b>';
  ?>
</td>
<td>
    <a href="save-order.php?order_id=<?php echo $result->order_id; ?>" onclick="return confirm('Do you want to download this order?');">
        <i class="fa fa-download" style="color: orangered;"></i>
    </a>
</td>
<td>
    <a href="assigned-orders.php?deliveredid=<?php echo $result->order_id; ?>" onclick="return confirm('Confirm Delivery?');">
        <i class="fa fa-check" style="color: green;"></i>
    </a>
    <br>
    <a href="assigned-orders.php?cancelid=<?php echo $result->order_id; ?>" onclick="return confirm('Cancel Order?');">
        <i class="fa fa-times" style="color: red;"></i>
    </a>
</td>




                      </tr>
                      <?php $cnt=$cnt+1; }} ?>
                    </tbody>
                  </table>
                </div>
              </div>
              <div><center><?php  echo COMPANY_LOGOS ?></center></div>
            </div>
          </div>
        </div>
      </div>
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
        }
                   , 3000);
      }
                       );
    </script>
  </body>
</html>
<?php } ?>
