<?php
include "header.php";
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Successful Reset</title>

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
    <h1>Continue Shopping With Us</h1>
    <p><b>Your Password have been reset succesfully. You can now login.</b></p>
   
    <a href=""class="button" data-toggle="modal" data-target="#Modal_login"><i aria-hidden="true" ></i>Login</a><br>
    <a href="index.php" class="button">Continue Shopping</a>
  </div>
</body>
</html>

<?php
include "newslettter.php";
include "footer.php";
?>
