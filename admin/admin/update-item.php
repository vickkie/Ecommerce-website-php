<?php
session_start();
error_reporting(0);
include('includes/config.php');


$allowedPositions = array('inventory manager','sales manager', 'superadmin' ,'admin');

// Check if the user is logged in and has an allowed position
if (empty($_SESSION['alogin']) || !in_array($_SESSION['position'], $allowedPositions)) {
    // Redirect the user to the access-denied page or any other appropriate page
    header('location:errors/access-denied.php');
    exit(); // Stop further execution of the script
}


if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
    if (isset($_GET['edititem'])) {
        $id = $_GET['edititem'];
    }

    if (isset($_POST['submit'])) {
        $code = $_POST['code'];
        $name = $_POST['name'];
        $category = $_POST['category'];
        $desc = $_POST['description'];
        $price = $_POST['sellingprice'];
        $supplier = $_POST['suppliers'];
        $quantity = $_POST['qtn'];
        $o_price = $_POST['originalprice'];
        $profit = $_POST['profit'];
        $date = $_POST['date_arrival'];
        $category_number = $_POST['product_cat'];

        // Picture upload
        $picture_name = $_FILES['image']['name'];
        $picture_tmp_name = $_FILES['image']['tmp_name'];
        $picture_type = $_FILES['image']['type'];
        $picture_size = $_FILES['image']['size'];
        $pic_name = '';

        // Validate and sanitize form inputs
        $code = filter_input(INPUT_POST, 'code', FILTER_SANITIZE_STRING);
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        $category = filter_input(INPUT_POST, 'category', FILTER_SANITIZE_STRING);
        $desc = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
        $price = filter_input(INPUT_POST, 'sellingprice', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $supplier = filter_input(INPUT_POST, 'suppliers', FILTER_SANITIZE_STRING);
        $quantity = filter_input(INPUT_POST, 'qtn', FILTER_SANITIZE_NUMBER_INT);
        $o_price = filter_input(INPUT_POST, 'originalprice', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $profit = filter_input(INPUT_POST, 'profit', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $date = filter_input(INPUT_POST, 'date_arrival', FILTER_SANITIZE_STRING);
        $category_number = filter_input(INPUT_POST, 'product_cat', FILTER_SANITIZE_NUMBER_INT);

        // Validate and process file upload
        if ($picture_type == "image/jpeg" || $picture_type == "image/jpg" || $picture_type == "image/png" || $picture_type == "image/gif") {
            if ($picture_size <= 50000000) {
                $pic_name = time() . "_" . $picture_name;
                move_uploaded_file($picture_tmp_name, "product_images/" . $pic_name);
            }
        }

        // Check if the product ID exists
        $sql = "SELECT product_id FROM products WHERE product_id = :editid";
        $qb = $dbh->prepare($sql);
        $qb->bindParam(':editid', $id, PDO::PARAM_STR);
        $qb->execute();
        $results = $qb->fetchAll(PDO::FETCH_OBJ);

        if (count($results) > 0) {
            // Update the product
            $sql = "UPDATE products SET 
                product_code = :code,
                product_title = :name,
                product_desc = :desc,
                product_price = :price,
                supplier = :supplier,
                qty = :quantity,
                o_price = :o_price,
                profit = :profit,
                gen_name = :category,
                date_arrival = :date,
                product_cat = :category_number,
                product_image = :pic_name 
                WHERE product_id = :editid";

            $q = $dbh->prepare($sql);
            $q->bindParam(':code', $code, PDO::PARAM_STR);
            $q->bindParam(':name', $name, PDO::PARAM_STR);
            $q->bindParam(':desc', $desc, PDO::PARAM_STR);
            $q->bindParam(':price', $price, PDO::PARAM_STR);
            $q->bindParam(':supplier', $supplier, PDO::PARAM_STR);
            $q->bindParam(':quantity', $quantity, PDO::PARAM_INT);
            $q->bindParam(':o_price', $o_price, PDO::PARAM_STR);
            $q->bindParam(':profit', $profit, PDO::PARAM_STR);
            $q->bindParam(':category', $category, PDO::PARAM_STR);
            $q->bindParam(':date', $date, PDO::PARAM_STR);
            $q->bindParam(':category_number', $category_number, PDO::PARAM_INT);
            $q->bindParam(':pic_name', $pic_name, PDO::PARAM_STR);
            $q->bindParam(':editid', $id, PDO::PARAM_STR);
            $q->execute();

            $error = ""; // Initialize the $error variable
            $msg = "Item updated successfully";
        } else {
            $error = "Product ID not found.";
        }
  
}
$sqltemp = "SELECT * from products where product_id = (:id)";
$querytemp = $dbh -> prepare($sqltemp);
$querytemp->bindParam(':id',$id,PDO::PARAM_STR);
$querytemp->execute();
$resulttemp=$querytemp->fetch(PDO::FETCH_OBJ);
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
              <a href="manage-items.php">
                  <i class="glyphicon glyphicon-circle-arrow-left" style="color:#3b3b3b">
                  </i>
                </a>&nbsp; &nbsp; Update Product
              </h2>
              <div class="row">
                <div class="col-md-12">
                  <div class="panel panel-default">
                    <div class="panel-heading">Product Info
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

                        <label class="col-sm-2 control-label">Product code
                            <span style="color:red">*
                            </span>
                          </label>
                          <div class="col-sm-4">
                            <input type="text" value="PRK-<?php 
                            $prefix= md5(time()*rand(1, 2)); echo strip_tags(substr($prefix ,0,4));?>" name="code" Readonly Required  class="form-control" required>
                          </div>

                          <label class="col-sm-2 control-label">Category
                            <span style="color:red">*
                            </span>
                          </label>
                          <div class="col-sm-3">
                            <select name="category" class="form-control" >
                              <option value="<?php echo htmlentities($resulttemp->gen_name); ?>">Select category
                              </option>
                             <?php
    try {
        // Assuming the 'categories' table has a column named 'category_name'
        $sql = "SELECT * FROM categories";
        $query = $dbh->prepare($sql);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);
        $cnt = 1;
        if ($query->rowCount() > 0) {
            foreach ($results as $result) {
?>
                <option value="<?php echo htmlentities($result->cat_title); ?>">
                    <?php echo htmlentities($result->cat_title); ?>
                </option>
<?php
            }
        }
    } catch (PDOException $e) {
        // Handle database errors here
        echo "Database Error: " . $e->getMessage();
    }
?>

                            </select>
                          </div>
                        </div>
                        <div class="hr-dashed">
                        </div>

                      <div class="form-group">
                        <label class="col-sm-2 control-label">Name
                            <span style="color:red">*
                            </span>
                          </label>
                          <div class="col-sm-4">
                            <input type="text" value="<?php echo htmlentities($resulttemp->product_title); ?>" name="name" class="form-control" required>
                          </div>


                      <div class="form-group">
                          <label class="col-sm-2 control-label">Quantity
                            <span style="color:red">*
                            </span>
                          </label>
                          <div class="col-sm-3">
                            <input type="number" name="qtn" class="form-control" value="<?php echo htmlentities($resulttemp->qty); ?>"required>
                          </div></div>
                          <div class="hr-dashed">
                        </div>


                     
                       
                         <div class="form-group">
                          <label class="col-sm-2 control-label">Supplier Price
                            <span style="color:red">*
                            </span>
                          </label>
                          <div class="col-sm-4">
                            <input type="number" name="originalprice"  class="form-control" value="<?php echo htmlentities($resulttemp->o_price); ?>" required placeholder="Kshs" onkeyup="sum();" >
                          </div>
                       
                          
                        <div class="form-group">
                          <label class="col-sm-2 control-label">Selling Price
                            <span style="color:red">*
                            </span>
                          </label>
                          <div class="col-sm-3">
                            <input type="number" name="sellingprice" class="form-control" value="<?php echo htmlentities($resulttemp->product_price); ?>"required placeholder="Kshs"onkeyup="sum();" >
                          </div></div>
                          <div class="hr-dashed">
                        </div>

                          <div class="form-group">
                          <label class="col-sm-2 control-label">profit
                            <span style="color:red">*
                            </span>
                          </label>
                          <div class="col-sm-4">
                            <input type="text" name="profit" value="<?php echo htmlentities($resulttemp->profit); ?>"class="form-control"  >
                          </div>

                          <label class="col-sm-2 control-label">Suppliers
                            <span style="color:red">*
                            </span>
                          </label>
                          <div class="col-sm-3">
                            <select name="suppliers" class="form-control" >
                              <option value="<?php echo htmlentities($resulttemp->supplier); ?>">Select supplier
                              </option>
                          <?php
    try {
        // Assuming the 'categories' table has a column named 'category_name'
        $sql = "SELECT * FROM suppliers";
        $query = $dbh->prepare($sql);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);
        $cnt = 1;
        if ($query->rowCount() > 0) {
            foreach ($results as $result) {
?>
                <option value="<?php echo htmlentities($result->name); ?>">
                    <?php echo htmlentities($result->name); ?>
                </option>
<?php
            }
        }
    } catch (PDOException $e) {
        // Handle database errors here
        echo "Database Error: " . $e->getMessage();
    }
?>
                            </select>
                          </div>
                        </div>
                        <div class="hr-dashed">
                        </div>
                        <div class="form-group">
                        <label class="col-sm-2 control-label">Supply date
                            <span style="color:red">*
                            </span>
                          </label>
                          <div class="col-sm-4">
                            <input type="date" name="date_arrival" value="<?php echo htmlentities($resulttemp->date_arrival); ?>" class="form-control" required>
                          </div>


                      <div class="form-group">
                          <label class="col-sm-2 control-label">category number
                            <span style="color:red">*
                            </span>
                          </label>
                          <div class="col-sm-3">
                            <input type="number" name="product_cat" value="<?php 

                            echo htmlentities($resulttemp->product_cat); ?>" class="form-control" required>
                          </div></div>
                          <div class="hr-dashed">
                        </div>


                        <label class="col-sm-2 control-label">Image
                            <span style="color:red">*
                            </span>
                          </label>
                         <div class="col-sm-4">
                               <input type="file" name="image" class="form-control" value="<?php echo "product_images/" . htmlentities($resulttemp->product_image); ?>">
                              </div>

                       
                           <div class="form-group">
                          <label class="col-sm-2 control-label">Description
                            <span style="color:red">*
                            </span>
                          </label>
                   <div class="col-sm-3">
                            <textarea class="form-control" required  name="description" value="<?php echo htmlentities($resulttemp->product_desc); ?>" >
                            </textarea>
                          </div>
                        </div>
                          <div class="hr-dashed"></div>
                        <div class="form-group">
                          <div class="col-sm-8 col-sm-offset-2">
                            <button class="btn btn-default" type="reset">Cancel
                            </button>
                            <button class="btn btn-primary" name="submit" type="submit">Save Changes
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
