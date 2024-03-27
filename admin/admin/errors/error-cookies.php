<?php
error_reporting(0);
include "../includes/config.php";
?>

<!DOCTYPE html>
<html>
<head>
  <link rel="shortcut icon" href="../<?php echo COMPANY_TOP_LOGO; ?>">
      <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="theme-color" content="#3e454c">

  <title>400 Bad request</title>
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="../css/font-awesome.min.css">
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" href="../css/bootstrap-social.css">
  <link rel="stylesheet" href="../css/bootstrap-select.css">
  <link rel="stylesheet" href="../css/fileinput.min.css">
  <link rel="stylesheet" href="../css/awesome-bootstrap-checkbox.css">
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="../css/adminlte.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/5.5.3/css/ionicons.min.css">
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <style type="text/css">
    @import url("https://fonts.googleapis.com/css?family=Raleway:400,400i,700");
    * {
      font-family: Raleway, sans-serif;
    }

    html,
    body,
    .content {
      flex-basis: 100%;
    }

    .text-center {
      text-align: center;
    }

    .color-white-shadow {
      color: #fff;
      text-shadow: 0 -1px #0f0f0f;
    }

    .content ol {
      /* Styles for the ordered list */
    }

    .content ol li {
      /* Styles for the list items */
      font-size: 16px;
      margin-bottom: 15px;
      /* Add more styles as needed */
    }
     .blurred-image {
        height: 100vh;
        width: 100%;
        object-fit: cover;
        filter: blur(5px); /* Adjust the blur value as needed */
    }
  </style>
</head>

<body>
  <div class="login-pages">
    <div class="containers">
      <div class="row">
                <div class="col-md-4">
          <div class="contents" >
            <div id="myCarousel" class="carousel slide" data-ride="carousel">
              <!-- Indicators -->
              <ol class="carousel-indicators">
                <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
              </ol>
              <!-- Slides -->
              <div class="carousel-inner">
                <div class="item active">
                  <img src="../img/indexs/index6.jpg" class="blurred-image">
                  <div class="text-overlay">
                    <center>
                      <h1 style="color: #fb0417;text-weight:bold">ERROR 400</h1><br>
                      <p style="color:black;">Enable cookies and try again</p>
                      <h2>
                        <a href="../index.php">Back to login<i class="fa fa-arrow-right" aria-hidden="true"></i></a>
                      </h2>
                    </center>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-8">
          <div class="content" style="margin-top: 60px;">

            <h1>How to enable cookies 🍪🍪
            </h1></center>
            <p style="color:blue;">This website requires cookies to function properly.</p>
            <p>Please follow the instructions below to enable cookies in your browser:</p>
            <h2 style="">Enabling Cookies in Chrome, Brave and Firefox</h2>
            <ol>
              <li>1. Click on the Chrome menu icon (three vertical dots) <?php
    for ($i = 1; $i <= 3; $i++) {
    echo "&nbsp;";
       }
      ?><i class="fa fa-bars" aria-hidden="true"></i>
                <?php
    for ($i = 1; $i <= 4; $i++) {
    echo "&nbsp;";
       }
      ?>
 in the top-right corner of the browser window.</li>
              <li>2. Select "Settings" from the dropdown menu.</li>
              <li>3. Scroll down and click on "Advanced" to expand the advanced settings.</li>
              <li>3. Under "Privacy and security," click on "Site settings."</li>
              <li>4. Locate the "Cookies" section and ensure that it is set to "Allowed" or "Ask first."</li>
              <li>5. Else You can search  "cookies"  in settings in other browsers</li>
            </ol>
            <br>
            <p>
              <a href="../index.php">Back to login</a>
            </p>
          </div>
        </div>

      </div>
    </div>
  </div>
</body>

</html>
