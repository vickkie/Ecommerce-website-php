<?php
if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) {
    exit('No direct script access allowed');
}
?>


<?php
session_start();
error_reporting(0);
include('includes/config.php');

$allowedPositions = array('inventory manager', 'admin' ,'superadmin');

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
      if (isset($_GET['edit'])) {
        $id = $_GET['edit'];
    }

if(isset($_POST['submit'])){

$category = $_POST['categories'];

//picture coding

$picture_name = $_FILES['image']['name'];
$picture_type = $_FILES['image']['type'];
$picture_tmp_name = $_FILES['image']['tmp_name'];
$picture_size = $_FILES['image']['size'];

if ($picture_type == "image/jpeg" || $picture_type == "image/jpg" || $picture_type == "image/png" || $picture_type == "image/gif") {
  if ($picture_size <= 50000000) {
    $pic_name = $name .time() . "_" . $picture_name;
    $upload_path = "itemimg/" . $pic_name;

    // Upload the original image
    move_uploaded_file($picture_tmp_name, $upload_path);

    // Resize the image
    list($width, $height) = getimagesize($upload_path);
    $new_width = 500;
    $new_height = 500;
    $resized_image = imagecreatetruecolor($new_width, $new_height);

    if ($picture_type == "image/jpeg" || $picture_type == "image/jpg") {
      $source_image = imagecreatefromjpeg($upload_path);
    } elseif ($picture_type == "image/png") {
      $source_image = imagecreatefrompng($upload_path);
    } elseif ($picture_type == "image/gif") {
      $source_image = imagecreatefromgif($upload_path);
    }

    imagecopyresampled($resized_image, $source_image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

    // Save the resized image
    if ($picture_type == "image/jpeg" || $picture_type == "image/jpg") {
      imagejpeg($resized_image, $upload_path, 90);
    } elseif ($picture_type == "image/png") {
      imagepng($resized_image, $upload_path, 9);
    } elseif ($picture_type == "image/gif") {
      imagegif($resized_image, $upload_path);
    }

    // Free up memory
    imagedestroy($source_image);
    imagedestroy($resized_image);
  }
  
$cateimg=$pic_name;
$categry=$_POST['categories'];
$sql = "UPDATE categories SET cat_title = :categories, cateimg = :cateimg WHERE cat_id = :id";

$query = $dbh->prepare($sql);
$query->bindParam(':categories',$categry,PDO::PARAM_STR);
$query->bindParam(':cateimg',$cateimg,PDO::PARAM_STR);
$query->bindParam(':id', $id, PDO::PARAM_STR);
$query->execute();
$queryupdate =$query;
if($queryupdate)
{
$msg="Category Updated successfully";
}
else 
{
$error="Not updated. Please try again";
}
}

else 
{
$error="Something went wrong. Please try again";
}
}

 // Fetch the category details from the database
    $sqltemp = "SELECT * FROM categories WHERE cat_id = :id";
    $querytemp = $dbh->prepare($sqltemp);
    $querytemp->bindParam(':id', $id, PDO::PARAM_STR);
    $querytemp->execute();
    $resulttemp = $querytemp->fetch(PDO::FETCH_OBJ);

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
    <title>Update Category
    </title>
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-social.css">
    <link rel="stylesheet" href="css/bootstrap-select.css">
    <link rel="stylesheet" href="css/fileinput.min.css">
    <link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
    <link rel="stylesheet" href="css/style.css">
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
              <h2 class="page-title">
          <a href="manage-category.php">
                <i class="fa fa-arrow-circle-left">Back</i>
                </a> &nbsp&nbsp&nbsp 

                Update Category  <?php echo $category ?>
              </h2>
              <div class="row">
                <div class="col-md-12">
                  <div class="panel panel-default">
                    <div class="panel-heading">Form fields
                    </div>
                    <div class="panel-body">
                      <form enctype="multipart/form-data" method="post" class="form-horizontal" onSubmit="return valid();">
                        <?php if($error){?>
                        <div class="errorWrap">
                          <?php echo htmlentities($error); ?> 
                        </div>
                        <?php } 
              else if($msg){?>
                        <div class="succWrap">
                          <strong>
                            <?php echo htmlentities($msg); ?> 
                            </div>
                          <?php }?>
                          <div class="form-group">
                            <label class="col-sm-4 control-label">Category Name
                            </label>
                            <div class="col-sm-6">
                              <input type="text" class="form-control" name="categories" value="<?php echo htmlentities($resulttemp->cat_title);?>" required>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-4 control-label">Category Image
                            </label>
                            <div class="col-sm-6">
                              <input type="file" class="form-control" name="image" required>
                            </div>
                          </div>
                          <div class="hr-dashed">
                          </div>
                          <div class="form-group">
                            <div class="col-sm-8 col-sm-offset-4">
                              <button class="btn btn-primary" name="submit" type="submit">Update
                              </button>
                            </div>
                          </div>
                          </form>
                        </div>
                    </div>
                    <center><img src="product_images/promokings.jpg" /></center>
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
