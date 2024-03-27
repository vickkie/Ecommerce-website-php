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

	<title>404 Not found</title>
	<!-- Bootstrap 3.3.6 -->
  	<link rel="stylesheet" href="css/bootstrap.min.css">
  	<style type="text/css">
  		@import url("https://fonts.googleapis.com/css?family=Raleway:400,400i,700");
		*{
		  font-family: Raleway, sans-serif;
		}

		html,
		body,
		.container {
		  width: 100%;
		  height: 100%;
		  padding: 0;
		  margin: 0;
		}

		.container {
		  background: black;
		  display: flex;
		  align-items: center;
		  justify-content: center;
		  flex-wrap: wrap;
		}

		.content {
		  margin: 20px;
		}

		.mask {
		  display: block;
		  /* animation: mask 1s infinite; */
		  mask-image: url(https://i.postimg.cc/sfHDSJTf/maskclassic.png);
		  mask-repeat: no-repeat;
		  -webkit-mask-image: url(https://i.postimg.cc/sfHDSJTf/maskclassic.png);
		  -webkit-mask-repeat: no-repeat;
		}

		.text-center {
		  text-align: center;
		}

		.color-white-shadow {
		  color: #fff;
		  text-shadow: 0 -1px #0f0f0f;
		}

  	</style>
</head>

<body>
<div class="container">
  <div class="content">
    <h2 class="color-white-shadow text-center">404 Error<br><small> Page Not Found</small></h2>
    <img src="https://images.unsplash.com/photo-1506202687253-52e1b29d3527?ixlib=rb-0.3.5&s=b43d68ed98b673427669234757d85e56&auto=format&fit=crop&w=300&q=80" width="300" height="166" class="mask">
    <p class="color-white-shadow text-center">This page doesnt exist or has been moved<br>😒🤦‍♂️.</p>
    <p class="text-center"><a href="#" onclick="window.history.go(-1); return false;">Go Back</a></p>
  </div>
</div>

</body>
</html>
