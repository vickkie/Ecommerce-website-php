<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin']) == 0 || $_SESSION['position'] !== 'driver') {
    // Redirect the user to the login page or any other appropriate page
    header('location:errors/access-denied.php');
    exit(); // Stop further execution of the script
}
else{
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
                    <div class="col-md-3">
                      <div class="panel panel-default">
                        <div class="panel-body bk-primary text-light">
                          <div class="stat-panel text-center">
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
                            <div class="stat-panel-title text-uppercase">Orders Assigned
                            </div>
                           <div class="icon">
                          <i class="fa fa-cart-arrow-down"></i>
                           </div>
                          </div>
                        </div>
                        <a href="assigned-orders.php" class="block-anchor panel-footer">Full Detail 
                          <i class="fa fa-arrow-right">
                          </i>
                        </a>
                      </div>
                    </div>

              

                     <div class="col-md-3">
                      <div class="panel panel-default">
                        <div class="panel-body bk-green text-light">
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

                          <div class="stat-panel-number h1 ">
                          <?php echo htmlentities($regbd);?>
                          </div>
                            <div class="stat-panel-title text-uppercase">Messages
                            </div><div><i class="ionicons ion-android-textsms"></i></div>
                          </div>

                        </div>
                          <a href="send-message.php" class="block-anchor panel-footer text-center">Full Detail &nbsp; 
                          <i class="fa fa-arrow-right">
                          </i>
                          </a>
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