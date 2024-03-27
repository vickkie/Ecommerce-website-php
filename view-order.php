<?php

error_reporting(E_ALL);
include "includes/config.php";
include "header-others.php";
include "contactwhatsapp.php";
if (isset($_SESSION["uid"])) {
  $userid = $_SESSION["uid"];

 if (isset($_REQUEST['order_id'])) {
  $orderid = ($_GET['order_id']);

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

echo "<section class='section'>
  <div class='container-checkout'>
    <div class='col-50'>
      <div class='row-checkout'>";



  $sql2 = "SELECT * FROM sales_orders 
  JOIN products  
  ON sales_orders.product_id = products.product_id
  WHERE user_id = :userid
  AND order_id= :orderid
  ORDER BY date DESC";

  $query2 = $dbh->prepare($sql2);
  $query2->bindParam(':userid', $userid, PDO::PARAM_INT);
  $query2->bindParam(':orderid', $orderid, PDO::PARAM_STR);
  $query2->execute();
  $results2 = $query2->fetchAll(PDO::FETCH_ASSOC);

  $i = 1;

  echo "<h3 class='history' style='text-align: center;'>ORDERED PRODUCTS
  <span class='price' style='color: black;'>
    <i class='fa fa-shopping-cart'></i>
  </span>
</h3>";

  echo "<table class='table table-condensed'>
    <thead>
      <tr>
        <th>No</th>
        <th>Product Image</th>
        <th>Product Title</th>
        <th>Quantity</th>
        <th>Amount</th>

      </tr>
    </thead>

    <tbody>";

  foreach ($results2 as $row) {
    echo "<tr>
      <td>" . $i++ . "</td>
      <td><img src='admin/admin/product_images/" . htmlentities($row['product_image']) . "' alt='Product Image' style='width: 60px; height: 60px;'></td>
      <td>" . htmlentities($row['product_title']) . "</td>
      <td>" . htmlentities($row['quantity']) . "</td>
      <td>" . htmlentities($row['product_price']) . "</td>
      
    </tr>";
  }

  echo "</tbody>
  </table>
  <hr>";
}
}

echo "</div>
    </div>
  </div>
</section>";

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