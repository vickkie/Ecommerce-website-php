<?php

session_start();

error_reporting(0);

include('includes/config.php');
$allowedPositions = array( 'superadmin' ,'admin');

// Check if the user is logged in and has an allowed position
if (empty($_SESSION['alogin']) || !in_array($_SESSION['position'], $allowedPositions)) {
    // Redirect the user to the access-denied page or any other appropriate page
    header('location:errors/access-denied.php');
    exit(); // Stop further execution of the script
}


if(strlen($_SESSION['alogin'])==0)

	{	

header('location:index.php');

}

else{

// Code for change password	

if (isset($_GET['id'])) {
  $id = $_GET['id'];
} else {
  echo "Error: 'id' parameter is missing.";
}

if (isset($_POST['submit'])) {
  $password = $_POST['newpassword'];
  $newpassword = md5($password);

  $sql = "SELECT * FROM users WHERE id=:id";
  $query = $dbh->prepare($sql);
  $query->bindParam(':id', $id, PDO::PARAM_STR);
  $query->execute();
  $results = $query->fetchAll(PDO::FETCH_OBJ);

  if ($query->rowCount() > 0) {
    $sql = "UPDATE users SET password=:newpassword WHERE id=:id";
    $chngpwd1 = $dbh->prepare($sql);
    $chngpwd1->bindParam(':id', $id, PDO::PARAM_STR);
    $chngpwd1->bindParam(':newpassword', $newpassword, PDO::PARAM_STR);
    $chngpwd1->execute();
    $msg = "Your password was successfully changed.";
  } else {
    $error = "Current password not changed.";
  }
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

	

	<title>Promokings | Admin Change Password</title>



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

	<!-- Admin Stye -->

	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/adminlte.css">

<script src="https://cdn.jsdelivr.net/npm/notiflix@2.7.0/dist/notiflix-aio-2.7.0.min.js"></script>

<script>
function password() {
  Notiflix.Notify.Success('Passwords do not match');
}

function valid() {
  if (document.chngpwd.newpassword.value !== document.chngpwd.confirmpassword.value) {
    password();
    return false;
  }
  return true;
}
</script>
    <script>
    function togglePasswordVisibility() {
  var passwordInput = document.getElementById('password-input');
  var passwordToggleIcon = document.getElementById('password-toggle-icon');

  if (passwordInput.type === 'password') {
    passwordInput.type = 'text';
    passwordToggleIcon.classList.remove('fa-eye');
    passwordToggleIcon.classList.add('fa-eye-slash');
  } else {
    passwordInput.type = 'password';
    passwordToggleIcon.classList.remove('fa-eye-slash');
    passwordToggleIcon.classList.add('fa-eye');
  }
}

  </script>



  <style>

		.errorWrap {

    padding: 10px;

    margin: 0 0 20px 0;

    background: crimson;

    border-left: 4px solid #dd3d36;

    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);

    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);

}

.succWrap{

    padding: 10px;

    margin: 0 0 20px 0;

    background: skyblue;

    border-left: 4px solid #5cb85c;

    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);

    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);

}

		</style>





</head>



<body>

	<?php include('includes/header.php');?>

	<div class="ts-main-content">

	<?php include('includes/leftbar.php');?>

		<div class="content-wrapper">

			<div class="container-fluid">



				<div class="row">

					<div class="col-md-12">

					

						<h2 class="page-title">
                <a href="manage-user.php">
                  <i class="glyphicon glyphicon-circle-arrow-left" style="color:#3b3b3b">
                  </i>
                </a>&nbsp; &nbsp; Change password
              </h2>



						<div class="row">

							<div class="col-md-10">

								<div class="panel panel-default">

									<div class="panel-heading">Form fields</div>

									<div class="panel-body">

										<form method="post" name="chngpwd" class="form-horizontal" onSubmit="return valid();">

										

											

  	        	  <?php if($error){?><div class="errorWrap"><strong>Problem:Contact Tech</strong>:<?php echo htmlentities($error); ?> </div><?php } 

				else if($msg){?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php }?>


											

											<div class="form-group">

												<label class="col-sm-4 control-label">New Password</label>

												<div class="col-sm-6">

													<input type="password" class="form-control" name="newpassword" id="newpassword" required>
													<i id="password-toggle-icon" class="toggle-icon fa fa-eye" onclick="togglePasswordVisibility()"></i>


												</div>

											</div>

											<div class="hr-dashed"></div>



											<div class="form-group">

												<label class="col-sm-4 control-label">Confirm Password</label>

												<div class="col-sm-6">

													<input type="password" class="form-control" name="confirmpassword" id="confirmpassword" required><i id="password-toggle-icon" class="toggle-icon fa fa-eye" onclick="togglePasswordVisibility()"></i>


												</div>

											</div>

											<div class="hr-dashed"></div>

										

								

											

											<div class="form-group">

												<div class="col-sm-8 col-sm-offset-4">

								

													<button class="btn btn-primary" name="submit" type="submit"  onclick="validatePassword()" >Save changes</button>

												</div>

											</div>



										</form>



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

	<script src="js/jquery.min.js"></script>

	<script src="js/bootstrap-select.min.js"></script>

	<script src="js/bootstrap.min.js"></script>

	<script src="js/jquery.dataTables.min.js"></script>

	<script src="js/dataTables.bootstrap.min.js"></script>

	<script src="js/Chart.min.js"></script>

	<script src="js/fileinput.js"></script>

	<script src="js/chartData.js"></script>

	<script src="js/main.js"></script>


<script>
function validatePassword() {
  var passwordInput = document.getElementById("newpassword");
  var password = passwordInput.value;

  // Regular expression pattern to check for at least one symbol or number
  var pattern = /^(?=.*[0-9!@#$%^&*])[a-zA-Z0-9!@#$%^&*]+$/;

  if (!pattern.test(password)) {
    alert("Password must contain at least one symbol or number.");
    event.preventDefault(); // Prevent form submission if validation fails
  }
}
</script>
	<script>
    ion.iconsLoaded.then(function () {
      var passwordToggleIcon = document.getElementById("password-toggle-icon");
      ion.add(passwordToggleIcon);
    });
  </script>
     <script type="text/javascript">
      $(document).ready(function () {
        setTimeout(function() {
          $('.succWrap').slideUp("slow");
        }
                   , 3000);
      }
                       );
    </script>



</body>



</html>

<?php } ?>