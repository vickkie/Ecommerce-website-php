<?php
if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) {
    exit('No direct script access allowed');
}
?>
<?php
session_start();
error_reporting(0);
include('includes/config.php');

$allowedPositions = array( 'admin', 'inventory-manager' ,'superadmin');

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
if(isset($_POST['submit'])){
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
$catid = $_POST['catid'];
$date = $_POST['date_arrival'];


//picture coding

$picture_name = $_FILES['image']['name'];
$picture_type = $_FILES['image']['type'];
$picture_tmp_name = $_FILES['image']['tmp_name'];
$picture_size = $_FILES['image']['size'];

if ($picture_type == "image/jpeg" || $picture_type == "image/jpg" || $picture_type == "image/png" || $picture_type == "image/gif") {
  if ($picture_size <= 50000000) {
    $pic_name = $name .time() . "_" . $picture_name;
    $upload_path = "product_images/" . $pic_name;

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
}


// ...

$a = $code;
$b = $name;
$c = $desc;
$d = $price;
$e = $supplier;
$f = $quantity;
$g = $o_price;
$h = $profit;
$i = $category;
$j = $date;
$k = $catid;
$m = $pic_name;

// Check if similar data exists in the table based on product_code
$checkSql = "SELECT COUNT(*) FROM products WHERE product_code = :a";
$checkStmt = $dbh->prepare($checkSql);
$checkStmt->execute(array(':a' => $a));
$count = $checkStmt->fetchColumn();

if ($count == 0) {
    // No similar data exists, proceed with the insertion
    $sql = "INSERT INTO products (product_code, product_title, product_desc, product_price, supplier, qty, o_price, profit, cat_title, date_arrival, product_cat, product_image) 
            VALUES (:a, :b, :c, :d, :e, :f, :g, :h, :i, :j, :k, :m)";
    $q = $dbh->prepare($sql);
    $q->execute(array(':a' => $a, ':b' => $b, ':c' => $c, ':d' => $d, ':e' => $e, ':f' => $f, ':g' => $g, ':h' => $h, ':i' => $i, ':j' => $j, ':k' => $k, ':m' => $m));

    $lastInsertId = $dbh->lastInsertId();

    if ($lastInsertId) {
        $msg = "Item added successfully";
    } else {
        $error = "Something went wrong. Please try again";
    }
} else {
   $error = "Similar data already exists in the table";
}
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
    <title>Add Items
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
              <h2 class="page-title">Add Product
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
                        <label class="col-sm-2 control-label">Name
                            <span style="color:red">*
                            </span>
                          </label>
                          <div class="col-sm-4">
                            <input type="text" name="name" class="form-control" required>
                          </div>

                        <label class="col-sm-2 control-label">Product code
                            <span style="color:red">*
                            </span>
                          </label>
                          <div class="col-sm-4">
                            <input type="text" value="PRK-<?php 
                            $prefix= md5(time()*rand(1, 2)); echo strip_tags(substr($prefix ,0,4));?>" name="code" Readonly Required  class="form-control" required>
                          </div>
                        </div>

<div class="hr-dashed"></div>

                    <div class="form-group">  
                       <label class="col-sm-2 control-label">Category<span style="color:red">*</span></label>
                       <div class="col-sm-4">
                     <select name="category" class="form-control" id="categorySelect">
                      <option value="">Select category</option>
                      <?php
                      try {
                           $sql = "SELECT * FROM categories";
                      $query = $dbh->prepare($sql);
                     $query->execute();
                      $results = $query->fetchAll(PDO::FETCH_OBJ);
                     $cnt = 1;
                    if ($query->rowCount() > 0) {
                      foreach ($results as $result) {
                      ?>
                      <option value="<?php echo htmlentities($result->cat_title); ?>" id="<?php echo htmlentities($result->cat_id); ?>">
                    <?php echo htmlentities($result->cat_title); ?>
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


                 <label class="col-sm-2 control-label">Category ID<span style="color:red">*</span></label>
                 <div class="col-sm-4">
                <input type="text" name="catid" id="categoryId" class="form-control" required readonly="">
                   </div>
                 
</div>
<div class="hr-dashed">
                        </div>




<!-- Include jQuery library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
$(document).ready(function() {
  // When the category select element changes
  $("#categorySelect").change(function() {
    // Get the selected category ID
    var categoryId = $(this).find(':selected').attr('id');
    // Set the category ID in the input field
    $("#categoryId").val(categoryId);
  });
});
</script>




                  


                      
<div class="form-group">
    
<label class="col-sm-2 control-label control-label text-left">Suppliers
                            <span style="color:red">*
                            </span>
                          </label>
                          <div class="col-sm-4">
                            <select name="suppliers" class="form-control" >
                              <option value="">Select supplier
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
  <div class="form-group">
                          <label class="col-sm-2 control-label control-label text-right">Quantity
                            <span style="color:red">*
                            </span>
                          </label>
                          <div class="col-sm-3">
                            <input type="number" name="qtn" class="form-control" required>
                          </div></div>
                          <div class="hr-dashed">
                        </div>                    
<div class="hr-dashed">
                        </div>
                     
                       
   <div class="form-group">
  <label class="col-sm-2 control-label control-label text-right">Supplier Price<span style="color:red">*</span></label>
  <div class="col-sm-4">
    <input type="number" name="originalprice" class="form-control" required placeholder="Kshs" oninput="calculateProfit()">
  </div>

                        

<div class="form-group">
  <label class="col-sm-2 control-label">Selling Price<span style="color:red">*</span></label>
  <div class="col-sm-3">
    <input type="number" name="sellingprice" class="form-control" required placeholder="Kshs" oninput="calculateProfit()">
  </div>
</div>
<script>
function calculateProfit() {
  var sellingPrice = parseFloat(document.getElementsByName("sellingprice")[0].value);
  var supplierPrice = parseFloat(document.getElementsByName("originalprice")[0].value);
  var profit = sellingPrice - supplierPrice;
  document.getElementsByName("profit")[0].value = profit.toFixed(2);
}
</script>
  <div class="hr-dashed"></div>





                        <div class="form-group">
                        <label class="col-sm-2 control-label">Supply date
                            <span style="color:red">*
                            </span>
                          </label>
                          <div class="col-sm-4">
                            <input type="date" name="date_arrival" class="form-control" required>
                          </div>



                        <label class="col-sm-2 control-label">Image
                            <span style="color:red">*
                            </span>
                          </label>
                          <div class="col-sm-3">
                            <input type="file" name="image" class="form-control" value="Select Image File">
                          </div>
                        </div>

                          <div class="hr-dashed"></div>

      <div class="form-group">
  <label class="col-sm-2 control-label text-right">Description
    <span style="color:red">*</span>
  </label>
  <div class="col-sm-4">
    <textarea class="form-control" name="description"></textarea>
  </div>


<div class="form-group">
  <label class="col-sm-2 control-label text-right">Profit
    <span style="color:red">*</span>
  </label>
  <div class="col-sm-3">
    <input type="text" name="profit" class="form-control" readonly>
  </div>
</div>

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
