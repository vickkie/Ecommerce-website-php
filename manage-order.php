<?php
// Start of the PHP code



error_reporting(E_ALL);
include "includes/config.php";
include "header-others.php";
include "contactwhatsapp.php";
if (isset($_SESSION["uid"])) {
  $userid = $_SESSION["uid"];


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



if(isset($_REQUEST['cancelid']))
{
$eid=($_GET['cancelid']);
$status='Cancelled';
$sql = "UPDATE orders_info SET status=:status WHERE order_id=:eid";
$query = $dbh->prepare($sql);
$query -> bindParam(':status',$status, PDO::PARAM_STR);
$query-> bindParam(':eid',$eid, PDO::PARAM_STR);
$query -> execute();
}

trackStatusChange($eid, 'current_status', $status);

echo "<link rel='stylesheet' type='text/css' href='css/themebyuzi.css'>";

echo "<style>
/* CSS styles */
</style>";

echo "<nav id='top'>
  <div class='container' id='top'>
    <ul class='top-nav'>
      <li class='active'><a href='customer-orders.php'>PRODUCTS</a></li>
      <li><a href='manage-order.php'>ORDERS</a></li>
      <li><a href='index.php'>HOME</a></li>
      <li><a href='store.php'>SHOP</a></li>
    </ul>
  </div>
</nav>";
echo "
<section class='section'>
  <div class='container-checkout'>
    <div class='col-50'>
      <div class='row-checkout'>
";

$sql2 = "SELECT * FROM orders_info
  WHERE user_id = :userid
  ORDER BY date DESC";

$query2 = $dbh->prepare($sql2);
$query2->bindParam(':userid', $userid, PDO::PARAM_INT);
$query2->execute();
$results2 = $query2->fetchAll(PDO::FETCH_ASSOC);

$i = 1;

echo "
<h3 class='history' style='text-align: center;'>ORDERS HISTORY
  <span class='price' style='color: black;'>
    <i class='fa fa-shopping-cart'></i>
  </span>
</h3>
";

echo "
<table class='table table-condensed'>
  <thead>
    <tr>
      <th>#</th>
      <th>Order Id</th>
      <th>Order date</th>
      <th>Products Quantity</th>
      <th>Amount</th>
      <th>Status</th>
      <th>#</th>
      <th>#</th>
      <th>Cancel order</th>
    </tr>
  </thead>
  <tbody>
";

foreach ($results2 as $row) {
    $status = htmlentities($row['status']);
    $statusClass = '';

    if ($status == 'Approved') {
        $statusClass = 'text-warning';
    } elseif ($status == 'Processing') {
        $statusClass = 'text-info';
    } elseif ($status == 'Delivered') {
        $statusClass = 'text-success';
    } elseif ($status == 'Cancelled') {
        $statusClass = 'text-danger';
    } elseif ($status == 'Delivering') {
        $statusClass = 'text-primary';
    }

    echo "
    <tr>
      <td>" . $i++ . "</td>
      <td>" . htmlentities($row['order_id']) . "</td>
      <td>" . htmlentities($row['date']) . "</td>
      <td>" . htmlentities($row['prod_count']) . "</td>
      <td>" . htmlentities($row['total_amt']) . "</td>
      <td><b class='" . $statusClass . "'>" . $status . "</b></td>
      <td>
        <form method='GET' action='view-order.php'>
          <input type='hidden' name='order_id' value='" . htmlentities($row['order_id']) . "'>
          <button type='submit' style='color: skyblue; background: none; border: none;'>View Order</button>
        </form>
      </td>
      <td>
        <form method='GET' action='order-tracking.php'>
          <input type='hidden' name='order_id' value='" . htmlentities($row['order_id']) . "'>
          <button type='submit' style='color: blue; background: none; border: none;'>Track Order</button>
        </form>
      </td>
      <td>
        <form method='GET' action='manage-order.php'>
          <input type='hidden' name='cancelid' value='" . htmlentities($row['order_id']) . "'>
          <button type='submit' onclick='confirmDelete();' style='color: red; background: none; border: none;'>Cancel</button>
        </form>
        <script>
          function confirmDelete() {
            return confirm('Do you want to cancel the order?');
          }
        </script>
      </td>
    </tr>
    ";
}
}

echo "
  </tbody>
</table>
<hr>
";

echo "
    </div>
  </div>
</div>
</section>
";


// End of the PHP code


if (!isset($_SESSION["uid"])) {




         //header:location('login-prompt.php'); }



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


}
?>

    
<?php
include "newslettter.php";
include "footer.php";
?>