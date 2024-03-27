<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin']) == 0 || $_SESSION['position'] !== 'inventory manager') {
    // Redirect the user to the login page or any other appropriate page
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


  if (isset($_SESSION['position'])) {
        $position = $_SESSION['position'];



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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  </head>
  <body>
    <?php include('includes/header.php');?>
    <div class="ts-main-content">
      <?php include('includes/leftbar.php');?>
      <div class="content-wrapper">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12"><center class="pull-right";><span ><img src="product_images/promokings.jpg" style="width:40%" /></center></span>
              <h2 class="page-title">Dashboard | <?php  echo $position ?>
              </h2>

             <!-- Main content -->
                 <div class="row">
                <div class="col-md-12">
                  <div class="row">
                    <div class="col-lg-2 col-6">
             <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                 <div class="stat-panel text-cent" style="color:white;">
           

                         <?php
                        $sql = "(SELECT COUNT(*) AS count FROM suppliers WHERE status = 'Approved')";
                        $query = $dbh->prepare($sql);
                        $query->execute();
                        $results = $query->fetchAll(PDO::FETCH_COLUMN);
                        $bg1 = array_sum($results);
                        ?>
                            


                            <div class="stat-panel-number h1 ">
                              <?php echo htmlentities($bg1);?>
                            </div>
                             <p style="color:white">Approved Suppliers
                           </p>
                            <div class="icon">
                          <i class="ion  ion-ios-people"></i>
                           </div>
                          </div>
                        </div>
                        <a href="manage-supplier.php" class="small-box-footer">more info
                          <i class="fa fa-arrow-right">
                          </i>
                        </a>
                      </div>
                    </div>



                  <!--   THE SECOND PART-->
                      <div class="col-lg-2 col-6">
            <!-- small box -->
            <div class="small-box bk-uzi3">
              <div class="inner">
                 <div class="stat-panel " style="color:white;">
           

                   <?php
                   $sql = "(SELECT COUNT(*) AS count FROM suppliers WHERE status = 'Unapproved')";
                   $query = $dbh->prepare($sql);
                   $query->execute();
                    $results = $query->fetchAll(PDO::FETCH_COLUMN);
                    $bg1 = array_sum($results);
                    ?>
                            


                            <div class="stat-panel-number h1 ">
                              <?php echo htmlentities($bg1);?>
                            </div>
                             <p style="color:white;">New Suppliers</p>                           
                              <div class="icon">
                          <i class="ion ion-ios-cart"></i>
                           </div>
                          </div>
                        </div>
                        <a href="new-supplier.php" class="small-box-footer">more info <i class="fa fa-arrow-circle-right"></i></a>
                      </div>
                    </div>


                         <div class="col-lg-2 col-6">
            <!-- small box -->
            <div class="small-box bk-uzi2">
              <div class="inner">
                 <div class="stat-panel text-cente" style="color:white;">

                          <?php 
                          $sql1 ="SELECT product_id from products";
                          $query1 = $dbh -> prepare($sql1);;
                          $query1->execute();
                           $results1=$query1->fetchAll(PDO::FETCH_OBJ);
                           $regbd=$query1->rowCount();
                              ?>
                            <div class="stat-panel-number h1 ">
                              <?php echo htmlentities($regbd);?>
                            </div>
                           <p style="color:white;">Products</p>
                            <div class="icon">
                          <i class="ion ion-ios-pricetags"></i>
                           </div>
                          </div>
                        </div>
                        <a href="manage-items.php" class="small-box-footer">more info <i class="fa fa-arrow-circle-right"></i></a>
                      </div>
                    </div>
              

                          <div class="col-lg-2 col-6">
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


          <div class="col-lg-2 col-6">
            <!-- small box -->
            <div class="small-box bk-uzi4">
              <div class="inner">
                 <div class="stat-panel  " style="color:white;">
                         <?php 
                         $sql1 = "SELECT * FROM products WHERE qty<15";
                         $query1 = $dbh->prepare($sql1);
                         $query1->execute();
                         $results1 = $query1->fetchAll(PDO::FETCH_OBJ);
                        $regbd = $query1->rowCount();
                         ?>
                            <div class="stat-panel-number h1 ">
                              <?php echo htmlentities($regbd);?>
                            </div>
                            <p style="color:white">Quantity Low🔻</p>
                            <div class="icon">
                          <i class="ion ion-ios-pricetag"></i>
                            </div>
                             </div>
                            </div>
                        <a href="below-quantity.php" class="small-box-footer">more info <i class="fa fa-arrow-circle-right"></i></a>
                
            </div>
          </div>

              <div class="col-lg-2 col-6">
            <!-- small box -->
            <div class="small-box" >
              <div class="inner">
                 
                <h5 style="color:black;text-align: center;">CLOCK</h5>
              </div>
               <div class="stat-panel-number h6 " style="text-align: center;">
                          <?php echo strtoupper($username);?>
                          </div>
              <div id="clock" style="text-center;font-size: 44px;">
                
              </div>
              <div class="icon">
             <i class="icon ion-clock" style="font-size: 120px;"></i>

             </div>
            <a><i class="fas fa-clock"></i></a>
            </div>
           </div> 
                    
  

           </div>
          </div>
        </div>
      </div>
    </div>

    
<!-- TABLE: LATEST ORDERS -->
<div class="row">
    <div class="col-lg-6">
        <div class="card">
                     <div class="card-header">
                <h3 class="card-title" style="color:#1600ff;">Latest Added  Products</h3>
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
                                <th>Product Id</th>
                                <th>Product Code</th>
                                <th>Item Name</th>
                                <th>Price</th>
                                <th>Profit</th>
                                <th>In Stock</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (isset($_SESSION['alogin'])) {
                                $username = $_SESSION['alogin'];

                                $sql = "SELECT * FROM products ORDER BY product_id DESC LIMIT 5";
                                $query = $dbh->prepare($sql);
                                $query->execute();
                                $products = $query->fetchAll(PDO::FETCH_ASSOC);

                                foreach ($products as $product) {
                                    $productid = $product['product_id'];
                                    $productname = $product['product_title'];
                                    $productcode = $product['product_code'];
                                    $price = $product['product_price'];
                                    $profit = $product['profit'];
                                    $stock = $product['qty'];
                                    ?>
                                    <tr>
                                        <td><?php echo htmlentities($productid); ?></td>
                                        <td><?php echo htmlentities($productcode); ?></td>
                                        <td><?php echo htmlentities($productname); ?></td>
                                        <td><?php echo htmlentities($price); ?></td>
                                        <td><?php echo htmlentities($profit); ?></td>
                                        <td><?php echo htmlentities($stock); ?></td>
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
                <a href="manage-items.php" class="btn btn-sm btn-info float-left">Products</a>
                <a href="manage-items.php" class="btn btn-sm btn-info float-right">View All Products</a>
            </div>
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->

<div class="col-lg-6">
    <?php
    try {
        // Calculate the date range for the last month and this month
        $lastMonthStart = date('Y-m-01', strtotime('last month'));
        $lastMonthEnd = date('Y-m-t', strtotime('last month'));
        $thisMonthStart = date('Y-m-01');
        $thisMonthEnd = date('Y-m-t');

        // SQL query to retrieve the most ordered products with quantity, price, order count, and product ID
        $sql = "SELECT product_id, product_title, product_code, SUM(quantity) AS total_quantity, SUM(quantity * product_price) AS total_price, COUNT(*) AS order_count
                FROM sales_orders
                WHERE (date >= :last_month_start AND date <= :last_month_end) OR (date >= :this_month_start AND date <= :this_month_end)
                GROUP BY product_id, product_title, product_code
                ORDER BY total_quantity DESC
                LIMIT 5";

        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':last_month_start', $lastMonthStart);
        $stmt->bindParam(':last_month_end', $lastMonthEnd);
        $stmt->bindParam(':this_month_start', $thisMonthStart);
        $stmt->bindParam(':this_month_end', $thisMonthEnd);
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Database connection failed: " . $e->getMessage();
        die();
    }
    ?>

    <div class="card">
        <div class="card-header no-border">
            <h3 class="card-title" style="color:#1600ff;">Products On Demand</h3>
               <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-widget="collapse">
                        <i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-widget="remove">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
        </div>
        <div class="card-body p-0">
            <table class="table table-striped table-valign-middle">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Total sales</th>
                        <th>Sales</th>
                        <th>Counts</th>
                        <th>View</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product) {
                        // Calculate the rise or fall in quantity
                        $lastMonthQuantity = 0;
                        $thisMonthQuantity = $product['total_quantity'];

                        $sql = "SELECT SUM(quantity) AS last_month_quantity
                                FROM sales_orders
                                WHERE product_title = :product_title AND product_code = :product_code AND date >= :last_month_start AND date <= :last_month_end";

                        $stmt = $dbh->prepare($sql);
                        $stmt->bindParam(':product_title', $product['product_title']);
                        $stmt->bindParam(':product_code', $product['product_code']);
                        $stmt->bindParam(':last_month_start', $lastMonthStart);
                        $stmt->bindParam(':last_month_end', $lastMonthEnd);
                        $stmt->execute();
                        $result = $stmt->fetch(PDO::FETCH_ASSOC);

                        if ($result && isset($result['last_month_quantity'])) {
                            $lastMonthQuantity = $result['last_month_quantity'];
                        }

                        // Determine the arrow direction and color
                        $arrow = "";
                        $color = "";
                        if ($lastMonthQuantity > 0) {
                            $percentageChange = (($thisMonthQuantity - $lastMonthQuantity) / $lastMonthQuantity) * 100;

                            if ($percentageChange > 0) {
                                $arrow = "fa fa-arrow-up";
                                $color = "text-success";
                            } elseif ($percentageChange < 0) {
                                $arrow = "fa fa-arrow-down";
                                $color = "text-danger";
                            }
                        } else {
                            $percentageChange = 100; // 100% increase if the product wasn't ordered in the last month
                            $arrow = "fa fa-arrow-up";
                            $color = "text-success";
                        }
                        ?>

                        <tr>
      <td>
        <?php
        $orderedProId = $product['product_id'];

        // Query the products table to get the product image
        $sql = "SELECT product_image FROM products WHERE product_id = :ordered_pro_id";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':ordered_pro_id', $orderedProId);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $imageSource = "product_images/default-image.jpg"; // Replace with the path to your default image or placeholder image

        if ($result && file_exists("product_images/{$result['product_image']}")) {
            $imageSource = "product_images/{$result['product_image']}";
        }
        ?>

        <img src="product_images/<?= $result['product_image']?>" class="img-circle img-size-32 mr-2">
        <?php
        $displayTitle = $product['product_title'];
        if (strlen($displayTitle) > 20) {
            $displayTitle = substr($displayTitle, 0, 17) . '...';
        }
        echo $displayTitle;
        ?>
    </td>

                            <td><?= "KES &nbsp" . (number_format($product['total_price'])) ?></td>
                            <td>
                                <small class="<?= $color ?> mr-1">
                                    <i class="<?= $arrow ?>"></i>
                                    <?= number_format(abs($percentageChange), 2) ?>%
                                </small>
                            </td>
                            <td><?= $product['order_count'] ?></td>
                            <td>
                                <a href="view-product.php?product_id=<?= $product['product_id'] ?>" class="text-muted">
                                    <i class="fa fa-search"></i>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- /.card -->
</div>

<!-- TO DO List -->
<div class="col-md-6">
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">
        <i class="ion ion-clipboard mr-1"></i>
        To do list
      </h3>
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
    <div class="card-body">
      <ul class="todo-list">
        <?php
        if (isset($_SESSION['alogin'])) {
          $username = $_SESSION['alogin'];

          try {
            $sql = "SELECT * FROM to_do_list WHERE tasker_name = :username ORDER BY task_id DESC LIMIT 5";
            $query = $dbh->prepare($sql);
            $query->bindParam(':username', $username, PDO::PARAM_STR);
            $query->execute();
            $tasks = $query->fetchAll(PDO::FETCH_BOTH);

            foreach ($tasks as $task) {
              $taskid = $task['task_id'];
              $taskername = $task['tasker_name'];
              $status = $task['status'];
              $dtime = $task['dtime'];
              $timing = $task['timing'];
              $task = $task['task'];
            

              // Add a class based on the task's status
              $statusClass = '';
              if ($status == 'completed') {
                $statusClass = 'badge-success';
              } elseif ($status == 'pending') {
                $statusClass = 'badge-warning';
              } elseif ($status == 'in-progress') {
                $statusClass = 'badge-info';
              }

              // Determine the background color based on the status class
              $backgroundColor = '';
              if ($statusClass == 'badge-warning') {
                $backgroundColor = '#f39c12'; // Yellow
              } elseif ($statusClass == 'badge-success') {
                $backgroundColor = '#00a65a'; // Green
              } elseif ($statusClass == 'badge-info') {
                $backgroundColor = '#00c0ef'; // Blue
              }
        ?>
              <li>
                <!-- drag handle -->
                <span class="handle">
                  <i class="fa fa-ellipsis-v"></i>
                  <i class="fa fa-ellipsis-v"></i>
                </span>
                <!-- checkbox -->
                <input type="checkbox" value="" name="">
                <!-- todo text -->
                <span class="text"><?php echo htmlentities($task); ?> </span>
                
                  <small class="badge <?php echo $statusClass; ?>"><i class="fa fa-clock-o"></i></small>
                
                 <?php  echo htmlentities($timing); ?>&nbsp
                <!-- Emphasis label -->

                 <?php echo htmlentities($time); ?>
                 
               </span>
                <!-- General tools such as edit or delete-->
                <div class="tools">
                  <i class="fa fa-edit"></i>
                  <i class="fa fa-trash-o"></i>
                </div>
              </li>
        <?php
            }
          } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
          }
        }
        ?>
      </ul>
    </div>
    <div class="card-footer clearfix">
                <a href="to-do.php" class="btn btn-sm btn-info float-left">Add Task</a>
                 <a href="to-do.php" class="btn btn-sm btn-info float-right">Manage Task</a>
              </div>
  </div>
</div>

</div>

</div>


    </div>
    <!-- /.col -->
</div>
<!-- /.row -->


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