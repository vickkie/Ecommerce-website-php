<?php
include "header.php";
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Thank You for Shopping With Us</title>
  <style>
    body {
      background-color: #f5f5f5;
    }
    .container {
      margin-top: 50px;
      text-align: center;
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
  <div class="container">
    <h1>Thank You for Shopping With Us</h1>
    <p>Your order has been received and is being processed. You will receive an email with your order details and estimated delivery date.</p>
    <a href="index.php" class="button">Continue Shopping</a>
  </div>
</body>
</html>

<?php
include "newslettter.php";
include "footer.php";
?>
