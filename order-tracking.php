<?php
error_reporting(E_ALL);
include "includes/config.php";
include "header-others.php";
include "includes/enter-data.php";
include "contactwhatsapp.php";
?>

<link rel="stylesheet" type="text/css" href="css/themebyuzi.css">
<style>
/* Add custom styles for the order status */
.track {
  display: flex;
  justify-content: space-between;
  width: 80%;
  margin: 0 auto;
  margin-top: 30px;
  margin-bottom: 60px;
}

.step {
  flex-basis: 25%;
  text-align: center;
}

.step .icon {
  font-size: 24px;
  color: #000;
}

.step.active .icon {
  color: #007bff;
}

.step.active .text {
  color: #007bff;
  font-weight: bold;
}
</style>

<?php 
if (isset($_SESSION["uid"])) {
  echo "
<nav id='top'>
  <div class='container' id='top'>
    <ul class='top-nav'>
      <li><a href='customer-orders.php'>PRODUCTS</a></li>
      <li class='active'><a href='manage-order.php'>ORDERS</a></li>
      <li><a href='index.php'>HOME</a></li>
      <li><a href='store.php'>SHOP</a></li>
    </ul>
  </div>
</nav>
";
}
?>

<?php 
if (isset($_SESSION["uid"])) {
  if (isset($_REQUEST['order_id'])) {
    $orderid = ($_GET['order_id']);

    echo '
    <section class="section">
      <div class="container-checkout">
        <div class="col-50">
          <div class="row-checkout">
            <h3 class="history">TRACKING ORDER NO:<span style="color:blue"> ' . $orderid . '  </span>:
              <span class="price" style="color:black">
                <i class="fa fa-shopping-cart"></i>
              </span>
            </h3>';
  }
}
?>


        <?php 
        if (!isset($_SESSION["uid"])) {

                    echo '
      <!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Promokings</title>

  <style>
    body {
      background-color: #f5f5f5;
    }
    .containers {
      margin-top: 50px;
      text-align: center;
      margin-bottom:30px;
    }
    h1 {
      font-size: 3em;
      color: #333;
      margin-bottom: 30px;
    }
    p {
      font-size: 1.2em;
      color: #777;
      margin-bottom: 30px;
    }
    .button {
      display: inline-block;
      margin-top: 30px;
      padding: 10px 20px;
      background-color: #00bfff;
      color: #fff;
      border: none;
      border-radius: 3px;
      font-size: 1.2em;
      text-decoration: none;
      text-align: center;
      cursor: pointer;
    }
  </style>
</head>
<body>
  <div class="containers">
    <h1>Continue Shopping With Us</h1>
    <p><b>Please login to View your orders.</b></p>
   
    <a href=""class="button" data-toggle="modal" data-target="#Modal_login"><i aria-hidden="true" ></i>Login</a><br>
  </div>
</body>
</html>';


       

          echo "</div>";
        } else {
          $userid = $_SESSION["uid"];

          if (isset($_REQUEST['order_id'])) {
            $orderid = ($_GET['order_id']);

            $sql2 = "SELECT * FROM status_history
                     JOIN sales_orders ON sales_orders.order_id = status_history.order_id
                     WHERE user_id = :userid AND sales_orders.order_id = :orderid";
            $query2 = $dbh->prepare($sql2);
            $query2->bindParam(':userid', $userid, PDO::PARAM_INT);
            $query2->bindParam(':orderid', $orderid, PDO::PARAM_STR);
            $query2->execute();
            $results2 = $query2->fetchAll(PDO::FETCH_ASSOC);

            $orderStatusLabels = array(
              'Ordered',
              'Approved',
              'Processing',
              'Delivering',
              'Delivered',
              'Cancelled'
            );

            $statusIcons = array(
  'Ordered' => 'fa fa-shopping-cart',
  'Approved' => 'fa fa-check-circle-o',
  'Processing' => 'fa fa-cog',
  'Delivering' => 'fa fa-truck',
  'Delivered' => 'fa fa-check',
  'Cancelled' => 'fa fa-product'
);

            echo "<div class='track'>";
            foreach ($orderStatusLabels as $index => $statusLabel) {
              $statusChecked = false;
              $changeDate = '';

              foreach ($results2 as $result) {
                if ($result['new_status'] === $statusLabel) {
                  $statusChecked = true;
                  $changeDate = $result['change_date'];
                  break;
                }
              }

              // Set the "Ordered" step as always active
              if ($statusLabel === 'Ordered' || ($index === 0 && !$orderedStatusExists)) {
                $statusChecked = true;
                $orderedStatusExists = true;

                // Retrieve the date from the sales_orders table
                if ($statusLabel === 'Ordered' && isset($result['order_id'])) {
                  $orderID = $result['order_id'];
                  $sql3 = "SELECT order_date FROM sales_orders WHERE order_id = :orderID";
                  $query3 = $dbh->prepare($sql3);
                  $query3->bindParam(':orderID', $orderID, PDO::PARAM_STR);
                  $query3->execute();
                  $orderResult = $query3->fetch(PDO::FETCH_ASSOC);

                  if ($orderResult) {
                    $changeDate = $orderResult['order_date'];
                  }
                }
              }

              $stepClass = "step" . ($statusChecked ? ' active' : '');
              $iconClass = "icon" . ($index === 0 ? ' active' : '');
              $textClass = "text" . ($index === 0 ? ' active' : '');

              echo "<div class='$stepClass'>";
              echo "<span class='$iconClass'><i class='fa fa-check'></i></span>";
               echo "<span class='$textClass' style='text-transform: uppercase; font-weight: bold; color: green;'>" . strtoupper($statusLabel) . "</span>";
              if ($changeDate) {
                echo "<span class='change-date'>$changeDate</span>";
               echo " <br>";
                if (isset($statusIcons[$statusLabel])) {
             echo "<span class='status-icon'><i class='fa " . $statusIcons[$statusLabel] . " fa-3x icon-crimson'></i></span>";
            }
              }
              echo "</div>";
            }
            echo "</div>";
          } else {
            // If no order ID is specified, retrieve the order status from the database
            $sql = "SELECT * FROM status_history
                    JOIN sales_orders ON sales_orders.order_id = status_history.order_id
                    WHERE user_id = :userid";
            $query = $dbh->prepare($sql);
            $query->bindParam(':userid', $userid, PDO::PARAM_INT);
            $query->execute();
            $results = $query->fetchAll(PDO::FETCH_ASSOC);

            $orderStatusLabels = array(
              'Ordered',
              'Approved',
              'Processing',
              'Delivering',
              'Delivered'
            );




            echo "<div class='track'>";
            $orderedStatusExists = false; // Flag to track if "Ordered" status exists

            foreach ($orderStatusLabels as $index => $statusLabel) {
              $statusChecked = false;
              $changeDate = '';

              foreach ($results as $result) {
                if ($result['new_status'] === $statusLabel) {
                  $statusChecked = true;
                  $changeDate = $result['change_date'];
                  break;
                }
              }

              // Set the "Ordered" step as always active
              if ($statusLabel === 'Ordered' || ($index === 0 && !$orderedStatusExists)) {
                $statusChecked = true;
                $orderedStatusExists = true;

                // Retrieve the date from the sales_orders table
                if ($statusLabel === 'Ordered' && isset($result['order_id'])) {
                  $orderID = $result['order_id'];
                  $sql3 = "SELECT 'date' FROM sales_orders WHERE order_id = :orderID";
                  $query3 = $dbh->prepare($sql3);
                  $query3->bindParam(':orderID', $orderID, PDO::PARAM_STR);
                  $query3->execute();
                  $orderResult = $query3->fetch(PDO::FETCH_ASSOC);

                  if ($orderResult) {
                    $changeDate = $orderResult['order_date'];
                  }
                }
              }

              $stepClass = "step" . ($statusChecked ? ' active' : '');
              $iconClass = "icon" . ($index === 0 ? ' active' : '');
              $textClass = "text" . ($index === 0 ? ' active' : '');

              echo "<div class='$stepClass'>";
              echo "<span class='$iconClass'><i class='fa fa-check'></i></span>";
             echo "<span class='$textClass' style='text-transform: uppercase; font-weight: bold; color:#11ee62;'>" . strtoupper($statusLabel) . "</span>";


              echo "<br>";
              if ($changeDate) {
                echo "<span class='change-date'>$changeDate</span>";



                echo "<br>";
               
                
           
 

 

              }
              echo "</div>";
            }
            echo "</div>";
          }
     
        

        echo '

      </div>
    </div>
  </div>
</section>



      <!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Promokings</title>

  <style>
    body {
      background-color: #f5f5f5;
    }
    .containerss {
      margin-top: 50px;
      text-align: center;
      margin-bottom:30px;
    }
    h1 {
      font-size: 3em;
      color: #333;
      margin-bottom: 30px;
    }
    p {
      font-size: 1.2em;
      color: #777;
      margin-bottom: 30px;
    }
    .button {
      display: inline-block;
      margin-top: 30px;
      padding: 10px 20px;
      background-color: #00bfff;
      color: #fff;
      border: none;
      border-radius: 3px;
      font-size: 1.2em;
      text-decoration: none;
      text-align: center;
      cursor: pointer;
    }
  </style>
</head>
<body>
  <div class="containerss">
    <h1>Continue Shopping With Us</h1>
    <p><b>Please login to View your orders.</b></p>
   
    
  </div>
</body>
</html>


<a style="margin-left: 50px;" href="customer-orders.php" class="btn btn-warning" data-abc="true"> <i class="fa fa-chevron-left"></i> Back to orders</a>
';
   }
?>

<?php
include "newslettter.php";
include "footer.php";
?>
