
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<script>
function success() {
  swal("Success💃", "Request Under review!", "success");

}
</script>
<script>
function exists() {
  swal("Wait🍹", "Under review!", "warning");

}
</script>
<script>
function failed() {
  swal("Failed💃", "Request Failed!", "error");

}
</script>

<?php
session_start();

include('includes/config.php');

error_reporting(E_ALL);

if(isset($_POST['submit'])) {
    $fullname = $_POST['fullname'];
    $id_no = $_POST['idno'];
    $employee = $_POST['employee'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $status = 'Requested';

    // Check if the record already exists
    $checkSql = "SELECT COUNT(*) FROM register_requests WHERE username = :username AND employee_no = :employee AND id_no=:id_no ";
    $checkQuery = $dbh->prepare($checkSql);
    $checkQuery->bindParam(':username', $username, PDO::PARAM_STR);
    $checkQuery->bindParam(':employee', $employee, PDO::PARAM_STR);
    $checkQuery->bindParam(':id_no', $id_no, PDO::PARAM_STR);
    
    $checkQuery->execute();
    $recordCount = $checkQuery->fetchColumn();

    if ($recordCount > 0) {
        echo '<script>exists();</script>';
    } else {
        // Insert the new record
        $insertSql = "INSERT INTO register_requests (fullname, username, id_no, employee_no,password, status) 
                      VALUES (:fullname, :username, :id_no, :employee, :password, :status)";
        $insertQuery = $dbh->prepare($insertSql);
        $insertQuery->bindParam(':fullname', $fullname, PDO::PARAM_STR);
        $insertQuery->bindParam(':username', $username, PDO::PARAM_STR);
        $insertQuery->bindParam(':id_no', $id_no, PDO::PARAM_STR);
        $insertQuery->bindParam(':employee', $employee, PDO::PARAM_STR);
        $insertQuery->bindParam(':password', $password, PDO::PARAM_STR);
        $insertQuery->bindParam(':status', $status, PDO::PARAM_STR);

        if ($insertQuery->execute()) {
            echo '<script>success();</script>';
        } else {
            echo '<script>failed();</script>';
        }
    }
}

?>




<!doctype html>

<html lang="en" class="no-js">

<head>
	<title>Promokings</title>
	   <link rel="shortcut icon" href="itemimg/promoking.jpg">

	<meta charset="UTF-8">

	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">

	<meta name="description" content="">

	<meta name="author" content="">



	

	<link rel="stylesheet" href="css/font-awesome.min.css">

	<link rel="stylesheet" href="css/bootstrap.min.css">

	<link rel="stylesheet" href="css/dataTables.bootstrap.min.css">

	<link rel="stylesheet" href="css/bootstrap-social.css">

	<link rel="stylesheet" href="css/bootstrap-select.css">

	<link rel="stylesheet" href="css/fileinput.min.css">

	<link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">

	<link rel="stylesheet" href="css/style.css">


	  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/5.5.3/css/ionicons.min.css">	

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
    function removeSpaces(input) {
        input.value = input.value.replace(/\s/g, '');
    }
</script>


	


</head>


<body style="background-image: url('img/do-not/office.jpg'); background-size: cover; background-repeat: no-repeat; background-position: center;">



	<div class="login-page bk-img" style="background-image: url(img/background.jpg);">

		<div class="form-content">

			<div class="container" >

				<div class="row" >

					<div class="col-md-6 col-md-offset-3">

						<h1 class="text-center text-bold  mt-2x" style="color:green;"> Register</h1>
						  

			               <div class="well row pt-2x pb-3x ">

							<div class="col-md-8 col-md-offset-2">

								<form method="post">


                                  <?php echo COMPANY_LOGO; ?>
<br>
                              
                              <div>
									<label for="" class="text-uppercase text-sm">Full  name </label>

									<input type="text" placeholder="First name" name="fullname" class="form-control mb" class="form-control mb"  maxlength="20">
									

                                    <label for="id-no" class="text-uppercase text-sm">ID NO</label>
                                   <input type="text" id="idno" placeholder="national id no" name="idno" class="form-control mb">

                                    <label for="" class="text-uppercase text-sm">Employee No.</label>
                                    <input type="text" placeholder="No. assigned" name="employee" class="form-control mb">

                                    <label for="" class="text-uppercase text-sm">Temporary Username</label>
									<input type="text" placeholder="Username" name="username" class="form-control mb" class="form-control mb"  maxlength="10">

									<label for="" class="text-uppercase text-sm">Temporary Password</label>
									<input type="Password" placeholder="Last name" name="password" class="form-control mb" class="form-control mb" onblur="removeSpaces(this)"  maxlength="14">
                                                                       
                                   <div class="checkbox icheck">
                                  <input type="checkbox" name="accept" id="terms-checkbox" required>
                                   <label for="terms-checkbox">I agree to <a href="terms.php">terms</a></label>

                                    </div>

                                    
                                   
                                    
                                    <button class="btn bk-uzi3 btn-block" name="submit" type="submit"> REQUEST</button><br>
                                    &nbsp&nbspCreated an account?&nbsp&nbsp<a href="index.php">Login</a>

                            
                            </form>

							</div>

						</div>

					</div>

				

			</div>

		</div>

	</div>
</body>

