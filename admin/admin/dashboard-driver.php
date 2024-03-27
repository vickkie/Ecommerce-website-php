<?php
session_start();
error_reporting(E_ALL);
include('includes/config.php');
if(strlen($_SESSION['alogin']) == 0 || $_SESSION['position'] !== 'driver') {
    // Redirect the user to the login page or any other appropriate page
    header('location:errors/access-denied.php');
    exit(); // Stop further execution of the script

    if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1500)) {
    // Last activity was more than 30 minutes ago
    session_unset();     // Unset all session variables
    session_destroy();   // Destroy the session
    header('location: index.php'); // Redirect the user to the login page
    exit(); // Stop further execution of the script
}

// Update last activity time stamp
$_SESSION['LAST_ACTIVITY'] = time();
}

  if (isset($_SESSION['position'])) {
        $position = $_SESSION['position'];
         $username = $_SESSION['alogin'];




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
    <title>Promokings | Dashboard
    </title>
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
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Admin Stye -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/adminlte.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<style>
  #clock {
    font-size: 36px;
    font-weight: bold;
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
            <div class="col-md-12"><center class="pull-right";><img src="product_images/promokings.jpg" /></center>
              <h2 class="page-title">Dashboard | <?php  echo $position ?>
              </h2>
               


              <div class="row">
                <div class="col-md-12">
                  <div class="row">
                    <div class="col-lg-4 col-6">
             <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                 <div class="stat-panel text-cent" style="color:white;">
                            <?php 
                           if (isset($_SESSION['position'])) {
                           $position = $_SESSION['position'];
                           $username = $_SESSION['alogin'];
    

                           $sql = "SELECT * FROM assign_driver WHERE driver_name=:username";
                           $query = $dbh->prepare($sql);
                          $query->bindParam(':username', $username, PDO::PARAM_STR);
                          $query->execute();
                          $results = $query->fetchAll(PDO::FETCH_OBJ);
                          $bg = $query->rowCount();
                          }
                           ?>

                            <div class="stat-panel-number h1 ">
                              <?php echo htmlentities($bg);?>
                            </div>
                            <p style="color:white">Orders Assigned
                           </p>
                     <div class="icon">
                    <i class="ion ion-bag"></i>
                    </div>
                          </div>
                        </div>
                       
                         <a href="assigned-orders.php" class="small-box-footer">more info <i class="fa fa-arrow-circle-right"></i></a>
                      
                      </div>
                    </div>

              

               <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                 <div class="stat-panel text-center" style="color:white;">
                         <?php
                        if (isset($_SESSION['position'])) {
                         $position = $_SESSION['position'];
                        $username = $_SESSION['alogin'];

                         $sql1 = "SELECT id FROM message WHERE receiver_name=:username";
                         $query1 = $dbh->prepare($sql1);
                         $query1->bindParam(':username', $username, PDO::PARAM_STR);
                         $query1->execute();
                         $results1 = $query1->fetchAll(PDO::FETCH_OBJ);
                        $regbd = $query1->rowCount();
                        }
                        ?>
                      </div>

                          <div class="stat-panel-number h1 ">
                          <?php echo htmlentities($regbd);?>
                          </div>

                <p style="color:black">Messages</p>
              </div>
              <div class="icon">
             <i class="ion ion-android-textsms"></i>
             </div>
            <a href="messaging.php" class="small-box-footer">more info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>



                <div class="col-lg-4 col-7">
            <!-- small box -->
            <div class="small-box" >
              <div class="inner">
                 
                <h5 style="color:black;text-align: center;">CLOCK</h5>
              </div>
               <div class="stat-panel-number h6 " style="text-align: center;">
                          <?php echo strtoupper($username);?>
                          </div>
              <div id="clock" style="text-center">
                
              </div>
              <div class="icon">
             <i class="icon ion-clock" style="font-size: 140px;"></i>

             </div>
            <a><i class="fas fa-clock"></i></a>
            </div>
           </div> 



                 </div>
                  </div>
                </div>
              </div>
        

 
   
            


         </div>
          </div>
        </div>
      </div>
    </div>

     <div class="container-fluid">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12">

              <!-- TABLE: LATEST ORDERS -->
            <div class="card" id="latest-orders-card">
              <div class="card-header border-transparent">
                <h3 class="card-title">Latest Orders</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-widget="collapse">
                    <i class="fa fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-widget="remove">
                    <i class="fa fa-times"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table m-0">
                    <thead>
                    <tr>
                      <th>Order ID</th>
                      <th>Status</th>
                       <th>Payment</th>
                      <th>Order amount</th>
                      
                      <th>Date</th>
                       <th></th>
                      <th>Contact</th>

                    </tr>
                    </thead>
  <tbody>
  <?php
  if (isset($_SESSION['alogin'])) {
    $username = $_SESSION['alogin'];
    $userid = $_SESSION['id'];

    $sql = "SELECT ad.order_id, oi.order_id, oi.status, oi.payment, oi.prod_count, oi.total_amt, oi.date, oi.contact
            FROM assign_driver AS ad
            JOIN orders_info AS oi 
            ON ad.order_id = oi.order_id
            WHERE ad.driver_name = '$username'
            ORDER BY ad.order_id DESC
            LIMIT 5";

    $query = $dbh->prepare($sql);
    $query->execute();
    $orders = $query->fetchAll(PDO::FETCH_ASSOC);

    foreach ($orders as $order) {
      $orderid = $order['order_id'];
      $status = $order['status'];
      $payment = $order['payment'];
      $productorder = $order['prod_count'];
      $totalamount = $order['total_amt'];
      $date = $order['date'];
      $contact = $order['contact'];

      // Add a class based on the status
      $statusClass = '';
      if ($status == 'Ordered') {
        $statusClass = 'badge-success';
      } elseif ($status == 'Approved') {
        $statusClass = 'badge-warning';
      } elseif ($status == 'Processing') {
        $statusClass = 'badge-info';
      } elseif ($status == 'Delivering') {
        $statusClass = 'badge-primary';
      } elseif ($status == 'Delivered') {
        $statusClass = 'badge-success';
      } elseif ($status == 'Cancelled') {
        $statusClass = 'badge-danger';
      }

      // Add a class based on the payment status
      $paymentClass = '';
      if ($payment == 'Paid') {
        $paymentClass = 'badge-success';
      } elseif ($payment == 'Unpaid') {
        $paymentClass = 'badge-danger';
      }
      ?>

      <tr>
        <td><?php echo htmlentities($orderid); ?></td>
        <td><span class="badge <?php echo $statusClass; ?>"><?php echo htmlentities($status); ?></span></td>
        <td><span class="badge <?php echo $paymentClass; ?>"><?php echo htmlentities($payment); ?></span></td>
        <td><?php echo htmlentities($totalamount); ?></td>
        <td><?php echo htmlentities($date); ?></td>
        <td><?php echo htmlentities($productorder); ?></td>
        <td><?php echo htmlentities($contact); ?></td>
      </tr>
    <?php
    }
  }
  ?>
</tbody>



                  </table>
                </div>
                <!-- /.table-responsive -->
              </div>
              <!-- /.card-body -->
              <div class="card-footer clearfix">
                <a href="assigned-orders.php" class="btn btn-sm btn-info float-left">Manage Orders</a>
                <a href="assigned-orders.php" class="btn btn-sm btn-secondary float-right">View All Orders</a>
              </div>
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->
          </div>


  <script type="text/javascript">
  function updateClock() {
    var now = new Date();
    var hours = now.getHours();
    var minutes = now.getMinutes();
    var seconds = now.getSeconds();

    hours = hours < 10 ? "0" + hours : hours;
    minutes = minutes < 10 ? "0" + minutes : minutes;
    seconds = seconds < 10 ? "0" + seconds : seconds;

    var time = hours + ":" + minutes + ":" + seconds;
    document.getElementById("clock").textContent = time;

    setTimeout(updateClock, 1000);
  }

  updateClock();
</script>
<script>
  $(document).ready(function() {
    // Minimize the card when the minus icon is clicked
    $('.card-tools .btn[data-widget="collapse"]').click(function() {
      var card = $(this).closest('.card');
      card.toggleClass('collapsed');
    });

    // Close the card when the times icon is clicked
    $('.card-tools .btn[data-widget="remove"]').click(function() {
      var card = $(this).closest('.card');
      card.remove();
    });
  });
</script>



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
  </body>
</html>
<?php } ?>