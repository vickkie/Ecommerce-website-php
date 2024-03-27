<?php
session_start();
error_reporting(0);
include('includes/config.php');
$allowedPositions = array('inventory manager', 'superadmin' ,'admin');

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
if(isset($_GET['del']))
{
$id=$_GET['del'];
$sql = "delete from products WHERE product_id=:id";
$query = $dbh->prepare($sql);
$query -> bindParam(':id',$id, PDO::PARAM_STR);
$query -> execute();
$msg="Data Deleted successfully";
}
if(isset($_REQUEST['unhomepage']))
{
$aeid=intval($_GET['unhomepage']);
$status='YES';
$sql = "UPDATE products SET homepage=:status WHERE  product_id=:aeid";
$query = $dbh->prepare($sql);
$query -> bindParam(':status',$status, PDO::PARAM_STR);
$query-> bindParam(':aeid',$aeid, PDO::PARAM_STR);
$query -> execute();
$msg="Changes Sucessfully";
}
if(isset($_REQUEST['homepage']))
{
$aeid=intval($_GET['homepage']);
$status='NO';
$sql = "UPDATE products SET homepage=:status WHERE  product_id=:aeid";
$query = $dbh->prepare($sql);
$query -> bindParam(':status',$status, PDO::PARAM_STR);
$query-> bindParam(':aeid',$aeid, PDO::PARAM_STR);
$query -> execute();
$msg="Changes Sucessfully";
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
    <title>Promokings | Manage Items
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
              <h2 class="page-title">Manage Items
              </h2>
              <!-- Zero Configuration Table -->
              <div class="panel panel-default">
                <div class="panel-heading">List Items
                </div>
                <div class="panel-body">
                  <?php if($error){?>
                  <div class="errorWrap" id="msgshow">
                    <?php echo htmlentities($error); ?> 
                  </div>
                  <?php } 
else if($msg){?>
                  <div class="succWrap" id="msgshow">
                    <?php echo htmlentities($msg); ?> 
                  </div>
                  <?php }?>
                  <table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th>#
                        </th>
                        <th>Image
                        </th>
                        <th>Name
                        </th>
                        <th>Category
                        </th>
                        <th>Description
                        </th>
                        <th>Quantity
                        </th>
                        <th>Price
                        </th>
                        <th>Supply date
                        </th>
                        <th>Action
                        </th>	
                      </tr>
                    </thead>
                    <tbody>
                      <?php $sql = "SELECT * from  products ";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{				?>	
                      <tr>
                        <td>
                          <?php echo htmlentities($cnt);?>
                        </td>
                        <td>
                          <img src="product_images/<?php echo htmlentities($result->product_image);?>" style="width:50px;"/>
                        </td>
                        <td>
                          <?php echo htmlentities($result->product_title);?>
                        </td>
                        <td>
                          <?php echo htmlentities($result->cat_title);?>
                        </td>
                        <td>
                          <?php echo htmlentities($result->product_desc);?>
                        </td>
                        <td>
                          <?php echo htmlentities($result->qty);?> 
                         
                        </td>
                        <td>
                          <?php echo htmlentities($result->product_price);?> Kshs
                          <a href="update-price.php?edititem=<?php echo $result->product_id;?>" onclick="return confirm('Do you want to update Price');">&nbsp; 
                            <i class="fa fa-pencil">
                            </i>
                          </a>
                        </td>
                        <td>
                          <?php echo htmlentities($result->date_arrival); ?>



                          <?php /*if($result->homepage == 'YES')
{?>
                          <a href="manage-items.php?homepage=<?php echo htmlentities($result->id);?>" onclick="return confirm('Do you really want to Remove item from Homepage')">YES
                          </a> 
                          <?php } else {?>
                          <a href="manage-items.php?unhomepage=<?php echo htmlentities($result->id);?>" onclick="return confirm('Do you really want to Make item on Homepage')">NO
                          </a>
                          <?php } */ ?>
                        </td>											
                        <td>
                          <a href="update-item.php?edititem=<?php echo $result->product_id;?>" onclick="return confirm('Do you want to update Product');">&nbsp; 
                            <i class="fa fa-pencil">
                            </i>
                          </a>

                          <a href="manage-items.php?del=<?php echo $result->product_id;?>" onclick="return confirm('Do you want to delete');">
                            <i class="fa fa-trash" style="color:red">
                            </i>
                          </a>
                        

                          
                        </td>
                      </tr>
                      <?php $cnt=$cnt+1; }} ?>
                    </tbody>
                  </table>
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
    <script>
    $(document).ready(function() {
        // Destroy existing DataTable instance (if any)
        if ($.fn.DataTable.isDataTable('#zctb')) {
            $('#zctb').DataTable().destroy();
        }

        // Initialize DataTable with pagination options
        $('#zctb').DataTable({
            "lengthMenu": [25, 50, 100,200], // Set the available page lengths
            "pageLength": 20, // Set the initial page length to 20
            "pagingType": "full_numbers", // Display pagination with first, previous, next, and last buttons
            "order": [], // Disable initial sorting
        });
    });
</script>
  </body>
</html>
<?php } ?>
