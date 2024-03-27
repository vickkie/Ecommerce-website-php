<?php
if ($_SERVER['SCRIPT_FILENAME'] == __FILE__) {
    exit('Direct access is not allowed.');
}

session_start();
error_reporting(0);

include('includes/config.php');
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

  <link rel="stylesheet" href="css/adminlte.css">

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

  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>




<div class="form-background"> 
  <div class="register-box">
    <div class="register-logo">
      <h2>Promokings</a></h2>
    </div>

    <div class="card">
      <div class="card-body register-card-body">
        <p class="login-box-msg">register</p>

          <div class="form-group has-feedback">
             <input type="text" name="username" id="name" value="" class="form-control" placeholder="username" >
          </div>
          <div class="form-group has-feedback">
            <input type="text" name="firstname" id="firstname" value="" class="form-control" placeholder="first name" >
          </div>
          <div class="form-group has-feedback">
           <input type="text" name="lastname" id="lastname" value="" class="form-control" placeholder="last name" >
          </div>
          <div class="form-group has-feedback">
             <input type="text" name="email" id="email" value="" class="form-control" placeholder="email" >
          </div>
          <div class="form-group has-feedback">
             <input type="password" name="password" id="password" class="form-control" placeholder="password" >
          </div>
          <div class="form-group has-feedback">
              <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="confirm passord" >
          </div>
          <div class="row">
            <div class="col-8">
              <div class="checkbox icheck">
                <label>
                  <input type="checkbox"> i agree to<a href="#">terms</a>
                </label>
              </div>
            </div>
            <?php if($this->recaptcha_status): ?>
              <div class="recaptcha-cnt">
                  <?php generate_recaptcha(); ?>
              </div>
            <?php endif; ?>
            <!-- /.col -->
            <div class="col-4">
              <input type="submit" name="submit" id="submit" class="btn btn-primary btn-block btn-flat" value="Register">
            </div>
            <!-- /.col -->
          </div>
        <?php echo form_close(); ?>

        <a href="index.php" class="text-center">Already have a membership</a>
      </div>
      <!-- /.form-box -->
    </div><!-- /.card -->
  </div>
</div>
