<?php
session_start();

include('includes/config.php');

$allowedPositions = array('superadmin' ,'admin');

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
if(isset($_GET['positionid']))
{
$userid=$_GET['positionid'];
}
if(isset($_POST['submit']))
{
$position=$_POST['position'];
$sql="UPDATE users SET position=' $position' WHERE id=$userid ";
$query = $dbh->prepare($sql);
$query->execute();
if($query){
$msg="Position Updated successfully";
} 
else 
{
 $error="Error Occured";   
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
    <title>Update Items
    </title>
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
    <script type= "text/javascript" src="../vendor/countries.js">
    </script>
    <style>
      .errorWrap {
        padding: 10px;
        margin: 0 0 20px 0;
        background: #dd3d36;
        color:#fff;
        -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
        box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
      }
      .succWrap{
        padding: 10px;
        margin: 0 0 20px 0;
        background: #5cb85c;
        color:#fff;
        -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
        box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
      }
    </style>
  </head>
  <body>
    <?php include('includes/header.php');?>
    <div class="ts-main-content">
      <?php include('includes/leftbar.php');?>
      <?php $sqltemp = "SELECT * from users where id = (:id)";
     $querytemp = $dbh -> prepare($sqltemp);
     $querytemp->bindParam(':id',$userid,PDO::PARAM_STR);
     $querytemp->execute();
     $resulttemp=$querytemp->fetch(PDO::FETCH_OBJ);         
      ?>
      <div class="content-wrapper">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <h2 class="page-title">
                <a href="new-user.php">
                  <i class="glyphicon glyphicon-circle-arrow-left" style="color:#3b3b3b">
                  </i>
                </a>&nbsp; &nbsp; Assign Position
              </h2>
              <div class="row">
                <div class="col-md-12">
                  <div class="panel panel-default">
                    <div class="panel-heading">User Info
                    </div>
                    <?php if($error){?>
                    <div class="errorWrap">
                      <?php echo htmlentities($error); ?> 
                    </div>
                    <?php } 
                else if($msg){?>
                    <div class="succWrap">
                      <?php echo htmlentities($msg); ?> 
                    </div>
                    <?php }?>
                    <div class="panel-body">
                      <form method="post" class="form-horizontal">
                        <div class="form-group">
                          <label class="col-sm-2 control-label">Name
                          </label>
                          <div class="col-sm-4">
                            <input class="form-control" required readonly value="<?php echo htmlentities($resulttemp->first_name); ?> &nbsp <?php echo htmlentities($resulttemp->last_name); ?>">
                          </div>
                      </div>
                 
                       <div class="hr-dashed"></div>

                    <div class="form-group">  
                       <label class="col-sm-2 control-label">Position<span style="color:red">*</span></label>
                       <div class="col-sm-4">
                     <select name="positions" class="form-control" id="positionSelect">
                      <option value="">Select position</option>
                      <?php
                      try {
                           $sql = "SELECT * FROM position";
                      $query = $dbh->prepare($sql);
                     $query->execute();
                      $results = $query->fetchAll(PDO::FETCH_OBJ);
                     $cnt = 1;
                    if ($query->rowCount() > 0) {
                      foreach ($results as $result) {
                      ?>
                      <option value="<?php echo htmlentities($result->cat_title); ?>" id="<?php echo htmlentities($result->position_name); ?>">
                          <?php echo htmlentities($result->position_name); ?>
                      </option>
                <?php
                 }
                   }
                   } catch (PDOException $e) {
                     echo "Database Error: " . $e->getMessage();
                    }
                    ?>
                   </select>
                     </div>
           

                 <label class="col-sm-2 control-label">Position
                    <span style="color:red">*</span></label>
                 <div class="col-sm-4">
                <input type="text" name="position" id="position" class="form-control" required readonly>
                   </div>
                 </div>
                 <div class="hr-dashed">
                        </div>


                        </div>
                        <div class="form-group">
                          <div class="col-sm-8 col-sm-offset-2">
                            <button class="btn btn-primary bk-uzi4" name="submit" type="submit" style="margin-bottom: 10px;">Update Changes
                            </button>
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
    <script src="js/jquery.min.js">
    </script>
    <script src="js/bootstrap-select.min.js">
    </script>
    <script src="js/bootstrap.min.js">
    </script>
    <script src="js/jquery.dataTables.min.js">
    </script>
    <script src="js/dataTables.bootstrap.min.js">
    </script>
    <script src="js/Chart.min.js">
    </script>
    <script src="js/fileinput.js">
    </script>
    <script src="js/chartData.js">
    </script>
    <script src="js/main.js">
    </script>
     <!-- Include jQuery library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
$(document).ready(function() {
  // When the category select element changes
  $("#positionSelect").change(function() {
    // Get the selected category ID
    var position = $(this).find(':selected').attr('id');
    // Set the category ID in the input field
    $("#position").val(position);
  });
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
    <script type="text/javascript">
      $(document).ready(function () {
        setTimeout(function() {
          $('.errorWrap').slideUp("slow");
        }
                   , 3000);
      }
                       );
    </script>
  </body>
</html>
<?php } ?>
