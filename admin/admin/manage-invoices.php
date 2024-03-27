<?php
session_start();
error_reporting(0);
include('includes/config.php');
include('includes//enter-data.php');


$allowedPositions = array('inventory manager','sales manager', 'superadmin' ,'admin');

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
if(isset($_REQUEST['confirmid']))
{
$eid=($_GET['confirmid']);
$status='Approved';
$sql = "UPDATE orders_info SET status=:status WHERE order_id=:eid";
$query = $dbh->prepare($sql);
$query -> bindParam(':status',$status, PDO::PARAM_STR);
$query-> bindParam(':eid',$eid, PDO::PARAM_STR);
$query -> execute();
$msg="Status Updated Sucessfully";
}
else
{
  $err="Not updated, sorry an error occured";
}
if(isset($_REQUEST['prepareid']))
{
$eid=($_GET['prepareid']);
$status='Processing';
$sql = "UPDATE orders_info SET status=:status WHERE order_id=:eid";
$query = $dbh->prepare($sql);
$query -> bindParam(':status',$status, PDO::PARAM_STR);
$query-> bindParam(':eid',$eid, PDO::PARAM_STR);
$query -> execute();
$msg="Status Updated Sucessfully";
}
else
{
  $err="Not updated, sorry an error occured";
}
if(isset($_REQUEST['wayid']))
{
$eid=($_GET['wayid']);
$status='Delivering';
$sql = "UPDATE orders_info SET status=:status WHERE order_id=:eid";
$query = $dbh->prepare($sql);
$query -> bindParam(':status',$status, PDO::PARAM_STR);
$query-> bindParam(':eid',$eid, PDO::PARAM_STR);
$query -> execute();
$msg="Status Updated Sucessfully";
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
    <link rel="stylesheet" href="css/uzi.css">

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
                <a href="manage-orders.php">Manage Invoices
                </a>
              </h2>
              <div class="x_content">
  <ul class="nav nav-tabs bar_tabs " id="myTab" role="tablist">
    <li class="nav-item">
      <a class="nav-link active" id="profile-tab" href="manage-invoices.php">Invoices</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" id="contact-tab" href="manage-orders.php">Orders</a>
    </li>
  </ul>
</div>

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
                        <th>Area
                        </th>
                        <th>Address
                        </th>
                        <th>Status
                        </th>
                        <th>Download
                        </th>
                      
                      </tr>
                    </thead>
                    <tbody>
                      <?php 
                      $sql = "SELECT * FROM orders_info WHERE status='Processing' order by order_id desc";
                      $query = $dbh -> prepare($sql);
                      $query->execute();
                      $results=$query->fetchAll(PDO::FETCH_OBJ);
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
                          <?php echo htmlentities($result->city);?>
                        </td>
                        <td>
                          <?php echo htmlentities($result->address);?>
                        </td>
                        <td>
  <?php
  $status = htmlentities($result->status);
  $statusClass = '';

  if ($status == 'ordered') {
    $statusClass = 'text-warning';
  } elseif ($status == 'Processing') {
    $statusClass = 'text-info';
  } elseif ($status == 'Delivered') {
    $statusClass = 'text-success';
  } elseif ($status == 'Cancelled') {
    $statusClass = 'text-danger';
  }
  elseif ($status == 'Delivering') {
    $statusClass = 'text-primary';
  }

  echo '<b class="' . $statusClass . '">' . $status . '</b>';
  ?>
</td>
<td>
    <a href="download-order.php?order_id=<?php echo $result->order_id; ?>" onclick="return confirm('Do you want to download this order?');">
        <i class="fa fa-download" style="color: orangered;"></i>
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
<?php } ?>
