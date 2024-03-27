<?php
session_start();
error_reporting(0);
include('includes/config.php');

$allowedPositions = array('inventory', 'superadmin' ,'admin', 'sales manager');

// Check if the user is logged in and has an allowed position
if (empty($_SESSION['alogin']) || !in_array($_SESSION['position'], $allowedPositions)) {
    // Redirect the user to the access-denied page or any other appropriate page
    header('location:errors/access-denied.php');
    exit(); // Stop further execution of the script
}

if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1500)) {
    // Last activity was more than 30 minutes ago
    session_unset();     // Unset all session variables
    session_destroy();   // Destroy the session
    header('location: index.php'); // Redirect the user to the login page
    exit(); // Stop further execution of the script
}

// Update last activity time stamp
$_SESSION['LAST_ACTIVITY'] = time();


if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
    if (isset($_GET['edit'])) {
        $id = $_GET['edit'];
    }

    if (isset($_POST['submit'])) {
        
       
        // Picture upload
        $file = $_FILES['categryimg']['name'];
        $file_loc = $_FILES['categryimg']['tmp_name'];
        $folder="itemimg/";
          $new_size = $file_size/1024;  
         $new_file_name = strtolower($file);
          $final_file=str_replace(' ','-',$new_file_name);
          if(move_uploaded_file($file_loc,$folder.$final_file))
   {
       $cateimg=$final_file;
       $categories = $_POST['categories'];

        // Check if the product ID exists
        $sql = "SELECT cat_id FROM categories WHERE cat_id = :edit";
        $qb = $dbh->prepare($sql);
        $qb->bindParam(':edit', $id, PDO::PARAM_STR);
        $qb->execute();
        $results = $qb->fetchAll(PDO::FETCH_OBJ);

        if (count($results) > 0) {
            // Update the product
            $sql = "UPDATE categories SET 
                cat_title = :categories,
                catimg = :pic_name 
                WHERE cat_id = :edit";

            $q = $dbh->prepare($sql);
            $q->bindParam(':categories', $categories, PDO::PARAM_STR);
            $q->bindParam(':pic_name', $cateimg, PDO::PARAM_STR);
             $q->bindParam(':edit', $id, PDO::PARAM_STR);
            $q->execute();

            $error = ""; // Initialize the $error variable
            $msg = "Category updated successfully";
        } else {
            $error = "Category ID not found.";
        }}
  
}
$sqltemp = "SELECT * from categories where cat_id = (:id)";
$querytemp = $dbh -> prepare($sqltemp);
$querytemp->bindParam(':id',$id,PDO::PARAM_STR);
$querytemp->execute();
$resulttemp=$querytemp->fetch(PDO::FETCH_OBJ);
?>

<!doctype html>
<html lang="en" class="no-js">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="theme-color" content="#3e454c">
    <title>Edit item
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
      <div class="content-wrapper">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <h2 
              class="page-title">
              <a href="manage-category.php">
                  <i class="glyphicon glyphicon-circle-arrow-left" style="color:#3b3b3b">
                  </i>
                </a>&nbsp; &nbsp; Update Category
              </h2>
              <div class="row">
                <div class="col-md-12">
                  <div class="panel panel-default">
                    <div class="panel-heading">Category Info
                    </div>
                    <?php if($error){?>
                    <div class="errorWrap">
                      <?php echo htmlentities($error); ?> 
                    </div>
                    <?php  }
                    else if($msg){?>
                    <div class="succWrap">
                      <?php echo htmlentities($msg); ?> 
                    </div>
                    <?php }?> 


                    <div class="panel-body">
                     <form method="post" class="form-horizontal" enctype="multipart/form-data">

                       <div class="form-group">
                            <label class="col-sm-4 control-label">Category Name
                            </label>
                            <div class="col-sm-6">
                              <input type="text" class="form-control"  value="<?php echo htmlentities($resulttemp->cat_title);?>" name="categories"  required>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-4 control-label">Category Image
                            </label>
                            <div class="col-sm-6">
                              <input type="file" class="form-control" name="categryimg"  required>
                            </div>
                          </div>
                          <div class="hr-dashed">
                          </div>
                          <div class="form-group">
                            <div class="col-sm-8 col-sm-offset-4">
                              <button class="btn btn-primary" name="submit" type="submit">Add
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
