<?php
session_start();
error_reporting(0);
include('includes/config.php');

$allowedPositions = array('superadmin' ,'admin');

if (empty($_SESSION['alogin']) || !in_array($_SESSION['position'], $allowedPositions)) {
    // Redirect the user to the login page or any other appropriate page
    header('location:errors/access-denied.php');
    exit(); // Stop further execution of the script
}

if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 120)) {
    // Last activity was more than 30 minutes ago
    session_unset();     // Unset all session variables
    session_destroy();   // Destroy the session
    header('location: index.php'); // Redirect the user to the login page
    exit(); // Stop further execution of the script
}

// Update last activity time stamp
$_SESSION['LAST_ACTIVITY'] = time();


{
  if (isset($_SESSION['position'])) {
        $position = $_SESSION['position'];
         $username = $_SESSION['alogin'];

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
    <link rel="stylesheet" href="css/adminlte.min.css">
  </head>
  <body>
    <?php include('includes/header.php');?>
    <div class="ts-main-content">
      <?php include('includes/leftbar.php');?>



      <div class="content-wrapper" style="border-radius: 10px;">

      <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <h2 class="page-title">Dashboard | <?php  echo $position ?>
              </h2>
               


              <div class="row">
              	
                      <div class="col-lg-2 col-6">
            <!-- small box -->
            <div class="small-box bk-uzi">
              <div class="inner">
                 <div class="stat-panel text-center">
                       <?php 
                             $sql ="SELECT order_id from orders_info";
                              $query = $dbh -> prepare($sql);
                              $query->execute();
                              $results=$query->fetchAll(PDO::FETCH_OBJ);
                              $bg=$query->rowCount();
                                ?>

                      </div>

                <div class="stat-panel-number h1 ">
                          <?php echo htmlentities($bg);?>
                          </div>

                <p>Orders</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="manage-orders.php" class="small-box-footer">more info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>



            <div class="col-lg-2 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                 <div class="stat-panel text-center">
                       <?php
                         $sql = "(SELECT COUNT(*) AS count FROM users WHERE status = 'Unapproved')
                          UNION
                         (SELECT COUNT(*) AS count FROM driver WHERE status = 'Unapproved')
                           UNION
                         (SELECT COUNT(*) AS count FROM suppliers WHERE status = 'Unapproved')";
                         $query = $dbh->prepare($sql);
                         $query->execute();
                         $results = $query->fetchAll(PDO::FETCH_COLUMN);
                        $bg = array_sum($results);
                        ?>
                      </div>

                        <div class="stat-panel-number h1 ">
                          <?php echo htmlentities($bg);?>
                          </div>

                <p>Unapproved Users</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="new-user.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>

          

              <div class="col-lg-2 col-6">
            <!-- small box -->
            <div class="small-box bk-uzi3">
              <div class="inner">
                 <div class="stat-panel text-center">
                       <?php
                               $sql = "(SELECT COUNT(*) AS count FROM users WHERE status = 'Approved')";
                               $query = $dbh->prepare($sql);
                               $query->execute();
                               $results = $query->fetchAll(PDO::FETCH_COLUMN);
                               $bg1 = array_sum($results);
                                ?>
                      </div>

                <div class="stat-panel-number h1 ">
                          <?php echo htmlentities($bg1);?>
                          </div>

                <p>Approved Users</p>
              </div>
              <div class="icon">
                <i class="ion ion-android-people"></i>
              </div>
              <a href="manage-orders.php" class="small-box-footer">more info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>

      

           <div class="col-lg-2 col-6">
            <!-- small box -->
            <div class="small-box bk-uzi2">
              <div class="inner">
                 <div class="stat-panel text-center">
                       <?php 
                              $sql1 ="SELECT * FROM customers";
                               $query1 = $dbh -> prepare($sql1);;
                               $query1->execute();
                               $results1=$query1->fetchAll(PDO::FETCH_OBJ);
                               $regbd=$query1->rowCount();
                                ?>
                   </div>

                           <div class="stat-panel-number h1 ">
                          <?php echo htmlentities($regbd);?>
                          </div>

                <p>Customers</p>
               </div>
              <div class="icon">
              <i class="ion ion-ios-people"></i>
              </div>
              <a href="manage-customer.php" class="small-box-footer">more info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>


           <div class="col-lg-2 col-6">
            <!-- small box -->
            <div class="small-box bk-uzi4">
              <div class="inner">
                 <div class="stat-panel text-center ">
                        <?php 
                             $sql1 ="SELECT product_id from products";
                             $query1 = $dbh -> prepare($sql1);;
                             $query1->execute();
                             $results1=$query1->fetchAll(PDO::FETCH_OBJ);
                             $regbd=$query1->rowCount();
                              ?>
                          </div>

                          <div class="stat-panel-number h1">
                          <?php echo htmlentities($regbd);?>
                          </div>

                  <p>PRODUCTS</p>
                 </div>
                 <div class="icon">
                <i class="ion ion-pricetags"></i>
              </div>
              <a href="manage-item.php" class="small-box-footer">more info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>


              

           <div class="col-lg-2 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                 <div class="stat-panel text-center">
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

                <p>Messages</p>
              </div>
              <div class="icon">
             <i class="ion ion-android-textsms"></i>
             </div>
            <a href="messaging.php" class="small-box-footer">more info <i class="fa fa-arrow-circle-right"></i></a>
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


<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
{ 
header('location:index.php');
}
else{
  $sendername= $_SESSION['alogin'];
  $profile_picture = $_SESSION['profilepicture'] ;
if(isset($_REQUEST['del']))
{
$delid=intval($_GET['del']);
$sqldel = "DELETE FROM message WHERE id=:delid";
$querydel = $dbh->prepare($sqldel);
$querydel-> bindParam(':delid',$delid, PDO::PARAM_STR);
$querydel -> execute();
unset($sqldel);
$msg="Message Deleted Sucessfully";
}
if(isset($_POST['submit']))
{


$receiver = $_POST['receiver'];
$sender = $sendername;
$message = $_POST['desc'];
$profpic = $profile_picture;

// Check if the same message and sender combination already exists
$sqlCheck = "SELECT * FROM message WHERE sender_name = :sender AND receiver_name = :receiver AND cmsg = :message";
$queryCheck = $dbh->prepare($sqlCheck);
$queryCheck->bindParam(':sender', $sender, PDO::PARAM_STR);
$queryCheck->bindParam(':receiver', $receiver, PDO::PARAM_STR);
$queryCheck->bindParam(':message', $message, PDO::PARAM_STR);
$queryCheck->execute();

if ($queryCheck->rowCount() == 0) {
    // Insert the data if the combination doesn't exist
    $sql = "INSERT INTO message(sender_name, receiver_name, cmsg, profpic) VALUES(:sender, :receiver, :message, :profpic)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':sender', $sender, PDO::PARAM_STR);
    $query->bindParam(':receiver', $receiver, PDO::PARAM_STR);
    $query->bindParam(':message', $message, PDO::PARAM_STR);
    $query->bindParam(':profpic', $profpic, PDO::PARAM_STR);
    $query->execute();
    $lastInsertId = $dbh->lastInsertId();


if($lastInsertId)
{
$msg="Message sent Sucessfully";
}
else 
{
$error="Something went wrong. Please try again";
}
}
}





?>



<!-- DIRECT CHAT -->
<div class="container-fluid">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-6">
                <!-- USERS LIST -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Latest Users</h3>

                        <div class="card-tools">
                            <span class="badge badge-danger">6 New Members</span>
                            <button type="button" class="btn btn-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            <button type="button" class="btn btn-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                        <ul class="users-list clearfix">
                            <?php
                            if (isset($_SESSION['alogin'])) {
                                $username = $_SESSION['alogin'];

                                $sql = "SELECT * FROM users ORDER BY id DESC LIMIT 8";
                                $query = $dbh->prepare($sql);
                                $query->execute();
                                $users = $query->fetchAll(PDO::FETCH_ASSOC);

                                foreach ($users as $user) {
                                    $userId = $user['id'];
                                    $username = $user['username'];
                                    $profpic = $user['profpic'];
                                    ?>
                                    <li>
                                        <div class="user-img-container">
                                            <img src="img/members/<?php echo htmlentities($profpic); ?>" style="width: 100%; max-width: 60%; border-radius: 60%;">
                                        </div>
                                        <a class="users-list-name" href="#"><?php echo htmlentities($username); ?></a>
                                    </li>
                                    <?php
                                }
                                }}
                              }
                            ?>
                        </ul>
                        <!-- /.users-list -->
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer text-center">
                        <a href="manage-user.php">View All Users</a>
                    </div>
                    <!-- /.card-footer -->
                </div>
                <!--/.card -->
            </div>
            <!-- /.col -->

            <!-- TABLE: LATEST ORDERS -->
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Latest Items</h3>
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
            <!-- /.card-footer -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->
</div>
<!-- /.row -->


    </div>
</div>

<div class="container-fluid">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-6">

              <!-- TABLE: LATEST ORDERS -->
            <div class="card">
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

        $sql = "SELECT * FROM orders_info ORDER BY order_id DESC LIMIT 5";
        $query = $dbh->prepare($sql);
        $query->execute();
         {
          // code...
        }$orders = $query->fetchAll(PDO::FETCH_ASSOC);

        foreach ($orders as $order) {
            $orderid = $order['order_id'];
            $status = $order['status'];
            $productorder = $product['prod_count'];
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
            }
            elseif ($status == 'Cancelled') {
                $statusClass = 'badge-danger';
            }
            ?>

            <tr>
                <td><?php echo htmlentities($orderid); ?></td>
                
                <td><span class="badge <?php echo $statusClass; ?>"><?php echo htmlentities($status); ?></span></td>
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
                <a href="manage-orders.php" class="btn btn-sm btn-info float-left">Manage Order</a>
                <a href="manage-orders.php" class="btn btn-sm btn-secondary float-right">View All Orders</a>
              </div>
              <!-- /.card-footer -->
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
                
                 <?php /*<?php echo htmlentities($timing); ?>&nbsp
                <!-- Emphasis label -->

                 <?php echo htmlentities($time); ?>
                 */?>
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
</div>
<?php ?>