<?php
session_start();
error_reporting(0);
include('includes/config.php');


$allowedPositions = array('inventory manager','driver', 'superadmin' ,'admin');

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
if(isset($_REQUEST['order_id']))
{
$orderid=($_GET['order_id']);
}
 // Check if success parameter is present and display success message if true
    if (isset($_GET['success']) && $_GET['success'] == 'true') {
        echo '<div class="success">PDF generated successfully!</div>';
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
    <title>Promokings | View Order  
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
        background: #fff;
        border-left: 4px solid #dd3d36;
        -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
        box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
      }
      .succWrap{
        padding: 10px;
        margin: 0 0 20px 0;
        background: #fff;
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



<!--bro this part// message display//BY VICTOR MWANGI KAMAU-->

<?php
                            // Check if success parameter is present and display success message if true
                            if (isset($_GET['success']) && $_GET['success'] == 'true') {
                                echo '<div class="success">Invoice generated successfully!</div>';
                            }
                            ?>
                            <style>
    .success {
        padding: 10px;
        margin: 0 0 20px 0;
        background: #5cb85c; /* Green background color */
        color: #fff; /* White text color */
        border-left: 4px solid #4cae4c;
        -webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
        box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
    }
</style>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        // Check if success parameter is present and display success message if true
        if (window.location.search.includes('success=true')) {
            $('.success').delay(3000).fadeOut('slow');
        }
    });
</script>


<!-- END OF MESSAGE //MADE BY VICTOR MWANGI KAMAU--LOL-->


              <div class="row">
                <div class="col-md-3 h5">
                  <a href="assigned-orders.php"> GO BACK
                  </a>
                </div>
                <div class="col-md-3 h5">
                </div>
                
                <div class="col-md-3 h5">
                  <b>Order No. : 
                    <?php echo htmlentities($orderid); ?>
                  </b>
                </div>
                <div class="col-md-3 h5">
               
               <div class="text-right">
    <a href="generate-pdf-driver.php?order_id=<?php echo $orderid; ?>" class="btn btn-danger" >Generate Invoice</a>
</div>	 </div>
              </div>
              <!-- Zero Configuration Table -->
              <div class="panel panel-default">
                <div class="panel-heading">Order
                </div>
                <div class="panel-body">
                  <div class="container ">
                    <div class="row">
                      <?php $sql = "SELECT * from orders_info WHERE order_id = :orderid";
$query = $dbh -> prepare($sql);
$query-> bindParam(':orderid',$orderid, PDO::PARAM_STR);
$query->execute();
$result=$query->fetch(PDO::FETCH_OBJ);
?>                    


                      <div class="col-md-12 h5">
                        <b style="text-decoration: underline;">CUSTOMER INFORMATION
                        </b> 
        
                        
                      </div>

                      <div class="col-md-6 h5">
                        <b>Name :
                        </b> 
                        <?php echo htmlentities(strtoupper($result->f_name)); ?> 
                        
                      </div>

                      <div class="col-md-6 h5">
                        <b>Phone :
                        </b>
                        0<?php echo htmlentities ($result->contact); ?>
                      </div>
                      <div class="col-md-6 h5">
                        <b>County :
                        </b> 
                        <?php echo htmlentities( strtoupper($result->city)); ?>
                      </div>
                      
                      <div class="col-md-6 h5">
                        <b>Order Date:
                        </b> 
                        <?php echo htmlentities($result->date); ?>
                      </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6 h5">
                          <b>Town Address :
                          </b> 
                          <?php echo htmlentities(strtoupper($result->address)); ?>
                        </div>	
                    </div>
                  </div>
                  <br>
                  <table class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th>#
                        </th>
                        <th>Product Name
                        </th>
                        <th>Quantity
                        </th>
                        <th>Price
                        </th>
                        <th>Total
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $sql = "SELECT * from sales_orders WHERE order_id = :orderid";
$query = $dbh -> prepare($sql);
$query-> bindParam(':orderid',$orderid, PDO::PARAM_STR);
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
                          <?php echo htmlentities($result->product_title);?> 
                      
                        </td>
                        <td>
                          <?php echo htmlentities($result->qty);?>
                        </td>
                        <td>
                          <?php echo htmlentities($result->product_price);?>
                        </td>
                        <td>
                        <?php echo htmlentities($result->qty * $result->product_price);?>
                        </td>
                      </tr>
                      <?php $cnt=$cnt+1; }} ?>	
                    </tbody>
                  </table>
                  <div class="container">
                    <div class="row">
                      <div class="col-md-8">
                      </div>
                      <?php 
$sqlgd = "SELECT total_amt as grandtotal from orders_info WHERE order_id = :orderid";
$querygd = $dbh -> prepare($sqlgd);
$querygd-> bindParam(':orderid',$orderid, PDO::PARAM_STR);
$querygd->execute();
$resultgd=$querygd->fetch(PDO::FETCH_OBJ); 
?>
                      <div class="col-md-4 h4">
                      <b> Total Amount : <?php echo CURRENCY ?> <?php echo strtoupper(number_format(htmlentities($resultgd->grandtotal), 2)); ?></b>


                      </div>
                      <center><?php //echo COMPANY_LOGO ?></center>
                    </div>
                  </div>





                </div>
              </div>
              </div><center><?php echo COMPANY_LOGO ?></center>
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
  </body>
</html>
<?php } ?>